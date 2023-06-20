<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/20
 * Time: 11:51
 */

namespace App\Controller;

use App\Service\User;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 * Class EventController
 * @package App\Controller
 */
class EventController
{
    /**
     * @Inject()
     * @var User
     */
    private $user;

    public function test(){

        return $this->user->register();

    }
}