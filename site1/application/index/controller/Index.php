<?php
namespace app\index\controller;
use think\Controller;
use think\Cookie;
use think\Session;
use think\Request;
class Index extends Controller
{
	protected $user;
    public function index()
    { 
        $this->user = $this->is_login();
    	$this->user || $this->redirect('Index/login');
        $postUrl = "http://sso.me/users"; 
		$res = httpPost($postUrl); 
		$res = json_decode($res);
		// var_dump(session_id());
		return $this->fetch();
    }
    public function login()
    {
    	if (request()->isPost()) {
    		$nickname = request()->post('nickname');
    		$password = request()->post('password');
    		$postUrl = "http://sso.me/login/".$nickname."/".$password; 
			$res = httpPost($postUrl); 
			$res = json_decode($res,true);  
			Session::set('user',$res['user']);
			Session::set('token',$res['token']);
			// $this->assign('uid', $res['uid']);
			// $this->assign('token', $res['token']);
			// return $this->fetch('login1');
      
            $this->redirect('Index/index');      // 
    	}else{
			return $this->fetch('login');
    	}
    	
    }
    public function logout()
    {
        Session::delete('user', null);
        Session::delete('token', null);
        $this->redirect('Index/login');
    }
    public function is_login()
    {
        $token = request()->post('token');
    	if (empty($token)) {
	        return 0;
	    } else {
            $postUrl = "http://sso.me/index/login/islogin/".$token; 
            $res = httpPost($postUrl);
            if (!$res) {
                return 0;
            }else{
                $this->redirect('Index/index');      // 
            }
	        // return Session::get('token') == md5($user) ? $user : 0;
	    }
    }

}
