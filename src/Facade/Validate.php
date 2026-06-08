<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Validate as ContractFacadeValidate;
use Nece\Framework\Adapter\Exception\ValidateException;
use think\facade\Validate as FacadeValidate;

class Validate  implements ContractFacadeValidate
{
    /**
     * @inheritDoc
     */
    public static function validate(array $data, array $validate, array $message = [], array $attributes = [], bool $batch = false): void
    {
        foreach ($validate as $key => $rule) {
            $validate[$key] = self::convertToThinkPHP($rule);
        }

        $validator = FacadeValidate::rule($validate)->message($message)->batch($batch);
        if (!$validator->check($data)) {
            $error = $validator->getError();
            $message = $error;
            if (is_array($error)) {
                $message = implode(';', $error);
            }

            throw new ValidateException($message, 'value_validate_fail');
        }
    }

    /**
     * 转换验证规则为ThinkPHP格式
     * 
     * 统一输入格式示例：
     * 必填|文件类型:扩展名|mimes:文件Mime类型|max:文件大小(M)
     * 'required|image:jpg,jpeg,png,gif,bmp,webp|max:1024',
     * 'required|file|mimes:mp4,mov,avi,wmv,flv,webm|max:51200',
     *
     * @author nece001@163.com
     * @create 2026-06-08 13:08:20
     *
     * @param string $rule
     * @return string ThinkPHP格式的验证规则
     */
    private static function convertToThinkPHP(string $rule): string
    {
        $items = [];
        $rules = explode('|', $rule);
        foreach ($rules as $r) {
            $parts = explode(':', $r);
            $key = strtolower($parts[0]);
            $value = $parts[1] ?? '';
            if (in_array($key, ['file', 'image', 'mimes'])) {
                if ($key == 'file') {
                    continue;
                }
                $key = 'fileExt';
            } elseif ($key == 'max') {
                $key = 'fileSize';
                $value = floatval($value) * 1024 * 1024;
            } elseif ($key == 'mimetypes') {
                $key = 'fileMime';
            } elseif ($key == 'required') {
                $key = 'require';
            }

            if ($value) {
                $items[] = $key . ':' . $value;
            } else {
                $items[] = $key;
            }
        }
        return implode('|', $items);
    }
}
