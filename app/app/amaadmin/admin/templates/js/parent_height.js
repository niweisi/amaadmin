define(function(require, exports, module) {
	var $ = require('jquery');
	$(document).ready(function() {
	ifreme_methei();
	});
	function ifreme_methei(mh) {
		mh=mh?mh:0;
		var m = $("body").height();
		var l = $('.metcms_cont_left', parent.document).height();
		l = m < l ? l : m;
		l = l < mh ? mh : l;
		l = l + 260;
		$(window.parent.document).find("#main").height(l);
	}
});