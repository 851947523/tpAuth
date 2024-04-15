<?php

namespace Gz\TpAuth;

use Gz\TpAuth\bus\AdminBus;
use Gz\TpAuth\bus\AuthGroupAccessBus;
use Gz\TpAuth\bus\AuthRuleBus;
use Gz\TpAuth\consts\cachePre\Admin;
use Gz\TpAuth\consts\cachePre\AuthGroupAccess;
use Gz\TpAuth\consts\cachePre\AuthRules;
use Gz\TpAuth\core\Core;
use Gz\TpCommon\exception\Error;
use Gz\TpCommon\lib\redis\Redis;
use League\Flysystem\Exception;
use think\facade\Cache;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class Auth extends Core
{
    /**
     * 检查权限
     * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param uid  int           认证用户的id
     */
    public function check($name = [], $uid = "")
    {
        if (empty($uid)) throw new Error('用户id不能为空');
        $this->setUid($uid);
        if (empty($name)) throw new Error('no name');
        if (empty($uid)) throw new Error('uid is not empty');
        try {
            $adminDetail = AdminBus::instance()->setUid($uid)
                ->getDetailByUid(['field' => "status,id,username,is_admin"]);
            if (!$adminDetail) throw new Error('用户不存在');
            if ($adminDetail['status'] == 0) throw new Error('当前用户禁止登录');
            if ($adminDetail['is_admin'] == 1) return true;
            $auth_rule_names = $this->getRuleName($uid);
            if (!$auth_rule_names) {
                $auth_rules = AuthRuleBus::instance()->setUid($uid)->getAuthRule();
                $auth_rule_names = array_column($auth_rules, 'name');
                $this->setRuleName($auth_rule_names);
            }
            //判断是否有权限
            return $this->checkExists($name, $auth_rule_names);
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    //重置权限
    public function reset($uid)
    {

        Cache::tag($this->_config['cache_tag'])->clear();
    }





}