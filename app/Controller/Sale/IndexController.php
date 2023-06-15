<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/15
 * Time: 10:59
 */

namespace App\Controller\Sale;


use App\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;


/**
 * @Controller(prefix="test")
 * Class IndexController
 * @package App\Controller\Sale
 */
class IndexController extends AbstractController
{
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

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * @RequestMapping (path="hello",methods="get,post")
     * author:jack(jimke127@126.com)
     * date:2023/6/15 11:15
     * @return string
     */
    public function asad()
    {
        return "ofjsjijsdi";
    }

}