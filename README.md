
Larvel Api接口，集成了统一输出json格式
## 目录结构  
   App/Service    数据操作层  
   App/Libraries  输出类库  
     |- GoResponse.php  输出类  
     |- GoVerify.php    验证类  
     |- Pagination      分页类  

# ```
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
}
# ```
