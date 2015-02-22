<!--<?php
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>{$_M[config][amaadmin_metinfo]}</title>
<link rel="stylesheet" href="{$_M[url][own]}admin/templates/amaadmin/css/style.default.css?ver={$version}" type="text/css" />
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/jquery.slimscroll.js"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/custom/general.js?ver={$version}"></script>
<script type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/custom/dashboard.js?ver={$version}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/excanvas.min.js"></script><![endif]-->
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href={$_M[url][own]}admin/templates/amaadmin/css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href={$_M[url][own]}admin/templates/amaadmin/css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="{$_M[url][own]}admin/templates/amaadmin/js/plugins/css3-mediaqueries.js"></script>
<![endif]-->

<script type="text/javascript">
var turnovertext = "{$_M[form][turnovertext]}";
var aa = "{$_M[form][a]}";
if(turnovertext!='') {
	alert(turnovertext);
	if(aa=='doamaadmin'){
		window.location.href = "{$_M[url][own_form]}a=doamaadmin";
	}
}
</script>

</head>

<body class="withvernav">
<div id="metcmsbox"></div>
<div class="bodywrapper">
    <div class="head">
    <div class="topheader">
        <div class="left">
            <h1 class="logo"><img src="{$_M[config][amaadmin_logo]}" /></h1>
            <span class="slogan admin">
            	您好，{$this->admin_information[admin_id]} |
                <a target="main" href="{$_M[site_admin]}admin/editor_pass.php?lang={$_M[langset]}&anyid=64">修改密码</a> |
                <a href="{$_M[site_admin]}login/login_out.php">退出</a>
            </span>
            
            <div class="headerwidget">
        	<div class="earnings">
            	<div class="one_half">
                	<a href="{$_M[url][site]}?met_mobileok=1&lang={$_M[lang]}" target="_blank" class="btn btn_orange btn_link"><span>浏览手机网站</span></a>
                </div><!--one_half-->
                <div class="one_half last alignright">
                	<a href="{$_M[url][site]}?lang={$_M[lang]}" target="_blank" class="btn btn_orange btn_world"><span>浏览网站</span></a>
                </div><!--one_half last-->
            </div><!--earnings-->
        	</div>
            
            <br clear="all" />
            
        </div><!--left-->
     
        <div class="right">
        	
            <div class="userinfo">
            	<img style="border:0 none;" src="{$_M[url][site]}public/images/flag/{$_M[langlist][web][$_M[lang]][flag]}" alt="" />
                <span>{$_M[langlist][web][$_M[lang]][name]}</span>
            </div><!--userinfo-->
            
            <div class="userinfodrop" style="padding:0;">
            	
                <div class="userdata">
                    <ul>
<!--
EOT;
foreach( $_M[langlist][web] as $val ){
echo <<<EOT
--> 
                    	<li>
                          <a href="{$_M[url][site_admin]}?lang={$val[lang]}&anyid={$_M[form][anyid]}&n={$_M[form][n]}&c={$_M[form][c]}&a={$_M[form][a]}">
                            <span><img src="{$_M[url][site]}public/images/flag/{$val[flag]}" alt="" /></span>
                            <span>{$val[name]}</span>
                          </a>
                        </li>
<!--
EOT;
}
echo <<<EOT
--> 
                    </ul>
                </div><!--userdata-->
            </div><!--userinfodrop-->
        </div><!--right-->
    </div><!--topheader-->
    
    
    <div class="header">
    	<ul class="headermenu">
<!--
EOT;
foreach( $this->navA as $val ){
	$url = "{$_M[url][own_form]}a={$val[url]}";
	$current = '';
    $title = '';
	if( $val[id] == $currentId ){ $current = 'current'; }
    if( $val[show]!=1 ) continue;
    if( $val[enable]!=1 ) { 
    	$current = 'disable'; 
        $url = 'javascript:void(0)';
        $title = "您没有购买此功能！";
    }else{
        $display_block = '';
        $num = '';
        if( ( $this->feedbackNum > 0 || $this->messageNum > 0 ) && $val[id]==4 ){
            $display_block = 'style="display:block;"';
            $num = $this->feedbackNum + $this->messageNum ;
        }elseif( $this->vipNum > 0 && $val[id]==7 ){
            $display_block = 'style="display:block;"';
            $num = $this->vipNum ;
        }
        
        if( $num>99 ){
            $num = '...';
        }
    }
echo <<<EOT
-->
        	<li id="aaa{$val[id]}" class="{$current}">
            	<a href="{$url}" title="{$title}">
                <span class="icon icon-{$val[icon]}"></span>{$val[name]}</a>
                <span class="icon-ts" {$display_block}>{$num}</span>
            </li>
<!--
EOT;
}
echo <<<EOT
--> 
        </ul>
        
        <div class="headerwidget">
        	<div class="earnings">
            	<div class="one_half">
                	<a href="{$_M[url][site]}?met_mobileok=1&lang={$_M[lang]}" target="_blank" class="btn btn_orange btn_link"><span>浏览手机网站</span></a>
                </div><!--one_half-->
                <div class="one_half last alignright">
                	<a href="{$_M[url][site]}?lang={$_M[lang]}" target="_blank" class="btn btn_orange btn_world"><span>浏览网站</span></a>
                </div><!--one_half last-->
            </div><!--earnings-->
        </div>
        
        
    </div><!--header-->
    </div>
<!--
EOT;
?>