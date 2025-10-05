<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\ISession;
use think\facade\Session as FacadeSession;

class Session extends FacadeSession implements ISession {}
