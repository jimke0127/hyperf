<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\BeforeRegister;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
#[Listener]
class ValidateRegisterListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            BeforeRegister::class
        ];
    }

    /**
     *
     * author:jack(jimke127@126.com)
     * date:2023/6/20 14:28
     * @param BeforeRegister $event
     */
    public function process(object $event)
    {
        $event->shouldRegister = (bool) rand(0,2);
        if($event->shouldRegister == false){
            $str = "不允许注册";
        }else{
            $str = "注册成功，成功后会发送短信";
        }
        file_put_contents("runtime/register.log",$str.PHP_EOL);
    }
}
