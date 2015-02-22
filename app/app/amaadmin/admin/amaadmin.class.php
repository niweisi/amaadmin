<?php
defined('IN_MET') or exit('No permission');//所有文件都是已这句话开头，保证系统单入口。

load::sys_class('admin');//包含后台基类，如果是前台包含web.class.php。‘.class.php’ 可以省略。

class amaadmin extends admin {//继承后台基类。类名称要与文件名一致
	public $jsonNavA,$navA,$json_ama_navuser,$ama_navuser,$admin_information,
	$feedbackNum,$messageNum,$vipNum;
    public function __construct() {
		global $_M;		
        parent::__construct();//如果重写了初始化方法,一定要调用父类的初始化函数。
		nav::set_nav(0, "首页", $_M['url']['own_form'].'a=doindex');
		nav::set_nav(1, "顶部导航编辑", $_M['url']['own_form'].'a=doama_edit_nav');
		nav::set_nav(2, "后台信息设置", $_M['url']['own_form'].'a=doadmin_edit');
		nav::set_nav(3, "查看后台", $_M['url']['own_form'].'a=doamaadmin');
		$this->admin_information = admin_information();//获取当前管理员信息数组
		$this->jsonNavA = '[
					{"id":1,"name":"常用功能","icon":"flatscreen","show":1,"enable":1,"url":"doamaadmin","no_order":"1"},
					{"id":2,"name":"产品","icon":"list","show":1,"enable":1,"url":"doama_product","no_order":"2"},
					{"id":3,"name":"内容","icon":"pencil","show":1,"enable":1,"url":"doama_content","no_order":"3"},
					{"id":4,"name":"互动","icon":"speech","show":1,"enable":1,"url":"doama_interaction","no_order":"4"},
					{"id":5,"name":"招聘","icon":"flatscreen","show":1,"enable":1,"url":"doama_job","no_order":"5"},
					{"id":6,"name":"订购","icon":"flatscreen","show":1,"enable":1,"url":"doama_order","no_order":"6"},
					{"id":7,"name":"会员","icon":"vip","show":1,"enable":1,"url":"doama_vip","no_order":"7"},
					{"id":8,"name":"设置","icon":"config","show":1,"enable":1,"url":"doama_config","no_order":"8"},
					{"id":9,"name":"推广","icon":"chart","show":1,"enable":1,"url":"doama_seo","no_order":"9"},
					{"id":10,"name":"手机网站","icon":"flatscreen","show":1,"enable":1,"url":"doama_wap","no_order":"10"}
		
		]';
		
		$this->navAadmin = jsondecode( $this->jsonNavA );
		
		//定义变量
		$ama_navuser = '{
				"1":{
					1:{"show":1,"enable":1,"no_order":1},
					2:{"show":1,"enable":1,"no_order":2},
					3:{"show":1,"enable":1,"no_order":3},
					4:{"show":1,"enable":1,"no_order":4},
					5:{"show":1,"enable":1,"no_order":5},
					6:{"show":1,"enable":1,"no_order":6},
					7:{"show":1,"enable":1,"no_order":7},
					8:{"show":1,"enable":1,"no_order":8},
					9:{"show":1,"enable":1,"no_order":9},
					10:{"show":1,"enable":1,"no_order":10},
				}
			} ';
		$nameConfig = 'amaadmin_navuser';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig ,$ama_navuser);
		$query = "SELECT * FROM {$_M['table']['config']} WHERE name='{$nameConfig}'";
		$one = DB::get_one($query);
		$this->json_ama_navuser = $one[value];		
			
		$this->ama_navuser = jsondecode( $this->json_ama_navuser );		

		$this->navAuser = $this->adminNav( $this->admin_information[id],$this->navAadmin, $this->ama_navuser);	
		
		$this->navA = arr_sort( $this->navAuser, $sort_key = 'no_order', $sort = SORT_ASC );	
		
		$this->feedbackNum = DB::counter($_M['table']['feedback'], "WHERE readok=0 AND lang='{$_M[lang]}'", "*");//未读反馈
		$this->messageNum = DB::counter($_M['table']['message'], "WHERE readok=0 AND lang='{$_M[lang]}'", "*");//未读留言
		$this->vipNum = DB::counter($_M['table']['admin_table'], "WHERE admin_ok=0 AND admin_approval_date IS NULL", "*");//新会员	
		
    }
	public function doindex(){//定义自己的方法
		global $_M;
		global $version;
		nav::select_nav(0);
		//$this->asaadminPermissions();//只有创始人可以访问
		//dump( get_adminnav());//获取后台导航栏目数组
		//dump( operation_column() );//获取当前管理员有权限操作的栏目信息。
		//dump( column_sorting(2) );//
		//echo jsonencode( $this->navA );
		//dump($this->navA);
		//dump( $this->contentList() );
		//dump($this->navAuser);
		//dump( $_M[user][cookie] );
		
		/*
		$curl = load::sys_class('curl', 'new'); //加载远程连接类
		$curl -> set('host', 'http://test.ts.ppblog.cn/'); //设置主机名
		$curl -> set('file', 'get/post.php'); //设置远程连接文件地址
		$post = array(
			'post' => 'yingyong',
			'thishost' => 'yingyong'		
		); //设置发送的post信息
		echo $curl -> curl_post( $post, $timeout = 30 ); //输出返回的请求信息
		*/
		
		//dump ( $shortcut );
		require_once $this->template('own/index');
		
	}
	//后台导航设置
	public function doama_edit_nav() {//
		global $_M;
		global $version;
		nav::select_nav(1);		
		$this->asaadminPermissions(2);
		$query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_type!=''";
		$admin_all = DB::get_all($query);
		
		require_once $this->template('own/ama_edit_nav');
	}
	public function doama_nav_json() {//
		global $_M;
		global $version;
		$this->asaadminPermissions(2);
		$table = load::sys_class('tabledata', 'new');
		
		$navAuser = $this->adminNav( $_M[form][search_admin],$this->navAadmin, $this->ama_navuser);		
		$navA = arr_sort( $navAuser, $sort_key = 'no_order', $sort = SORT_ASC );
		
		$array = $navA;
		foreach($array as $key => $val){
			$list = array();
			$list[] = "<input name=\"id\" type=\"checkbox\" value=\"{$val[id]}\">";
			$list[] = "<input type=\"text\" name=\"no_order-{$val[id]}\" class=\"ui-input met-center\" style=\"width:20px;\" value=\"{$val[no_order]}\">";
			$list[] = $val[name];			
			$isShow = $val[show]?'checked="checked"':'';
			$list[] = "<input name=\"show-{$val[id]}\" type=\"checkbox\" {$isShow} value=\"1\">";
			$isEnable = $val[enable]?'checked="checked"':'';
			$list[] = "<input name=\"enable-{$val[id]}\" type=\"checkbox\" {$isEnable} value=\"1\">";
			$rarray[] = $list;
		}	
		$table->rdata($rarray);
	}
	public function doama_nav_save() {//
		global $_M;
		global $version;
		$this->asaadminPermissions(2);
		foreach( $this->navAadmin as $val ){
			$this->ama_navuser[$_M[form][search_admin]][$val[id]][show] = $_M[form]['show-'.$val[id]];
			$this->ama_navuser[$_M[form][search_admin]][$val[id]][enable] = $_M[form]['enable-'.$val[id]];
			$this->ama_navuser[$_M[form][search_admin]][$val[id]][no_order] = $_M[form]['no_order-'.$val[id]];
		}
		$ama_navuser = jsonencode($this->ama_navuser);
		//定义变量
		$nameConfig = 'amaadmin_navuser';
		$langConfig = 'metinfo';	
		$this->updateConfig( $nameConfig, $langConfig ,$ama_navuser );
		turnover("{$_M[url][own_form]}a=doama_edit_nav", '操作成功！');
	}
	
	/**********/
	public function doadmin_edit() {//后台信息设置
		global $_M;
		global $version;
		nav::select_nav(2);	
		$this->asaadminPermissions();//只有创始人可以访问	
		require_once $this->template('own/admin_edit');
	}
	public function doadmin_form() {//后台信息设置保存表单
		global $_M;
		global $version;
		nav::select_nav(2);
		$this->asaadminPermissions();//只有创始人可以访问
		//定义变量
		$nameConfig = 'amaadmin_logo';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		//定义变量
		$nameConfig = 'amaadmin_logintitle';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		//定义变量
		$nameConfig = 'amaadmin_metinfo';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		//定义变量
		$nameConfig = 'amaadmin_logo_login';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		//定义变量
		$nameConfig = 'amaadmin_powered';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		//定义变量
		$nameConfig = 'amaadmin_loginmetinfo';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		//定义变量
		$nameConfig = 'amaadmin_powered_by';
		$langConfig = 'metinfo';	
		$this->insertConfig( $nameConfig, $langConfig );		
		$this->updateConfig( $nameConfig, $langConfig ,$_M[form][$nameConfig] );
		
		turnover("{$_M[url][own_form]}a=doadmin_edit", '操作成功！');		
	}
	
	//后台页面开始*********************************
	public function doamaadmin() {//定义自己的方法
		global $_M;
		global $version;
		nav::select_nav(3);
		$currentId = 1;	
		$shortcutA = jsondecode( $this->admin_information[admin_shortcut] );
		
		foreach ( $shortcutA as $val ){
			if( $val[name] == 'lang_tmptips' ) continue;
			$shortcut[] = $val;
		}
		
		require_once $this->template('own/amaadmin');
	}
	public function doama_index() {//默认框架中首页
		global $_M;
		global $version;
		$lanmu_link = $this->contentList();
				
		$query = "SELECT * FROM {$_M['table']['visit_summary']}";
		$visit_summary_all = DB::get_all($query);
		$visit_summary_stattime = arr_sort($visit_summary_all, 'stattime',  SORT_DESC) ;
		$visit_summary_pv = arr_sort($visit_summary_all, 'pv',  SORT_DESC) ;
		$visit_summary_ip = arr_sort($visit_summary_all, 'ip',  SORT_DESC) ;
		$visit_summary_alone = arr_sort($visit_summary_all, 'alone',  SORT_DESC) ;
		
		$visit_summary_pv_date = date("Y-m-d",$visit_summary_pv[0][stattime] ) ;
		$visit_summary_ip_date = date("Y-m-d",$visit_summary_ip[0][stattime] ) ;
		$visit_summary_alone_date = date("Y-m-d",$visit_summary_alone[0][stattime] ) ;
		
		foreach( $visit_summary_all as $val ){
			$visit_summary_pv_us += (integer)$val[pv];
			$visit_summary_ip_us += (integer)$val[ip];
			$visit_summary_alone_us += (integer)$val[alone];
		}
		
		$todayCapita = (float)$visit_summary_stattime[0][pv]/(float)$visit_summary_stattime[0][alone];//今日人均浏览次数
		$yesterdayCapita = (float)$visit_summary_stattime[1][pv]/(float)$visit_summary_stattime[1][alone];//昨日人均浏览次数
		
		require_once $this->template('own/ama_index');
	}
	public function doama_product() {//产品
		global $_M;
		global $version;
		$currentId = 2;
		$this->navPermissions( $currentId );//当前用户是否可用
		
		//侧栏		
		$sidebarNav = array();
		$sidebarA = $this->contentList();
		foreach( $sidebarA[class1] as $val ){
			if($val[module]!=3){ continue; }//不输出产品模型
			$sidebarNav[$val[id]] = $val;
			$sidebarNav[$val[id]][child] = $sidebarA[class2][$val[id]];
			foreach( $sidebarNav[$val[id]][child] as $val2 ){
				$sidebarNav[$val[id]][child][$val2[id]][child] = $sidebarA[class3][$val2[id]];
			}
			
		}
		$sidebarNavA = get_adminnav();//获取后台导航栏目数组
		$addSID = 33;//增加回收站
		$sidebarNav[9900+$addSID] = $sidebarNavA[$addSID];
		$sidebarNav[9900+$addSID][conturl] = $sidebarNavA[$addSID][url].'&module=3#';
		
		$site_adminUrl = $_M[site_admin];
		$conturl = 'conturl';
		$anyid29 = '29';
		require_once $this->template('own/ama_product');
	}
	public function doama_content() {//内容
		global $_M;
		global $version;
		$currentId = 3;
		$this->navPermissions( $currentId );//当前用户是否可用
		//侧栏
		$sidebarNav = array();
		$sidebarA = $this->contentList();
		foreach( $sidebarA[class1] as $val ){
			if($val[module]==3){ continue; }//不输出产品模型
			$sidebarNav[$val[id]] = $val;
			$sidebarNav[$val[id]][child] = $sidebarA[class2][$val[id]];
			foreach( $sidebarNav[$val[id]][child] as $val2 ){
				$sidebarNav[$val[id]][child][$val2[id]][child] = $sidebarA[class3][$val2[id]];
			}
			
		}
		$sidebarNavA = get_adminnav();//获取后台导航栏目数组
		$addSID = 33;//增加回收站
		$sidebarNav[9900+$addSID] = $sidebarNavA[$addSID];
		$sidebarNav[9900+$addSID][conturl] = $sidebarNavA[$addSID][url].'&module=2#';
		
		$site_adminUrl = $_M[site_admin];
		$conturl = 'conturl';
		$anyid29 = '29';
		require_once $this->template('own/ama_content');
	}
	public function doama_interaction() {//互动
		global $_M;
		global $version;
		$currentId = 4;
		$this->navPermissions( $currentId );//当前用户是否可用
		//侧栏
		$sidebarNav = array();
		$sidebarA = $this->contentList();
		foreach( $sidebarA[class1] as $val ){
			if($val[module]==7 || $val[module]==8){ //只输出反馈和留言
				$sidebarNav[$val[id]] = $val;
			}
		}
		foreach( $sidebarA[class2] as $val ){
			foreach( $val as $val2 ){				
				if($val2[module]==7 || $val2[module]==8){ //只输出反馈和留言
					$sidebarNav[$val2[id]] = $val2;
				}				
			}
		}
		foreach( $sidebarA[class3] as $val ){
			foreach( $val as $val2 ){				
				if($val2[module]==7 || $val2[module]==8){ //只输出反馈和留言
					$sidebarNav[$val2[id]] = $val2;
				}				
			}
		}
		
		$sidebarNavA = get_adminnav();//获取后台导航栏目数组
		$addSID = 71;//增加-在线客服
		if($sidebarNavA[$addSID]){
			$sidebarNav[9900+$addSID] = $sidebarNavA[$addSID];
			$sidebarNav[9900+$addSID][conturl] = $sidebarNavA[$addSID][url].'#';
		}
		
		$site_adminUrl = $_M[site_admin];
		$conturl = 'conturl';
		$anyid29 = '29';
		require_once $this->template('own/ama_interaction');
	}
	public function doama_job() {//招聘
		global $_M;
		global $version;
		$currentId = 5;
		$this->navPermissions( $currentId );//当前用户是否可用
		//侧栏
		$sidebarNav = array();
		$sidebarA = $this->contentList();
		foreach( $sidebarA[class1] as $val ){
			if($val[module]==6){ //只输出反馈和留言
				$sidebarNav[$val[id]] = $val;
			}
		}
		foreach( $sidebarA[class2] as $val ){
			foreach( $val as $val2 ){				
				if($val2[module]==6){ //只输出反馈和留言
					$sidebarNav[$val2[id]] = $val2;
				}				
			}
		}
		foreach( $sidebarA[class3] as $val ){
			foreach( $val as $val2 ){				
				if($val2[module]==6){ //只输出反馈和留言
					$sidebarNav[$val2[id]] = $val2;
				}				
			}
		}
		foreach( $sidebarNav as $val ){
			$joburl = $val[conturl];
		}
		
		
		$anyid29 = '29';
		require_once $this->template('own/ama_job');
	}
	public function doama_order() {//订购
		global $_M;
		global $version;
		$currentId = 6;
		$this->navPermissions( $currentId );//当前用户是否可用
		require_once $this->template('own/ama_order');
	}
	public function doama_vip() {//会员
		global $_M;
		global $version;
		$currentId = 7;
		$this->navPermissions( $currentId );//当前用户是否可用
		require_once $this->template('own/ama_vip');
	}
	public function doama_config() {//设置
		global $_M;
		global $version;
		$currentId = 8;
		$this->navPermissions( $currentId );//当前用户是否可用
		$sidebarNavA = get_adminnav();//获取后台导航栏目数组
		$adminPower = background_privilege();//获取管理员权限
		$navigation = explode('|',$adminPower[navigation]);
		foreach( $sidebarNavA as $val ){
			if( $val[bigclass] == 5 && ( in_array( $val[field],$navigation )|| $navigation[0]=='metinfo' ) ){
				$sidebarNav[$val[id]] = $val;
			}
		}
		$addSID = 12;//增加-网站安全与效率
		if($sidebarNavA[$addSID]){
			$sidebarNav[9900+$addSID] = $sidebarNavA[$addSID];
			$sidebarNav[9900+$addSID][conturl] = $sidebarNavA[$addSID][url].'#';
		}
		$addSID = 13;//增加-数据备份/恢复
		if($sidebarNavA[$addSID]){
			$sidebarNav[9900+$addSID] = $sidebarNavA[$addSID];
			$sidebarNav[9900+$addSID][conturl] = $sidebarNavA[$addSID][url].'#';
		}
		$addSID = 47;//增加-管理员管理
		if($sidebarNavA[$addSID]){
			$sidebarNav[9900+$addSID] = $sidebarNavA[$addSID];
			$sidebarNav[9900+$addSID][conturl] = $sidebarNavA[$addSID][url].'#';
		}
		
		$site_adminUrl = '';
		$conturl = 'url';
		$anyid29 = '';
		unset($sidebarNav[77]);//删除数组中的元素
		unset($sidebarNav[75]);
		//print_r($sidebarNavA);
		require_once $this->template('own/ama_config');
	}
	public function doama_seo() {//推广
		global $_M;
		global $version;
		$currentId = 9;
		$this->navPermissions( $currentId );//当前用户是否可用
		$sidebarNavA = get_adminnav();//获取后台导航栏目数组
		$adminPower = background_privilege();//获取管理员权限
		$navigation = explode('|',$adminPower[navigation]);
		foreach( $sidebarNavA as $val ){
			if( $val[bigclass] == 3 && ( in_array( $val[field],$navigation )|| $navigation[0]=='metinfo' ) ){
				$sidebarNav[] = $val;
			}
		}
		$site_adminUrl = '';
		$conturl = 'url';
		$anyid29 = '';
		
		require_once $this->template('own/ama_seo');
	}
	public function doama_wap() {//手机网站
		global $_M;
		global $version;
		$currentId = 10;
		$this->navPermissions( $currentId );//当前用户是否可用
		require_once $this->template('own/ama_wap');
	}
//公共方法
/**
 * 函数作用 判断后台当前管理员是否有访问权限，只有创始人可以访问  
 * @param  int	    $id    	  管理员id        
 */
	public function asaadminPermissions($id = 1){ 
		global $_M;
		global $version;
		if( $this->admin_information[id] !=1 && $this->admin_information[id] !=$id ) {
			turnover("{$_M[url][own_form]}a=doamaadmin", '您没权限！');
			exit;
		}
	}
/**
 * 函数作用 判断后台当前管理员是否有当前导航模块的访问权限                           
 * @param  int	    $currentId     	  导航id      
 */
	public function navPermissions( $currentId ){
		global $_M;
		global $version;
		if( $this->navAuser[$currentId-1][enable] !=1  ) {
			turnover("{$_M[url][own_form]}a=doamaadmin", '您没有购买此功能！');
			exit;
		}
	}
/**
 * 函数作用 组合指定后台管理员的后台导航                             
 * @param  int	    $adminId     	  管理员ID       
 * @param  array	$navAadmin     	  默认后台导航数组
 * @param  array	$navUser     	  指定管理员后台导航数组
 * @return array			  		  返回
 */
	public function adminNav( $adminId,$navAadmin,$navUser ){
		$navAuser = array();
		foreach( $navAadmin as $val ){
				$val[show] = $navUser[$adminId][$val[id]][show];
				$val[enable] = $navUser[$adminId][$val[id]][enable];
				$val[no_order] = $navUser[$adminId][$val[id]][no_order];			
			$navAuser[] = $val;			
		}
		return $navAuser;
	}
/**
 * 函数作用 向config表中插入变量                               
 * @param  string	$name     		  变量名称       
 * @param  string	$lang     		  所属语言，值为met_lang表mark字段值       
 * @param  string	$value    		  变量值       
 * @param  string	$mobile_value     手机版中变量值，部分自定义字段名称
 * @param  string	$columnid     	  所属栏目ID，（反馈，留言，招聘栏目）
 * @param  string	$flashid 		  FLASH配置信息所属ID
 * @return Boolean			  		  返回值，是否插入成功
 */
	public function insertConfig(				
							$name,
							$lang,
							$value = '',
							$mobile_value = null,
							$columnid = null,
							$flashid = null							
						){
		global $_M;
		
		$nameIsNull = DB::counter($_M['table']['config'], "WHERE name='{$name}'", "*");
		
		if( $nameIsNull == 0 ){
			$query = "INSERT INTO {$_M['table']['config']} (
							name, 
							value,
							mobile_value,
							columnid,
							flashid,
							lang
						) VALUES (
							'{$name}',
							'{$value}',
							'{$mobile_value}',
							'{$columnid}',
							'{$flashid}',
							'{$lang}'
						)";
			
			if(DB::query($query)){
				return true;
			}else{
				return false;
			}	
		}else {
			return false;
		}		
	}
/**
 * 函数作用 修改config表中插入变量                               
 * @param  string	$name     		  变量名称       
 * @param  string	$lang     		  所属语言，值为met_lang表mark字段值       
 * @param  string	$value    		  变量值       
 * @param  string	$mobile_value     手机版中变量值，部分自定义字段名称
 * @param  string	$columnid     	  所属栏目ID，（反馈，留言，招聘栏目）
 * @param  string	$flashid 		  FLASH配置信息所属ID
 * @return Boolean			  		  返回值，是否插入成功
 */
	public function updateConfig(
								$name,
								$lang,
								$value,
								$mobile_value = null,
								$columnid = null,
								$flashid = null
								){
		global $_M;
		$query = "UPDATE {$_M['table']['config']} SET 
					value='{$value}',
					mobile_value='{$mobile_value}',
					columnid='{$columnid}',
					flashid='{$flashid}' 
					WHERE name ='{$name}' AND lang = '{$lang}'";
		if(DB::query($query)){
			return true;
		}else{
			return false;
		}
		
	}
	
	
/*
返回带url的分类
*/
	public function contentList() {//返回带url的分类
		global $_M;
		$lang = $_M[lang];
		global $version;
		$url_content = 'content/';
		$sidebarA = column_sorting(2);
		foreach ($sidebarA[class1] as $key=>$val){//一级分类
			if($val['module']<9 && !$val['if_in']){
				$contentlistes[] = $val;
			}
		}
		foreach($contentlistes as $key=>$val){
				switch($val['module']){
					case '1':
						$val['url']=$url_content.'about/content.php?id='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'about/about.php?id='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '2':
							$val['url']=$url_content.'article/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'article/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '3':
						$val['url']=$url_content.'product/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'product/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '4':
						$val['url']=$url_content.'download/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'download/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
									<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '5':
						$val['url']=$url_content.'img/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'img/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
									<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '6':
						$val['url']=$url_content.'job/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'job/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['incurl']=$url_content.'job/inc.php?lang='.$lang.'&anyid='.$anyid;
						$val['cvurl']=$url_content.'job/cv.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div>
									<p class='lt'><a href='{$val[conturl]}'>{$lang_manager}</a></p><span>-</span>
									<p class='rt'><a href='{$val[cvurl]}'>{$lang_cveditorTitle}</a></p>
									</div>
									";
					break;
					case '7':
						$val['incurl']=$url_content.'message/inc.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'message/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtmsg}</a></div>";
					break;
					case '8':
						$val['url']=$url_content.'feedback/inc.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'feedback/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtfed}</a></div>";
					break;
				}
				$contentlist[$val[id]] = $val;
				
			}//一级分类结束
		foreach ($sidebarA[class2] as $key=>$val){//二级分类
			foreach ($sidebarA[class2][$key] as $key1=>$val1){
				if($val['module']<9 && !$val['if_in']){
					$contentlistes1[] = $val1;
				}
			}
		}
		
		foreach($contentlistes1 as $key=>$val){
				switch($val['module']){
					case '1':
						$val['url']=$url_content.'about/content.php?id='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'about/about.php?id='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '2':	
						if(!$val[releclass]){
							$val['url']=$url_content.'article/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'article/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
						}else{
							$val['url']=$url_content.'article/content.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'article/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
						}
						
					break;
					case '3':
						if(!$val[releclass]){
							$val['url']=$url_content.'product/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'product/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}else{
							$val['url']=$url_content.'product/content.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'product/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}
					break;
					case '4':
						if(!$val[releclass]){
							$val['url']=$url_content.'download/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'download/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}else{
							$val['url']=$url_content.'download/content.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'download/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}
					break;
					case '5':
						if(!$val[releclass]){
							$val['url']=$url_content.'img/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'img/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}else{
							$val['url']=$url_content.'img/content.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'img/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}
					break;
					case '6':
						$val['url']=$url_content.'job/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'job/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['incurl']=$url_content.'job/inc.php?lang='.$lang.'&anyid='.$anyid;
						$val['cvurl']=$url_content.'job/cv.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div>
									<p class='lt'><a href='{$val[conturl]}'>{$lang_manager}</a></p><span>-</span>
									<p class='rt'><a href='{$val[cvurl]}'>{$lang_cveditorTitle}</a></p>
									</div>
									";
					break;
					case '7':
						if(!$val[releclass]){
							$val['incurl']=$url_content.'message/inc.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'message/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtmsg}</a></div>";
						}else{
							$val['incurl']=$url_content.'message/inc.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'message/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtmsg}</a></div>";
						}
					break;
					case '8':
						if(!$val[releclass]){
							$val['url']=$url_content.'feedback/inc.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'feedback/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtfed}</a></div>";
						}else{
							$val['url']=$url_content.'feedback/inc.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'feedback/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtfed}</a></div>";
						}
					break;
				}
				$contentlist2[$val[bigclass]][$val[id]] = $val;
				}//二级分类end
		
		foreach ($sidebarA[class3] as $key=>$val){
			foreach ($sidebarA[class3][$key] as $key1=>$val1){
				if($val['module']<9 && !$val['if_in']){
					$contentlistes2[] = $val1;
				}
			}
		}
		foreach($contentlistes2 as $key=>$val){
				switch($val['module']){
					case '1':
						$val['url']=$url_content.'about/content.php?id='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'about/about.php?id='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
					break;
					case '2':	
						$column_types2=array();
						foreach($met_class2 as $key1=>$val1){
							foreach($val1 as $key11=>$val11){								
								if($val11[id]==$val[bigclass]){
									$column_types2=$met_class1[$key1];
								}
							}							
						}
						if($column_types2['module']!=$val['module']){
							$val['url']=$url_content.'article/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'article/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
						}else{
							$val['url']=$url_content.'article/content.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;	
							$val['conturl']=$url_content.'article/index.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
									<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
									</div>";
						}
						
					break;
					case '3':
						$column_types2=array();
						foreach($met_class2 as $key1=>$val1){
							foreach($val1 as $key11=>$val11){								
								if($val11[id]==$val[bigclass]){
									$column_types2=$met_class1[$key1];
								}
							}							
						}
						if($column_types2['module']!=$val['module']){
							$val['url']=$url_content.'product/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'product/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}else{
							$val['url']=$url_content.'product/content.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'product/index.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span><p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}
					break;
					case '4':
						$column_types2=array();
						foreach($met_class2 as $key1=>$val1){
							foreach($val1 as $key11=>$val11){								
								if($val11[id]==$val[bigclass]){
									$column_types2=$met_class1[$key1];
								}
							}							
						}						
						if($column_types2['module']!=$val['module']){
							$val['url']=$url_content.'download/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'download/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}else{
							$val['url']=$url_content.'download/content.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'download/index.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}
					break;
					case '5':
						$column_types2=array();
						foreach($met_class2 as $key1=>$val1){
							foreach($val1 as $key11=>$val11){								
								if($val11[id]==$val[bigclass]){
									$column_types2=$met_class1[$key1];
								}
							}							
						}
						if($column_types2['module']!=$val['module']){
							$val['url']=$url_content.'img/content.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'img/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}else{
							$val['url']=$url_content.'img/content.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'img/index.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div>
										<p class='lt'><a href='{$val[url]}'>{$lang_addinfo}</a></p><span>-</span>
										<p class='rt'><a href='{$val[conturl]}'>{$lang_manager}</a></p>
										</div>";
						}
					break;
					case '6':
						$val['url']=$url_content.'job/content.php?class1='.$val[id].'&action=add&lang='.$lang.'&anyid='.$anyid;
						$val['conturl']=$url_content.'job/index.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['incurl']=$url_content.'job/inc.php?lang='.$lang.'&anyid='.$anyid;
						$val['cvurl']=$url_content.'job/cv.php?class1='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
						$val['set']="<div>
									<p class='lt'><a href='{$val[conturl]}'>{$lang_manager}</a></p><span>-</span>
									<p class='rt'><a href='{$val[cvurl]}'>{$lang_cveditorTitle}</a></p>
									</div>
									";
					break;
					case '7':
						$column_types2=array();
						foreach($met_class2 as $key1=>$val1){
							foreach($val1 as $key11=>$val11){								
								if($val11[id]==$val[bigclass]){
									$column_types2=$met_class1[$key1];
								}
							}							
						}						
						if($column_types2['module']!=$val['module']){
							$val['incurl']=$url_content.'message/inc.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'message/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtmsg}</a></div>";
						}else{
							$val['incurl']=$url_content.'message/inc.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'message/index.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtmsg}</a></div>";
						}
					break;
					case '8':
						$column_types1=array();
						$column_types2=array();
						foreach($met_class2 as $key1=>$val1){
							foreach($val1 as $key11=>$val11){								
								if($val11[id]==$val[bigclass]){
									$column_types2=$met_class1[$key1];
								}
							}							
						}						
						if($column_types2['module']!=$val['module']){
							$val['url']=$url_content.'feedback/inc.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'feedback/index.php?class1='.$val[bigclass].'&class2='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtfed}</a></div>";
						}else{
							$val['url']=$url_content.'feedback/inc.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['conturl']=$url_content.'feedback/index.php?class1='.$column_types2[id].'&class2='.$val[bigclass].'&class3='.$val[id].'&lang='.$lang.'&anyid='.$anyid;
							$val['set']="<div><a href='{$val[conturl]}'>{$lang_eidtfed}</a></div>";
						}
					break;
				}
				$contentlist3[$val[bigclass]][$val[id]] = $val;
				}//三级分类end
		$sidebarA[class1] = $contentlist;
		$sidebarA[class2] = $contentlist2;
		$sidebarA[class3] = $contentlist3;
		return $sidebarA;
		
	}	
	
}
?>