<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Request as ContractRequest;
use Nece\Framework\Adapter\Facade\Session;
use think\Request as ThinkRequest;

class Request implements ContractRequest
{
    /**
     * 请求实例
     *
     * @var ThinkRequest|null
     */
    private $request;

    /**
     * 动态属性存储
     *
     * @var array
     */
    private $attributes = [];

    /**
     * 设置动态属性
     *
     * @param string $name  属性名
     * @param mixed  $value 属性值
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * 获取动态属性
     *
     * @param string $name 属性名
     * @return mixed
     */
    public function __get(string $name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return $this->request->$name;
    }

    /**
     * 检查动态属性是否存在
     *
     * @param string $name 属性名
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]) || isset($this->request->$name);
    }

    /**
     * 取消设置动态属性
     *
     * @param string $name 属性名
     * @return void
     */
    public function __unset(string $name): void
    {
        unset($this->attributes[$name]);
    }

    public function __construct()
    {
        $this->request = \request();
    }

    /**
     * 获取当前请求的参数（合并GET、POST、路由参数）
     *
     * @param string|array $name    变量名，支持数组批量获取
     * @param mixed        $default 默认值
     * @param string|array $filter  过滤方法
     * @return mixed
     */
    public function param($name = '', $default = null, $filter = '')
    {
        return $this->request->param($name, $default, $filter);
    }

    /**
     * 获取包含文件在内的所有请求参数
     *
     * @param string|array $name   变量名
     * @param string|array $filter 过滤方法
     * @return mixed
     */
    public function all($name = '', $filter = '')
    {
        return $this->request->all($name, $filter);
    }

    /**
     * 获取GET参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function get($name = '', $default = null, $filter = '')
    {
        return $this->request->get($name, $default, $filter);
    }

    /**
     * 获取POST参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function post($name = '', $default = null, $filter = '')
    {
        return $this->request->post($name, $default, $filter);
    }

    /**
     * 获取PUT参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function put($name = '', $default = null, $filter = '')
    {
        return $this->request->put($name, $default, $filter);
    }

    /**
     * 获取DELETE参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function delete($name = '', $default = null, $filter = '')
    {
        return $this->request->delete($name, $default, $filter);
    }

    /**
     * 获取变量（底层方法，支持过滤和默认值）
     *
     * @param string|bool  $name    字段名
     * @param mixed        $default 默认值
     * @param string|array $filter  过滤函数
     * @return mixed
     */
    public function input($name = '', $default = null, $filter = '')
    {
        return $this->request->param($name, $default, $filter);
    }

    /**
     * 获取路由参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function route($name = '', $default = null, $filter = '')
    {
        return $this->request->route($name, $default, $filter);
    }

    /**
     * 获取Cookie参数
     *
     * @param string       $name    变量名
     * @param mixed        $default 默认值
     * @param string|array $filter  过滤方法
     * @return mixed
     */
    public function cookie(string $name = '', $default = null, $filter = '')
    {
        return $this->request->cookie($name, $default, $filter);
    }

    /**
     * 获取Session对象
     *
     * @param string $name    变量名（空字符串返回Session对象）
     * @param mixed  $default 默认值
     * @return mixed
     */
    public function session(string $name = '', $default = null)
    {
        return Session::get($name, $default);
    }

    /**
     * 获取SERVER参数
     *
     * @param string $name    变量名
     * @param string $default 默认值
     * @return mixed
     */
    public function server(string $name = '', string $default = '')
    {
        return $this->request->server($name, $default);
    }

    /**
     * 获取Header信息
     *
     * @param string     $name    header名称
     * @param string     $default 默认值
     * @return mixed
     */
    public function header(string $name = '', string $default = null)
    {
        return $this->request->header($name, $default);
    }

    /**
     * 获取上传文件
     *
     * @param string $name 文件字段名
     * @return mixed
     */
    public function file(string $name = '')
    {
        $file = $this->request->file($name);
        if ($file) {
            if (is_array($file)) {
                return UploadFile::instances($file);
            }
            return UploadFile::instance($file);
        }
        return null;
    }

    /**
     * 判断请求类型
     *
     * @param bool $origin 是否获取原始请求类型
     * @return string
     */
    public function method(bool $origin = false): string
    {
        return $this->request->method($origin);
    }

    /**
     * 是否为GET请求
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->request->isGet();
    }

    /**
     * 是否为POST请求
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->request->isPost();
    }

    /**
     * 是否为PUT请求
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->request->isPut();
    }

    /**
     * 是否为DELETE请求
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->request->isDelete();
    }

    /**
     * 是否为AJAX请求
     *
     * @param bool $ajax true时只检测X-Requested-With头
     * @return bool
     */
    public function isAjax(bool $ajax = false): bool
    {
        return $this->request->isAjax($ajax);
    }

    /**
     * 是否为JSON请求
     * @return bool
     */
    public function isJson(): bool
    {
        return $this->request->isJson();
    }

    /**
     * 是否为HTTPS请求
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->request->isSsl();
    }

    /**
     * 是否为CLI模式
     * @return bool
     */
    public function isCli(): bool
    {
        return $this->request->isCli();
    }

    /**
     * 是否存在指定请求参数
     *
     * @param string $name       参数名
     * @param string $type       参数类型
     * @param bool   $checkEmpty 是否检查空值
     * @return bool
     */
    public function has(string $name, string $type = 'param', bool $checkEmpty = false): bool
    {
        return $this->request->has($name, $type, $checkEmpty);
    }

    /**
     * 只获取指定的参数
     *
     * @param array        $name   要获取的参数名数组
     * @param string|array $data   数据源类型或数组
     * @param string|array $filter 过滤方法
     * @return array
     */
    public function only(array $name, $data = 'param', $filter = ''): array
    {
        return $this->request->only($name, $data, $filter);
    }

    /**
     * 排除指定参数后获取
     *
     * @param array  $name 要排除的参数名数组
     * @param string $type 参数类型
     * @return array
     */
    public function except(array $name, string $type = 'param'): array
    {
        return $this->request->except($name, $type);
    }

    /**
     * 获取客户端IP地址
     * @return string
     */
    public function ip(): string
    {
        return $this->request->ip();
    }

    /**
     * 获取当前URL
     *
     * @param bool $complete 是否包含完整域名
     * @return string
     */
    public function url(bool $complete = false): string
    {
        return $this->request->url($complete);
    }

    /**
     * 获取当前域名
     *
     * @param bool $port 是否包含端口号
     * @return string
     */
    public function domain(bool $port = false): string
    {
        return $this->request->host(!$port);
    }

    /**
     * 获取当前请求的pathinfo
     * @return string
     */
    public function pathinfo(): string
    {
        return $this->request->pathinfo();
    }

    /**
     * @inheritDoc
     */
    public function path(): string
    {
        $path_info = $this->request->pathinfo();
        return '/' . ltrim($path_info, '/');
    }

    /**
     * 获取当前URL的后缀
     * @return string
     */
    public function ext(): string
    {
        return $this->request->ext();
    }

    /**
     * 获取当前请求的Content-Type
     * @return string
     */
    public function contentType(): string
    {
        return $this->request->header('content-type', '');
    }

    /**
     * 获取当前请求的完整内容
     * @return string
     */
    public function getContent(): string
    {
        return $this->request->getContent();
    }

    /**
     * 获取请求时间
     *
     * @param bool $float 是否返回浮点类型
     * @return int
     */
    public function time(bool $float = false): int
    {
        if ($float) {
            return (int)(microtime(true) * 1000000);
        }
        return (int)time();
    }

    /**
     * 获取值
     *
     * @param array         $params  参数数组
     * @param string|array  $name    变量名
     * @param mixed         $default 默认值
     * @param string|array  $filter  过滤方法
     * @return mixed
     */
    protected function getValue(array $params, $name = '', $default = null, $filter = '')
    {
        if ($name === '' || $name === true) {
            if ($filter) {
                return $this->filterValues($params, $filter);
            }
            return $params;
        }

        if (is_array($name)) {
            $result = [];
            foreach ($name as $key) {
                $value = $params[$key] ?? $default;
                $result[$key] = $this->filterValue($value, $filter);
            }
            return $result;
        }

        $value = $params[$name] ?? $default;
        return $this->filterValue($value, $filter);
    }

    /**
     * 过滤单个值
     *
     * @param mixed        $value  值
     * @param string|array $filter 过滤方法
     * @return mixed
     */
    protected function filterValue($value, $filter = '')
    {
        if (!$filter || empty($value)) {
            return $value;
        }

        if (is_callable($filter)) {
            return call_user_func($filter, $value);
        }

        if (is_string($filter)) {
            $filters = explode(',', $filter);
            foreach ($filters as $f) {
                $f = trim($f);
                if (function_exists($f)) {
                    $value = $f($value);
                }
            }
        }

        return $value;
    }

    /**
     * 过滤数组值
     *
     * @param array         $values 值数组
     * @param string|array  $filter 过滤方法
     * @return array
     */
    protected function filterValues(array $values, $filter = '')
    {
        foreach ($values as &$value) {
            if (is_array($value)) {
                $value = $this->filterValues($value, $filter);
            } else {
                $value = $this->filterValue($value, $filter);
            }
        }
        return $values;
    }
}
