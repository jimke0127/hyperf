<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 16:47
 */

namespace App\Service;


class User
{
    public function userinfo() : array
    {
        return [
            "name" => "张三",
            "gender" => 1,
            "age" => 22
        ];
    }
}