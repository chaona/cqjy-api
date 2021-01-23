<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 14:22
 */

namespace app\lib\enum;

/**
 * 图书状态
 */
class BookStatusEnum
{
    // 删除
    const DELETE = 0;

    // 在馆
    const IN_LIBRARY = 1;

    // 流通
    const CIRCULATION = 2;

    // 下架
    const PULL = 3;
}