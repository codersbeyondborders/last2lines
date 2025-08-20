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



/*** Delete Author **/
	if (isset($_POST['deleteEntrySubmit'])) {
		$coupletToDelete = null;
		$deleteFlag = false;
		$deleteMessage = "";
		$chapterId = null;
		
		if(isset($_POST['coupletToDelete']))
		$coupletToDelete = mysql_prep($_POST['coupletToDelete']);
		
		if(isset($_POST['chapterId']))
		$chapterId = mysql_prep($_POST['chapterId']);
		
		
		if($coupletToDelete !=null && $chapterId !=null)
			$deleteFlag = true;
		else 
			$deleteFlag = false;
		
		
			
		
	if($deleteFlag){
			//success
				if(!IDcheckIfExists($coupletToDelete)){
					$deleteMessage = "No Such ID exists!!";
				}else if(!authenticateCoupletChapterID($coupletToDelete,$chapterId)){
				$deleteMessage = "Chapter ID and Couplet ID do not Match";
		}else if(delete_author_by_id($coupletToDelete)){
				
				
//Overwrite poem file afresh

//populate and overwrite poem2.txt


$myFile2 = "../poem".$chapterId."_copy".".txt";
//$myFile2 = "../poem2.txt";
$myFileLink2 = fopen($myFile2, 'w+') or die("Can't open the file.");

$line1=null;
$line1=null;
$name=null;
$last_author = null;
$authors_result_set = getEntriesByChapter($chapterId);
if($authors_result_set != false)
{
	foreach($authors_result_set as $author ) {
		$line1=$author['line1'];
		$line2=$author['line2'];
		$name=$author['name'];
		$verse1 = $line1.PHP_EOL;
		fwrite($myFileLink2, $verse1);
		$verse2 = $line2.PHP_EOL;
		fwrite($myFileLink2, $verse2);
		$authorName = $name.PHP_EOL;
		fwrite($myFileLink2, $authorName);
		$last_author = $author;
		}
}	
fclose($myFileLink2);
						

//swap and rename poem files
$fileNameNew = "../poem".$chapterId.".txt";
$fileNameTemp = "../poemTemp.txt";
$fileNameOld = "../poem".$chapterId."_copy".".txt";



rename($fileNameNew, $fileNameTemp);
rename($fileNameOld, $fileNameNew);
rename($fileNameTemp, $fileNameOld);

//write to lastCouplet poetry file lastCouplet.txt
$myFile3 = "../lastCouplet".$chapterId.".txt";

$myFileLink3 = fopen($myFile3, 'w+') or die("Can't open the file.");
//$last_author = get_last_author();

$newContents1 = $last_author['line1'].PHP_EOL;
$newContents2 = $last_author['line2'].PHP_EOL;
$newContents3 = $last_author['name'];
fwrite($myFileLink3, $newContents1);
fwrite($myFileLink3, $newContents2);
fwrite($myFileLink3, $newContents3);
fclose($myFileLink3);

//write to lastCouplet poetry file lastCouplet.txt			
				
$_SESSION['adminMsg'] = "Deleted Successfully!!";
redirect_to("dashboard.php");}else{
				$deleteMessage = "Failed To Delete!!";
				}
				
			}else{
				$deleteMessage = "Both Fields Are Required.";
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
                    <div class="col-md-12">
					<br/>
					<h2>Delete Couplet</h2>
					<hr/>
						
					</div>
					
					<div class="col-md-12">
                        <!-- DELETE COUPLET -->
						<?php if (!empty($deleteMessage)) {echo "<br/><p class=\"text-danger\">" . $deleteMessage . "</p>";} ?>
						
						<form class="Compose-Message"
						action="dashboardDeleteCouplet.php" method="post"
						>
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    Delete Couplet
                                </div>
                                <div class="panel-body">
                                    
                                    

                                    
									<label>Enter author-couplet ID:  </label>
                                    <input type="text" name="coupletToDelete"class="form-control" />
                                    <label>Enter Chapter ID:  </label>
                                    <input type="text" name="chapterId"class="form-control" />
									
                                    <hr />
                                    <input  type="submit" name="deleteEntrySubmit" value="submit" class="btn btn-danger"/>
                                </div>
                                
                            </div>
                        </form>
                        <!-- Delete Entry-->
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