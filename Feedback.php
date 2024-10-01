<?php

namespace addons\feedback;

use think\Addons;

/**
 * 用户反馈插件
 */
class Feedback extends Addons
{
    public $info = [
        'name' => 'feedback',
        'title' => 'Feedback',
        'description' => 'Feedback plugin',
        'status' => 0,
        'author' => 'Foyez',
        'version' => '1.0'
    ];

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件启用方法 
     */
    public function enable()
    {

        $menus = @include MAC_ADMIN_COMM . 'auth.php';

        $menus['11']['sub']['feedback'] = array("show" => 1, 'name' => 'Feedback', 'controller' => 'feedback', 'action' => 'index', 'param' => '');
        mac_arr2file(APP_PATH . 'admin/common/auth.php', $menus);
        return true;
    }

    /**
     * 插件禁用方法
     */
    public function disable()
    {
        $menus = @include MAC_ADMIN_COMM . 'auth.php';
        unset($menus['11']['sub']['feedback']);
        mac_arr2file(APP_PATH . 'admin/common/auth.php', $menus);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * 实现的mydemohook钩子方法
     * @return mixed
     */
    public function feedbackhook($param)
    {
        // 调用钩子时候的参数信息
        print_r($param);
        // 当前插件的配置信息，配置信息存在当前目录的config.php文件中，见下方
        print_r($this->getConfig());
        // 可以返回模板，模板文件默认读取的为插件目录中的文件。模板名不能为空！
        return $this->fetch('info');
    }
}
