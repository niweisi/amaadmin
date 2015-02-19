define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	var langtxt = common.langtxt();

	$(document).ready(function() {
		var ver = $('.v52fmbx').attr("data-metcms_v"),patch = $('.v52fmbx').attr("data-patch");
		var url = apppath+'n=platform&c=system&a=dosysnew'+'&ver='+ver+'&patch='+patch;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'jsonp',
			cache: false,
			success: function(data) {
				if(data.metok==1){
					$(".newpatch").html(langtxt.be_updated+data.metcms_v+'&nbsp;&nbsp;<span style="color:#2064e2;" class="download-noclick"></span><span style="color:#2064e2;" class="download" data-a-download="cms|new|doc|1|">'+langtxt.checkupdate+'</span>');
					$(".newpatch").css('color','#ff9600');
				}else{
					$(".newpatch").html(langtxt.latest_version);
				}
			}
		});
	})
});