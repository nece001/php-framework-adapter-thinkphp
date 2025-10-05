<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use think\db\Query as ThinkQuery;

class Query extends ThinkQuery implements IQuery {}
