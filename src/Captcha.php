<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Captcha as ContractCaptcha;
use Nece\Framework\Adapter\Request;
use think\captcha\facade\Captcha as FacadeCaptcha;

class Captcha implements ContractCaptcha
{
    /**
     * @inheritDoc
     */
    public function image(): string
    {
        return FacadeCaptcha::create()->getContent();
    }

    /**
     * @inheritDoc
     */
    public function check(string $phrase): bool
    {
        return FacadeCaptcha::check($phrase);
    }
}
