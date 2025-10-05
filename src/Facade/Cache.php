<?php

namespace Nece\Framework\Adapter\Facades;

use Nece\Framework\Adapter\Contract\Facade\ICache;
use think\facade\Cache as FacadeCache;

class Cache extends FacadeCache implements ICache {}
