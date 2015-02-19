define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	require('epl/font-awesome/css/font-awesome.min.css');//图标字体

	require('epl/include/box');
	
	common.defaultjs();//页面初始效果处理
	
	common.modexecution();//组件加载
	
	require('tem/js/own');//加载默认文件

	
});
