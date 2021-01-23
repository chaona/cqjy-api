<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 14:08
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    // 是否需要自动写入时间
    protected $autoWriteTimestamp = false;

    protected function getCreateTimeAttr($time)
    {
        // TODO 数据库字段设计优化
        return $time;//返回create_time原始数据，不进行时间戳转换。
    }

    protected function getUpdateTimeAttr($time)
    {
        // TODO 数据库字段设计优化
        return $time;//返回update_time原始数据，不进行时间戳转换。
    }
}