<?php require_once("functions.php"); ?>
<?php require_once("connection.php"); ?>
<?php

$_SESSION['tokenTest']='';
//couplet submission 
# request sent using HTTP_X_REQUESTED_WITH
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ){

 
   
	if (isset($_POST['authorName']) && isset($_POST['authorEmail']) && isset($_POST['line1']) && isset($_POST['line2']) && isset($_POST['tnc'])) {
		
		//echo 'Thanks';
		$authorName = null;
		$authorEmail = null;
		$line1 = null;
		$line2 = null;
		$token = 0;
		
		if(isset($_POST['authorName']))
		$authorName = $_POST['authorName'];
		if(isset($_POST['authorEmail']))
		$authorEmail = strtolower($_POST['authorEmail']);
		if(isset($_POST['line1']))
		$line1 = $_POST['line1'];
		if(isset($_POST['line2']))
		$line2 = $_POST['line2'];
		if(isset($_POST['tnc'])) 
		$tnc = $_POST['tnc'];
		
		if($authorName!='' && $authorEmail!='' && $line1!='' && $line2!='' &&  $tnc == 'YES')
		$flag = true;
	else
		$flag = false;
		
	if($flag){
	//success
	//$_SESSION['$msg'] = 'Success';
	
	// 1. check Email is exists in users table
	//if(checkTokenEmail($authorEmail)){
	if(false){
	
	// 2.1 already exists
	
	$authorName = ucfirst($authorName);
	
	
	
	
	echo "<h1 class=\"text-center\">Dear {$authorName}, Welcome back.</h1>
	<p>Please use the token that you have already received in your mailbox, to complete your submission:</p>
	
	<form class=\"\" id=\"tokenForm\" action=\"includes/tokenFormProcessor.php\" method=\"POST\" style=\"color:#333;\">
              
                <input type=\"hidden\" name=\"authorNameToken\" value=\"{$authorName}\"/>
                
				 <input type=\"hidden\" name=\"authorEmailToken\" value=\"{$authorEmail}\"/>
                
				<input type=\"hidden\" name=\"line1Token\" value=\"{$line1}\"/>
                
				<input type=\"hidden\" name=\"line2Token\" value=\"{$line2}\"/>
				
				<label for=\"tokenNumber\" class=\"control-label\">Please enter the token we emailed to you</label>
				<input type=\"text\" name=\"tokenNumber\" class=\"form-control\" placeholder=\"e.g. 1234\" required maxlength=\"4\" size=\"4\" />
               <div class=\"footer-text\">
			   <br/>
	<input type=\"submit\" value=\"Proceed\" name=\"submitToken\" id=\"submitToken\" class=\"btn btn-green\"/>
	</div>
			 </form>
			 <div class=\"col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8\">
		<div class=\"tokenOutput\"></div>
	</div>";
	/*echo "<script type='text/javascript'> $('#testLink').click(function(){ $('#tokenForm').addClass(\"visible\").removeClass(\"hidden\"); }); 
	console.log(\"Testing\");
	</script>";
	*/
	// 3. Validate user-entered Token
	
	
	
	
	
	}else{
	
	// 2.2 New user Journey
	
	// 2.2.1 generate random Token
	//$token = generateToken();
	$token = 16;

	// 2.2.2 store email-token in Users Table
	insertIntoUsersTb($authorEmail,$token);
	
	// 2.2.3 Email token to user email
	//sendEmailToken($authorName,$authorEmail,$token);
	$authorName = ucfirst($authorName);
	echo "
	
	<h1 class=\"text-center\">Hello {$authorName}, Welcome to Last2Lines</h1>
	<p class=\"text-center\">Just to prove that you are not a robot, please answer this simple question:</p>
	<form class=\"col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8 text-center\" id=\"tokenForm\" action=\"includes/tokenFormProcessor.php\" method=\"POST\" style=\"color:#333;\">
              
                <input type=\"hidden\" name=\"authorNameToken\" value=\"{$authorName}\"/>
                 
				 <input type=\"hidden\" name=\"authorEmailToken\" value=\"{$authorEmail}\"/>
                
				<input type=\"hidden\" name=\"line1Token\" value=\"{$line1}\"/>
                
				<input type=\"hidden\" name=\"line2Token\" value=\"{$line2}\"/>
				<h4>What is 10+6 ?</h4>
				<label for=\"tokenNumber\" class=\"control-label\">Please enter your answer here:</label>
				<input type=\"text\" name=\"tokenNumber\" class=\"form-control\" placeholder=\"e.g. 12\" required size=\"4\" />
               <div class=\"footer-text\">
			   <br/>
	<input type=\"submit\" value=\"Proceed\" name=\"submitToken\" id=\"submitToken\" class=\"btn btn-green\"/>
	</div>
			 </form>
			 <div class=\"col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8\">
		<div class=\"tokenOutput\"></div>
	</div>";
	// 3. Validate user-entered Token
	
	
	
	}
	
	
	
	
	}else{
	//error
	//$_SESSION['$msg'] = 'Error';
	echo '<h4 class=\"text-warning\"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> All fields are required</h4>';
	}
}else{
		echo '<h4 class=\"text-warning\"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> All fields are required</h4>';
	}
	return;

}
//couplet submission 
 

/**
if(isset($_POST['newUsersubmit'])){
	
	$authorName = null;
	$authorEmail = null;
	$line1 = null;
	$line2 = null;
	$token = 0;
	$flag = false;
	
	if(isset($_POST['authorName']))
	$authorName = $_POST['authorName'];
	if(isset($_POST['authorEmail']))
	$authorEmail = $_POST['authorEmail'];
	if(isset($_POST['authorName']))
	$line1 = $_POST['line1'];
	if(isset($_POST['line2']))
	$line2 = $_POST['line2'];
	
	if($authorName != null && $authorEmail != null &&$line1 != null && $line2 != null)
		$flag = true;
	else
		$flag = false;
		
	
	
if($flag){
	//success
	//$_SESSION['$msg'] = 'Success';
	
	//generate random Token
	$token = generateToken();
	
}else{
	//error
	//$_SESSION['$msg'] = 'Error';
	}
}
**/
//couplet submission

?>
