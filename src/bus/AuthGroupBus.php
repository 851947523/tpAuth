<?php

namespace Gz\TpAuth\bus;

use Gz\TpAuth\core\Core;
use think\facade\Db;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class AuthGroupBus  extends Core
{

    public function __construct()
    {
        parent::__construct();
        $this->model = Db::table($this->_config['auth_group']);
    }
}