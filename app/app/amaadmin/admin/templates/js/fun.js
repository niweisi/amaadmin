jQuery(window).resize(function(){
  	headHeight();
});
function headHeight(){
	
	var headH = jQuery(".head").height();
	jQuery(".iconmenu").css("top",headH);
	jQuery(".iconmenu1").css("top",headH);
	jQuery(".centercontent").css("margin-top",headH);
}