<?php
return[
    // 权限设置
    'auth_config'            => [
        'auth_on'            => true,                      // 认证开关
        'auth_group'         => 'tp_auth_group',        // 用户组数据表名
        'auth_group_access'  => 'tp_auth_group_access', // 用户-用户组关系表
        'auth_rule'          => 'tp_auth_rule',         // 权限规则表
        'auth_user'          => 'tp_admin',            // 用户信息表
        'cache_expire'  => 24*3600,                   //缓存时效
    ],
];