<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
 * ��ȡCOOKIEֵ
 * @param  string  $key                             ָ����ֵ
 * @return string  $_M['user']['cookie'][$key]	    ���ص�ǰ����Ա���Ա�����COOKIEֵ
 * ����get_met_cookie('metinfo_admin_name'):���ص�ǰ����Ա���˺�
	   get_met_cookie('metinfo_member_name'):���ص�ǰ��Ա���˺�
	   get_met_cookie('metinfo_admin_pass'):���ص�ǰ����Ա������
	   get_met_cookie('metinfo_member_pass'):���ص�ǰ��Ա������
 */
function get_met_cookie($key){
	global $_M;
	if($key == 'metinfo_admin_name' || $key == 'metinfo_member_name'){
		$val = urldecode($_M['user']['cookie'][$key]);
		$val = sqlinsert($val);
		return $val;
	}
	return $_M['user']['cookie'][$key];
}

/**
 * �ж�COOKIE�Ƿ񳬹�һ��Сʱ�����û�г��������$_M['user']['cookie']�е���Ϣ
 */
function met_cooike_start(){
	global $_M;
	$_M['user']['cookie'] = array();
	$met_webkeys = $_M['config']['met_webkeys'];
	list($username, $password) = explode("\t",authcode($_M['form']['met_auth'], 'DECODE', $met_webkeys.$_COOKIE['met_key']));
	$username=sqlinsert($username);
	$query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$username}'";
	$user = DB::get_one($query);
	$usercooike = json_decode($user['cookie']);
	if(md5($user['admin_pass']) == $password && time()-$usercooike->time<3600){
		foreach($usercooike as $key=>$val){
			$_M['user']['cookie'][$key] = $val;
		}
		if(defined('IN_ADMIN')){
			$_M['user']['admin_name'] = $_M['user']['cookie']['metinfo_admin_name'];
			$_M['user']['admin_id'] = $_M['user']['cookie']['metinfo_admin_id'];
			$privilege = background_privilege();
			$_M['user']['langok'] = $privilege['langok'];
		}
		$_M['user']['cookie']['time'] = time();
		$json = json_encode($_M['user']['cookie']);
		$query = "update {$_M['table']['admin_table']} set cookie = '{$json}' WHERE admin_id = '{$username}'";
		$user = DB::query($query);
	}
}

/**
 * ���COOKIE
 * @param  int $userid �û�ID    
 */
function met_cooike_unset($userid){
	global $_M;
	$met_admin_table = $_M['table']['admin_table'];
	$userid = sqlinsert($userid);
	$query = "UPDATE {$_M['table']['admin_table']} set cookie = '' WHERE admin_id='{$userid}' AND usertype = '3'";
	DB::query($query);
	met_setcookie("met_auth",'',time()-3600);
	met_setcookie("met_key",'',time()-3600);
	met_setcookie("appsynchronous",0,time()-3600,'');
	unset($_M['user']['cookie']);
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>