<!--<?php
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
//require_once $this->template('ui/head');//引用头部UI文件
require_once $this->template('own/header');
echo <<<EOT
-->
    <div class="vernav vernav-current iconmenu1">
		
    	<ul>
<!--
EOT;
foreach($shortcut as $val ){
	$val[name] = $_M[word][substr( $val[name], 5 )];
	if( $val[hidden] == 1 ) continue;
echo <<<EOT
-->
       	  <li class="main-show"><a href="{$val[url]}" class="editor" target="main">{$val[name]}</a></li>
<!--
EOT;
}
echo <<<EOT
-->
			<li class=""><a href="system/shortcut.php?anyid=54&lang={$_M[lang]}" target="main" class="editor">{$_M[word][shortcut]}</a></li>
        </ul>
		<div class="ver-tab">
		  <table cellspacing="0" cellpadding="0" border="0" class="stdtable" >
			  <thead>
				  <tr>
					  <th class="head0">程序名称</th>
				  </tr>
			  </thead>
			  <tbody>
				  <tr>
					  <td>{$_M[config][amaadmin_metinfo]}</td>
				  </tr>			   
			  </tbody>
		  </table>		  
		</div>
		<div class="ver-tab">		  
		  <table cellspacing="0" cellpadding="0" border="0" class="stdtable" >
			<thead>
				<tr>
					<th class="head0">版权信息</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{$_M[config][amaadmin_powered]}</td>
				</tr>			   
			</tbody>
		  </table>
		</div>
      <a class="togglemenu"></a>
    </div><!--leftmenu-->
<style>    
.stdtable tbody tr td {
	/*padding:8px 6px;*/
}
.ver-tab{
	margin:10px;
}
.menucoll .ver-tab{
	display:none;
}
</style>		
    <div class="centercontent">
		<!--
		<div class="contentwrapper">
				<ul class="shortcuts">
					<li><a class="settings" href="#"><span>Settings</span></a></li>
					<li><a class="users" href="#"><span>Users</span></a></li>
					<li><a class="gallery" href="#"><span>Gallery</span></a></li>
					<li><a class="events" href="#"><span>Events</span></a></li>
					<li><a class="analytics" href="#"><span>Analytics</span></a></li>
				</ul>
		</div>
		-->
        <iframe frameborder="0" scrolling="no" src="{$_M[url][own_form]}a=doama_index" name="main" id="main" style="width:100%;"></iframe>
        
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->


<!--
EOT;
require_once $this->template('own/footer');
require_once $this->template('ui/foot');//引用底部UI文件
?>