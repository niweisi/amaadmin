define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	
	/*原内核URL处理*/
	function getQueryString_box(url,name) {
			url = url.split('?');
			url = '?'+url[1];
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		var r = url.substr(1).match(reg);
		if (r != null) return unescape(r[2]); return null;
	}
	if($("#metcmsbox").length>0&&$("#metcmsbox").attr("data-iframeurl")!=''){
		var u = $("#metcmsbox").attr("data-iframeurl"),
			h = '<iframe src="'+u+'" frameborder="0" id="main" name="main" scrolling="no"></iframe>',
			a = getQueryString_box(u,'anyid'),
			d = $("#metnav_"+a);
			d.addClass('on');
			if(d.parents("dl.jslist").length>0){
				d.parents("dl.jslist").find("dt").addClass("on");
			}
			$(".metcms_cont_right_box_box").html(h);
	}
	
	/*链接处理*/
	function aclick(d){
		var z = siteurl+ret['admin']+'/index.php?',u = d.attr("href");
		if(u.indexOf(z)==-1){
			var h = '<iframe src="'+u+'" frameborder="0" id="main" name="main" scrolling="no"></iframe>';
			$(".metcms_cont_right_box_box").html(h);
			ula.removeClass('on');
			d.addClass('on');
		}else{
			window.location.href=u;
		}
	}
	
	/*侧栏*/
	function leftsideshow(dl,t){
		var dd = dl.find("dd");
		$(".metcms_cont_left dl.jslist dd").stop(true,true);
		$(".metcms_cont_left dl.jslist").removeClass('on');
		dl.addClass('on');	
		if(t==1){
			$(".metcms_cont_left dl.jslist dd").hide();
			dd.show(); 
		}else{
			dd.show(); 
		}
	}
	
	var times,times1;
	$(".metcms_cont_left dl.jslist").hover(
		function(){
			clearTimeout(times);
			var dl=$(this),dd = $(this).find("dd");
				if(dd.is(":hidden")){
					times1 = setTimeout(function () {
						$(".metcms_cont_left dl.jslist dd").hide();
						leftsideshow(dl);
					}, 200);
				}
		},
		function(){
			clearTimeout(times1);
			var dd = $(this).find("dd");
			times = setTimeout(function() {
				dd.hide()
			}, 300)
		}
	);
	
	function leftsidedefulate(){
		var ai = $("#metcmsbox").attr("data-anyid");
		var dm = $("#metnav_"+ai);
		if(dm.parents("dl.jslist").length>0){
			dm.parents("dl.jslist").find("dt").addClass("on");
		}
		//leftsideshow(dm.parents("dl.jslist"),1);
		dm.addClass("on");
	}
	leftsidedefulate();

	
	/*左右等高*/
	function boxheit(){
		var dh = $('.metcms_cont_right_box').height();
		var wh = $(window).height()-50-50;
		if(dh<wh){
			$('.metcms_cont_right_box').css("min-height",wh+"px");
		}
		wh = $('.metcms_cont_left').height();
		if(dh<wh){
			$('.metcms_cont_right_box').css("min-height",wh+"px");
			$('.metcms_cont_left dl:last').css("border-bottom","0px");
		}else{
			//$('.metcms_cont_left dl:last').css("border-bottom","1px solid #ccc");
		}
	}
	//boxheit();
	$('.metcms_cont_right_box').css("min-height",$('.metcms_cont_left').height()-8+'px');

	
	/*语言下拉*/
	var langtime;
	$(".metcms_top_right_box li.lang").hover(function(){
		clearTimeout(langtime);
		var dl = $(this).find("dl");
		langtime = setTimeout(function () { dl.show();  }, "200");
	},function(){
		clearTimeout(langtime);
		var dl = $(this).find("dl");
		dl.hide();
		//langtime = setTimeout(function () { dl.hide();  }, "200");
	});
	
	if($(window).width()<1100){
		$(".metcms_cont").css('width','99%');
		$(".metcms_top_box").css('width','99%');
	}
	
	/*加载完成显示页面*/
	$("#metcmsbox").css("visibility",'visible');
	
});
