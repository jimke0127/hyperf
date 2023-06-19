<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 16:30
 */

namespace App\Controller;

use App\Annotation\PreAuthorization;
use App\Service\Queue\QueueService;
use App\Service\User;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\GetMapping;
use App\Middleware\AuthMiddleware;

/**
 * @Controller(prefix="test")
 * @Middleware(AuthMiddleware::class)
 */
class TestController extends CommController
{

    /**
     * @Inject
     * @var User
     */
    protected $user;
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    /**
     * @RequestMapping(path="test",methods="get,post")
     */
    public function test()
    {
        for ($i = 1; $i < 10; $i++) {
            $this->service->sendEmail([
                'aaabbc ' . $i
            ]);
        }

        return 'hello hyperf 33!';
    }

    /**
     * @GetMapping(path="/tt")
     */
    public function test1()
    {
        $param = $this->request->getQueryParams();
        return [
            "data" => 'aaaab 00' . $param["id"],
            "user" => $this->user->userinfo()
        ];
    }

    /**
     * @RequestMapping(path="bbb",methods="get,post")
     * @PreAuthorization(value="test:test2")
     */
    public function test2()
    {
        $params = $this->request->getQueryParams();
        return ["data" => $params];
    }

    /**
     * @RequestMapping(path="detail/{id}",methods="get")
     * @PreAuthorization(value="test:detail")
     * @param int $id
     * @return string[]
     */
    public function detail(int $id)
    {
        return ["data" => $id];
    }

    /**
     * @RequestMapping(path="ccc",methods="post")
     */
    public function post()
    {
        $params = $this->request->post();
        return ["data" => $params];
    }

    /**
     * @RequestMapping(path="ddd/{id}",methods="delete")
     * @param int $id
     * @return int[]
     */
    public function delete(int $id)
    {
        return ["data" => $id];
    }

    /**
     * @RequestMapping(path="show",methods="get")
     * @PreAuthorization(value="test:show")
     * author:jack(jimke127@126.com)
     * date:2023/6/19 14:56
     */
    public function show()
    {
        return [
            "Annotation" => "注解学习",
            "Aspect" => "AOP学习"
        ];
    }
}