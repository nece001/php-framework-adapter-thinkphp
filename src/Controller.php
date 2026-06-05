<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Controller as ContractController;
use Nece\Framework\Adapter\Request;
use Nece\Framework\Adapter\Facade\Response;
use Nece\Framework\Adapter\Facade\Session as FacadeSession;

class Controller implements ContractController
{
    private  $request;

    private $cookies = [];

    /**
     * 获取当前请求
     * 
     * @return Request
     */
    public function request(): Request
    {
        if (!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function response(string $body = '', int $status = 200, array $headers = [])
    {
        $response = Response::response($body, $status, $headers);
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function render(string $view, $data)
    {
        return $this->addCookiesToResponse(Response::view($view, $data));
    }

    /**
     * @inheritDoc
     */
    public function redirect(string $url, int $code = 302)
    {
        return $this->addCookiesToResponse(Response::redirect($url, $code));
    }

    /**
     * @inheritDoc
     */
    public function json($data, int $code = 200, array $headers = [])
    {
        $response = Response::json($data);
        foreach ($headers as $key => $value) {
            $response->withHeader($key, $value);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function xml($data, int $code = 200, array $headers = [])
    {
        $response = Response::xml($data);
        foreach ($headers as $key => $value) {
            $response->withHeader($key, $value);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function download(string $file, string $name = null, array $headers = [])
    {
        $response = Response::download($file, $name);
        foreach ($headers as $key => $value) {
            $response->withHeader($key, $value);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function stream($stream, int $code = 200, array $headers = [])
    {
    }

    /**
     * @inheritDoc
     */
    protected function addCookiesToResponse( $response)
    {
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function session(string $name = '', $default = null)
    {
        return FacadeSession::get($name, $default);
    }

    /**
     * @inheritDoc
     */
    public function pullSession(string $name, $default = null)
    {
        $value = FacadeSession::get($name, $default);
        FacadeSession::delete($name);
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setSession(string $name, $value)
    {
        FacadeSession::set($name, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function deleteSession(string $name)
    {
        FacadeSession::delete($name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSessionLifeTime(int $life_time) {}

    /**
     * @inheritDoc
     */
    public function setCookie(string $name, string $value = '', int $expire = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httpOnly = true)
    {
        $this->cookies[$name] = [
            'name' => $name,
            'value' => $value,
            'expire' => $expire,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly,
        ];
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function deleteCookie(string $name, string $path = '/', string $domain = '')
    {
        unset($this->cookies[$name]);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function successPagedList(Paginator $page)
    {
        $data = [
            'total' => $page->total(),
            'page' => $page->currentPage(),
            'page_size' => $page->pageSize(),
            'pages' => $page->lastPage(),
            'items' => $page->all(),
        ];
        return $this->success($data);
    }

    /**
     * 返回成功数据
     *
     * @author nece001@163.com
     * @create 2026-06-04 17:23:27
     *
     * @param mixed $data
     * @return Response
     */
    public function success($data = null, string $message = 'success')
    {
        return $this->json(['code' => 0, 'status' => 'success', 'message' => $message, 'data' => $data], 200);
    }

    /**
     * 返回失败数据
     *
     * @author nece001@163.com
     * @create 2026-06-04 17:23:43
     *
     * @param string $message
     * @param string $code
     * @param mixed $data
     * @return Response
     */
    public function failure(string $message = 'failure', $code = '', $data = null)
    {
        return $this->json(['code' => $code, 'status' => 'failure', 'message' => $message, 'data' => $data]);
    }

    /**
     * 返回异常数据
     *
     * @author nece001@163.com
     * @create 2026-06-04 17:23:49
     *
     * @param \Exception $e
     * @return Response
     */
    public function exception(\Exception $e)
    {
        return $this->failure($e->getMessage(), $e->getCode());
    }
}
