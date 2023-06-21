<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/21
 * Time: 12:19
 */

namespace App\Service;


use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Cache\Annotation\CachePut;

class CacheService
{
    /**
     * @Cacheable(prefix="user", ttl=300)
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:22
     * @return array
     */
    public function user(){
        sleep(3);
        return [
            "id" => 1,
            "name" => "Tom",
            "age" => 23
        ];
    }
    /**
     * @CachePut(prefix="user", ttl=300)
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:22
     * @return array
     */
    public function updateUser(){
        return [
            "id" => 1,
            "name" => "Jack",
            "age" => 33
        ];
    }

    /**
     * @CacheEvict(prefix="user")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:35
     * @return bool
     */
    public function deleteUserCache(){
        return true;
    }

    /**
     * @Cacheable(prefix="userInfo", ttl=300,value="#{id}")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:55
     * @param $id
     * @param $name
     * @param $age
     * @return array
     */
    public function userInfo($id,$name,$age){
        sleep(3);
        return [
            "id" => $id,
            "name" => $name,
            "age" => $age
        ];
    }

    /**
     * @CachePut(prefix="userInfo", ttl=300,value="#{id}")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:55
     * @param $id
     * @param $name
     * @param $age
     * @return array
     */
    public function updateUserInfo($id,$name,$age){
        return [
            "id" => $id,
            "name" => $name,
            "age" => $age
        ];
    }
}