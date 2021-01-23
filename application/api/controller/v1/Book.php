<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 13:56
 */

namespace app\api\controller\v1;

use app\api\model\Book as BookModel;
use app\api\model\Borrow as BorrowModel;
use app\api\model\Keywords as KeywordsModel;
use app\api\validate\BookName;
use app\api\validate\IDParameter;
use app\api\validate\PagingParameter;
use app\lib\exception\MissException;


class Book
{
    /**
     * 获取最近上传的图书 分页
     * @url /book/recent
     * @http GET
     */
    public function getRecent($page=1, $size=5){
        (new PagingParameter())->goCheck();

        $list = BookModel::getRecent($page, $size);
        if($list->isEmpty()){
            return [
                'current_page' => $list->currentPage(),
                'data' => []
            ];
        }

        $data = $list->hidden(['rfid_num','operator'])
            ->toArray();
        return [
            'current_page' => $list->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 获取书籍详情信息
     * @url /book/detail/:id
     * @http GET
     */
    public function getDetail($id){
        (new IDParameter())->goCheck();

        $info = BookModel::getDetail($id);
        if(!$info){
            throw new MissException(['msg'=>'图书或者期刊不存在']);
        }
        return $info;
    }

    /**
     * 馆藏数量
     * @url /book/library/count
     * @http GET
     */
    public function getLibraryBooksCount(){
        $library_books_count = BookModel::getAll();
        $borrow_books_count = BorrowModel::getAll();
        return json(['library_count'=>$library_books_count, 'borrow_count'=>$borrow_books_count]);
    }

    /**
     * 图书借阅排行榜
     * @url /book/borrow/top
     * @http GET
     */
    public function getBookTop(){
        $list = BookModel::getTop();
        if($list->isEmpty()){
            throw new MissException(['msg'=>'借阅排行榜暂无数据']);
        }
        return $list;
    }

    /**
     * 根据书名搜索图书
     * @url /book/search/title/:book_name
     * @http GET
     */
    public function searchByBookName($book_name, $page=1, $size=5){
        (new BookName())->goCheck();
        (new PagingParameter())->goCheck();

        $list = BookModel::searchBooksByName($book_name, $page, $size);
        $data = $list->toArray();
        if($data['data']) {
            KeywordsModel::addKeywords($book_name);
        }
        return $list;
    }
}