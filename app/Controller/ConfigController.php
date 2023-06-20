<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/20
 * Time: 9:38
 */

namespace App\Controller;


use Hyperf\Config\Annotation\Value;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * 3种取配置的方法，推荐使用第三种最方便
 * @AutoController()
 * Class ConfigController
 * @package App\Controller
 */
class ConfigController
{
    /**
     * @Inject()
     * @var ConfigInterface
     */
    private $config;

    /**
     * @Value("foo.bar")
     */
    private $bar;

    public function inject(){
        return $this->config->get("foo.bar");
    }

    public function value(){
        return $this->bar;
    }

    public function config(){
        return config("foo.bar");
    }
}