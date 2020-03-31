<?php


namespace App\Libraries\Goyeer;

/*
 * 分页类
 * */
class Pagination
{
   /*
    *
    * */
   public static function  getPaging($pageIndex,$totalRecord){

       $pageSize    = env('PAGESIZE',15);
       $currentPage = (empty($pageIndex) || ($pageIndex<1))?1:$pageIndex;
       $totalPage   = $totalRecord%$pageSize==0?$totalRecord/$pageSize:(floor($totalRecord/$pageSize)+1);
       $startRecord = ($currentPage-1) * $pageSize;
       $currentPage = $currentPage >= $totalPage?$totalPage:$currentPage;
       $data['first'] = $currentPage==1?true:false;
       $data['last']  = $pageIndex==$totalPage?true:false;
       $data['pageIndex']   = $currentPage; //当前页数
       $data['startRecord'] = $startRecord; //当前页开始记录号
       $data['totalPage']   = $totalPage;   //总页数
       $data['pageSize']    = $pageSize;    //每页显示的记录数
       return $data;
   }
}
