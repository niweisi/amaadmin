<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
require_once $this->template('ui/head');//引用头部UI文件
echo <<<EOT
-->

<form method="POST" class="ui-from" name="myform" action="{$_M[url][own_form]}a=doadmin_form" target="_self">
	<div class="v52fmbx">
		<h3 class="v52fmbx_hr">常用功能<span class="tips">描述文字，用于说明该设置的作用。</span></h3>
	
		
		
<!--简短文本输入框-->
		<dl>
			<dt>后台登陆页面title</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="amaadmin_logintitle" value="{$_M['config']['amaadmin_logintitle']}" placeholder="" data-required="1" />
				</div>
				<span class="tips"></span>
			</dd>
		</dl>
<!--简短文本输入框-->
		<dl>
			<dt>管理系统名称：</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="amaadmin_metinfo" value="{$_M['config']['amaadmin_metinfo']}" placeholder="" data-required="1" />
				</div>
				<span class="tips"></span>
			</dd>
		</dl>
<!--简短文本输入框-->
		<dl>
			<dt>理念：</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="amaadmin_loginmetinfo" value="{$_M['config']['amaadmin_loginmetinfo']}" placeholder="" data-required="1" />
				</div>
				<span class="tips"></span>
			</dd>
		</dl>
		<!--简短文本输入框-->
		<dl>
			<dt>版权所有：</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="amaadmin_powered" value="{$_M['config']['amaadmin_powered']}" placeholder="" data-required="1" />
				</div>
				<span class="tips"></span>
			</dd>
		</dl>

<!--上传组件-->
		<dl>
			<dt>后台logo</dt>
			<dd class="ftype_upload">
				<div class="fbox">
					<input 
						name="amaadmin_logo" 
						type="text" 
						data-upload-type="doupimg"
						value="{$_M['config']['amaadmin_logo']}" 
					/>
				</div>
				<span class="tips">修改AMA后台logo</span>
			</dd>
		</dl>
<!--上传组件-->
		<dl>
			<dt>登陆页面logo</dt>
			<dd class="ftype_upload">
				<div class="fbox">
					<input 
						name="amaadmin_logo_login" 
						type="text" 
						data-upload-type="doupimg"
						value="{$_M['config']['amaadmin_logo_login']}" 
					/>
				</div>
				<span class="tips"></span>
			</dd>
		</dl>
<!--编辑器（小）-->
		<dl>
			<dt>foot版权信息</dt>
			<dd class="ftype_ckeditor">
				<div class="fbox">
					<textarea name="amaadmin_powered_by" data-ckeditor-type="1">{$_M['config']['amaadmin_powered_by']}</textarea>
				</div>
				<span class="tips"></span>
			</dd>
		</dl>
		<dl class="noborder">
			<dt>&nbsp;</dt>
			<dd>
				<input type="submit" name="submit" value="保存" class="submit" />
			</dd>
		</dl>
	</div>
</form>


<!--
EOT;
require_once $this->template('ui/foot');//引用底部UI文件
?>