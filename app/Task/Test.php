<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 17:55
 */

namespace App\Task;

use Hyperf\Crontab\Annotation\Crontab;
/**
 * @Crontab(name="Test", rule="*\/2 * * * *", callback="execute", memo="这是一个示例的定时任务")
 */
class Test
{
    public function execute()
    {
        file_put_contents("runtime/test_cron.log",date("Y-m-d H:i:s")." runing... cron2");
    }
    /**
     * @Crontab(rule="*\/5 * * * *", memo="foo")
     */
    public function foo()
    {
        file_put_contents("runtime/test_foo.log",date("Y-m-d H:i:s")." runing... foo");
    }
}