<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/19
 * Time: 10:20
 */

namespace App\Aspect;


use App\Controller\IndexController;
use App\Controller\TestController;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

/**
 * @Aspect()
 * Class IndexAspect
 * @package App\Aspect
 */
class IndexAspect extends AbstractAspect
{

    public $classes = [
        IndexController::class . '::'.'index',
        'App\Controller\TestController::test',
        'App\Controller\Sale\SiteController::asad',
    ];

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // TODO: Implement process() method.
        // 切面切入后，执行对应的方法会由此来负责
        // $proceedingJoinPoint 为连接点，通过该类的 process() 方法调用原方法并获得结果
        // 在调用前进行某些处理
        file_put_contents("runtime/Aspect.log", "start--");
        $result = $proceedingJoinPoint->process();
        file_put_contents("runtime/Aspect.log", $result, FILE_APPEND);
        // 在调用后进行某些处理
        if(is_array($result)){
            return array_merge($result,["test"=>"Aspect"]);
        }
        return 'before ' . $result;
    }
}