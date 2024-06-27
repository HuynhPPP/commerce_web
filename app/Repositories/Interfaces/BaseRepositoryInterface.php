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
        array $join = [],
        array $extend = [],
        int $perpage = 1,
        array $relation = []
    );
    public function updateByWhereIn($whereInField = '', array $whereIn = [], array $payload = []);
}