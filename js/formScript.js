/**
* AJAX Form Submit
*
* http://www.last2lines.com
*
*/

$(document).ready(function() {
	var form = $('#coupletForm'); // couplet form
	var submit = $('#newUsersubmit');	// submit button
	var output = $('.output'); // output div for show output message

	// form submit event
	form.on('submit', function(e) {
		e.preventDefault(); // prevent default form submit
		// sending ajax request through jQuery
		$.ajax({
			url: 'includes/coupletProcessor.php', // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html', // request type html/json/xml
			data: form.serialize(), // serialize form data 
			beforeSend: function() {
				console.log("before sending..");
				output.fadeOut();
				submit.html('Sending....'); // change submit button text
			},
			success: function(data) {
				console.log("Success");
				//form.fadeOut();
				output.html(data).fadeIn(); // fade in response data
				//form.trigger('reset'); // reset form
				//submit.html('Submit'); // reset submit button text
			},
			error: function(e) {
				console.log("error!!");
				console.log(e)
			}
		});
	});
	
	
});

