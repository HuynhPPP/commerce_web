<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
interface DistrictRepositoryInterface
{
    public function all();
    public function findDistrictByProvinceID(int $province_id); 

}