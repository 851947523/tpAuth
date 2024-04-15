<?php
namespace Gz\TpAuth\consts\cachePre;
use Gz\TpCommon\lib\redis\Redis;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class AuthRules
{

    /**
     * authRule表内容
     * @param $uid
     * @return string
     */
    public static function getAuthRulePreCacheById($uid){
        return 'tp_auth_rule_name_'.$uid;
    }
    public static function removeAuthRulePreCacheById($uid){
       return Redis::del(self::getAuthRulePreCacheById($uid));
    }
    
    /**
     * 获取['admin-mudule-index'...]
     * @param $uid
     * @return string
     */
    public static function getAuthRuleNamePreCacheById($uid){
        return 'tp_auth_rule_name_'.$uid;
    }
    public static function removeAuthRuleNamePreCacheById($uid){
        return Redis::del(self::getAuthRuleNamePreCacheById($uid));
    }
}