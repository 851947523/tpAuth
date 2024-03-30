<?php
namespace Gz\TpAuth\core;
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
    public static function handle(){
        $rootPath = app()->getRootPath();
        $toFile = $rootPath.'/config/auth.php';
        $fromFile = __DIR__.'/../config/auth.php';
        if (!file_exists($fromFile)) {
            copy($fromFile,$toFile);
        }
     }

}