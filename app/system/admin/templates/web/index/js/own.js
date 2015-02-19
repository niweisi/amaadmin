define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	var langtxt = common.langtxt();
	if($(".index_box").length>0){
		function chartwidth(){
			$(".index_stat_chart").width(function(){
				var dlw = $(".index_stat dl").width()-10;
				if($(window).width()>700)dlw = dlw - $(".index_stat_table").width();
				$(this).find("canvas").attr("width",dlw);
				return dlw;
			});
			require('tem/js/Chart.min');
			var cdm = document.getElementById("myChart");
			var ctx = cdm.getContext("2d");
			var myNewChart = new Chart(ctx).Line(jQuery.parseJSON(chartdata),{});
		}
		$(document).ready(function(){ 
			chartwidth();
		});

		$(".index_stat_table table tr").hover(function(){
			$(this).addClass("met_hover");
		},function(){
			$(this).removeClass('met_hover');
		});
		
		function metgetdata(d,url){
			var url = d.attr("data-newslisturl");
			d.html('Loading...');
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'jsonp',
				jsonp: 'jsoncallback',
				success: function(data) {
					d.empty();
					d.append(data.msg);
				}
			});
		}
		
		/*圆环进度条*/
		(function($){
		$.fn.sectorUI = function(options){
		var defaults = {
			speed:10
		}
		var options = $.extend(defaults, options); 

		this.each(function(){
			var t=$(this);
			clearInterval(this.timeO);
			clearInterval(this.timeT);
			var i=0,j=0;
			var nums=t.find(".center").data("value");
			var angle=(360/100)*nums;
			t.find(".partO").css(
			{"transform":"rotate("+i+"deg)",
			 "-ms-transform":"rotate("+i+"deg)",
			 "-moz-transform":"rotate("+i+"deg)",
			 "-webkit-transform":"rotate("+i+"deg)",
			 "-o-transform":"rotate("+i+"deg)",
			 "z-index":"0"});
			t.find(".partT").css(
			{"transform":"rotate("+j+"deg)",
			 "-ms-transform":"rotate("+j+"deg)",
			 "-moz-transform":"rotate("+j+"deg)",
			 "-webkit-transform":"rotate("+j+"deg)",
			 "-o-transform":"rotate("+j+"deg)"});

			this.timeO=setInterval(function(){
				if(i<=angle){
					if(i==180){t.find(".partO").css("z-index","2");}
					t.find(".partO").css(
					{"transform":"rotate("+i+"deg)",
					 "-ms-transform":"rotate("+i+"deg)",
					 "-moz-transform":"rotate("+i+"deg)",
					 "-webkit-transform":"rotate("+i+"deg)",
					 "-o-transform":"rotate("+i+"deg)"});
					i++;
				}else{
					clearInterval(this.timeO);
					clearInterval(this.timeT);
				}
			},options.speed);

			this.timeT=setInterval(function(){
				if(i>=180){
					if(j<=(angle-180)){
						t.find(".partT").css(
						{"transform":"rotate("+j+"deg)",
						 "-ms-transform":"rotate("+j+"deg)",
						 "-moz-transform":"rotate("+j+"deg)",
						 "-webkit-transform":"rotate("+j+"deg)",
						 "-o-transform":"rotate("+j+"deg)"});
						j++;
					}else{
						clearInterval(this.timeT);
					}
				}
			},options.speed);

		}); 
		}; 
		})(jQuery);

		$(function(){$(".Sector").sectorUI({speed:0});});
		
		$(".index_point ul li").hover(function(){
			$(this).find(".Sector").eq(0).sectorUI({speed:0});
		},function(){
		});
	
		$(document).ready(function(){ 
			/*获取推荐模板列表*/
			url = apppath + 'n=platform&c=platform&a=dotable_temlist_json&type=dlist&adminhome=1';
			$.ajax({
				type: "GET",
				cache: false,
				dataType: "jsonp",
				url: url,
				success: function(json){
					var html='',adu=apppath.split('index.php'),imgsrc='',price='';
					$.each(json, function(i, item){ 
						price  = item.price_html;
						imgsrc = item.icon;
						html+= '<li>';
						html+= '<dl><dt><a href="'+adminurl+'n=appstore&c=appstore&a=doappdetail&type=tem&no='+item.no+'&appid='+item.id+'&anyid=65" title="'+item.appname+'"><img src="'+imgsrc+'"></a></dt>';
						html+= '<dd><h4><a href="'+adminurl+'n=appstore&c=appstore&a=doappdetail&type=tem&no='+item.no+'&appid='+item.id+'&anyid=65" title="'+item.appname+'">'+item.appname+'</a></h4><h5>'+price+'<span>'+langtxt.attention+'&nbsp;'+item.hits+'</span></h5></dd></dl></a></li>'; 
					}); 
					$(".index_hottem ul").html(html);
					//$(".index_hottem dl").css("margin-left",($(".index_hottem li").width()-200)/2);
				}
			});
			
			/*推荐应用*/
			$.ajax({
				type: "GET",
				dataType: "jsonp",
				url: apppath + 'n=platform&c=platform&a=dotable_applist_json&type=dlist',
				success: function(json) {
					var html='',adu=apppath.split('index.php'),imgsrc='',price='';
					$.each(json, function(i, item){ 
						price  = item.price_html;
						imgsrc = item.icon;
						html+= '<li>';
						html+= '<dl><dt><a href="'+adminurl+'n=appstore&c=appstore&a=doappdetail&type=app&no='+item.no+'&anyid=65" title="'+item.appname+'"><img src="'+imgsrc+'"></a></dt>';
						html+= '<dd><h4><a href="'+adminurl+'n=appstore&c=appstore&a=doappdetail&type=app&no='+item.no+'&anyid=65" title="'+item.appname+'">'+item.appname+'</a></h4><h5>'+price+'</h5><h6>'+langtxt.installations+'&nbsp;' +item.download+'</h6></dd></dl></a></li>'; 
					}); 
					$(".index_hotapp ul").html(html);
					$(".index_hotapp dl").css("margin-left",($(".index_hotapp li").width()-200)/2);
				}
			});
			metgetdata($('#newslist'));
			

			var bdUrl = $(".bdsharebuttonbox").attr("data-bdUrl"),
				bdText = $(".bdsharebuttonbox").attr("data-bdText"),
				bdPic = $(".bdsharebuttonbox").attr("data-bdPic"),
				bdCustomStyle = $(".bdsharebuttonbox").attr("data-bdCustomStyle");
			window._bd_share_config={
				"common":{
					"bdUrl":bdUrl,
					"bdSnsKey":{},
					"bdText":bdText,
					"bdMini":"2",
					"bdMiniList":false,
					"bdPic":bdPic,
					"bdStyle":"2",
					"bdSize":"16"
				},
				"share":[{
					bdCustomStyle: bdCustomStyle
				}]
			};
			with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
			
		})
	
	}
});