<!--<?php
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
//PHP代码
//require_once $this->template('ui/head');//引用头部UI文件

echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script type="text/javascript" src="{$_M[url][site]}public/js/jQuery1.7.2.js?52107"></script>


<title>网站基本信息设置</title>

</head>
<body>

<div id="lanmu_link">
	<div class="lanmu_link_left">栏目快速管理</div>
	<ul id="test" class="columnlist">
<!--
EOT;
foreach( $lanmu_link[class1] as $val ) {
echo <<<EOT
-->
		<li class="contlist">
			<div class="box">
				<a href="{$val[conturl]}29">
					<img width="70" height="70" src="{$_M[url][site_admin]}templates/met/images/metv5/tubiao_{$val[module]}.png?new">
 
					<h2>{$val[name]}</h2>
				</a>
			</div>
		</li>
<!--
EOT;
}
echo <<<EOT
-->
		
 
	</ul>   
    
</div>
<div style="clear:both;"></div>
<div class="v52fmbx_tbmax">
<div class="v52fmbx_tbbox">
<table cellspacing="1" cellpadding="0" class="stat_table">
<tbody><tr>
	<td class="title" colspan="5">
	{$_M[word][statips42]}
	</td>
</tr>
	<tr class="j">
		<td width="18%" class="t"></td>
		<td width="20%" class="t">PV</td>
		<td width="20%" class="t">{$_M[word][statips21]}</td>
		<td width="20%" class="t">IP</td>
		<td width="20%" class="t">{$_M[word][statips22]}</td>
	</tr>
	<tr class="j">
		<td class="t">{$_M[word][statips10]}</td>
		<td>{$visit_summary_stattime[0][pv]}</td>
		<td>{$visit_summary_stattime[0][alone]}</td>
		<td>{$visit_summary_stattime[0][ip]}</td>
		<td>{$todayCapita}</td>
	</tr>
	<tr class="j">
		<td class="t">{$_M[word][statips11]}</td>
		<td>{$visit_summary_stattime[1][pv]}</td>
		<td>{$visit_summary_stattime[1][alone]}</td>
		<td>{$visit_summary_stattime[1][ip]}</td>
		<td>{$yesterdayCapita}</td>
	</tr>
	<tr>
		<td class="t">{$_M[word][statips43]}</td><!--每日平均-->
		<td>4</td>
		<td>1</td>
		<td>1</td>
		<td></td>
	</tr>
	<tr>
		<td class="t">{$_M[word][statips44]}</td><!--历史最高-->
		<td>{$visit_summary_pv[0][pv]}<span>({$visit_summary_pv_date})</span></td>
		<td>{$visit_summary_alone[0][alone]}<span>({$visit_summary_alone_date})</span></td>
		<td>{$visit_summary_ip[0][ip]}<span>({$visit_summary_ip_date})</span></td>
		<td></td>
	</tr>
	<tr>
		<td class="t">{$_M[word][statips45]}</td><!--历史累计-->
		<td>{$visit_summary_pv_us}</td>
		<td>{$visit_summary_alone_us}</td>
		<td>{$visit_summary_ip_us}</td>
		<td></td>
	</tr>
</tbody></table>
<table cellspacing="1" cellpadding="0" class="stat_table">
<tbody><tr>
	<td class="title">{$_M[word][statips46]}</td>
</tr>
<tr>
  <td id="charttd_td">
  <div style="height:270px;" id="charttd"><div id='chartContainer'></div></div>
  
  </td>
</tr>
</tbody></table>
</div>
</div>
<script language="JavaScript" src="{$_M[url][site_admin]}templates/met/images/Chart/js/FusionCharts.js"></script>
<script type="text/javascript">
$(document).ready(function(){	
	var wdth = $('#charttd').width()-20;
	var heth = '270';
   var chart = new FusionCharts("{$_M[url][site_admin]}templates/met/images/Chart/swf/FCF_MSLine.swf", "ChartId", wdth, heth);
   chart.setDataURL("{$_M[url][site_admin]}app/stat/data.php?action=time%26st={$visit_summary_stattime[0][stattime]}%26et={$visit_summary_stattime[0][stattime]}%26lang={$_M[lang]}");		   
   chart.render("chartContainer");
});
</script>


<link rel="stylesheet" type="text/css" href="{$_M[url][site_admin]}templates/met/images/css/metinfo.css"/>
<link rel="stylesheet" type="text/css" href="{$_M[url][site_admin]}templates/met/images/css/newstyle.css" />
<style>
#lanmu_link {
    background-color: #f5f5f5;
    background-image: url("{$_M[url][own]}admin/templates/images/lanmu_link_bg.jpg");
    background-position: left top;
    background-repeat: repeat-y;
    border: 1px solid #dfdfdf;
    margin: 10px 10px;
    overflow: hidden;
    position: relative;
}
#lanmu_link .lanmu_link_left {
    color: #000;
    float: left;
    font-size: 12px;
    height: 100%;
    left: 0;
    letter-spacing: 2em;
    line-height: 1.5em;
    margin: 8px 0 0 12px;
    position: absolute;
    text-align: center;
    top: 0;
    width: 17px;
}
#lanmu_link .columnlist {
    float: left;
    margin-left: 45px;
    overflow: hidden;
    padding: 12px 0;
}
#lanmu_link .columnlist li {
    margin: 0;
    width: 86px;
}
#lanmu_link .columnlist li a {
    padding: 0 !important;
    width: 84px;
}
.stat_table td {
	font-size:12px;
}
</style>
<script>
$(document).ready(function() {
	ifreme_methei();
});
	function ifreme_methei(mh) {
		mh=mh?mh:0;
		var m = $("body").height();
		var l = $('.metcms_cont_left', parent.document).height();
		l = m < l ? l : m;
		l = l < mh ? mh : l;
		l = l + 100;
		$(window.parent.document).find("#main").height(l);
	}
</script>
<!--
EOT;
require_once $this->template('own/footer');
require_once $this->template('ui/foot');//引用底部UI文件
?>