<?php
namespace Gz\TpAuth\consts\cachePre;
use Gz\TpCommon\lib\redis\Redis;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class Admin
{

    /**
     * authRule表内容
     * @param $uid
     * @return string
     */
    public static function getAdminPreCacheById($uid){
        return 'tp_auth_admin_'.$uid;
    }
    public static function removeAdminPreCacheById($uid){
       return Redis::del(self::getAdminPreCacheById($uid));
    }

}