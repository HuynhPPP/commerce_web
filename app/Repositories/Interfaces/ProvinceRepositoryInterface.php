<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function all(array $relation = []);

}