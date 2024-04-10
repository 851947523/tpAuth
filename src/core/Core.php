<?php

namespace Gz\TpAuth\core;


use Gz\TpAuth\consts\cachePre\AuthRules;
use Gz\TpCommon\exception\Error;
use Gz\TpCommon\lib\redis\Redis;
use Gz\Utools\Instance\Instance;
use Composer\Composer;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 03-30
 */
abstract class  Core
{
    use Instance;

    private $uid;
    public $model;
    protected $_config = array(
        'auth_on' => true,                      // 认证开关
        'auth_type' => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'auth_group' => 'auth_group',        // 用户组数据表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
        'auth_rule' => 'auth_rule',         // 权限规则表
        'auth_user' => 'admin',             // 管理员表
        'cache_tag' => 'gz_tp_auth_tag_',         //缓存标签
        'origin_cache_tag' => 'gz_tp_auth_tag_',         //缓存标签
        'cache_expire' => 24 * 3600         //缓存时效
    );

    public function __construct()
    {
        $prefix = config('database.connections.mysql.prefix');
        $this->_config['auth_group'] = $prefix . $this->_config['auth_group'];
        $this->_config['auth_rule'] = $prefix . $this->_config['auth_rule'];
        $this->_config['auth_user'] = $prefix . $this->_config['auth_user'];
        $this->_config['auth_group_access'] = $prefix . $this->_config['auth_group_access'];
        $this->_config['cache_tag'] = $this->_config['cache_tag'];
        $this->_config['cache_expire'] = $this->_config['cache_expire'];
        if (config('auth.auth_config')) {
            //可设置配置项 auth_config, 此配置项为数组。
            $this->_config = array_merge($this->_config, config('auth.auth_config'));
        }
    }

    protected function setUid($uid)
    {

        $this->uid = $uid;
        $this->_config['cache_tag'] = $this->_config['origin_cache_tag'] . $uid;
        return $this;
    }

    protected function getUid()
    {
        if (empty($this->uid)) throw new Error('设置uid');
        return $this->uid;
    }

    protected function getDetailById($id, $attr = [])
    {
        try {
            return $this->model->where("id", $id)->cache(true, $this->_config['cache_expire'], $this->_config['cache_tag'])->find();
        } catch (Exception $e) {
            return [];
        }
    }


    /**
     * 监测权限是否
     * @param $name 逗号隔开，或者数组
     * @param $auth_rule_names
     * @return true
     * @throws Error
     */
    protected function checkExists($name, $auth_rule_names)
    {
        $nameArr = is_array($name) ? $name : explode(',', $name);
        foreach ($nameArr as $v) {
            if (!in_array($v, $auth_rule_names)) {
                throw new Error('权限不足');
            }
        }
        return true;
    }

    /**
     * 根据authGroupAccess->rules=>分割成数组 rule_ids
     * @param $uid
     * @param $authGroupAccessArr
     * @return array|string[]
     */
    protected function handleRuleByAuthGroupAccessArr($uid, $authGroupAccessArr)
    {
        $rulesArr = [];
        foreach ($authGroupAccessArr as $v) {
            $ruless = explode(',', $v['rules']);
            $rulesArr = array_merge($rulesArr, $ruless);
        }
        return $rulesArr;
    }


    //获取['admin-mudule-index'...]
    protected function getRuleName($uid)
    {
        $ruleName = Redis::get(AuthRules::getAuthRuleNamePreCacheById($uid));
        return $ruleName;
    }
    protected function setRuleName($data)
    {
        $uid = $this->getUid();
        Redis::tag($this->_config['cache_tag'])
            ->set(AuthRules::getAuthRuleNamePreCacheById($uid),$data,$this->_config['cache_expire']);
    }
}
