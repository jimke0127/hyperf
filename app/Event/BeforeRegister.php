<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/20
 * Time: 14:22
 */

namespace App\Event;


class BeforeRegister
{
    /**
     * @var bool
     */
    public $shouldRegister = true;
}