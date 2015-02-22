<?php
defined('IN_MET') or exit('No permission');//所有文件都是已这句话开头，保证系统单入口。

load::sys_class('web');//包含后台基类，如果是前台包含web.class.php。‘.class.php’ 可以省略。

class m1624 extends web {//继承后台基类。类名称要与文件名一致
    public function __construct() {
        parent::__construct();//如果重写了初始化方法,一定要调用父类的初始化函数。
    }
	public function doindex(){//定义自己的方法
		global $_M;
		require_once $this->custom_template('own/index', 1);
	}
}
?>