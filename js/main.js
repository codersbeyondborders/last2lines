
$(document).ready(function(){
	counterWayPoint();
	//Script for nav scroll */
	$(window).bind('scroll', function(e) {
    scrollingfn();
  });
  /*=== one page navigation ====*/
    $('#main_navigation_menu').onePageNav({
            currentClass: 'active'
    });

	function scrollingfn() {
	  var scrollPosition = $(window).scrollTop();
	}
	// Script for top Navigation Menu
    jQuery(window).bind('scroll', function () {
      if (jQuery(window).scrollTop() > 100) {
        jQuery('#head-nav').addClass('fixed-top').removeClass('topnavbar');
      } else {
        jQuery('#head-nav').removeClass('fixed-top').addClass('topnavbar');
      }
    });
	// Script for scrollUP*/
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 500, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 500, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
		/*scroll to end*/	
	});
	
	/* Counter */
	function counter() {
		$('.js-counter').countTo({
			 formatter: function (value, options) {
	      return value.toFixed(options.decimals);
	    },
		});
	}
	
	function counterWayPoint() {
	if ($('#ourJourneySoFar').length > 0 ) {
			$('#ourJourneySoFar').waypoint( function( direction ) {
										
				if( direction === 'down' && !$(this.element).hasClass('animated') ) {
					setTimeout( counter , 400);					
					$(this.element).addClass('animated');
						
				}
			} , { offset: '90%' } );
		}
		console.log("Test 1");
	}
	
	/* Counter */
	
	/* Form Validations */
		     
    $('#coupletForm').bootstrapValidator({
	 container: function($field, validator) {
               
                return $field.parent().next('.messageContainer');
            },
        feedbackIcons: {
            
            invalid: 'fa fa-exclamation-circle',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            authorName: {
                validators: {
                    notEmpty: {
                        message: 'Author name is required'
                    },
					stringLength: {
                        min: 3,
						message: 'Please enter your full name'
                    },
					regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'Name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            authorEmail: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
					emailAddress: {
                        message: 'The email address is not valid'
                    }
                }
            },
            line1: {
                validators: {
                    notEmpty: {
                        message: 'First verse is required and cannot be empty'
                    },
					stringLength: {
                        min: 20,
						message: 'First verse is too short'
                    },
					regexp: {
                        regexp: /[^1234567890]+$/i,
                        message: 'The verse can consist of alphabetical characters, special symbols and spaces only'
                    }
                }
            },
            line2: {
                validators: {
                    notEmpty: {
                        message: 'Second verse is required and cannot be empty'
                    },
					stringLength: {
                        min: 20,
						message: 'Second verse is too short'
                    },
					regexp: {
                        regexp: /[^1234567890]+$/i,
                        message: 'The verse can consist of alphabetical characters, special symbols and spaces only'
                    }
                }
            },
			tnc: {
				validators:{
					notEmpty: {
                        message: 'You cannot proceed without accepting Terms and Conditions'
                    }
				
				}
			
			}
			
            
        }
    }).on('success.form.bv',function(e){
      e.preventDefault(); // <----- THIS IS NEEDED

      $('#newUsersubmit').prop('disabled', true);
  $('#newUsersubmit').attr("disabled", "disabled"); 
});
	
});

//Tweet Carousel
$('#tweet-carousel').carousel()
