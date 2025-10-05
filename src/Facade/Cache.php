<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\ICache;
use think\facade\Cache as FacadeCache;

class Cache extends FacadeCache implements ICache {}
