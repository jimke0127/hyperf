<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\BeforeRegister;
use App\Event\UserRegistered;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
#[Listener]
class MultipleListener implements ListenerInterface
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
            BeforeRegister::class,
            UserRegistered::class
        ];
    }

    public function process(object $event)
    {
        if($event instanceof BeforeRegister){
            file_put_contents("runtime/register_before.log",get_class($event).$event->shouldRegister);
        }elseif($event instanceof UserRegistered){
            file_put_contents("runtime/register_after.log",get_class($event).$event->userId);
        }
    }
}
