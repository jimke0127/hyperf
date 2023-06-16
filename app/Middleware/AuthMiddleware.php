<?php

declare(strict_types=1);
/**
 * Api middleware
 */

namespace App\Middleware;

use App\Controller\Sale\UserController;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('authorization');
        if ($token) {
            $token = substr($token, 7);
        } else {
            $token = $request->getHeaderLine('x-customized-token');
        }
        //$user_id = (new UserController())->getLoginId($token);
        $user_id = 1;
        if($token != "123456789"){
            $user_id = 0;
        }
        if ( 0 === $user_id) {
            return $this->response->json([
                'errcode' => 401,
                'errmsg' => 'Unauthorized'
            ])->withStatus(401);
        }
        file_put_contents("runtime/auth.log","check auth");
        Context::set('user_id',$user_id);

        return $handler->handle($request);
    }
}
