$(document).ready(function() {

var hpSlideSpeed1 = 1500;
var hpSlideSpeed2 = 1500;
var hpDelaySpeed = 1500;
function hpSlideshow() {
	$("#Slide1").fadeIn(hpSlideSpeed1, function() {
		$(this).children('.tagline').fadeIn(hpSlideSpeed1+3000, function() {
		
			$(this).fadeOut(hpSlideSpeed1);
			$("#Slide2").fadeIn(hpSlideSpeed1, function() {
				$(this).fadeOut(hpSlideSpeed1, function() {
					$("#Slide3").fadeIn(hpSlideSpeed1, function() {
						$(this).fadeOut(hpSlideSpeed1);
						$("#Slide4").fadeIn(hpSlideSpeed1, function() {
							$(this).fadeOut(hpSlideSpeed1);
							hpSlideshow();
						});
					});
				});
			});
			
		});
	});
}

if($("#Slide1").length) {
	$.preLoadImages(
		[
		  '/images/slideshow/1bg.png', 
		  '/images/slideshow/2bg.png', 
		  '/images/slideshow/3bg.png', 
		  '/images/slideshow/4bg.png'
		], function(){
		  hpSlide14(1);
		}
	);
}

function hpSlide14(id) {
	$("#Slide"+id).fadeIn(hpSlideSpeed1, function() {
		$("#Slide"+id+ ' .tagline').fadeIn(hpSlideSpeed1, function() {
			setTimeout(function() {
				$("#Slide"+id).children().fadeOut(hpSlideSpeed1);	
				$("#Slide"+id).fadeOut(hpSlideSpeed1, function() {
					if(id > 3) {
						hpSlide5();
					}
					else {
						hpSlide14(id+1);
					}
				});
			}, hpDelaySpeed);
		});
	});
}

function hpSlide5() {
	$("#Slide5").fadeIn(hpSlideSpeed1, function() {
		$("#Slide5 .img1").fadeIn(hpSlideSpeed1, function() {
			$("#Slide5 .img2").fadeIn(hpSlideSpeed1, function() {
				
					setTimeout(function() {
						$("#Slide5 img").fadeOut(hpSlideSpeed1);
						$("#Slide5").fadeOut(hpSlideSpeed1, function() {
							hpSlide7();
						});
					}, hpDelaySpeed+500);
				
			});
		});
	});
}

function hpSlide6() {
	$("#Slide6").fadeIn(hpSlideSpeed1, function() {
		$("#Slide6 .img1").fadeIn(hpSlideSpeed1, function() {
			$("#Slide6 .img2").fadeIn(hpSlideSpeed1, function() {
				$("#Slide6 .img3").fadeIn(hpSlideSpeed1, function() {
					setTimeout(function() {
						$("#Slide6").children().fadeOut(hpSlideSpeed1);
						$("#Slide6").fadeOut(hpSlideSpeed1, function() {
							hpSlide7();
						});
					}, hpDelaySpeed+500);
				});
			});
		});
	});
}

function hpSlide7() {
	$("#Slide7").fadeIn('fast', function() {
		$("#Slide7 .img1").fadeIn(hpSlideSpeed1, function() {
			setTimeout(function() {
				$("#Slide7").children().fadeOut(hpSlideSpeed1);
				$("#Slide7").fadeOut(hpSlideSpeed1, function() {
					hpSlide14(1);
				});
			}, hpDelaySpeed+1000);
		});
	});
}

});