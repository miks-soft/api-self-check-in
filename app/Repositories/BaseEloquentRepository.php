<?php

namespace App\Repositories;

use App\DTO\BaseDto;
use App\DTO\PaginatedDtoCollection;
use App\DTO\PaginatorDto;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class BaseEloquentRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    private Model $model;

    /**
     * @param string $modelClass
     * @param string $modelDtoClass
     */
    public function __construct(
        protected string $modelClass,
        protected string $modelDtoClass
    )
    {
        $this->model = app()->make($this->modelClass);
    }

    /**
     * @param array|string $columns
     * @param null|array|string $relations
     * @return Collection
     * @throws UnknownProperties
     */
    public function all(array|string $columns = ['*'], null|array|string $relations = null): Collection
    {
        return $this->toDto($this->query($relations)->get($columns));
    }

    /**
     * @param array|string $relations
     * @param array|string $columns
     * @return Collection
     * @throws UnknownProperties
     */
    public function allWith(array|string $relations, array|string $columns = ['*']): Collection
    {
        return $this->all($columns, $relations);
    }

    /**
     * @param array|int|string $id
     * @param string $column
     * @param array|string $columns
     * @param bool $throwOnFail
     * @param null|array|string $relations
     * @return null|BaseDto|Collection
     * @throws UnknownProperties
     * @throws ModelNotFoundException
     */
    public function find(array|int|string $id, string $column = 'id', array|string $columns = ['*'], bool $throwOnFail = false, null|array|string $relations = null): null|BaseDto|Collection
    {
        $query = $this->query($relations);

        if (is_array($id)) {
            return $this->toDto($query->whereIn($column, $id)->get($columns));
        }

        $query->where($column, $id);

        return $this->toDto($throwOnFail ? $query->firstOrFail($columns) : $query->first($columns));
    }

    /**
     * @param array|int|string $id
     * @param array|string $relations
     * @param string $column
     * @param array|string $columns
     * @param bool $throwOnFail
     * @return null|BaseDto|Collection
     * @throws UnknownProperties
     * @throws ModelNotFoundException
     */
    public function findWith(array|int|string $id, array|string $relations, string $column = 'id', array|string $columns = ['*'], bool $throwOnFail = false): null|BaseDto|Collection
    {
        return $this->find($id, $column, $columns, $throwOnFail, $relations);
    }

    /**
     * @param array|Arrayable $data
     * @param null|array|string $relations
     * @return BaseDto
     * @throws UnknownProperties
     */
    public function create(array|Arrayable $data, null|array|string $relations = null): BaseDto
    {
        $data = is_array($data)
            ? $data
            : $data->toArray();

        $model = $this->query()->create($data);

        $model->refresh();
        if ($relations) {
            $model->load($relations);
        }

        return $this->toDto($model);
    }

    /**
     * @param array $attributes
     * @param null|array|Arrayable $data
     * @param null|array|string $relations
     * @return BaseDto
     * @throws UnknownProperties
     */
    public function firstOrCreate(array $attributes = [], null|array|Arrayable $data = null, null|array|string $relations = null): BaseDto
    {
        if (is_null($data)) {
            $data = [];
        }

        $data = is_array($data)
            ? $data
            : $data->toArray();

        $model = $this->query()->firstOrCreate($attributes, $data);

        $model->refresh();
        if ($relations) {
            $model->load($relations);
        }

        return $this->toDto($model);
    }

    /**
     * @param int|string $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(int|string $id): bool
    {
        return $this->query()
            ->where($this->model->getKeyName(), $id)
            ->firstOrFail()
            ->delete();
    }

    /**
     * @param int|string $id
     * @param array|Arrayable $data
     * @param bool $returnModel
     * @param null|array|string $relations
     * @return bool|BaseDto
     * @throws UnknownProperties
     * @throws ModelNotFoundException
     */
    public function update(int|string $id, array|Arrayable $data, bool $returnModel = false, null|array|string $relations = null): bool|BaseDto
    {
        $model = $this->query()
            ->where($this->model->getKeyName(), $id)
            ->firstOrFail();

        $data = is_array($data)
            ? $data
            : $data->toArray();

        $bool = $model->update($data);
        if (!$returnModel) {
            return $bool;
        }

        $model->refresh();
        if ($relations) {
            $model->load($relations);
        }

        return $this->toDto($model);
    }

    /**
     * @param null|array|string $relations
     * @return Builder
     */
    protected function query(null|array|string $relations = null): Builder
    {
        return $this->model
            ->query()
            ->when($relations, fn (Builder $query) => $query->with($relations));
    }

    /**
     * @param Builder $query
     * @param null|int|Closure $perPage
     * @param array|string $columns
     * @param string $pageName
     * @param null|int $page
     * @return PaginatedDtoCollection
     * @throws UnknownProperties
     */
    protected function paginate(Builder $query, null|int|Closure $perPage = null, array|string $columns = ['*'], string $pageName = 'page', ?int $page = null): PaginatedDtoCollection
    {
        $paginator = $query->paginate($perPage, $columns, $pageName, $page);

        return new PaginatedDtoCollection([
            'items' => $this->toDto(collect($paginator->items())),
            'paginator' => new PaginatorDto([
                'total' => $paginator->total(),
                'page' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
                'lastPage' => $paginator->lastPage(),
            ]),
        ]);
    }

    /**
     * @param null|Model|Collection $data
     * @param null|string $dtoClass
     * @return null|BaseDto|Collection
     * @throws UnknownProperties
     */
    protected function toDto(null|Model|Collection $data, ?string $dtoClass = null): null|BaseDto|Collection
    {
        $dtoClass = $dtoClass ?? $this->modelDtoClass;

        return match (true) {
            $data instanceof Model => new $dtoClass($data->toArray()),
            $data instanceof Collection => $data->map(fn (Model $model) => new $dtoClass($model->toArray())),
            default => null
        };
    }
}
