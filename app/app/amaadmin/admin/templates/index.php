<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
require_once $this->template('ui/head');//引用头部UI文件
echo <<<EOT
-->


<h3>前台模板</h3>


<!--
EOT;
require_once $this->template('ui/foot');//引用底部UI文件
?>