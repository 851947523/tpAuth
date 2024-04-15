<?php

namespace Gz\TpAuth\bus;

use Gz\TpAuth\consts\cachePre\AuthRules;
use Gz\TpAuth\core\Core;
use Gz\TpCommon\lib\redis\Redis;
use think\facade\Db;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 04-09
 */
class AuthRuleBus extends Core
{

    public function __construct()
    {
        parent::__construct();
        $this->model = Db::table($this->_config['auth_rule']);
    }

    public function getDataByRuleIds($ruleIds)
    {
        $data = $this->model->where("id", "in", $ruleIds)
            ->field("name")
            ->cache(true, $this->_config['cache_expire'], $this->_config['cache_tag'])->select();
        $data = is_object($data) ? $data->toArray() : $data;
        $this->setAuthRule($data);
        return $data;
    }

    private function setAuthRule($data)
    {
        return Redis::tag($this->_config['cache_tag'])->set(AuthRules::getAuthRulePreCacheById($this->getUid()), $data, $this->_config['cache_expire']);
    }

    public function getAuthRule()
    {
        $uid = $this->getUid();
        $auth_rules = Redis::get(AuthRules::getAuthRulePreCacheById($uid));
        if (!$auth_rules) {
            $authGroupAccessArr = AuthGroupAccessBus::instance('',false)
                ->setUid($uid)->getDataByUid();
            //所有规则数据
            $ruleIds = $this->handleRuleByAuthGroupAccessArr($uid, $authGroupAccessArr);
            $auth_rules = AuthRuleBus::instance()->setUid($uid)
                ->getDataByRuleIds($ruleIds);
            $this->setAuthRule($auth_rules);
        }

        return $auth_rules;
    }
}