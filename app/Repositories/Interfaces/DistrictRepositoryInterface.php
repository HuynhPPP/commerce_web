<?php

namespace App\Repositories\Interfaces;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
interface DistrictRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function findDistrictByProvinceID(int $province_id); 

}