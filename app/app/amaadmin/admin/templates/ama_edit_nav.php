<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
require_once $this->template('ui/head');//引用头部UI文件
echo <<<EOT
-->
<form method="POST" name="myform" class="ui-from" action="{$_M[url][own_form]}a=doama_nav_save" target="_self">
<div class="v52fmbx">
	<div class="v52fmbx-table-top">		
		<div class="ui-float-left">
			<select name="search_admin" data-table-search="1">
<!--
EOT;
foreach( $admin_all as $val ){
echo <<<EOT
-->
				<option value="{$val[id]}">{$val[admin_id]}</option>
<!--
EOT;
}
echo <<<EOT
-->
				
			</select>	
		</div>
	</div>
<table class="display dataTable ui-table" data-table-ajaxurl="{$_M[url][own_form]}a=doama_nav_json" data-table-pageLength="10">
    <thead>
        <tr>
			<th width="25" data-table-columnclass="met-center"><input name="id" data-table-chckall="id" type="checkbox" value="" /></th>
            <th width="25">排序</th>
            <th>名称</th>
            <th width="">显示</th>
			<th width="">可用</th>
        </tr>
    </thead>
	<tbody>
	</tbody>
    <tfoot>
        <tr>
            <th width="25" data-table-columnclass="met-center"><input name="id" data-table-chckall="id" type="checkbox" value="" /></th>
            <th width="">
				<input type="submit" name="save" value="保存排序" class="submit" />
				
			</th>
            <th>
			
			</th>
            <th width=""></th>
			<th width=""></th>
        </tr>
    </tfoot>
	
</table>
</div>
</form>
<!--
EOT;
require_once $this->template('ui/foot');//引用底部UI文件
?>