//模板设置快捷导航定位
$(document).ready(function() {
	
	var topint = 2;
	if($("#skedtype").size()>0){
		var navH = $("#skedtype").offset().top + topint; 
		$("#skedtype").wrap("<div style='height:45px'></div>");
		var dbox = new Array;
		$(".skedtype span").each(function(i){
			var sliding = $(this).attr('sliding');
				dbox[i] = $("h3[sliding='"+sliding+"']").offset().top - 40;
		});
		$(window.parent).scroll(function(){
			var scroH = $(this).scrollTop(); 
			if(scroH>navH){
				var scroZ=scroH-topint-5;
				$("#skedtype").css({
					position:'absolute',
					top: scroZ+'px'
				});
				$(".skedtype span").each(function(i){
					if(scroZ>dbox[i]){
						$(".skedtype span").removeClass('ond');
						$(this).addClass('ond');
					}
				});
			}else{
				$("#skedtype").css({
					position:''
				});
			}
			
		});
	}
	$(".skedtype span").click(function(){
		var sliding = $(this).attr('sliding');
		var top = $("h3[sliding='"+sliding+"']").offset().top-25;
		$("html",parent.document).animate({scrollTop: top}, 1000); 
		$("body",parent.document).animate({scrollTop: top}, 1000); 
	});
	submitTop();
	$(window.parent).scroll(function(){
		submitTop();
	});
	$(window.parent).resize(function(){
		submitTop();
	});
	function submitTop(){
		var scroH = $(window.parent).scrollTop();
		var parentH = $(window.parent).height();		
		var centercontent_top = parseInt($(".centercontent", window.parent.document).css("margin-top"));
		$("#main", window.parent.document).css("min-height",(parentH-centercontent_top )+'px');
		$(".v52fmbx_submit").css("top",( parentH+scroH-centercontent_top-54 )+'px');
	}
	
	
	
});