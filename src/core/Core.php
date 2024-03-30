<?php

namespace Gz\TpAuth\core;

use Composer\Script\Event;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 03-30
 */
class Core
{
    /**
     * 处理文件
     * @return void
     */
    public static function handle()
    {
       self::createConfig();
    }

    /**
     * 创建配置文件
     * @return void
     */
    private  static  function createConfig(){
        $toFile = './config/auth.php';
        $fromFile = __DIR__.'/../config/auth.php';
        if (!file_exists($toFile)) {
            copy($fromFile,$toFile);
        }
    }

}