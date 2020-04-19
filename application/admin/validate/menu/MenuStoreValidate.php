<?php

namespace app\admin\validate\menu;

use think\Validate;

class MenuStoreValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'menu_id' => ['require'],
	    'menu_parent_id' => ['require', 'integer'],
        'menu_name' => ['require', 'length:1,30'],
        'menu_icon' => ['length:1,50'],
        'menu_href' => ['length:1,80'],
        'menu_desc' => ['length:1,255'],
        'menu_sort_order' => ['integer'],
        'menu_status' => ['in:0,1']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'store' => ['menu_parent_id','menu_name','menu_icon','menu_href','menu_desc','menu_sort_order','menu_status'],
        'update' => ['menu_id','menu_parent_id','menu_name','menu_icon','menu_href','menu_desc','menu_sort_order','menu_status'],
        'status' => ['menu_id', 'menu_status']
    ];
}
