<?php

namespace App\Repositories\Interfaces;

/**
 * Class UserService
 * @package App\Services
 */
interface BaseRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function create(array $payload);
    public function update(int $id = 0, array $payload = []);
    public function delete(int $id = 0);
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
        array $orderBy = ['id', 'DESC'],
        array $join = [],
        array $relations = [],  
    );
    public function updateByWhereIn($whereInField = '', array $whereIn = [], array $payload = []);
    public function createLanguagePivot($model, array $payload = []);
}