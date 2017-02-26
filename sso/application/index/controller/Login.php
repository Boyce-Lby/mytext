<?php

namespace app\index\controller;

use app\index\model\Login as LoginModel;
use think\Controller;
use think\Session;
use think\Request;
class Login extends Controller
{
    public function login($user_name='',$user_passwd='',$checkToken=''){
        if (!$checkToken) {
            $user = LoginModel::get([
                'nickname' => $user_name,
                'password' => md5($user_passwd)
                ]);
            if($user){
                // Session::set('user',$user['nickname']);
                // Session::set('token',md5($user['nickname']));
                $res['uid'] = $user['id'];
                $res['token'] = md5($user['nickname']);
                return json($res);
            }else{
                return json(0);
            }
          }else{
              $this->authUrl();
              if(isset(request()->post('token'))){
                  Cookie::set('usertoken',request()->post('token'),null);
                  Cookie::set('userid',request()->post('userid'),null);
                  Session::set(['token'] , request()->post('token'));
                  $res['auth'] = 'SUC';
                  return json($res);
              }
          }
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
