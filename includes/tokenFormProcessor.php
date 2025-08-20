<?php require_once("functions.php"); ?>
<?php require_once("connection.php"); ?>
<?php require_once("session.php"); ?>
<?php
$_SESSION['tokenTest'] = '';
$_SESSION['authorName'] = '';
$_SESSION['authorEmail'] = '';
$_SESSION['authorLineOne'] = '';
$_SESSION['authorLineTwo'] = '';



//couplet submission 



	if (isset($_POST['authorNameToken']) && isset($_POST['authorEmailToken']) && isset($_POST['line1Token']) && isset($_POST['line2Token']) && isset($_POST['tokenNumber'])){
	
	
		$authorName = null;
		$authorEmail = null;
		$line1 = null;
		$line2 = null;
		$token = '';
		
		if(isset($_POST['authorNameToken']))
		$authorName = $_POST['authorNameToken'];
		if(isset($_POST['authorEmailToken']))
		$authorEmail = strtolower($_POST['authorEmailToken']);
		if(isset($_POST['line1Token']))
		$line1 = $_POST['line1Token'];
		if(isset($_POST['line2Token']))
		$line2 = $_POST['line2Token'];
		if(isset($_POST['tokenNumber']))
		$token = $_POST['tokenNumber'];
		
		
		if($authorName!='' && $authorEmail!='' && $line1!='' && $line2!='' && $token!='')
		$flag = true;
	else
		$flag = false;
		
	if($flag){
	//success
	
	
	// 1. check Token authenticity
	//if(authenticateToken($authorEmail,$token)){
        if($token == 16){

		
		//success: Correct Token Match
		
		
		//Insert entry into Master tb
		insertIntoMasterTb($authorEmail,$authorName,$line1,$line2,$token);

		//Write to Unpublished Poem File
		$unpublishedFile = "../unpublished".$chapter_id.".txt";
		$unpublishedFileLink = fopen($unpublishedFile, 'a') or die("Can't open the file.");
		fwrite($unpublishedFileLink, $authorName.PHP_EOL);
		fwrite($unpublishedFileLink, $authorEmail.PHP_EOL);
		fwrite($unpublishedFileLink, $line1.PHP_EOL);
		fwrite($unpublishedFileLink, $line2.PHP_EOL);
		fclose($unpublishedFileLink);

		//Email author's data to L2L admin
		sendEmail($authorEmail,$authorName,$line1,$line2);
		
		
		$_SESSION['tokenTest'] = 'correctToken';
		
		
		
		 
	
	}else{
		//Error: wrong Token
		$_SESSION['tokenTest'] = 'wrongToken';
		
		$_SESSION['authorName'] = $authorName;
		
		
		$_SESSION['authorEmail'] = $authorEmail;
		$_SESSION['authorLineOne'] = $line1;
		
		$_SESSION['authorLineTwo'] = $line2;
	}
		
	}else{
	
	
	//Token field is required
	$_SESSION['tokenTest'] = 'noToken';
	
	}
	
}else{
		$_SESSION['tokenTest'] = 'noToken';
	}
redirect_to("../index.php#write");
?>
