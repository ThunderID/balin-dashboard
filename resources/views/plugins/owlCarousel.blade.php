{!! HTML::style('plugins/owlCarousel/assets/owl.carousel.css') !!}
{!! HTML::script('plugins/owlCarousel/owl.carousel.js') !!}

<script>
	$('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:10,
	    responsiveClass:true,
	    lazyLoad: true,
	    navText: ['<p class="hidden" id="car-btn-prev">prev</p>', '<p class="hidden" id="car-btn-next">next</p>' ],
	    responsive:{
	        0:{
	            items:2,
	            nav:true
	        },
	        600:{
	            items:3,
	            nav:false
	        },
	        1000:{
	            items:4,
	            nav:true,
	            loop:false
	        }
	    }
	})	
</script>