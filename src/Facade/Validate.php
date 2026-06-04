<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Validate as ContractFacadeValidate;
use Nece\Framework\Adapter\Contract\Exception\ValidateException;
use think\facade\Validate as FacadeValidate;

class Validate  implements ContractFacadeValidate
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
