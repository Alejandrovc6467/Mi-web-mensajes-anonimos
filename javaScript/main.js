$(document).ready(function(){
	
	$('.fa-bars').click(function() {
		$(this).toggleClass('fa-times');/** */
		$('.nav').toggleClass('nav-toggle');
	})
	
	$(window).on('scroll load', function() {
		
		$('.fa-bars').removeClass('fa-times');
		$('.nav').removeClass('nav-toggle');
		
		$('section').each(function() {
			var id = $(this).attr('id');
			var height = $(this).height();
			var offset = $(this).offset().top -200;
			var top = $(window).scrollTop();
			if(top >= offset && top < offset + height) {
				$('.navbar ul li a').removeClass('active')
			$('.nav').find('[href="#'+id+'"]').addClass('active')
			}
		});
		
	});
	
	
});








