jQuery(function($){

	/*----------- Default Functions ----------*/
	$.fn.isInViewport=function(){var t=$(this).offset().top+100,i=t+$(this).outerHeight(),o=$(window).scrollTop(),n=o+$(window).height();return i>o&&t<n};

	const stickyFooter = () => {
		$('body').height() < $(window).outerHeight() ? $('.site-footer').addClass('sticky') : $('.site-footer').removeClass('sticky');
	}

	function smoothScroll(){$(".anim").each(function(){
		$(this).isInViewport()&&$(this).addClass("screen-in")}
	)}

	/*----------- Default Functions Ends ----------*/

	jQuery(document).ready(function(e) {
		
		smoothScroll(); stickyFooter();

	});



	$(window).on('resize scroll', function(){
		
		smoothScroll(); stickyFooter();

	});

	/*-------- Lock Header Script With Scroll Up and down ----------*/
    var lastPosY = 0;
    $(window).scroll(function(event){
       var scroll_amount = $(this).scrollTop();
       if (scroll_amount >= lastPosY || scroll_amount < $('.site-header').outerHeight() - 75 ){
           $('.site-header').removeClass('sticky');
       }else{
           $('.site-header').addClass('sticky');
        }
        lastPosY = scroll_amount ;
    });
	/*-------- Lock Header Script With Scroll Up and down Ends ----------*/


	


});