<?php

namespace app\common\validate;

use think\Validate;

class Feedback extends Validate
{
    protected $rule =   [
        'user_email'      => 'require|email',
        'content'    => 'require|max:191',
    ];

    protected $message  =   [
        'user_email.require' => 'validate/require_name',
    ];

    protected $scene = [
        'add'  =>  ['user_email', 'content'],
        'edit'  =>  ['user_name'],
    ];
}
