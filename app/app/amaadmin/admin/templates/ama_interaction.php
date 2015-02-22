<!--<?php
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
//require_once $this->template('ui/head');//引用头部UI文件
require_once $this->template('own/header');
require_once $this->template('own/sidebar');
echo <<<EOT
-->

    <div class="centercontent">
    
        <iframe frameborder="0" scrolling="no" src="{$mainUrl}" name="main" id="main" style="width:100%;"></iframe>
        
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->


<!--
EOT;
require_once $this->template('own/footer');
require_once $this->template('ui/foot');//引用底部UI文件
?>