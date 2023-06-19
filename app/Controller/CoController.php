<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/19
 * Time: 16:49
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Utils\Parallel;
use Hyperf\Utils\WaitGroup;
use Swoole\Coroutine\Channel;

/**
 * @AutoController()
 * Class CoController
 * @package App\Controller
 */
class CoController extends CommController
{
    /**
     * @Inject()
     * @var ClientFactory
     */
    private $clientFatory;


    public function sleep($seconds = 1){
        //$seconds = $this->request->input('s', 2);
        sleep($seconds);
        return $seconds;
    }

    /**
     * 正常运行，需要6秒
     * 使用协程，只需要3秒
     * author:jack(jimke127@126.com)
     * date:2023/6/19 18:05
     * @return mixed
     */
    public function normalRun(){
        $result[] = $this->sleep(1);
        $result[] = $this->sleep(2);
        $result[] = $this->sleep(3);
        return $result;
    }
    public function co(){
        $channel = new Channel();
        co(function () use($channel){
            $this->sleep(1);
            $channel->push(1);
        });
        co(function () use($channel){
            $this->sleep(2);
            $channel->push(2);
        });
        co(function () use($channel){
            $this->sleep(3);
            $channel->push(3);
        });
        $result[] = $channel->pop();
        $result[] = $channel->pop();
        $result[] = $channel->pop();
        return $result ;
    }
    public function waitgroup(){
        $wg = new WaitGroup();
        $result = [];
        $wg->add(3);
        co(function () use($wg,&$result){
            $this->sleep(1);
            $result[] = 1;
            $wg->done();
        });
        co(function () use($wg,&$result){
            $this->sleep(2);
            $result[] = 2;
            $wg->done();
        });
        co(function () use($wg,&$result){
            $this->sleep(3);
            $result[] = 3;
            $wg->done();
        });
        $wg->wait();
        return $result ;
    }

    public function parallel(){
        $parallel = new Parallel();
        $parallel->add(function(){
            $this->sleep(1);
            return 1;
        },"a");
        $parallel->add(function(){
            $this->sleep(2);
            return 2;
        },"b");
        $parallel->add(function(){
            $this->sleep(3);
            return 3;
        },"c");
        $result = $parallel->wait();
        return $result;
    }

    public function parallel2(){
       $result = parallel([
            function(){
                $this->sleep(1);
                return 1;
            },
            function(){
                $this->sleep(2);
                return 2;
            },
            function(){
                $this->sleep(3);
                return 3;
            },
        ]);
       return $result;
    }
}