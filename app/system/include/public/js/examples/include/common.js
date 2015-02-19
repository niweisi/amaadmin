define(function(require, exports, module) {

	var $ = require('jquery');
		require('epl/include/jquery-migrate-1.2.1.min');//增加对$.browser.msie的支持
		require('epl/include/cookie');
		
	/*全局变量*/
	window.adminlang = $.cookie('langset');
	window.own_form  = $("#metcmsbox").attr("data-own_form");
	window.own_name  = $("#metcmsbox").attr("data-own_name");
	window.apppath   = $("#metcmsbox").attr("data-apppath");
	window.adminurl  = $("#metcmsbox").attr("data-adminurl");
	window.tem       = $("#metcmsbox").attr("data-tem");
	
	/*加载控件*/
	exports.modexecution = function(){
	
		var f;
		/*标签增加器*/
		if($('.ftype_tags').length>0){
			f = require.async('epl/tags/tags',function(d){
				d.execution();
			});
		}
		
		/*表格控件*/
		if($('.ui-table').length>0){
			f = require.async('epl/table/table',function(d){
				d.execution();
			});
		}
		
		/*操作成功，失败提示信息*/
		if($('.returnover').length>0)require.async('epl/include/ptips');
			
		/*表单验证*/
		if($('form.ui-from').length>0)require.async('epl/form/form');
		
		/*上传组件*/
		if($('.ftype_upload .fbox input').length>0)require.async('epl/uploadify/upload');
		
		/*编辑器*/
		if($('.ftype_ckeditor .fbox textarea').length>0)require.async('epl/ckeditor/ckeditor');
		
		/*颜色选择器*/
		if($('.ftype_color').length>0){
			f = require.async('epl/colorpicker/colorpicker',function(d){
				d.execution();
			});
		}
		
		/*滑块*/
		if($('.ftype_range .fbox input').length>0)require.async('epl/range/range');
		
		/*日期选择器*/
		if($('.ftype_day input').length>0)require.async('epl/time/time');
		
		/*联动菜单*/
		if($('.ftype_select-linkage .fbox').length>0)require.async('epl/select-linkage/select');
		
		/*升级控件*/	
		if($('.download').length>0)require.async('epl/include/download');
		
		/*自动补丁*/
		if($('#met_automatic_upgrade').val() == 1)require.async('epl/include/patch');
	}
	
	/*弹出框*/
	exports.remodal = function(){
		//alert(6);
		//require('epl/remodal/jquery.remodal.css');
		//require('epl/remodal/jquery.remodal.min');
		//var box = $('[data-remodal-id!='']');
	}
	
	/*数值转换为金额*/
	exports.fmoney = function(s, n){
		n = n > 0 && n <= 20 ? n : 2; 
		s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + ""; 
		var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1]; 
		t = ""; 
		for (i = 0; i < l.length; i++) { 
		t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : ""); 
		} 
		return '￥'+t.split("").reverse().join("") + "." + r; 
	} 
	
	/*列表自适应排版*/
	function listpun(zd,ld,min,i){
			i = i?i:1;
		var z= zd.width(),
			l= ld.length,
			h = parseInt(l/i),
			p = parseInt(z/h);
		if(p>min){
			var w = 1/h*100;
			w = w.toFixed(5)+'%';
			ld.css("width",w);
		}else{
			listpun(zd,ld,min,i+1);
		}
	}
	exports.listpun = function(zd,ld,min){//整体元素,列表元素,最小宽度
		listpun(zd,ld,min);
	}
	
	/*替换URL特定参数*/
	exports.replaceParamVal = function(Url,Name,Val){
		var re=eval('/('+ Name+'=)([^&]*)/gi');
		var nUrl = Url.replace(re,Name+'='+Val);
		return nUrl;
	}
	
	/*默认选中*/
	exports.defaultoption = function(box){
		function ckchuli(n,v){
			$("input[name='"+n+"'][value='"+v+"']").attr('checked',true);
		}
		var cklist = $("input[data-checked],select[data-checked]");
		if(box)cklist = box.find("input[data-checked],select[data-checked]");
		if(cklist.length>0){
			cklist.each(function(){
				var v = $(this).attr('data-checked'),n=$(this).attr('name'),t=$(this).attr('type');
				if(v!=''){
					if($(this)[0].tagName=='SELECT'){
						$(this).val(v);
					}
					if(t=='radio')ckchuli(n,v);
					if(t=='checkbox'){
						if(v.indexOf("|")==-1){
							ckchuli(n,v);
						}else{
							v = v.split("|");
							for (var i = 0; i < v.length; i++) {
								if(v[i]!=''){
									ckchuli(n,v[i]);
								}
							}
						}
					}
				}
			});
		}	
	}

	/*表格内容修改后自动勾选对应选项*/
	exports.modifytick = function(){
		var fints = $(".ui-table td input,.ui-table td select");
		if(fints.length>0){
			var nofocu = true;
			fints.each(function() {
				$(this).data($(this).attr('name'), $(this).val());
			});
			fints.focusout(function() {
				var tr = $(this).parents("tr");
				if ($(this).val() != $(this).data($(this).attr('name'))) tr.find("input[name='id']").attr('checked', nofocu);
			});
			$(".ui-table td input:checkbox[name!='id']").change(function(){
				var tr = $(this).parents("tr");
				tr.find("input[name='id']").attr('checked', nofocu);
			});
		}
	}
		
	/*等高*/
	function ifreme_methei(mh){
		
	}
	exports.ifreme_methei = function(mh){
		ifreme_methei(Number(mh));
	}
	
	/*语言文字*/
	exports.langtxt = function(){
		var bol = '';
			$.ajax({
				type: "GET",
				async:false,
				cache: false,
				dataType: "json",
				url: siteurl + 'cache/lang_json_admin_'+adminlang+'.php',
				success: function(json){
					bol = json;
				}
			});
		return bol;
	}

	/*页面效果初始化*/
	exports.defaultjs = function(){
		
		/*输入状态*/
		$(document).on('focus',"input[type='text'],input[type='input'],input[type='password'],textarea",function(){
			$(this).addClass('met-focus');
		});
		$(document).on('focusout',"input[type='text'],input[type='input'],input[type='password'],textarea",function(){
			$(this).removeClass('met-focus');
		});
		
		var dlp = '';
		/*浏览器兼容*/
		if($.browser.msie || ($.browser.mozilla && $.browser.version == '11.0')){  
			var v = Number($.browser.version);
			if(v<10){
				function dlie(dl){
					var dw;
					dl.each(function(){
						var dt = $(this).find("dt"),dd = $(this).find("dd");
						if(dt.length>0){
							dt.css({"float":"left","overflow":"hidden"});
							dd.css({"float":"left","overflow":"hidden"});
							var wd = $(this).width() - (dt.width()+30) - 15;
							dd.width(wd);
							dw = wd;
						}
					});
					dl.each(function(){
						var dt = $(this).find("dt"),dd = $(this).find("dd");
						if(dt.length>0){
							dd.width(dw);
						}
					});
				}
				var dl = $(".v52fmbx dl");
				dlie(dl);
				dlp = 1;
			}
			if(v<12){
				/*提示文字兼容*/
				function searchzdx(dom,label){
					if(dom.val()==''){
						label.show();
					}else{
						label.hide();
					}
					dom.keyup(function(){
						if($(this).val()==''){
							label.show();
						}else{
							label.hide();
						}
					});
					label.click(function(){
						$(this).next().focus();
					});
				}
				$(document).ready(function(){ 
					var pd = $("input[type!='hidden'][placeholder],textarea[placeholder]");
					pd.each(function(){
						var t = $(this).attr("placeholder");
						$(this).removeAttr("placeholder");
						$(this).wrap("<div class='placeholder-ie'></div>");
						$(this).before("<label>"+t+"</label>");
						searchzdx($(this),$(this).prev("label"));
					});
					setInterval(function(){
						pd.each(function(){
							searchzdx($(this),$(this).prev("label"));
						});
					}, "200"); 
				});
			}
		}
		
		/*宽度变化后调整*/
		$("body").attr("data-body-wd",$("body").width());
		$(window).resize(function() {
			if($("body").attr("data-body-wd")!=$("body").width()){
				if(dlp==1){
					dlie(dl);
				}else{
					ifreme_methei();
				}
				$(".ui-table").width("100%");
				$("body").attr("data-body-wd",$("body").width());
			}
		});
		
	}
});
