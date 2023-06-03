<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 17:02
 */
use Hyperf\Crontab\Crontab;
return [
    'enable' => true,
    // 通过配置文件定义的定时任务
    'crontab' => [
        //(new Crontab())->setName('TestCron')->setRule('*/2 * * * *')->setCallback([App\Task\Test::class,'execute'])->setMemo('测试计划任务'),
    ],
];