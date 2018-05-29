document.documentElement.className = 'js';
jQuery(function ($) {
	
	//Accodion Arrow change
	$('.accordion').on('show hide', function(e){
		$(e.target).siblings('.tab-head').find('.accordion-toggle i').toggleClass('icon-angle-down icon-angle-up', 200);
	});
		 
	 //table checkbox-active
	 $(".js-admin-select-all").click(function(){
		$(".js-checkbox-active").attr('checked',true);										  
	});
	 
	 $(".js-admin-none-all").click(function(){
		$(".js-checkbox-active").attr('checked',false);										  
	});
  

});