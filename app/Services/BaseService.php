<?php

namespace App\Services;

use App\DTO\BaseDto;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

abstract class BaseService implements BaseServiceInterface
{
    /**
     * @param BaseRepositoryInterface $repository
     */
    public function __construct(
        private BaseRepositoryInterface $repository
    )
    {
    }

    /**
     * @param array|string $columns
     * @param null|array|string $relations
     * @return Collection
     */
    public function all(array|string $columns = ['*'], null|array|string $relations = null): Collection
    {
        return $this->repository->all($columns, $relations);
    }

    /**
     * @param array|string $relations
     * @param array|string $columns
     * @return Collection
     */
    public function allWith(array|string $relations, array|string $columns = ['*']): Collection
    {
        return $this->repository->allWith($relations, $columns);
    }

    /**
     * @param array|int|string $id
     * @param array|string $columns
     * @param bool $throwOnFail
     * @param null|array|string $relations
     * @return null|BaseDto|Collection
     */
    public function findById(array|int|string $id, array|string $columns = ['*'], bool $throwOnFail = true, null|array|string $relations = null): null|BaseDto|Collection
    {
        return $this->repository->find($id, 'id', $columns, $throwOnFail, $relations);
    }

    /**
     * @param array|int|string $id
     * @param array|string $relations
     * @param array|string $columns
     * @param bool $throwOnFail
     * @return null|BaseDto|Collection
     */
    public function findByIdWith(array|int|string $id, array|string $relations, array|string $columns = ['*'], bool $throwOnFail = true): null|BaseDto|Collection
    {
        return $this->repository->findWith($id, $relations, 'id', $columns, $throwOnFail);
    }

    /**
     * @param array|Arrayable $data
     * @param null|array|string $relations
     * @return BaseDto
     */
    public function create(array|Arrayable $data, null|array|string $relations = null): BaseDto
    {
        return $this->repository->create($data, $relations);
    }

    /**
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @param int|string $id
     * @param array|Arrayable $data
     * @param bool $returnModel
     * @param null|array|string $relations
     * @return bool|BaseDto
     */
    public function update(int|string $id, array|Arrayable $data, bool $returnModel = true, null|array|string $relations = null): bool|BaseDto
    {
        return $this->repository->update($id, $data, $returnModel, $relations);
    }
}
