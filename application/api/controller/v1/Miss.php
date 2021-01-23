<?php
/**
 * author: liukai305
 * since: 2021-01-19 下午 16:47
 */

namespace app\api\controller\v1;


use app\lib\exception\MissException;
use think\Controller;

/**
 * MISS路由，当全部路由没有匹配到时
 * 将返回资源未找到的信息
 */
class Miss extends Controller
{
    public function miss(){
        throw new MissException();
    }
}