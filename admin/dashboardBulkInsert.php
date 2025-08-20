<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

?>

<?php 
//confirm_logged_in();
$message ='';

	if(isset($_POST['StartBulkInsert'])){
		$flag = false;
		$bulk_content = null;
		$chapter_id = null;

		if(isset($_POST['chapter_id']))
		$chapter_id = mysql_prep($_POST['chapter_id']);
		
		if(isset($_POST['bulk_content']))
		$bulk_content = mysql_prep($_POST['bulk_content']);
		

		if($bulk_content != null && $chapter_id !=null)
			$flag = true;
		else 
			$flag = false;
		
		if($flag){
			//success
			if(authenticateChapterID($chapter_id)){
				
			$pieces = explode("\\r\\n", $bulk_content);
			$listOfEntires = [];

			$users = [];
			$user = new stdClass();

			// Process each line
			foreach ($pieces as $index => $line) {
			    $line = trim($line);

			    // If the line is not empty, add it to the current user data
			    if (!empty($line)) {
			        // Determine the property based on the count of lines for the current user
			        switch (($index + 1) % 4) {
			            case 1:
			                $user = new stdClass();
			                $user->name = $line;
			                break;
			            case 2:
			                $user->email = $line;
			                break;
			            case 3:
			                $user->line1 = $line;
			                break;
			            case 0:
			                $user->line2 = $line;
			                $users[] = $user;
			                break;
			        }
			    }
			}

			//AW
			$myFile2 = "../poem".$chapter_id.".txt";
			$myFileLink2 = fopen($myFile2, 'a') or die("Can't open the file.");
			$contents = '';
			$newContents = '';
			$newContents2 = '';

			$userEmailList = [];
			foreach ($users as $user) {


				$userEmailList[] = $user->email;
						
				//1. insert new entry Into DB
				$query = "INSERT INTO current_table (
						email, name, line1, line2, chapter_id  
					) VALUES ('{$user->email}', '{$user->name}','{$user->line1}','{$user->line2}',{$chapter_id});";

				if ($result = mysqli_query($connection,$query)) {
			
				// 2. write to main poetry file poem.txt
				$contents = $user->line1.PHP_EOL;
				fwrite($myFileLink2, $contents);
				$newContents = $user->line2.PHP_EOL;
				fwrite($myFileLink2, $newContents);
				$newContents2 = $user->name.PHP_EOL;
				fwrite($myFileLink2, $newContents2);
										
				//write to main poetry file poem.txt

				//write to lastCouplet poetry file lastCouplet.txt
				$_SESSION['adminMsg'] = "The couplet was successfully added.";
				$message = "The couplet was successfully added.";
				}else{
					$message = "There was some problem while adding the couplet";
				}
			}
			fclose($myFileLink2);
			// 3. write to lastCouplet poetry file lastCouplet.txt
			$myFile3 = "../lastCouplet".$chapter_id.".txt";
			$myFileLink3 = fopen($myFile3, 'w+') or die("Can't open the file.");
			fwrite($myFileLink3, $contents);
			fwrite($myFileLink3, $newContents);
			fwrite($myFileLink3, $newContents2);
			fclose($myFileLink3);

		
			//$userEmailList = ["wajid.parray@gmail.com","travelihood@gmail.com"];
			
			sendEmailToUsers($userEmailList);
				
			
			$message = "Bulk Insert Done Successfully.";


			
			}else{
				$message = "Wrong Chapter ID.<br/>This Chapter ID does not exist";
			}

			}else{
				$message = "Oops!! Something Went Wrong.<br/>
				Please enter some content.";
			
			}
}else{
	//error
	$message = "Oops!! Something Went Wrong.<br/>All fields are required. Please fill again";
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Free Html Bootstrap Admin Template" />
    <meta name="author" content="" />
    <meta name="keywords" content="bootstrap, template,admin,free template" />
    <link rel="canonical" href="http://www.htmladmin.com/">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- Favicon Icon ( put .ico favicon URL in href below ) -->
    <link rel="icon" href="#" />
    <title>Last Two Lines</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM STYLES-->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="set-body">

  
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">L2L ADMIN

                </a>
            </div>

            <div class="notifications-wrapper">
                <ul class="nav">



                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cogs"></i><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            
                            
                            <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
        <!-- /. NAV TOP  -->
        
		 <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    
                    <li class="active">
                        <a  href="dashboardNewEntry.php"><i class="fa fa-plus "></i>New Couplet</a>

                    </li>
                    <li>
                        <a href="dashboardSearchCouplet.php"><i class="fa fa-search "></i>Search Couplet</a>

                    </li>
					<li>
                        <a href="dashboardDeleteCouplet.php"><i class="fa fa-times "></i>Delete Couplet</a>

                    </li>
					<li>
                        <a href="dashboardEditCouplet.php"><i class="fa fa-pencil-square-o "></i>Edit Couplet</a>

                    </li>
					<li>
                        <a href="dashboardSearchToken.php"><i class="fa fa-search "></i>Search Token</a>

                    </li>
					<li>
                        <a href="dashboardNewChapter.php"><i class="fa fa-plus"></i>New Chapter</a>

                    </li>
					<li>
                        <a href="dashboardEditChapter.php"><i class="fa fa-pencil-square-o "></i>Edit Chapter</a>

                    </li>
					<li>
                        <a href="dashboardAllChapters.php"><i class="fa fa-star "></i>All Chapters</a>

                    </li>
					<li>
                        <a href="imageUploader/imageUploader.php"><i class="fa fa-upload "></i>Upload Guidelines Image</a>

                    </li>
					<li>
                        <a href="dashboardNewCarousal.php"><i class="fa fa-plus "></i>New carousal</a>

                    </li>
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">DASHBOARD </h1>
                    </div>
                </div>
                <div class="row">
                    
                </div>

                
                                <div class="row space-get">
                    <div class="col-md-12">
					<h2>New Couplet</h2>
					<hr/>
                        <!-- COMPOSE MESSAGE START -->
						<?php if (!empty($message)) {echo "<br/><p class=\"text-danger\">" . $message . "</p>";} ?>
						
						<form class="Compose-Message"
						action="dashboardBulkInsert.php" method="post"
						>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Compose Next Couplet
                                </div>
                                <div class="panel-body">

                                	<label>Enter Chapter ID: </label>
                                    <input type="text" name="chapter_id"class="form-control" />
                                    <hr />

                                   <label>Enter Contents Here</label>
                                    <textarea class="form-control"name="bulk_content" rows="8" cols="40"></textarea>
                                    <hr />
                                    <input  type="submit" name="StartBulkInsert" value="submit" class="btn btn-success"/>
                                </div>
                                
                            </div>
                        </form>
                        <!-- COMPOSE MESSAGE END -->
                    </div>
   
					

                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>



    </div>
    <!-- /. WRAPPER  -->
	
    <footer>
        <p>copyright&nbsp;&copy;&nbsp;<?php echo date('Y');?>&nbsp;<a href="http://www.last2Lines.com">Last2Lines.com</a>
								&nbsp;|&nbsp;All Rights Reserved.</p>
    </footer>
    <!-- /. FOOTER  -->

    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CHARTS SCRIPTS -->
    <script src="assets/js/Chart.js"></script>
    <!-- CHARTS SCRIPTS SCRIPTS-->
    <script src="assets/js/custom-charts.js"></script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php
	// 5. Close connection
	mysqli_close($connection);
?>