<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/19
 * Time: 15:02
 */

namespace App\Aspect;


use App\Annotation\PreAuthorization;
use App\Exception\BusinessException;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\AnnotationException;
use Hyperf\Logger\LoggerFactory;;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;



/**
 * @Aspect()
 * Class PreAuthorizationAspect
 * @package App\Aspect
 */
class PreAuthorizationAspect extends AbstractAspect
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    public $logger;

    public $annotations = [
        PreAuthorization::class
    ];


    public function __construct(LoggerFactory $loggerFactory)
    {
        // 第一个参数对应日志的 name, 第二个参数对应 config/autoload/logger.php 内的 key
        $this->logger = $loggerFactory->get('log', 'default');
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // 切面切入后，执行对应的方法会由此来负责
        try {
            $authorization = $this->getAuthorizationAnnotation($proceedingJoinPoint->className, $proceedingJoinPoint->methodName);
            if (!$this->checkPermission($authorization->value)) {
                throw new BusinessException(422, '权限不足');
            }
        } catch (\Exception  $e) {
            $this->logger->info("PreAuthorizationAspect 执行过程异常：%s", [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [
                "errcode" => $e->getCode(),
                "errmsg" => $e->getMessage()
            ];
        }
        try {
            return $proceedingJoinPoint->process();
        } catch (\Exception $e) {
            $this->logger->info("PreAuthorizationAspect 执行过程异常：%s", [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * desc: 获取注解类
     * @param string $className
     * @param string $method
     * @return PreAuthorization
     * @throws AnnotationException
     */
    protected function getAuthorizationAnnotation(string $className, string $method): PreAuthorization
    {
        $annotation = AnnotationCollector::getClassMethodAnnotation($className, $method)[PreAuthorization::class] ?? null;
        if (!$annotation instanceof PreAuthorization) {
            throw new AnnotationException("Annotation PreAuthorization couldn't be collected successfully.");
        }
        return $annotation;
    }
    /**
     * desc: 校验操作权限
     * @param string $annotationValue
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function checkPermission(string $annotationValue): bool
    {
        $hasPerms = ["test:index","test:detail"]; //模拟登录者拥有的操作权限
        if (in_array($annotationValue, $hasPerms)) {
            return true;
        }
        return false;
    }

}