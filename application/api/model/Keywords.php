<?php
/**
 * author: liukai305
 * since: 2021-01-22 下午 16:41
 */

namespace app\api\model;


class Keywords extends BaseModel
{
    protected $table = 'hot_retrieval';

    /**
     * 更新或者添加搜索词
     */
    public static function addKeywords($param){
        $id = self::where('name','=', $param)->value('number');
        // 如果找到该关键词，则nums加1
        if($id){
            self::where('name', '=', $param)->setInc('number');
        } else {
            // 如果未找到，则新增该关键词
            $data = [
                'name' => $param,
                'number' => 1
            ];
            return self::create($data, true);
        }
    }

    /**
     * 获取热门检索词
     */
    public static function getKeywords(){
        $list = self::order('number desc')
            ->limit(config('setting.search_hot_keywords_count'))
            ->select();
        return $list;
    }
}