<?php
namespace App\Http\Controllers\Admin;
use App\Service\UserService;
use Illuminate\Http\Request;
use App\Libraries\Goyeer\GoResponse;
use App\Libraries\Goyeer\GoVerify;
use App\Http\Controllers\Controller;
class UserController extends  Controller
{
    private $userService;
    private $goResponse;
    private $goVerify;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->goResponse = GoResponse::getInstance();
        $this->goVerify = GoVerify::getInstance();
    }

    /*
     * [用户表]分页查询列表
    * */
    public function index(Request $request)
    {
        $where = '1';
        $order_by = '';
        $page = $request->get('page');
        $keyword = $this->goResponse->check_sql($request->get('search_keywords'));
        if (!empty($keyword)) {
            $where .= " and (uuid like '%$keyword%' or phone like '%$keyword%' or `name` like '%$keyword%' or email like '%$keyword%')";
        }

        $users = $this->userService->findPagePayWhere($where, $order_by, $page);
        return $this->goResponse->response_msg(1, 'success', 'users', $users);
    }

    /*
     * [用户表]不分页查询列表
     * */
    public function  list(Request $request)
    {
        $where = "1";
        $keyword = $this->goResponse->check_sql($request->get('search_keywords'));
        if (!empty($keyword)) {
            $where .= " and (uuid like '%$keyword%' or phone like '%$keyword%' or `name` like '%$keyword%' or email like '%$keyword%')";
        }
        $users = $this->userService->findAllByWhere($where);
        $info['users'] = $users;
        return $this->goResponse->response_msg(1, 'success', 'users', $info, true);
    }




    /*
     * [用户表]根据主键查询
     * */
    public function show(Request $request)
    {
        $where = '';
        $uid = $this->goResponse->check_sql($request->get('uid'));
        $where = "uid = $uid";
        $user = $this->userService->findOneByWhere($where);
        $info['user'] = empty($user)?array():$user;
        return $this->goResponse->response_msg(1, 'success', 'user', $info,true);
    }

    /*
     *  [用户表]新增
     **/
    public function create(Request $request)
    {

        $uid = $this->goResponse->check_sql($request->post('uid'));
        $data['uid'] = $uid;
        $uuid = $this->goResponse->check_sql($request->post('uuid'));
        $data['uuid'] = $uuid;
        $email = $this->goResponse->check_sql($request->post('email'));
        $data['email'] = $email;
        $phone = $this->goResponse->check_sql($request->post('phone'));
        $data['phone'] = $phone;
        $password = $this->goResponse->check_sql($request->post('password'));
        $data['password'] = $password;
        $password_tac = $this->goResponse->check_sql($request->post('password_tac'));
        $data['password_tac'] = $password_tac;
        $fb_token = $this->goResponse->check_sql($request->post('fb_token'));
        $data['fb_token'] = $fb_token;
        $fa_id = $this->goResponse->check_sql($request->post('fa_id'));
        $data['fa_id'] = $fa_id;
        $google_token = $this->goResponse->check_sql($request->post('google_token'));
        $data['google_token'] = $google_token;
        $google_id = $this->goResponse->check_sql($request->post('google_id'));
        $data['google_id'] = $google_id;
        $register_tac = $this->goResponse->check_sql($request->post('register_tac'));
        $data['register_tac'] = $register_tac;
        $name = $this->goResponse->check_sql($request->post('name'));
        $data['name'] = $name;
        $referral_code = $this->goResponse->check_sql($request->post('referral_code'));
        $data['referral_code'] = $referral_code;
        $referral_by = $this->goResponse->check_sql($request->post('referral_by'));
        $data['referral_by'] = $referral_by;
        $dataofbirth = $this->goResponse->check_sql($request->post('dataofbirth'));
        $data['dataofbirth'] = $dataofbirth;
        $country = $this->goResponse->check_sql($request->post('country'));
        $data['country'] = $country;
        $city = $this->goResponse->check_sql($request->post('city'));
        $data['city'] = $city;
        $address = $this->goResponse->check_sql($request->post('address'));
        $data['address'] = $address;
        $user_level = $this->goResponse->check_sql($request->post('user_level'));
        $data['user_level'] = $user_level;
        $red_point = $this->goResponse->check_sql($request->post('red_point'));
        $data['red_point'] = $red_point;
        $green_point = $this->goResponse->check_sql($request->post('green_point'));
        $data['green_point'] = $green_point;
        $created_at = $this->goResponse->check_sql($request->post('created_at'));
        $data['created_at'] = $created_at;
        $is_delete = $this->goResponse->check_sql($request->post('is_delete'));
        $data['is_delete'] = $is_delete;
        $id = $this->userService->insert($data);
        $user = $this->userService->findOneByWhere("keyid=$id");
        if ($id)
            return $this->goResponse->response_msg(1, '', '$user', $user);
        else
            return $this->goResponse->response_msg(2);
    }

    /*
    *  [用户表]修改
    **/
    public function update(Request $request)
    {
        $where = [];
        $keyid = $this->goResponse->check_sql($request->post('keyid'));
        $_param = ["keyid", "=", "$keyid"];
        array_push($where, $_param);

        $data = [];
        $uid = $this->goResponse->check_sql($request->post('uid'));
        $data['uid'] = $uid;
        $uuid = $this->goResponse->check_sql($request->post('uuid'));
        $data['uuid'] = $uuid;
        $email = $this->goResponse->check_sql($request->post('email'));
        $data['email'] = $email;
        $phone = $this->goResponse->check_sql($request->post('phone'));
        $data['phone'] = $phone;
        $password = $this->goResponse->check_sql($request->post('password'));
        $data['password'] = $password;
        $password_tac = $this->goResponse->check_sql($request->post('password_tac'));
        $data['password_tac'] = $password_tac;
        $fb_token = $this->goResponse->check_sql($request->post('fb_token'));
        $data['fb_token'] = $fb_token;
        $fa_id = $this->goResponse->check_sql($request->post('fa_id'));
        $data['fa_id'] = $fa_id;
        $google_token = $this->goResponse->check_sql($request->post('google_token'));
        $data['google_token'] = $google_token;
        $google_id = $this->goResponse->check_sql($request->post('google_id'));
        $data['google_id'] = $google_id;
        $register_tac = $this->goResponse->check_sql($request->post('register_tac'));
        $data['register_tac'] = $register_tac;
        $name = $this->goResponse->check_sql($request->post('name'));
        $data['name'] = $name;
        $referral_code = $this->goResponse->check_sql($request->post('referral_code'));
        $data['referral_code'] = $referral_code;
        $referral_by = $this->goResponse->check_sql($request->post('referral_by'));
        $data['referral_by'] = $referral_by;
        $dataofbirth = $this->goResponse->check_sql($request->post('dataofbirth'));
        $data['dataofbirth'] = $dataofbirth;
        $country = $this->goResponse->check_sql($request->post('country'));
        $data['country'] = $country;
        $city = $this->goResponse->check_sql($request->post('city'));
        $data['city'] = $city;
        $address = $this->goResponse->check_sql($request->post('address'));
        $data['address'] = $address;
        $user_level = $this->goResponse->check_sql($request->post('user_level'));
        $data['user_level'] = $user_level;
        $red_point = $this->goResponse->check_sql($request->post('red_point'));
        $data['red_point'] = $red_point;
        $green_point = $this->goResponse->check_sql($request->post('green_point'));
        $data['green_point'] = $green_point;
        $created_at = $this->goResponse->check_sql($request->post('created_at'));
        $data['created_at'] = $created_at;
        $is_delete = $this->goResponse->check_sql($request->post('is_delete'));
        $data['is_delete'] = $is_delete;
        $flag = $this->userService->updateByWhere($data, $where);
        if ($flag) {
            $user = $this->userService->findOneByWhere("keyid=$keyid");
            return $this->goResponse->response_msg(1, '', '$user', $user);
        } else {
            return $this->goResponse->response_msg(2);
        }
    }

    /*
     *  [用户表]删除
     **/
    public function destroy(Request $request)
    {
        $uid = $this->goResponse->check_sql($request->post('uid'));
        if (!is_numeric($uid)) {
            return $this->goResponse->response_msg(3, 'Illegal Operation');
        }
        $return_val = $this->userService->delete($uid);
        if ($return_val) {
            return $this->goResponse->response_msg(1);
        } else {
            return $this->goResponse->response_msg(2);
        }
    }


    /*
    * [用户表]分页查询列表
   * */
    public function referralrecord_page(Request $request)
    {
        $where = '1';
        $order_by = '';
        $page = $request->get('page');
        $uid = $this->goResponse->check_sql($request->get('uid'));
        $users = $this->userService->findAllByReferralByUid($uid,$page);
        return $this->goResponse->response_msg(1, 'success', 'users', $users);
    }

    public  function referralrecord(Request $request)
    {
        $uid = $this->goResponse->check_sql($request->get('uid'));
        $users = $this->userService->findReferralByByWhereUid($uid);
        $info['users'] = $users;

        return $this->goResponse->response_msg(1, 'success', 'users', $info,true);
    }

    public  function purchased_courses_page(Request $request){
        $where = '1';
        $order_by = '';
        $page = $request->get('page');
        $uid = $this->goResponse->check_sql($request->get('uid'));
        $_where =" a.uid = $uid";
        $courses = $this->userService->get_purchased_courses_page($_where,$page);
        return $this->goResponse->response_msg(1, 'success', 'courses', $courses,false);
    }


    public  function purchased_courses(Request $request){
        $uid = $this->goResponse->check_sql($request->get('uid'));
        $_where =" a.uid = $uid";
        $courses = $this->userService->get_purchased_courses($_where);
        $info['courses'] =   empty($courses)?array(): $courses;
        return $this->goResponse->response_msg(1, 'success', 'courses', $info,true);
    }



}
