/**
* AJAX Form Submit
*
* http://www.last2lines.com
*
*/

$(document).ready(function() {

//Token Form Submission
var tokenForm = $('#tokenForm'); // token Form 
	var tokenSubmit = $('#submitToken');	// submit button
	var tokenOutput = $('.tokenOutput'); // output div for show output message

	// form submit event
	tokenForm.on('tokenSubmit', function(e) {
		e.preventDefault(); // prevent default form submit
		// sending ajax request through jQuery
		$.ajax({
			url: 'includes/tokenFormProcessor.php', // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html', // request type html/json/xml
			data: tokenForm.serialize(), // serialize form data 
			beforeSend: function() {
				console.log("authorizing Token..");
				tokenOutput.fadeOut();
				tokenSubmit.html('authorizing Token..'); // change submit button text
			},
			success: function(data) {
				console.log("Success Token");
				//form.fadeOut();
				tokenOutput.html(data).fadeIn(); // fade in response data
				//form.trigger('reset'); // reset form
				//submit.html('Submit'); // reset submit button text
			},
			error: function(e) {
				console.log("error!! Token");
				console.log(e)
			}
		});
	});
	
});

