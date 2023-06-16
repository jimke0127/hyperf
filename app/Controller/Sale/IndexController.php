<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/15
 * Time: 10:59
 */

namespace App\Controller\Sale;


use App\Controller\AbstractController;
use App\Service\User;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;


/**
 * @Controller(prefix="test")
 * @Middleware(AuthMiddleware::class)
 * Class IndexController
 * @package App\Controller\Sale
 */
class IndexController extends AbstractController
{
    /**
     * @Inject()
     * @var User
     */
    private $user;

    /**
     * @RequestMapping(path="index",mothods={"get","post"})
     * author:jack(jimke127@126.com)
     * date:2023/6/15 11:24
     * @return array
     */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return $this->success([
            'method' => $method,
            'message' => "Hi {$user}.",
        ]);
    }

    /**
     * @GetMapping(path="testget")
     * author:jack(jimke127@126.com)
     * date:2023/6/15 14:17
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function asad()
    {
        $redis = $this->container->get(\Hyperf\Redis\Redis::class);
        $redis->set("wms:name", "jack test");
        return $this->error("参数不能为空");
        return [
            $this->user->userinfo(),
            $redis->get("wms:name"),
            Context::get('user_id',"null"),
            Context::get('user',"null")
        ];
    }

    /**
     * @GetMapping(path="test")
     * author:jack(jimke127@126.com)
     * date:2023/6/15 14:18
     * @return array
     */
    public function test()
    {
        Context::set('user',"aaa");
        $city = "深圳";
        $res1 = compact("city");
        $province = "广东";
        $area = "南山区";
        $res2 = compact("city", "province");
        $vars = array("city", "province","area");
        $res3 = compact("province", $vars);
        $res4 = compact("province", "vars");
        return [$res1, $res2, $res3,$res4,Context::get('user',"null")];
    }

}