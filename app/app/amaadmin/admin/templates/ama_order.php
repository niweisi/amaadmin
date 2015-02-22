<!--<?php
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
//require_once $this->template('ui/head');//引用头部UI文件
require_once $this->template('own/header');
echo <<<EOT
-->
        
    <div class="centercontent noneleft">
    
        <iframe frameborder="0" scrolling="no" src="{$_M[site_admin]}content/job/index.php?lang={$_M[lang]}&class1=36&anyid=29" name="main" id="main" style="width:100%;"></iframe>
		
        
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->
<style>
body.withvernav {
	background-image: url();
}
</style>

<!--
EOT;
require_once $this->template('own/footer');
require_once $this->template('ui/foot');//引用底部UI文件
?>