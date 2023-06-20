<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\UserRegistered;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
#[Listener]
class SendSmsListener implements ListenerInterface
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
            UserRegistered::class
        ];
    }

    /**
     *
     * author:jack(jimke127@126.com)
     * date:2023/6/20 11:48
     * @param UserRegistered $event
     */
    public function process(object $event)
    {
        file_put_contents("runtime/register.log","发送短信给".$event->userId,FILE_APPEND);
        echo "发送短信给".$event->userId.PHP_EOL;
    }
}
