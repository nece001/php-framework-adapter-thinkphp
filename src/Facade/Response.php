<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Response as ResponseContract;

class Response implements ResponseContract
{
    /**
     * @inheritDoc
     */
    public static function response(string $body = '', int $status = 200, array $headers = [])
    {
        return \response($body, $status, $headers);
    }

    /**
     * @inheritDoc
     */
    public static function json($data, int $status = 200, array $headers = [], array $options = [])
    {
        return \json($data, $status, $headers, $options);
    }

    /**
     * @inheritDoc
     */
    public static function xml($xml, int $status = 200, array $headers = [], array $options = [])
    {
        return \xml($xml, $status, $headers, $options);
    }

    /**
     * @inheritDoc
     */
    public static function jsonp($data, int $status = 200, array $headers = [], array $options = [])
    {
        return \jsonp($data, $status, $headers, $options);
    }

    /**
     * @inheritDoc
     */
    public static function redirect(string $location, int $status = 302)
    {
        return \redirect($location, $status);
    }

    /**
     * @inheritDoc
     */
    public static function view(mixed $template = null, array $vars = [], int $status = 200)
    {
        return \view($template, $vars, $status);
    }

    /**
     * @inheritDoc
     */
    public static function download(string $filename, string $name='', bool $content = false, int $expire = 180)
    {
        return \download($filename, $name, $content, $expire);
    }

    /**
     * @inheritDoc
     */
    public static function notFound()
    {
        return \abort(404);
    }

    /**
     * @inheritDoc
     */
    public static function buildData($code, $status, $message, $data = [])
    {
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}
