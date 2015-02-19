define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('epl/colorpicker/js/colorpicker');
		require('epl/colorpicker/css/colorpicker.css');
	
	function ftype_color(){
		var d = $('.ftype_color');
		d.each(function(){
			var d,v,a,t,m;
			d = $(this).find('.fbox');
			if(d.find('.colorpickerbox').length==0){
				v = d.find('input').val();
				a = d.find('input').attr('name');
				t = '<div class="colorpickerbox"><div style="background-color: #ffffff"></div></div>';
				t+= d.html();
				t+= '<div class="clear"></div>';
				d.html(t);
				m = d.find('.colorpickerbox');
				m.find('div').css('backgroundColor', v);
				m.ColorPicker({
					color: v,
					onShow: function (c) {
						$(c).fadeIn(500);
						return false;
					},
					onHide: function (c) {
						$(c).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						m.find('div').css('backgroundColor', '#' + hex);//让选择器区块更换颜色
						$("input[name='"+a+"']").val('#'+hex);
					}
				});
			}
		});
	}
	exports.execution = function(){
		ftype_color();
	}
	
});