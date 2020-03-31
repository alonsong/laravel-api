<?php
namespace App\Service;
use  Illuminate\Support\Facades\DB;
use  App\Libraries\Goyeer\Pagination;
/**
 * 用户课程;
 * author    alon<84789887@qq.com>
 * since      1.0
 */
class UserCourseService
{
    //链接字符串
    private $connect;

    function __construct()
    {
        $this->connect = env('default', 'mysql');
    }

    /*
     * [用户课程]分页查询
     */
    public function findPagePayWhere($where, $orderby = '', $pageIndex = 0)
    {
        $_where = empty($where) ? "" : " where $where";
        $_orderby = empty($orderby) ? "" : " order by $orderby";
        $totalRecord = $this->findCountByWhere($where);
        $paging = Pagination::getPaging($pageIndex, $totalRecord);
        $pageIndex = $paging['pageIndex'];
        $startRecord = $paging['startRecord'];
        $totalPage = $paging['totalPage'];
        $pageSize = $paging['pageSize'];
        $limit = "LIMIT  $startRecord,$pageSize";
        $sql = "select  ucid, uid, cid, complete_time, total_time, is_purchase, is_fav, is_unlock, created_at, is_delete  from  user_course  $_where  $_orderby $limit";
        $usercourses = DB::connection($this->connect)->select($sql);
        $data['pageIndex'] = $pageIndex;
        $data['startRecord'] = $startRecord;
        $data['totalPage'] = $totalPage;
        $data['pageSize'] = $pageSize;
        $data['data'] = $usercourses;
        return $data;
    }


    /*
     * [用户课程]分页查询
     */
    public function findCountByWhere($where = '')
    {
        $_where = empty($where) ? "" : " where $where";
        $sql = "select COUNT(*) as cnt from user_course $_where";
        $usercourse = DB::connection($this->connect)->selectOne($sql);
        return $usercourse->cnt;
    }

    /**
     *[用户课程]查询记录条数
     */
    public function findAllByWhere($where = '')
    {
        $_where = empty($where) ? "" : " where $where";
        $sql = "select  ucid, uid, cid, complete_time, total_time, is_purchase, is_fav, is_unlock, created_at, is_delete  from  user_course  $_where";
        $usercourses = DB::connection($this->connect)->select($sql);
        return $usercourses;
    }


    /*
     * 用户课程 一条查询
     * */
    public function findOneByWhere($where)
    {
        $_where = empty($where) ? "" : " where $where";
        $sql = "select  ucid, uid, cid, complete_time, total_time, is_purchase, is_fav, is_unlock, created_at, is_delete  from  user_course  $_where";
        $usercourse = DB::connection($this->connect)
            ->selectOne($sql);
        return $usercourse;
    }

    /*
     * 用户课程 新增
     * */
    public function insert($usercourse)
    {
        return DB::connection($this->connect)
            ->table('user_course')
            ->insertGetId($usercourse);
    }

    /*
     *用户课程 修改根据主键
     */
    public function update($usercourse, $keyid)
    {
        return DB::connection($this->connect)
            ->table('user_course')
            ->where('id', $keyid)
            ->update($usercourse);
    }

    /*
     *用户课程 修改根据条件
     */
    public function updateByWhere($usercourse, $search)
    {
        return DB::connection($this->connect)
            ->table('user_course')
            ->where($search)
            ->update($usercourse);
    }


    /*
     * 用户课程 根据主键删除记录
     * */
    public function delete($keyid)
    {
        return DB::connection($this->connect)
            ->table('user_course')
            ->where('id', '=', $keyid)
            ->delete();
    }

    /*
      * deleteByWhere 根据条件删除记录
      * */
    public function deleteByWhere($where)
    {
        if (empty($where)) {
            return false;
        }
        return DB::connection($this->connect)
            ->table('user_course')
            ->where($where)
            ->delete();
    }
}
