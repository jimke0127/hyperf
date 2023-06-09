<?php

declare(strict_types=1);
/**
 * Api middleware
 */

namespace App\Middleware;

use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Router\Dispatched;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;
use Psr\Http\Message\ServerRequestInterface;

class CoreMiddleware implements MiddlewareInterface
{
    /**
     * @Inject()
     * @var TranslatorInterface
     */
    protected $translator;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //获取当前的控制器、方法和路由
        $dispatched = $request->getAttribute(Dispatched::class)->handler;
        file_put_contents("runtime/dispatched.log",print_r($dispatched,true));
        //可以设置语言，如果不设置，默认英文
        $this->translator->setLocale('zh_CN');

        $response = Context::get(ResponseInterface::class);
        $response = $this->allowCors($response);
        Context::set(ResponseInterface::class, $response);

        if ($request->getMethod() === 'OPTIONS') {
            return $response;
        }

        $response = $this->allowCors($handler->handle($request));

        if (\strpos($response->getHeaderLine('content-type'), 'application/json') !== 0) {
            return $response;
        }

        $result = json_decode($response->getBody()->getContents(), true);

        return $response->withBody(
            new SwooleStream(\json_encode(
                \array_merge([
                    'errcode' => 0,
                    'errmsg' => 'ok',
                ], $result && \is_array($result) ? $result : [])
            ), \JSON_UNESCAPED_UNICODE)
        );
    }

    private function allowCors(ResponseInterface $response): ResponseInterface
    {
        return $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, PATCH, GET, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'DNT, Keep-Alive, User-Agent, Cache-Control, Content-Type, Authorization, Platform-Token, X-Customized-Token, X-Customized-Version, X-Shop, X-Plist-Token');
    }
}
