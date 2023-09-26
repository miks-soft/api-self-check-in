<?php

namespace App\Services\Interfaces;

use App\DTO\BaseDto;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface BaseServiceInterface
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
     * @param array|string $columns
     * @param bool $throwOnFail
     * @param null|array|string $relations
     * @return null|BaseDto|Collection
     */
    public function findById(array|int|string $id, array|string $columns = ['*'], bool $throwOnFail = true, null|array|string $relations = null): null|BaseDto|Collection;

    /**
     * @param array|int|string $id
     * @param array|string $relations
     * @param array|string $columns
     * @param bool $throwOnFail
     * @return null|BaseDto|Collection
     */
    public function findByIdWith(array|int|string $id, array|string $relations, array|string $columns = ['*'], bool $throwOnFail = true): null|BaseDto|Collection;

    /**
     * @param array|Arrayable $data
     * @param null|array|string $relations
     * @return BaseDto
     */
    public function create(array|Arrayable $data, null|array|string $relations = null): BaseDto;

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
    public function update(int|string $id, array|Arrayable $data, bool $returnModel = true, null|array|string $relations = null): bool|BaseDto;
}
