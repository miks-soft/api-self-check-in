<?php

namespace App\Repositories\Interfaces;

use App\DTO\BaseDto;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param array|string $columns
     * @param null|array|string $relations
     * @return Collection
     */
    public function all(array|string $columns = ['*'], null|array|string $relations = null): Collection;

    /**
     * @param array|string $relations
     * @param array|string $columns
     * @return Collection
     */
    public function allWith(array|string $relations, array|string $columns = ['*']): Collection;

    /**
     * @param array|int|string $id
     * @param string $column
     * @param array|string $columns
     * @param bool $throwOnFail
     * @param null|array|string $relations
     * @return null|BaseDto|Collection
     */
    public function find(array|int|string $id, string $column = 'id', array|string $columns = ['*'], bool $throwOnFail = false, null|array|string $relations = null): null|BaseDto|Collection;

    /**
     * @param array|int|string $id
     * @param array|string $relations
     * @param string $column
     * @param array|string $columns
     * @param bool $throwOnFail
     * @return null|BaseDto|Collection
     */
    public function findWith(array|int|string $id, array|string $relations, string $column = 'id', array|string $columns = ['*'], bool $throwOnFail = false): null|BaseDto|Collection;

    /**
     * @param array|Arrayable $data
     * @param null|array|string $relations
     * @return BaseDto
     */
    public function create(array|Arrayable $data, null|array|string $relations = null): BaseDto;

    /**
     * @param array $attributes
     * @param null|array|Arrayable $data
     * @param null|array|string $relations
     * @return BaseDto
     */
    public function firstOrCreate(array $attributes = [], null|array|Arrayable $data = null, null|array|string $relations = null): BaseDto;

    /**
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * @param int|string $id
     * @param array|Arrayable $data
     * @param bool $returnModel
     * @param null|array|string $relations
     * @return bool|BaseDto
     */
    public function update(int|string $id, array|Arrayable $data, bool $returnModel = false, null|array|string $relations = null): bool|BaseDto;
}
