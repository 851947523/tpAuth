<?php

namespace Gz\TpAuth\bus;

use Gz\TpAuth\consts\cachePre\Admin;
use Gz\TpAuth\core\Core;
use think\facade\Db;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class AdminBus  extends Core
{

    public function __construct()
    {
        parent::__construct();
        $this->model = Db::table($this->_config['auth_user']);
    }

    public function getDetailByUid($attr = []){
        $uid = $this->getUid();
        return $this->model->where(['id'=>$uid])
            ->cache(Admin::getAdminPreCacheById($uid),$this->_config['cache_expire'],$this->_config['cache_tag'])
            ->field($attr['field']??'*','')->find();
    }


}