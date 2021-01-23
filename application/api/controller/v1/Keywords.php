<?php
/**
 * author: liukai305
 * since: 2021-01-22 下午 18:11
 */

namespace app\api\controller\v1;

use app\api\model\Keywords as KeywordsModel;
use app\lib\exception\MissException;

class Keywords
{
    /**
     * 获取热门检索词
     * @url keywords/hot/list
     * @http GET
     */
    public function getHotKeywords(){
        $list = KeywordsModel::getKeywords();
        if($list->isEmpty()){
            throw new MissException(['msg'=>'暂无热门检索词']);
        }
        return $list;
    }
}