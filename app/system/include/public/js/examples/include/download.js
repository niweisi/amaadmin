define(function(require, exports, module) {
	var $ = require('jquery');
	var common = require('common');
	var langtxt = common.langtxt();

	require('tem/remodal/jquery.remodal.css');
	require('tem/remodal/jquery.remodal.min');
	
	var box = $('[data-remodal-id=modal]');

	$(document).on('click',".download",function(){
		var html = $(this);
		var data_download = html.attr('data-a-download');
		if(data_download){			
			if(data_download == 'end'){
				return true;
				/*
				if(data_download == 'complete_refresh'){
					html.html("安装完成,3秒后刷新页面");
					setTimeout(function (){parent.window.location.reload();},3000);
				}else{
					html.html('<a href='+ adminurl+'&n=myapp&c=myapp&a=doopen&no='+ +'>打开</a>');
				}
				*/
			}else{
				url = adminurl+'n=system&c=download&a=dodownload&data='+data_download;
				$.ajax({
					url: url,//新增行的数据源
					type: "POST",
					cache: false,
					dataType: "json",
					success: function(data) {
						html.attr('data-a-download',data.data);

						if(data.suc == 1){
							$(".download-noclick").html(data.html);
							html.html('');
						}else{
							$(".download-noclick").html('');
							html.html(data.html);
						}
						
						if(data.jsdo == 'confirm' || data.suc == 0){
							$(".temset_box").html(data.confirm);
							var inst = $.remodal.lookup[box.data('remodal')];
							inst.open();
						}	
						if(data.jsdo == 'refresh'){
							setTimeout(function (){parent.window.location.reload();},3000);
						}
						if (data.click == 1) {
							html.click();
						}
					}
				});
			}
		}
		return false;
	});
	
	$(document).on('click', "input[name='remodal-confirm']", function () {
		$.remodal.lookup[box.data('remodal')].close();
		$(".download").html('');
		$(".download-noclick").html(langtxt.detection+'...');
		setTimeout(function (){$('.download').click();},1000);
	});

	$(document).on('click', "input[name='remodal-cancel']", function () {
		$(".remodal-close").click();
	});
	$(document).on('click', '.remodal-close', function () {
		$(".download-noclick").html('');
		$(".download").html('<a href="#">'+langtxt.try_again+'</a>');
		var str = $(".download").attr('data-a-download');
		var data = str.split('|');
		$(".download").attr('data-a-download', str.replace('|doc|','|check|'));
	});	
});