<?php

namespace app\admin\controller;

use think\Db;
use think\Request;

class Feedback extends Base
{
    public function index()
    {
        $param = input();
        $param["page"] = intval($param["page"]) < 1 ? 1 : $param["page"];
        $param["limit"] = intval($param["limit"]) < 1 ? $this->_pagesize : $param["limit"];
        $where = [];
        if (!empty($param["wd"])) {
            $param["wd"] = htmlspecialchars(urldecode($param["wd"]));
            $where["content"] = ["like", "%" . $param["wd"] . "%"];
        }
        $order = "id desc";
        $res = model("Feedback")->listData($where, $order, $param["page"], $param["limit"]);
        $this->assign("list", $res["list"]);
        $this->assign("total", $res["total"]);
        $this->assign("page", $res["page"]);
        $this->assign("limit", $res["limit"]);
        $param["page"] = "{page}";
        $param["limit"] = "{limit}";
        $this->assign("param", $param);
        $this->assign("title", lang("admin/feedback/title"));
        return $this->fetch("admin@feedback/index");
    }

    public function del()
    {
        $param = input();
        $ids = $param['ids'];

        if (!empty($ids)) {
            $where = [];
            $where['id'] = ['in', $ids];
            $res = model('Feedback')->delData($where);
            if ($res['code'] > 1) {
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        } elseif (!empty($param['repeat'])) {
            $st = ' not in ';
            if ($param['retain'] == 'max') {
                $st = ' in ';
            }
            $sql = 'delete from ' . config('database.prefix') . 'feedback where id' . $st . '(select id from (select max(id) as id from ' . config('database.prefix') . 'feedback group by content) as tmp)';
            $res = model('Feedback')->execute($sql);
            if ($res === false) {
                return $this->success(lang('del_err'));
            }
            return $this->success(lang('del_ok'));
        }
        return $this->error(lang('param_err'));
    }
}
