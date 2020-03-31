<?php
namespace App\Service;
use  Illuminate\Support\Facades\DB;
use  App\Libraries\Goyeer\Pagination;
/**
 * 后台管理;
 * author    alon<84789887@qq.com>
 * since      1.0
 */
class AdminService
{
    //链接字符串
    private  $connect;
    function  __construct(){
        $this->connect=env('CONNECT_NAME','mysql');
    }
    /*
     * [后台管理]分页查询
     */
    public function  findPagePayWhere($where,$orderby='',$pageIndex=0)
    {
        $_where = empty($where)?"":" where $where";
        $_orderby = empty($orderby)?"":" order by $orderby";
        $totalRecord = $this->findCountByWhere($where);
        $paging = Pagination::getPaging($pageIndex,$totalRecord);
        $pageIndex   = $paging['pageIndex'];
        $startRecord = $paging['startRecord'];
        $totalPage = $paging['totalPage'];
        $pageSize = $paging['pageSize'];
        $limit = "LIMIT  $startRecord,$pageSize";
        $sql = "select  aid, uuid, email, phone, password, password_tac, name, gender, is_super, created_at, is_delete, profile_pic  from  Admin  $_where  $_orderby $limit";
        $admins =  DB::connection($this->connect)->select($sql);
        $data['pageIndex']=$pageIndex;
        $data['startRecord']=$startRecord;
        $data['totalPage']=$totalPage;
        $data['pageSize']=$pageSize;
        $data['data']=$admins;
        return $data;
    }


    /*
     * [后台管理]分页查询
     */
    public  function  findCountByWhere($where=''){
        $_where = empty($where)?"":" where $where";
        $sql = "select COUNT(*) as cnt from admin $_where";
        $admin =DB::connection($this->connect)->selectOne($sql);
        return $admin->cnt;
    }

    /**
     *[后台管理]查询记录条数
     */
    public  function  findAllByWhere($where=''){
        $_where = empty($where)?"":" where $where";
        $sql = "select  aid, uuid, email, phone, password, password_tac, name, gender, is_super, created_at, is_delete, profile_pic  from  admin  $_where";
        $admins =  DB::connection($this->connect)->select($sql);
        return $admins;
    }




    /*
     * 后台管理 一条查询
     * */
    public  function  findOneByWhere($where){
        $_where = empty($where)?"":" where $where";
        $sql = "select  aid, uuid, email, phone, password, password_tac, name, gender, is_super, created_at, is_delete, profile_pic  from  admin  $_where";
        $admin =  DB::connection($this->connect)
            ->selectOne($sql);
        return $admin;
    }



    

    /*
     * 用户管理员查询根据$aid
     * */
    public  function  findOne($aid){
      $admin =DB::connection($this->connect)
             ->table('admin')
             ->where([['aid','=',$aid]])
             ->select('aid', 'uuid', 'email', 'phone', 'password', 'name', 'gender', 'created_at', 'profile_pic')
             ->get()->first();
      return $admin;
    }

    /*
     * 后台管理 新增
     * */
    public  function  insert($admin){
        return DB::connection($this->connect)
            ->table('admin')
            ->insertGetId($admin);
    }

    /*
     *后台管理 修改根据主键
     */
    public  function  update($admin,$keyid) {
        return DB::connection($this->connect)
            ->table('admin')
            ->where('aid',$keyid)
            ->update($admin);
    }
    /*
     *后台管理 修改根据条件
     */
    public  function  updateByWhere($admin,$search){
        return DB::connection($this->connect)
            ->table('admin')
            ->where($search)
            ->update($admin);
    }




    /*
     * 后台管理 根据主键删除记录
     * */
    public  function  delete($keyid){
        return DB::connection($this->connect)
            ->table('admin')
            ->where('aid', '=', $keyid)
            ->delete();
    }

    /*
      * deleteByWhere 根据条件删除记录
      * */
    public  function  deleteByWhere($where){
        if(empty($where)){
            return false;
        }
        return DB::connection($this->connect)
            ->table('admin')
            ->where($where)
            ->delete();
    }
}
