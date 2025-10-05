<?php

namespace Nece\Framework\Adapter\Facades;

use Nece\Framework\Adapter\Contract\Facade\ILog;
use think\facade\Log as FacadeLog;

class Log extends FacadeLog implements ILog {}
