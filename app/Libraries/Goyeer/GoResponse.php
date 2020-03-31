<?php


namespace App\Libraries\Goyeer;


class GoResponse
{
    private static $instance = null;
    private function __construct(){}
    private function __clone(){}
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public  function response_msg($status=1,$message='success',$infoname='data',$data=null,$extension=false){
      $info['status']  = $status;
      $_message ='success';
      switch ($status){
          case 1:
              $_message='success';
              break;
          case 2:
              $_message='fail';
              break;
          default:
              $_message=$message;
              break;
      }
      $info['message'] = $_message;
      if($extension)
      {
          $info=array_merge($info,$data);
      }else{
          if(!empty($data))
              $info[$infoname] = $data;
      }

      return response()->json($info);
    }



    /*
     * 防止sql注入
     * */
    public function check_sql($post){
        if (!get_magic_quotes_gpc()) // 判断magic_quotes_gpc是否为打开
        {
            $post = addslashes($post); // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤
        }
        $post = str_replace("_", "\_", $post); // 把 '_'过滤掉
        $post = str_replace("%", "\%", $post); // 把' % '过滤掉
        $post = nl2br($post); // 回车转换
        $post= htmlspecialchars($post); // html标记转换
        return $post;
    }

    /*
     * 生成GUID
     * */
    public  function create_uuid(){
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid =''
            .substr($charid, 0, 6).$hyphen
            .substr($charid, 6, 6).$hyphen
            .substr($charid,12, 6).$hyphen
            .substr($charid,18, 6).$hyphen
            .substr($charid,24,8);
        return $uuid;
    }

    public  function  create_token($uuid){
      $time=time();
      $rand_seed  = explode('-',$uuid);
      $send_index = rand(0,4);
      $token=md5($time.$rand_seed[$send_index]);
      return $token;
    }

    public  function  create_code($len=4){
        $code='';
        $randChar='abcdefghijklmnopqrstuvwxyz123456789';//定义字符串
        $_char=strtoupper($randChar);
        for ($i=0;$i<$len;$i++){
            $code.=substr($_char,rand(0, strlen($_char)),1);
        }
        return $code;

    }




}
