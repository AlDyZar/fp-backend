<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 28/03/2018
 * Time: 7:47 PM
 */

namespace App\Repositories;

use App\Models\User;

class UserRepository{

    public function __construct(User $user)
    {
        $this->user = $user;
    }

}