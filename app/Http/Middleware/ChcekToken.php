<?php
namespace App\Http\Middleware;
use Closure;
use App\Libraries\Goyeer\GoResponse;
use http\Env\Response;
use  App\Libraries\Goyeer\GoVerify;
use App\Service\SessionAdminService;


class ChcekToken
{
  public  function handle($request, Closure $next){
     $response =  $next($request);
     $goResponse = GoResponse::getInstance();
     $goVerify   = GoVerify::getInstance();
     $parameters = $request->all();
     $token='';
     if(isset($parameters['token'])){
         $token=$parameters['token'];
     }
     $is_token = $goVerify->validator($token,'char');
     if(!$is_token){
         return $goResponse->response_msg(3,'Token is error');
     }
     $sessionAdminService = new SessionAdminService();
     $where = " token = '$token'";
     $sessionAdmin = $sessionAdminService->findOneByWhere($where);
     if(!$sessionAdmin){
         return $goResponse->response_msg(3,'Token is error');
     }
     return $response;
  }
}
