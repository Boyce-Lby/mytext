<?php

namespace app\index\controller;

use app\index\model\Login as LoginModel;
use think\Controller;
use think\Session;
use think\Request;
class Login extends Controller
{
    public function islogin()
    {
      $token = request()->get('token');
      if (!$token) {
        return json(0);
      }else{
        if ($token == Session::get('token')) {
          return json(1);
        }
      }
    }
    public function login($user_name='',$user_passwd=''){
        // if (!$checkToken) {
            $user = LoginModel::get([
                'nickname' => $user_name,
                'password' => md5($user_passwd)
                ]);
            if($user){
                // Session::set('user',$user['nickname']);
                Session::set('token',md5($user['id']));
                $res['user'] = $user['id'];
                $res['token'] = md5($user['id']);
                return json($res);
            }else{
                return json(0);
            }
          // }else{
              // $this->authUrl();
              // if(isset(request()->post('token'))){
              //     Cookie::set('usertoken',request()->post('token'),null);
              //     Cookie::set('userid',request()->post('userid'),null);
              //     Session::set(['token'] , request()->post('token'));
              //     $res['auth'] = 'SUC';
              //     return json($res);
              // }
          // }
      }
      private function authUrl(){
            $origin = $_SERVER['HTTP_ORIGIN'];
            if (in_array($origin, $this->urlArr)) {
                header("Access-Control-Allow-Origin:" . $origin);
                header("Access-Control-Allow-Credentials: true ");
            }else{
                echo "error!";
                exit;
            }
        }
}
