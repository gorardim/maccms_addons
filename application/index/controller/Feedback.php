<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Feedback extends Base
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
        $param = input();
        if (Request()->isPost()) {
            $param = input();
            $res = model('Feedback')->saveData($param);
            if ($res['code'] == 1) {
                $this->success($res['msg']);
                exit;
            }
            $this->error($res['msg']);
            return json($res);
        }
        return $this->fetch('feedback/index');
    }
}
