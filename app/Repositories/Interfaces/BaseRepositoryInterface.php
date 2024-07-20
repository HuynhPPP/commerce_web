<?php

namespace App\Repositories\Interfaces;

/**
 * Class UserService
 * @package App\Services
 */
interface BaseRepositoryInterface
{
    public function all(array $relation = []);
    public function findById(int $id);
    public function create(array $payload);
    public function update(int $id = 0, array $payload = []);
    public function delete(int $id = 0);
    public function forceDelete(int $id = 0);
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
        array $orderBy = ['id', 'DESC'],
        array $join = [],
        array $relations = [], 
        array $rawQuery = []
    );
    public function updateByWhereIn($whereInField = '', array $whereIn = [], array $payload = []);
    public function createPivot($model, array $payload = [], string $relation = '');
    public function findByCondition($condition = []);
}