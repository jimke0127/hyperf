<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/20
 * Time: 11:32
 */

namespace App\Event;


class UserRegistered
{
    /**
     * @var int
     */
    public $userId;

    /**
     * UserRegistered constructor.
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}