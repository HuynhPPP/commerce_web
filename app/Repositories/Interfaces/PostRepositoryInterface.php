<?php

namespace App\Repositories\Interfaces;
use App\Repositories\Interfaces\BaseRepositoryInterface;

use App\Models\User;

/**
 * Class PostRepositoryInterface
 * @package App\Services
 */
interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function getPostById(int $id = 0, $language_id = 0);
}
