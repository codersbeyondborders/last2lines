<?php 
  require(__DIR__."/../vendor/autoload.php");
  require_once("EmailConstants.php");
  use Mailgun\Mailgun;

/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

	// This file is the place to store all basic functions

	function mysql_prep( $value ) {
		global $connection;
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysqli_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysqli_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string($connection,$value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysqli_error());
		}
	}
	
	
	
	
	
	
	
	/** Get All Registered Users**/
	function get_all_authors(){
		
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM current_table ORDER BY dateTime";
		
		$authors_result_set = mysqli_query($connection, $query);
		confirm_query($authors_result_set);
		return $authors_result_set;
		
		
	}
	
	/** check Email if it exists**/
	function checkEmail($email){
	
		$email = strtolower($email);
		global $connection;
		$query = "SELECT * From current_table where email = '{$email}'";
		$count = 0;
		$count = mysqli_num_rows(mysqli_query($connection, $query));
		
		if($count<1){
		return false;
		}else{
		return true;}
		
	}
	
	/** Get All Author's work by Email**/
	function get_author_by_email($email){
		
		$email = strtolower($email);
		
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM current_table where email = '{$email}' ORDER BY dateTime";
		
		$authors_result_set = mysqli_query($connection, $query);
		confirm_query($authors_result_set);
		return $authors_result_set;
		
		
	}
	
	
	
	/** Get Last Registered User**/
	function get_last_author(){
		$last_author = null;
		$authors_result_set = get_all_authors();
		$size = 0;
		
		if($authors_result_set != false)
		{
			foreach($authors_result_set as $author ) {
				
			//

			}
			$last_author = $author;
		}
		return $last_author ;
		
	}


	
	/** Get All Registered emails of Authors**/
	function get_all_author_emails(){
		
	$emails = array();
	$authors_result_set = get_all_authors();


	if($authors_result_set != false)
	{
		foreach($authors_result_set as $author ) {
		
		$emails[] = strtolower($author['email']);

		}
	}

	return $emails;

		
	}
	
	
	/** Check Duplicate email entries**/
	function check_author_email($email){
	$email = strtolower($email);
	$flag = false;	
	$test = get_all_author_emails();
	foreach($test as $t)
		{	
			if($email == $t)
			{	
				$flag = true;
				break;
			}
			
		}
	return $flag;
	}
	
	

	
	/** Delete one entry**/
	function delete_author_by_id($id){
		global $connection;
		// LIMIT 1 isn't necessary but is a good fail safe
		$query = "DELETE FROM current_table WHERE id = {$id} LIMIT 1";
		$result = mysqli_query($connection, $query);
		if(count($result)==1){
			// Successfully deleted
			return true;
		} else {
			// Deletion failed
			return false;
		}
	}
	
	/** Update one entry**/
	function update_author_by_id($id,$name,$line1,$line2,$chapterId){
		global $connection;
		
		$query = "UPDATE current_table set name = '{$name}',line1='{$line1}',line2='{$line2}',chapter_id={$chapterId} where id = {$id}";
		$result = mysqli_query($connection, $query);
		if($result){
			// Successfully updated
			return true;
		} else {
			// Update failed
			return false;
		}
	}
	
	/** New Entry into Master Table**/
	function insertIntoMasterTb($email,$name,$line1,$line2,$token){
	$email = strtolower($email);
	global $connection;
	$query = "INSERT INTO master_table (email,name,line1,line2,token) VALUES ('{$email}', '{$name}','{$line1}','{$line2}',{$token});";
	if ($result = mysqli_query($connection,$query)) {
		return true;
	}else{
		return false;
	}
	}
	
	
	/** Sending email to Admin for new entry**/
	function sendEmail($email, $name, $line1, $line2) {
	  $msg = "Name: ".$name."<br>Email: ".$email."<br>Line 1: ".$line1."<br>Line 2: ".$line2;
	  $m = new Mailgun('key-2-umhfj5ex7k7dbi9k1lo--54gsclx64');
	  $domain = "mail.last2lines.com";	
	  $m->sendMessage($domain, [
	  	'from' => EMAIL_FROM,
	  	'to' => EMAIL_TO,
	  	'subject' => 'Last2Lines - New Submission',
	  	'html' => $msg
	  ]);
/*
	  $email = strtolower($email);
	  $headers = "From: " . strip_tags(EMAIL_FROM) . "\r\n";
	  $headers .= "Reply-To: ". strip_tags(EMAIL_FROM) . "\r\n";
	  $headers .= "CC: " . strip_tags(EMAIL_CC) . "\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
	  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	  $emailBody = "New submission with following details:
		<br/>
		Name: {$name}
		<br/>
		Email: {$email}
		<br/>
		Line 1: {$line1}
		<br/>
		Line 2: {$line2}
		<br/>";	
	  if(mail(EMAIL_TO, EMAIL_SUBJECT_NEW, $emailBody, $headers)){
		//mail sent to admin
	  }
*/
	}
	/** Sending email to Admin **/
	
	function get_number_of_authors(){
	global $connection;
	
	$active_chapter = null;
	$active_chapter_id = null;
	$active_chapters = get_active_chapter();
	if($active_chapters != false)
	{
		foreach($active_chapters as $ac) {
		
			$active_chapter = $ac;
		}
	}
	$active_chapter_id = $active_chapter['chapter_id'];
	$query = "SELECT * From current_table WHERE chapter_id = {$active_chapter_id}";
	return mysqli_num_rows(mysqli_query($connection, $query));
		}
		
	function IDcheckIfExists($id){
		global $connection;
		$query = "SELECT * From current_table where id = {$id}";
		$countTemp = 0;
		$countTemp = mysqli_num_rows(mysqli_query($connection, $query));
		
		if($countTemp<1){
		return false;
		}else{
		return true;}
	
	}
	
	
	
	/** check Email if it exists in Users Table**/
	function checkTokenEmail($email){
		$email = strtolower($email);
		global $connection;
		
		
		/*
		$flag = false;
		$query = "SELECT * From users";
		
		$result_set = mysqli_query($connection, $query);
		
		if($result_set)
		foreach($result_set as $result) {
				
			if($result['email'] == $email){
			$flag = true;
			break;
			}else{
			$flag = false;
			}

			}
			
		
		return $flag;
		
		*/
		
		
		$query = "SELECT * From users where email ='{$email}'";
		
		$count = 0;
		$count = mysqli_num_rows(mysqli_query($connection, $query));
		if($count<1){
		return false;
		}else{
		return true;}
		
		
		
	}
	
	/** authenticate Token from Users Table**/
	function authenticateToken($email,$token){
		$email = strtolower($email);
		global $connection;
		$query = "SELECT * From users where email = '{$email}' AND token = {$token}";
		$count = 0;
		$count = mysqli_num_rows(mysqli_query($connection, $query));
		
		if($count<1){
		return false;
		}else{
		return true;}
		
	}
	
	
	/** Get Tokens by Email**/
	function get_token_by_email($email){
		$email = strtolower($email);
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM users where email = '{$email}'";
		
		$result_set = mysqli_query($connection, $query);
		confirm_query($result_set);
		return $result_set;
		
		
	}
	//generate Random Token -- by default 4 digit
	function generateToken($digits = 4){
    $i = 0; //counter
    $token = ""; //our default token is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $token .= mt_rand(0, 9);
        $i++;
    }
    return $token;
}

/** New Entry into Users Table**/
	function insertIntoUsersTb($email,$token){
	$email = strtolower($email);
	global $connection;
	$query = "INSERT INTO users VALUES ('{$email}',{$token});";
	if ($result = mysqli_query($connection,$query)) {
		return true;
	}else{
		return false;
	}
	}
	
	/** Sending token via email to user**/
	function sendEmailToken($authorName, $authorEmail, $token){
	  $msg = "Hi {$authorName},
	  		 <br>
	  		 Welcome to Last2Lines!
	  		 <br>
	  		 You have successfully registered at Last2Lines, and we couldn't be more excited to have you on board.
	  		 <br>
	  		 <h3>Your Token: <strong>{$token}</strong></h3>
	  		 <br>
	  		 Please use the same for all future submissions.
	  		 <br>
	  		 Regards,
	  		 <br>
	  		 Team Last2Lines
	  		 <br>
	  		 <a href='www.last2lines.com'>www.last2lines.com</a>
	  		 ";
	  $m = new Mailgun('key-2-umhfj5ex7k7dbi9k1lo--54gsclx64');
	  $domain = "mail.last2lines.com";	
	  $m->sendMessage($domain, [
	  	'from' => EMAIL_FROM,
	  	'to' => $authorEmail,
	  	'subject' => 'Last2Lines - Your Token is '.$token,
	  	'html' => $msg
	  ]);	
	}
	
	
	
	
	//Get Active Chapter
	function get_active_chapter(){
		
		$active_chapters = null;
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM chapter_table WHERE active = 1 LIMIT 1";
		
		$active_chapters = mysqli_query($connection, $query);
		return $active_chapters;
		
		
	}
	
	function authenticateCoupletChapterID($coupletID,$chapterID){
	
		$chapters = null;
		$chapter = null;
		$chapter_id = null;
		global $connection;
		$query = "SELECT * From current_table where id = {$coupletID}";
		
		$chapters = mysqli_query($connection, $query);
		
		if($chapters != false)
		{
			foreach($chapters as $ch) {
			
				$chapter = $ch;

			}
		}
		
		if($chapter['chapter_id'] == $chapterID){
		return true;
		}else{
		return false;}
		
	}
	
	function authenticateChapterID($chapterID){
		$isPresent = false;
		$chapters = null;
		global $connection;
		$query = "SELECT * From chapter_table";
		
		$chapters = mysqli_query($connection, $query);
		
		if($chapters != false)
		{
			foreach($chapters as $chapter) {
				if($chapter['chapter_id'] == $chapterID){
					$isPresent = true;
				}
				

			}
		}
		
		return $isPresent;
		
		
		
	}
	
	function getAllChapters(){
		$query = "SELECT * From chapter_table";
		global $connection;
		$chapters = mysqli_query($connection, $query);
		
		if($chapters != false)
		return $chapters;
	
	}
	
	function getAllCoupletsByChapter($chapter_id){
		
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM current_table WHERE chapter_id = {$chapter_id} ORDER BY dateTime ASC";
		
		$couplets_result_set = mysqli_query($connection, $query);
		confirm_query($couplets_result_set);
		
		
		return $couplets_result_set;
		
		
	}
	
	function getFirst2Couplets($chapter_id){
		
		global $connection;
		$couplets = null;
		$counter = 1;
		
		$first2Couplets = array();
		$couplets = getAllCoupletsByChapter($chapter_id);
		
		foreach($couplets as $couplet){
			
			if($counter == 1)
				$first2Couplets[0] = $couplet;
			else if($counter == 2)
				$first2Couplets[1] = $couplet;
			else 
				break;
			$counter = $counter + 1;
		
		}
		
		return $first2Couplets;
		
		
		
		
	}
	
	function getChapterById($chapterID){
		$query = "SELECT * From chapter_table WHERE chapter_id ={$chapterID}";
		global $connection;
		$chapter = mysqli_query($connection, $query);
		
		if($chapter != false)
		{
			foreach($chapter as $ch) {
			
				//

			}
		}
		
		return $ch;
	
	}
	
	function getChapterNamebyId($chapterID){
		$query = "SELECT chapter_name From chapter_table WHERE chapter_id ={$chapterID}";
		global $connection;
		$chapter = mysqli_query($connection, $query);
		
		if($chapter != false)
		{
			foreach($chapter as $ch) {
			
				//

			}
		}
		
		return $ch['chapter_name'];
	
	}
	
	function getEntriesCountFromChapter($chapterId){
	global $connection;
	
	$query = "SELECT * From current_table WHERE chapter_id = {$chapterId}";
	return mysqli_num_rows(mysqli_query($connection, $query));
		}
		
	//Activate Chapter
	function activateChapter($chapterIdToActivate){
		global $connection;
		$query = "UPDATE chapter_table set active = 1 where chapter_id = {$chapterIdToActivate}";
		
		$result = mysqli_query($connection, $query);
		if($result){
			// Successfully updated
			$query2 = "UPDATE chapter_table set active = 0 where chapter_id != {$chapterIdToActivate}";
			$result2 = mysqli_query($connection, $query2);
			if($result2){
				return true;
			}else{
				return false;
			}
			
			
			
			
		} else {
			// Update failed
			return false;
		}
	
	}
	
	//Get entries by Chapter
	function getEntriesByChapter($chapterId){
		
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM current_table WHERE chapter_id={$chapterId} ORDER BY dateTime";
		
		$authors_result_set = mysqli_query($connection, $query);
		confirm_query($authors_result_set);
		return $authors_result_set;
		
		
	}
	
	
	function searchTest($key,$chid){
		
		global $connection;
		
		
		
    $query = $key;
    $sql = "SELECT name FROM current_table WHERE chapter_id = {$chid} AND name LIKE '%{$query}%'";
	$array = array();
    
	$result_set = mysqli_query($connection, $sql);
	
	if($result_set != false)
		{
			foreach($result_set as $row) {
				
			$array[] = array (
            'label' => $row['name'],
            'value' => $row['name'],
        );

			}
			
		}
		
		
	
   
    echo json_encode ($array);

		
		
	}
	
	
	/*
	function searchDisplay($key,$CHID){
		
		global $connection;
		
		
		$data="";
    $query = $key;
   $sql = "SELECT line1, line2, name , id FROM current_table WHERE chapter_id = {$CHID} AND name LIKE '%{$query}%'";
	$array = array();
    
	$sqlFull = "SELECT line1, line2, name , id FROM current_table WHERE chapter_id = {$CHID}";
	$result_setFull = mysqli_query($connection, $sqlFull);
	$array = array();
	$result_set = mysqli_query($connection, $sql);
	
	if($result_setFull != false && $result_set != false)
		{
			foreach($result_setFull as $rowFull){
			foreach($result_set as $row){
			if($rowFull['id']==$row['id']){	
			$data.="<div  class=\"text-danger\">";
			$data.=$rowFull['line1'];
			$data.="<br/>";
			$data.=$rowFull['line2'];
			$data.="<br/>";
			$data.="<strong>";
			$data.=$rowFull['name'];
			$data.="</strong><br/>";
			$data.="</div><br/>";
			}else{
			$data.=$rowFull['line1'];
			$data.="<br/>";
			$data.=$rowFull['line2'];
			$data.="<br/>";
			$data.="<strong>";
			$data.=$rowFull['name'];
			$data.="</strong><br/><br/>";
			}

			}
			
		}
		}
		
		return $data;
	}
	*/
	
		function searchDisplay($key,$CHID){
		
		global $connection;
		
		
		$data="";
    $query = $key;
   $sql = "SELECT line1, line2, name , id FROM current_table WHERE chapter_id = {$CHID} AND name LIKE '%{$query}%'";
	$array = array();
	$result_set = mysqli_query($connection, $sql);
	
	if($result_set != false)
		{
			
			foreach($result_set as $row){
			
			$data.=$row['line1'];
			$data.="<br/>";
			$data.=$row['line2'];
			$data.="<br/>";
			$data.="<strong>";
			$data.=$row['name'];
			$data.="</strong><br/><br/>";
			

			}
			
		
		}
		
		return $data;
	}

?>