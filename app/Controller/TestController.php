<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 16:30
 */

namespace App\Controller;

use App\Annotation\PreAuthorization;
use App\Service\CacheService;
use App\Service\Queue\QueueService;
use App\Service\User;
use App\Service\ValidateService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\GetMapping;
use App\Middleware\AuthMiddleware;
use Hyperf\Redis\Redis;

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
     * @Inject()
     * @var CacheService
     */
    protected $cache;

    /**
     * @Inject()
     * @var ValidateService
     */
    protected $validateFactory;

    /**
     * @RequestMapping(path="test",methods="get,post")
     */
    public function test()
    {
        $data = $this->request->all();
        for ($i = 1; $i < 10; $i++) {
            $this->service->sendEmail([
                'aaabbc ' . $i
            ]);
        }

        return [
            'data' => $data,
            'name' => $this->request->input("name","Hello"),
            'info'=>'hello hyperf 33!'
        ];
    }

    /**
     * @GetMapping(path="/tt")
     */
    public function test1()
    {
        $data = $this->request->all();
        $rule = [
            'id' => 'required|numeric',
            'name' => 'required',
            'age' => 'required|numeric',
            'email' => 'required|email',
        ];
        $result = $this->validateFactory->validate($data,$rule,422);
        if($result["errcode"] > 0){
            return $result;
        }
        return [
            "data" => $data,
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

    /**
     * @RequestMapping(path="testCache",methods="get")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:30
     * @return array
     */
    public function testCache(){
        $userinfo = $this->cache->userInfo(1,"aaa",22);
        $user = $this->cache->user();
        return [
            "userInfo" => $userinfo,
            "user" => $user
        ];
    }

    /**
     * @RequestMapping(path="updateCache",methods="get")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:33
     * @return array
     */
    public function updateCache(){
        return $this->cache->updateUser();
    }

    /**
     * @RequestMapping(path="delCache",methods="get")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:35
     * @return array
     */
    public function delCache(){
        return $this->cache->deleteUserCache(1);
    }

    /**
     * @RequestMapping(path="showRedisKey",methods="get")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 12:40
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function showRedisKey(){
        $redis = $this->container->get(Redis::class);
        return $redis->keys('*');
    }

    /**
     * @RequestMapping(path="lang",methods="get")
     * author:jack(jimke127@126.com)
     * date:2023/6/21 14:44
     * @return array
     */
    public function lang(){
        return [
            "hello" =>  __('messages.welcome')
        ];
    }
}