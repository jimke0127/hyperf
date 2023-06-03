<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 18:25
 */
declare(strict_types=1);

namespace App\Service\Queue;

use Hyperf\AsyncQueue\Annotation\AsyncQueueMessage;

class QueueService
{
    /**
     * @AsyncQueueMessage
     */
    public function sendEmail($params)
    {
        sleep(10);
        // 需要异步执行的代码逻辑
        // 这里的逻辑会在 ConsumerProcess 进程中执行
        file_put_contents("runtime/queue_test.log",print_r($params,true));
    }
}