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

// START FORM PROCESSING

	
/*** Edit Author Entry **/
	if (isset($_POST['editEntrySubmit'])) {
		$chapter_id = null;
		$chapter_name = null;
		$chapter_summary = null;
		$guidelines = null;
		$start_date = null;
		$end_date = null;
		
		
		$editIDFlag = false;
		$editMessage = "";
		
		if(isset($_POST['chapter_id']))
		$chapter_id = mysql_prep($_POST['chapter_id']);
		
		
		if(isset($_POST['chapter_name']))
		$chapter_name = mysql_prep($_POST['chapter_name']);
		
		
		if(isset($_POST['chapter_summary']))
		$chapter_summary = mysql_prep($_POST['chapter_summary']);
		
		if(isset($_POST['guidelines']))
		$guidelines = mysql_prep($_POST['guidelines']);
		
		
		if(isset($_POST['start_date']))
		$start_date = mysql_prep($_POST['start_date']);
		
		$start_date = strtotime($start_date);
		$start_date = date('Y-m-d', $start_date);
		
		if(isset($_POST['end_date']))
		$end_date = mysql_prep($_POST['end_date']);
		
		$end_date = strtotime($end_date);
		$end_date = date('Y-m-d', $end_date);
		
		
		
		if($chapter_id != null && $chapter_name != null && $chapter_summary!= null && $guidelines!= null && $start_date!=null && $end_date !=null)
			$editIDFlag = true;
		else 
			$editIDFlag = false;
		
	if($editIDFlag){
			//success
			if(authenticateChapterID($chapter_id)){
			
			
			//1. Update Chapter Table
			$query = "UPDATE chapter_table set chapter_name = '{$chapter_name}',start_date='{$start_date}',end_date='{$end_date}',chapter_summary='{$chapter_summary}',guidelines='{$guidelines}' where chapter_id = {$chapter_id}";
			
			if ($result = mysqli_query($connection,$query)) {
			
			
			// 2. Create poem.txt
			$myFile2 = "../poem".$chapter_id.".txt";
			
			$myFileLink2 = fopen($myFile2, 'a') or die("Can't open the file.");
			fclose($myFileLink2);
									
			

			// 3. Create lastCouplet poetry file lastCouplet.txt

				
				$myFile3 = "../lastCouplet".$chapter_id.".txt";
				$myFileLink3 = fopen($myFile3, 'w+') or die("Can't open the file.");
				fclose($myFileLink3);

				
			$_SESSION['adminMsg'] = "The chapter was successfully updated.";
			$editMessage = "The chapter was successfully updated.";
			redirect_to("dashboard.php");}else{
			$editMessage = "There was some problem while adding the chapter";
			
			}
			
		}else{
			$editMessage = "This Chapter ID does Not Exist!!";
		}
		
		}else{
			//error
			$editMessage = "Oops!! Something Went Wrong.<br/>
			All fields are required. Please fill again";
			}	
		

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
                    <!-- Edit Entry-->
					<div class="col-md-12">
						<br/>
					<h2>Edit Chapter</h2>
					<hr/>
					<?php if (!empty($editMessage)) {echo "<br/><p class=\"text-danger\">" . $editMessage . "</p>";} ?>
						
						<form class="Compose-Message"
						action="dashboardEditChapter.php" method="post"
						>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Edit Chapter
                                </div>
                                <div class="panel-body">
                                    
                                    
									<label>Chapter ID:</label>
                                    <input type="text" name="chapter_id"class="form-control" />
                                    <label>Chapter Name:</label>
                                    <input type="text" name="chapter_name"class="form-control" />
									<label>Chapter Summary</label>
                                    <textarea class="form-control"name="chapter_summary" rows="8" cols="40"></textarea>
									<label>Guidelines</label>
                                    <textarea class="form-control"name="guidelines" rows="8" cols="40"></textarea>
									<label>Start Date: </label>
                                    <input placeholder="e.g. 20160330"
									type="text" name="start_date"class="form-control" />
									<label>End Date: </label>
                                    <input placeholder="e.g. 20170126"
									type="text" name="end_date"class="form-control" />
									
                                    <hr />
                                    <input  type="submit" name="editEntrySubmit" value="Update" class="btn btn-primary"/>
                                </div>
                                
                            </div>
                        </form>
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