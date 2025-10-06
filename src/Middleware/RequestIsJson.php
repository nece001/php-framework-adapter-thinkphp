<?php

namespace Nece\Framework\Adapter\Middleware;

use Closure;
use Nece\Framework\Adapter\Contract\IMiddleware;

/**
 * 请求是否为JSON格式
 *
 * @author nece001@163.com
 * @create 2025-10-06 23:15:54
 * 
 * @implement Request<\think\http\Request>
 */
class RequestIsJson implements IMiddleware
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        $request->is_json_request = $this->isJson($request);

        return $next($request);
    }

    private function isJson($request)
    {
        if ($request->isJson()) {
            // 需要设置HTTP请求头的Accept为application/json
            return true;
        } else {
            return $request->contentType() == 'application/json';
        }
        return false;
    }
}
