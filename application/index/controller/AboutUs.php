<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class AboutUs extends Base
{
    public function __construct()
    {
        parent::__construct();

        define('THIRD_LOGIN_CALLBACK',  $GLOBALS['http_type'] . $_SERVER['HTTP_HOST'] . '/index.php/user/logincallback/type/');

        //判断用户登录状态
        $ac = request()->action();
        if (in_array($ac, ['login', 'logout', 'ajax_login', 'reg', 'findpass', 'findpass_msg', 'findpass_reset', 'reg_msg', 'oauth', 'logincallback', 'visit'])) {
        } else {
            if ($GLOBALS['user']['user_id'] < 1) {
                model('User')->logout();
                return $this->error(lang('index/no_login') . '', url('user/login'));
            }
            /*
            $res = model('User')->checkLogin();
            if($res['code']>1){
                model('User')->logout();
                return $this->error($res['msg'], url('user/login'));
            }
            */
            $this->assign('obj', $GLOBALS['user']);
        }
    }

    public function index()
    {
        return $this->fetch('about_us/index');
    }
}
