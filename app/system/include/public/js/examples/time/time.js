define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('epl/time/moment.min');
		require('epl/time/daterangepicker');
		require('epl/time/daterangepicker-bs3.css');
	
	var d = $('.ftype_day input');
	d.each(function(){
		var t = $(this).attr("data-day-type");
			t = t?Number(t):1;
		$(this).before('<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>');
		switch(t){
			case 1:
				$(this).daterangepicker(
					{ 
						format: 'YYYY-MM-DD',
						showDropdowns:true,
						singleDatePicker: true 
					}, 
					function(start, end, label) {
						common.ifreme_methei();
						//console.log(start.toISOString(), end.toISOString(), label);
					}
				);
			break;
			case 2:
				$(this).daterangepicker(
					{ 
						format: 'YYYY-MM-DD H:mm',
						showDropdowns:true,
						timePicker:true,
						timePicker12Hour:false,
						singleDatePicker: true 
					}, 
					function(start, end, label) {
						common.ifreme_methei();
						//console.log(start.toISOString(), end.toISOString(), label);
					}
				);
			break;			
		}
	});
	d.focus(function() {
		var t = $(this).attr("data-day-type");
			t = t?Number(t):1;
		var n = $('body').height()-$(this).offset().top,h=t==2?380:300;
		var mh=0;
		if(n<h){
			mh=$('body').height()+(h-n);
		}
		common.ifreme_methei(mh);
	});
	
});