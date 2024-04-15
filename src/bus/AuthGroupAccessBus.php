<?php

namespace Gz\TpAuth\bus;

use Gz\TpAuth\consts\cachePre\AuthGroupAccess;
use Gz\TpAuth\core\Core;
use Gz\TpCommon\lib\redis\Redis;
use think\facade\Db;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class AuthGroupAccessBus extends Core
{
    public function __construct()
    {

        parent::__construct();
        $this->model = Db::table($this->_config['auth_group_access']);
    }


    public function getDataByUid()
    {
        $data = $this->model
            ->alias("a")
            ->where(['a.uid' => $this->getUid()])
            ->field("b.rules")
            ->join([
                $this->_config['auth_group'] => 'b'
            ], 'a.group_id = b.id')
            ->cache(true, $this->_config['cache_expire'], $this->_config['cache_tag'])
            ->select();
        return $data;


    }
}