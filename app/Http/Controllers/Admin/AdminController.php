<?php
namespace App\Http\Controllers\Admin;
use App\Service\AdminService;
use App\Service\SessionAdminService;
use Illuminate\Http\Request;
use App\Libraries\Goyeer\GoResponse;
use App\Libraries\Goyeer\GoVerify;
use App\Http\Controllers\Controller;
class AdminController extends  Controller
{
    private $adminService;
    private $goResponse;
    private $goVerify;
    private $sessionAdminService;

    function __construct(AdminService $adminService,SessionAdminService $sessionAdminService)
    {
        $this->adminService = $adminService;
        $this->sessionAdminService=$sessionAdminService;
        $this->goResponse = GoResponse::getInstance();
        $this->goVerify = GoVerify::getInstance();
    }

    /*
     * [后台管理]分页查询列表
    * */
    public function index(Request $request)
    {
        $where = '1';
        $order_by = '';
        $page = $request->get('page');
        $keyword = $this->goResponse->check_sql($request->get('keyword'));
        if (!empty($name)) {
            $where .= " and (email like '$keyword%' OR phone like '$keyword%' OR `name`='$keyword%')";
        }
        $admins = $this->adminService->findPagePayWhere($where, $order_by, $page);
        return $this->goResponse->response_msg(1, 'success', 'admins', $admins);
    }

    /*
     * [后台管理]不分页查询列表
     * */
    public function  list(Request $request)
    {
        $where = "1";
        $keyword = $this->goResponse->check_sql($request->get('keyword'));
        if (!empty($keyword)) {
            $where .= " and (email like '$keyword%' OR phone like '$keyword%' OR `name`='$keyword%')";
        }
        $admins = $this->adminService->findAllByWhere($where);
        return $this->goResponse->response_msg(1, 'success', 'admins', $admins);
    }

    /*
     * [后台管理]根据主键查询
     * */
    public function show(Request $request)
    {
        $where = '';
        $id = $this->goResponse->check_sql($request->get('aid'));
        $where = "aid=$id";
        $admin = $this->adminService->findOneByWhere($where);
        if(!empty($admin))
        {
            return $this->goResponse->response_msg(1, 'success', 'admin', $admin);
        }else{
            return $this->goResponse->response_msg(2);
        }

       }

    /*
     *  [后台管理]新增
     **/
    public function create(Request $request)
    {
        $uuid = $this->goResponse->create_uuid();
        $data['uuid'] = $uuid;
        $email = $this->goResponse->check_sql($request->post('email'));
        $is_email=$this->goVerify->validator($email,'email');
        if(!$is_email){
            return $this->goResponse->response_msg(3,'Email address error');
        }
        $has_email =$this->adminService->findCountByWhere(" email='$email'");
        if($has_email){
            return $this->goResponse->response_msg(3,'Email already exists');
        }
        $data['email'] = $email;

        $phone = $this->goResponse->check_sql($request->post('phone'));
        $has_phone =$this->adminService->findCountByWhere(" phone='$phone'");
        if($has_phone){
            return $this->goResponse->response_msg(3,'Phone already exists');
        }
        $data['phone'] = $phone;

        $password = $this->goResponse->check_sql($request->post('password'));

        $data['password'] =md5($password);
        $password_tac = $this->goResponse->check_sql($request->post('password_tac'));
        $data['password_tac'] = $password_tac;
        $name = $this->goResponse->check_sql($request->post('name'));
        if(empty($name)){
            return $this->goResponse->response_msg(3,'UserName error');
        }

        $has_name =$this->adminService->findCountByWhere(" `name`='$name'");
        if($has_name){
            return $this->goResponse->response_msg(3,'Name already exists');
        }
        $data['name'] = $name;
        $gender = $this->goResponse->check_sql($request->post('gender'));
        $is_gender=$this->goVerify->validator($gender,'digit');
        if(!$is_gender){
            return $this->goResponse->response_msg(3,'Gender error');
        }
        $gender = $gender>2 || $gender<0 ?1:$gender;
        $data['gender'] = $gender;
        $data['created_at'] = date('y-m-d h:i:s',time());
        $data['is_delete'] = 0;
        $profile_pic = $this->goResponse->check_sql($request->post('profile_pic'));
        $data['profile_pic'] = $profile_pic;
        $id = $this->adminService->insert($data);
        $admin=$this->adminService->findOne($id);
        if ($id){
            return $this->goResponse->response_msg(1,'','admin',$admin);
        }else{
            return $this->goResponse->response_msg(2);
        }

    }

    /*
    *  [后台管理]修改
    **/
    public function update(Request $request)
    {
        $where = [];
        $keyid = $this->goResponse->check_sql($request->post('aid'));
        $_param = ["aid", "=", "$keyid"];
        array_push($where, $_param);
        $email = $this->goResponse->check_sql($request->post('email'));
        $is_email = $this->goVerify->validator($email, 'email');
        if (!$is_email) {
            return $this->goResponse->response_msg(0, 'Email address error');
        }
        $data['email'] = $email;
        $phone = $this->goResponse->check_sql($request->post('phone'));
        $data['phone'] = $phone;
        $name = $this->goResponse->check_sql($request->post('name'));
        if (empty($name)) {
            return $this->goResponse->response_msg(0, 'UserName error');
        }
        $data['name'] = $name;
        $gender = $this->goResponse->check_sql($request->post('gender'));
        $is_gender = $this->goVerify->validator($gender, 'digit');
        if (!$is_gender) {
            return $this->goResponse->response_msg(0, 'Gender error');
        }
        $gender = $gender > 2 || $gender < 0 ? 1 : $gender;
        $data['gender'] = $gender;
        $data['created_at'] = date('y-m-d h:i:s', time());
        $profile_pic = $this->goResponse->check_sql($request->post('profile_pic'));
        $data['profile_pic'] = $profile_pic;
        $flag = $this->adminService->updateByWhere($data, $where);
        $admin = $this->adminService->findOne($keyid);
        if ($flag) {
            return $this->goResponse->response_msg(1, '', 'admin', $admin);
        } else {
            return $this->goResponse->response_msg(2);
        }

    }

    /*
     *  [后台管理]删除
     **/
    public function destroy(Request $request)
    {
        $input =  $request->input();
        $keyid = $this->goResponse->check_sql($input['uid']);
        if (!is_numeric($keyid)) {
            return $this->goResponse->response_msg(3, 'Illegal Operation');
        }
        $return_val = $this->adminService->delete($keyid);
        if ($return_val) {
            return $this->goResponse->response_msg(1);
        } else {
            return $this->goResponse->response_msg(2);
        }
    }

    /*
     * 管理员登录
     * */
    public function  login(Request $request)
    {
        $email = $this->goResponse->check_sql($request->post('email'));
        $is_email=$this->goVerify->validator($email,'email');
        if(!$is_email){
            return $this->goResponse->response_msg(2,'Email address error');
        }
        $password = $this->goResponse->check_sql($request->post('password'));
        $is_password = $this->goVerify->validator($password,'char');
        if(!$is_password){
            return $this->goResponse->response_msg(2,'Password error');
        }
        $where =" email ='$email'";
        $admin = $this->adminService->findOneByWhere($where);
        if(empty($admin)){
            return $this->goResponse->response_msg(2);
        }

        if($admin->password!=md5($password)){
            return $this->goResponse->response_msg(2);
        }
        $uuid  = $admin->uuid;
        $token = $this->goResponse->create_token($uuid);
        $session['uid']=$admin->aid;
        $session['token']=$token;
        $sessionId=$this->sessionAdminService->insert($session);
        if(empty($sessionId)){
            return  $this->goResponse->response_msg(2);
        }else{
            $admininfo['aid']=$admin->aid;
            $admininfo['token']=$token;
            return  $this->goResponse->response_msg(1,'','admin',$admininfo);
        }

    }

    /*
     * 验证session是否存在
     * */
    public function  checksession(Request $request){
        $token = $this->goResponse->check_sql($request->post('token'));
        $is_token = $this->goVerify->validator($token,'char');
        if(!$is_token){
            return $this->goResponse->response_msg(2);
        }
        $aid   = $this->goResponse->check_sql($request->post('aid'));
        $is_aid = $this->goVerify->validator($aid,'char');
        if(!$is_aid){
            return $this->goResponse->response_msg(2);
        }
        $where =" uid='$aid' and token='$token'";
        $session=$this->sessionAdminService->findOneByWhere($where);
        if(empty($session)){
            return $this->goResponse->response_msg(2,'','is_login','2');
        }else{
            return $this->goResponse->response_msg(1,'','is_login','1');
        }

    }
    /*
     * 忘记密码发送邮件或者手机号
     * */
    public  function  forgotpassword(Request $request){
        $email = $this->goResponse->check_sql($request->post('email'));
        $is_email =$this->goVerify->validator($email,'email');

        if(!$is_email){
            return $this->goResponse->response_msg(2);
        }
        $where = " email='$email'";
        $admin = $this->adminService->findOneByWhere($where);
        if(empty($admin)){
            return $this->goResponse->response_msg(2);
        }
        $code = $this->goResponse->create_code(6);
        $data['password_tac'] = $code;
        $_where=[['aid','=',$admin->aid]];
        $flag = $this->adminService->updateByWhere($data,$_where);
        if($flag){
            return $this->goResponse->response_msg(1,'','password_tac',$code);
        }else{
            return $this->goResponse->response_msg(2);
        }



    }

    /*
     * 忘记密码找回
 *  */
    public function  restorepassword(Request $request){
        $email = $this->goResponse->check_sql($request->post('email'));
        $is_email =$this->goVerify->validator($email,'email');
        if(!$is_email){
            return $this->goResponse->response_msg(3,'Email is error');
        }
        $password_tac = $this->goResponse->check_sql($request->post('password_tac'));
        $where = " email='$email'";
        $admin = $this->adminService->findOneByWhere($where);
        if($admin->password_tac==$password_tac){
            return $this->goResponse->response_msg(1);
        }else{
            return $this->goResponse->response_msg(2);
        }
    }

    public  function  editpassword(Request $request){
        $aid = $this->goResponse->check_sql($request->post('aid'));
        $is_aid = $this->goVerify->validator($aid,'number');
        if(!$is_aid){
            return $this->goResponse->response_msg(3,'aid is error');
        }
        $password = $request->post('password');
        if(empty($password)){
            return $this->goResponse->response_msg(3,'Password is error');
        }

        $data['password'] = md5($password);
        $_where=[['aid','=',$aid]];
        $flag = $this->adminService->updateByWhere($data,$_where);
        if($flag){
            return $this->goResponse->response_msg(1);
        }else{
            return $this->goResponse->response_msg(2);
        }

    }

}

