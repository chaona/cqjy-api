<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 18:33
 */

namespace app\api\behavior;

/**
 * 跨越资源共享（CORS)
 * 在 tags.php 配置
 */
class CORS
{
    public function appInit(&$params){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT');
        if(request()->isOptions()){
            exit();
        }
    }
}