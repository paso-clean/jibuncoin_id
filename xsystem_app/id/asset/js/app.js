$(function(){
	$(document).on('click','.btn-slide',function(){
		const slide_panel = $(this).data('panel');
		appSwiper.slideTo(slide_panel);
	});
});