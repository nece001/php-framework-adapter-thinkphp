<?php

namespace Nece\Framework\Adapter;

use app\BaseController;
use Nece\Framework\Adapter\Contract\IController;
use Nece\Framework\Adapter\Facade\Session;
use Nece\Framework\Adapter\Response as AdapterResponse;
use Nece\Gears\ResponseData;
use think\facade\View;
use think\Request;
use think\Response;
use Throwable;

/**
 * 控制器基类
 *
 * @author nece001@163.com
 * @create 2025-10-05 13:48:11
 * 
 * @implements Request<Request>
 * @implements Response<Response>
 */
abstract class Controller extends BaseController implements IController
{
    /**
     * 获取当前请求
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * 是否为JSON请求
     * 
     * @return bool
     */
    public function isJsonRequest(): bool
    {
        if ($this->request->isJson()) {
            // 需要设置HTTP请求头的Accept为application/json
            return true;
        } else {
            return $this->request->contentType() == 'application/json';
        }
        return false;
    }

    /**
     * 获取请求参数
     *
     * @author nece001@163.com
     * @create 2025-10-05 12:50:26
     *
     * @param string $name 参数键名
     * @param mixed $default 默认值
     * @param string|array|null $filter 过滤函数
     * @return mixed
     */
    public function param($name = '', $default = null, string|array|null $filter = null)
    {
        return $this->request->param($name, $default, $filter);
    }

    /**
     * 渲染视图
     * 
     * @param string $template 模板路径
     * @param array $data 视图数据
     * @return Response
     */
    public function renderView(string $template, $data)
    {
        $response = new AdapterResponse($this->getRequest()->is_json_request);
        return $response->view($template, $data);
    }

    /**
     * 重定向
     * 
     * @param string $url 重定向URL
     * @param mixed $result 重定向结果
     * @param int $code HTTP状态码
     * @return Response
     */
    public function redirectTo(string $url, $result, int $code = 302)
    {
        $response = new AdapterResponse($this->getRequest()->is_json_request);
        return $response->redirect($url, $result, $code);
    }
}
