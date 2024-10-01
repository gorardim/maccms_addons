<?php

namespace app\common\model;

use think\Db;

class Feedback extends Base
{
    // 设置数据表（不含前缀）
    protected $name = 'feedback';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

    // 自动完成
    protected $auto       = [];
    protected $insert     = [];
    protected $update     = [];

    public function listData($where, $order, $page, $limit = 20)
    {
        $page = $page > 0 ? (int)$page : 1;
        $limit = $limit ? (int)$limit : 20;
        $total = $this->where($where)->count();
        $list = Db::name('Feedback')->where($where)->order($order)->page($page)->limit($limit)->select();
        return ['code' => 1, 'msg' => lang('data_list'), 'page' => $page, 'pagecount' => ceil($total / $limit), 'limit' => $limit, 'total' => $total, 'list' => $list];
    }

    public function delData($where)
    {
        $res = $this->where($where)->delete();
        if ($res === false) {
            return ['code' => 1001, 'msg' => lang('del_err') . '：' . $this->getError()];
        }
        return ['code' => 1, 'msg' => lang('del_ok')];
    }

    public function saveData($data)
    {
        $validate = \think\Loader::validate('Feedback');
        if (!$validate->check($data)) {
            return ['code' => 1001, 'msg' => lang('param_err') . '：' . $validate->getError()];
        }

        // xss过滤
        $filter_fields = [
            'user_name',
            'content',
        ];
        foreach ($filter_fields as $filter_field) {
            if (!isset($data[$filter_field])) {
                continue;
            }
            $data[$filter_field] = mac_filter_xss($data[$filter_field]);
        }

        $data['ip'] = mac_get_ip_long();

        if (!empty($data['id'])) {
            $where = [];
            $where['id'] = ['eq', $data['id']];
            $res = $this->allowField(true)->where($where)->update($data);
        } else {
            $data['time'] = time();
            $res = $this->allowField(true)->insert($data);
        }
        if (false === $res) {
            return ['code' => 1002, 'msg' => lang('save_err') . '：' . $this->getError()];
        }
        return ['code' => 1, 'msg' => lang('save_ok')];
    }
}
