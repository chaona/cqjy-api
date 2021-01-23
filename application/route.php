<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

/* 示例
请求路径	　　　　	请求方法	　　　　	作用
/user/1	HTTP　　　GET	　　　　　 查询id为1的user
/user/1	HTTP　　　DELETE	　　　删除id为1的user
/user/1	HTTP　　　PUT　　　　　 编辑id为1的user
/user	HTTP　　　POST   　　　新增user
*/

//Miss 404
//Miss 路由开启后，默认的普通模式也将无法访问
Route::miss('api/v1.Miss/miss');

// 图书
Route::group('api/:version/book', function(){
    // 最近上传图书
    Route::get('/recent', 'api/:version.Book/getRecent');
    // 馆藏数量
    Route::get('/library/count', 'api/:version.Book/getLibraryBooksCount');
    // 借阅排行榜
    Route::get('/borrow/top', 'api/:version.Book/getBookTop');
    // 书名检索
    Route::get('/search/title/:book_name', 'api/:version.Book/searchByBookName');
    // 图书详情
    Route::get('/detail/:id', 'api/:version.Book/getDetail');
});

// 借还
Route::group('api/:version/borrow', function(){
    // 借阅清单
    Route::get('/all/list/:id', 'api/:version.Borrow/getBorrowListByID');
    // 已过期
    Route::get('/expire/list/:id', 'api/:version.Borrow/getBorrowExpireListByID');
    // 将过期
    Route::get('/soon_expire/list/:id', 'api/:version.Borrow/getBorrowWillExpireListByID');
    // 在借中
    Route::get('/borrowing/list/:id', 'api/:version.Borrow/getBorrowingExpireListByID');
    // 借阅状态数量列表
    Route::get('/count/list/:id', 'api/:version.Borrow/getBorrowCountList');
    // 在借中 全部续借
    Route::put('/renew/borrowing/:id', 'api/:version.Borrow/updateBorrowingListRenew');
    // 将过期 全部续借
    Route::put('/renew/expire/:id', 'api/:version.Borrow/updateBorrowExpireListRenew');
});

// 读者
Route::group('api/:version/reader', function(){
    // 绑定读者证
    Route::post('/card', 'api/:version.Reader/bindCard');
    // 修改密码
    Route::put('/password', 'api/:version.Reader/updatePassword');
    // 修改读者资料
    Route::put('/profile', 'api/:version.Reader/updateProfile');
    // 读者详情
    Route::get('/detail/:id', 'api/:version.Reader/getReaderByID');
});

// 搜索词
Route::group('api/:version/keywords', function(){
    // 热门检索词
    Route::get('/hot/list', 'api/:version.Keywords/getHotKeywords');
});