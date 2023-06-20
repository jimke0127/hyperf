<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/2/24
 * Time: 16:47
 */

namespace App\Service;


use App\Event\BeforeRegister;
use App\Event\UserRegistered;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;

class User
{
    /**
     * @Inject()
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function userinfo() : array
    {
        return [
            "name" => "张三",
            "gender" => 1,
            "age" => 22
        ];
    }

    /**
     * 模拟注册，并返回最新ID
     * author:jack(jimke127@126.com)
     * date:2023/6/20 11:30
     * @return int
     */
    public function register(){
        //注册前,检测允许注册与否
        $user_id = 0;
        $beforeReg = new BeforeRegister();
        $this->eventDispatcher->dispatch($beforeReg);
        if($beforeReg->shouldRegister){
            //模拟注册，并得到最新的userID
            $user_id = mt_rand(1,10);
        }

        //注册成功后
        if($user_id){
            //$this->sendEmail();
            //$this->sendSms();
            //....
            //注册完之后触发事件,把发送email和短信等都丢到事件中
            $this->eventDispatcher->dispatch(new UserRegistered($user_id));
        }

        return $user_id;
    }

    public function sendEmail(){
        //发送email
        return true;
    }
    public function sendSms(){
        //发送短信
        return true;
    }
}