<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\IValidate;
use Nece\Framework\Adapter\Contract\Exception\ValidateException;
use think\facade\Validate as FacadeValidate;

class Validate  implements IValidate
{
    /**
     * @inheritDoc
     */
    public static function validate(array $data, array $validate, array $message = [], array $attributes = [], bool $batch = false): void
    {
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
}
