<?php
/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

?>
<?php
	
	require_once(__DIR__."/includes/connection.php"); 
	require_once(__DIR__."/includes/functions.php");
	require_once(__DIR__."/includes/constants.php");
//require_once(__DIR__."/includes/analyticstracking.php");

?>
<?php
//Get Active Chapter;
$active_chapter = null;
$active_chapters = get_active_chapter();
if($active_chapters != false)
{
	foreach($active_chapters as $ac) {
	
		$active_chapter = $ac;

	}
}
?>
<?php
session_start();
$name="";
$data="";

$searchFlag=false;





if(isset($_POST['submitSearchBtn'])){
	
	if(isset($_POST['name']) && $_POST['name'] != ""){
		$name= $_POST['name'];
		$data = searchDisplay($name,$active_chapter['chapter_id']);
		$searchFlag=true;
		$_SESSION['searchFlag'] = 1;
		$_SESSION['data']= $data;
		$_SESSION['name'] = $name;
        header("Location:fullPoem.php");
       exit;
		
		
	}
	

}else{
$searchFlag=false;
$name="";
$data="";




}


?>

<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Last2Lines is unconventional way to protest against any kind of injustice in the form of poetry. Last2Lines is a medium to express and register our protest peacefully using two lines of poetry.">
		
		<meta name="keywords" content="Last2Lines, L2L, Last Two Lines, Kashmir, Protest, Poetry">
		
		<meta name="author" content="Abdul Wajid , Ubaid Darwaish">
		<title>Last2Lines</title>
        <meta name="description" content="">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		
		<!-- Style -->
        <link rel="stylesheet" href="css/main.css">
		
		<!-- Responsiv -->
		 <link rel="stylesheet" href="css/responsive.css">

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		
		
        
		<!-- Animations min -->
		<link rel="stylesheet" href="css/animations.min.css">
		
		<!-- Lightbox -->
		<link rel="stylesheet" href="css/lightbox.css" />
       
		<!-- Custom Style -->
        <link rel="stylesheet" href="css/customStyle.css">
		
		<!-- Script -->
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
			
			<!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
<!--[if IE]><link rel="shortcut icon" href="favicon.png"><![endif]-->

<!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. --> 
<link rel="apple-touch-icon-precomposed" href="favicon.png">

<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. --> <link rel="icon" href="favicon.png">


<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/vendor/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/typeahead.js"></script>
<style>


#header .navbar-fixed-top{
	background: #2A3039;
	width: 100%;
	height: 70px;

}
#poemSummary{
	//background:url(img/poem_lg.png) no-repeat;
	
}
#poemSummary .container-full{
	margin-top:150px;
	background:#ffffff;
	opacity:0.9;
	border-radius:20px;
}
#poemSummary{
color: #000000;
}

.tt-hint,
        .autosearch {
            border: 2px solid #CCCCCC;
            border-radius: 6px 6px 6px 6px;
            font-size: 24px;
            height: 35px;
            line-height: 20px;
            outline: medium none;
            padding: 6px 8px;
            width: 220px;
        }

        .tt-dropdown-menu {
            width: 220px;
            margin-top: 5px;
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px 8px 8px 8px;
            font-size: 18px;
            color: #111;
            background-color: #F1F1F1;
        }
   

</style>
<script>
        $(document).ready(function() {

            $('input.autosearch').typeahead({
                name: 'name',
                remote: 'search.php?<?php echo "chid={$active_chapter['chapter_id']}";?>&query=%QUERY'
				

            });

        })
    </script>
	
	
	
    </head>
	

    <body>
        <!-- Header -->
			<header id="header">

					<nav id="head-nav" class="navbar topnavbar navbar-fixed-top" role="navigation" data-spy="affix" data-offset-top="200">
						<div class="container">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
									<i class="fa fa-bars"></i>
								</button>
								<a href="index.php#header" class="navbar-brand header"><img src="img/logo.png" alt=""></a>
							</div> <!-- /#navbar-header -->

							<!-- Navigation -->
							<div class="collapse navbar-collapse" id="navbar">
								<ul class="nav pull-right navbar-nav" id="">
									
									
									<li><a href="index.php#header">Home</a></li>
									<li><a href="index.php#about">About</a></li>
									<li><a href="index.php#currentCouplet">Poem</a></li>
									<li><a href="index.php#write">Write Now</a></li>
									<li><a href="index.php#submissionGuidelines">Guidelines</a></li>
									<li class="active"><a href="fullPoem.php">Full Poem</a></li>
									<li class="dropdown" id="archivesDropdownMenu"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Archives <span class="caret"></span></a>
			  <?php
			  $chapterArchives = null;
			  $chapterArchives = getAllChapters();
			  ?>
			  <ul role="menu" class="dropdown-menu">
				
				<?php
				foreach($chapterArchives as $chapter){
				
				echo "<li><a href=\"archives.php?chID={$chapter['chapter_id']}\">".$chapter['chapter_name']."</a></li>";
				
				}
				
				?>
				
				
			  </ul>
			  </li>
									
								</ul>
							</div>
						</div>
					</nav> <!-- /#navbar -->
		</header>


		
<div id="poemSummary" class="row">
			<div class="col-md-offset-1 col-lg-offset-1 col-md-7 col-lg-7">
				<div id="currentCouplet" class="container-full">
					<div class="container">
						<div class="bm-remove " >
							<div class="">


		  
		  <div class="poem">
			  <div class="">
			  <?php
				if(!isset($_SESSION["data"])){
				//echo $active_chapter['chapter_name'];
				$xyz;
				}else{
					if($_SESSION["data"] == "")
					{echo "<h3>Sorry no results for <strong>{$_SESSION['name']}</strong>!!</h3><br/>
					<h4 class=\"\">
<strong style=\"color:#111;\">Looks like your contribution is wanted. </strong><br/><br/><a class=\"btn btn-green\" href=\"index.php#write\">Lets Write Now <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>
<strong style=\"color:#111;\"><br/><br/>.. because without you we cannot make a difference.</strong>

</h4>
					
					";
					
					}
					else
					{echo "<div><h3>Search results for <strong>{$_SESSION['name']}</strong> :</h3></div>";}}
			  
			  
			  ?>
			  
			  </div>
			  
		  <!-- Display search results -->
<?php 
	if(isset($_SESSION["data"]))
	{echo "<br/>";
	
if(isset($_SESSION["data"]))
{
echo "<div class=\"text-warning\">";
echo $_SESSION["data"];
echo "</div>";

echo "<br/><h3 class=\"text-muted\">------------------------------</h3>";




unset($_SESSION["data"]);
}

	
	}
	
	
?>
<!-- Display search results -->
<h3>
<?php 

echo "The Poem: <strong>" . $active_chapter['chapter_name'] . "</strong>";  

?>
</h3>
			  <hr class="col-sm-6"/>
			  
			  <br/><br/>
			  
			  
			  
			  <div class="">
<!-- Read Poem -->




<?php
$fullPoem="";
$fullPoemFlag = false;
if(isset($_GET['page']))
{
if($_GET['page'] == 000)
	$fullPoemFlag = true;
else
	$fullPoemFlag = false;
}else{
	$fullPoemFlag = false;
}

if($fullPoemFlag){
$poemFileName = "poem" .$active_chapter['chapter_id'] .".txt"; 
$handle = fopen($poemFileName, "r");

//$handle = fopen("poem.txt", "r");
if ($handle) {
	$counter=1;
    while (($line = fgets($handle)) !== false) {
        $line = str_replace("\n", "", $line);
		if($counter%3 == 0){
			$fullPoem.= "<h4><span class=\"text-primary\">"."( ".str_replace("\\", "", htmlspecialchars($line)).")</span></h4><br/>";
		}else{ 
			$fullPoem.= "<h4>".str_replace("\\", "", htmlspecialchars($line))."</h4>";
		}
		$counter++;
    }
    fclose($handle);
}
}
?>
			  </div>
		  
<br/>

<!-- Pagination -->
<?php
	

	$tbl_name="current_table";//your table name
	
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	global $connection;
	
	$query = "SELECT COUNT(*) FROM current_table WHERE chapter_id = {$active_chapter['chapter_id']}";
	$total_pages = mysqli_fetch_array(mysqli_query($connection ,$query),MYSQLI_NUM);
	$total_pages = $total_pages[0];
	
	/* Setup vars for query. */
	$targetpage = "fullPoem.php"; 	//your file name  (the name of this file)
	$limit = LIMIT_PER_PAGE; 								//how many items to show per page
	
	if(!isset($_GET['page']))
	$_GET['page'] = 1;
	
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT line1,line2,name FROM $tbl_name WHERE chapter_id = {$active_chapter['chapter_id']} ORDER BY dateTime LIMIT $start, $limit";
	$result = mysqli_query($connection , $sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination pagination-md\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li><a href=\"$targetpage?page=$prev\">&laquo; Previous</a></li>";
		else
			$pagination.= "<li class=\"disabled\"><a href=\"#\">&laquo; Previous</a></li>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$pagination.= "<li class=\"";
					
					if(!$fullPoemFlag)
					$pagination.= "active";
					
					$pagination.= "\"><a href=\"$targetpage?page=$counter\">$counter</a></li>";}
				else
					$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page){
						$pagination.= "<li class=\"";
						
						if(!$fullPoemFlag)
						$pagination.= "active";
						
						
						$pagination .= "\"><a href=\"$targetpage?page=$counter\">$counter</a></li>";}
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
				}
				$pagination.= "<li><a href=\"#\">...</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
				$pagination.= "<li><a href=\"#\">...</a></li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page){
						$pagination.= "<li class=\"";
						
						
						if(!$fullPoemFlag)
					$pagination.= "active";
						
						
						$pagination .= "\"><a href=\"$targetpage?page=$counter\">$counter</a></li>";}
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a><li>";					
				}
				$pagination.= "<li><a href=\"#\">...</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
				$pagination.= "<li><a href=\"#\">...</a></li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$pagination.= "<li class=\"";
						
						if(!$fullPoemFlag)
					$pagination.= "active";
						
						$pagination .= "\"><a href=\"$targetpage?page=$counter\">$counter</li></a>";}
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1 && !$fullPoemFlag) 
			$pagination.= "<li><a href=\"$targetpage?page=$next\">Next &raquo;</a></li>";
		else
		$pagination.= "<li class=\"disabled\"><a href=\"#\">Next &raquo;</a></li>";
		$tempString = "";
		$tempString = "<li class=\"";
		
		if($fullPoemFlag)
		$tempString.= "active";
		
		$tempString .= "\"><a href=\"fullPoem.php?page=000\">Full Poem</a></li>";
		
		$pagination.= $tempString;
		
		//$pagination.= "<li class=\"active\"><a href=\"fullPoem.php?page=000\">Full Poem</a></li>";
		
		$pagination.= "</ul>\n";		
	}
?>
<?php
		if(!isset($_SESSION["data"]))
		if(!$fullPoemFlag){while($row = mysqli_fetch_array($result,MYSQLI_NUM))
		{
	
		// Your while loop here
		echo "<h4>".$row[0]."</h4>";
		
		echo "<h4>".$row[1]."</h4>";
		
		echo "<h4>"."<span class=\"text-primary\"> ( ".$row[2]." )</span>"."</h4>";
		
		echo "<br/>"; 
	
		}
		}
	?>

<br/>

<section >
<?php
	if(!isset($_SESSION["data"]))
	if($fullPoemFlag)
		echo $fullPoem;
	
	if(!isset($_SESSION["data"]))
		echo $pagination;
?>
</section>
<hr class="col-md-6
<?php
if(isset($_SESSION["data"]))
echo "hidden";
?>
"/>	
<br/>
<!-- Pagination -->
<br/>
<h3 class="
<?php
if(isset($_SESSION["data"]))
echo " hidden";
?>
">
<a class="btn btn-green" href="index.php#write">Write Your Two Lines</a>
</h3>
<br/>

				



</div>
						
						</div>
		 
		
		</div>
		
		 
						
				</div>				
</div>
</div> 
		
<div class="OtherChaptersFromArchive col-md-4 col-lg-4 ">
<br/><br/><br/><br/><br/>			  
<div class="container">

<!-- Search -->
<div class="" >
<form action="fullPoem.php" method="post" >
            <h3 class="text-info">Search your couplet(s)</h3>
			<hr/>
            <input type="text" name="name" size="" class="autosearch" placeholder="Please enter a name">
			<br/><br/>
			<input type="submit" name="submitSearchBtn" value="Search" class="btn btn-submitSearchBtn"/>
			<br/>
			
        </form>
		
		
<br/>
</div>
<!-- Search -->
<br/><br/>
<h3 class="text-info">Other chapters from our archive:</h3>

<hr/>

<?php
$chapterArchives = null;
$chapterArchives = getAllChapters();
foreach($chapterArchives as $chapter){
if($chapter['chapter_id'] != $active_chapter['chapter_id'])
echo "<a class=\"btn btn-green-archives\" href=\"archives.php?chID={$chapter['chapter_id']}\">{$chapter['chapter_name']}</a>
<br/><br/>";


}





?>

<br/>
</div>
		  </div><!--Poem-->
	</div> 
			
			<!-- /#Mobile description -->
			
	
			

			<!-- footer -->
			<footer id="footer">
				<div class="container-full">
					<div class="container">
						<div class="bm-remove animate" data-anim-type="fadeInDownLarge">
							<div class="col-md-12 text-center">
							
<div class="hidden-xs">
			
				<br/>
				<a href="index.php"><strong>Home</strong> </a><a href="privacyPolicy.php"> | Privacy Policy | </a><a href="tnc.php"> T&amp;C</a>
				
				
		
		<div class="">
								<br/>
								<p class="">copyright &copy; <?php echo date('Y');?> <a href="index.php">Last2Lines.com</a>
								&nbsp;|&nbsp;All Rights Reserved.</p>
	<!--							
	<p class="">
		
		Combined work of&nbsp;<a href="#" target="_new" title="Ubaid Darwaish">Ubaid Darwaish</a> &amp; <a href="http://www.facebook.com/abdulwajid786" target="_new" title="Abdul Wajid">Abdul Wajid</a><br/>Photo courtesy: <a href="http://www.facebook.com/basitparray" target="_new" title="Abdul Basit">Abdul Basit</a>
	</p>
	-->


							</div>
</div>
<div class="hidden-xs">
								<div class="socile">
									<ul>
										<li><a href="http://www.facebook.com/last2lines" target="_new"><i class="fa fa-facebook"></i></a></li>
										<li><a href="http://www.twitter.com/last2lines" target="_new"><i class="fa fa-twitter" ></i></a></li>
										<li><a href="#myModal" role="button" data-toggle="modal" title="Contact Last2Lines"><i class="fa fa-info-circle"></i></a></li>
										
									</ul>
									
								</div>

								</div>
								
<div class="visible-xs">
<div class="text-left">
<a href="index.php"><strong>Home</strong></a>
<br/>
<a href="privacyPolicy.php">Privacy Policy</a>
<br/>
<a href="tnc.php">T&amp;C</a>
</div>
</div>
<div class="visible-xs">
<div class="text-left">
<br/><p class="">copyright &copy; <?php echo date('Y');?><a href="index.php"> Last2Lines.com</a><br/>
All Rights Reserved.</p>

<!--
<p class="">
Combined work of&nbsp;<a href="#" target="_new" title="Ubaid Darwaish"> Ubaid Darwaish </a>
and<a href="http://www.facebook.com/abdulwajid786" target="_new" title="Abdul Wajid"> Abdul Wajid</a>
<br/>Photo courtesy: <a href="http://www.facebook.com/basitparray" target="_new" title="Abdul Basit">Abdul Basit</a></p>-->
</div>
</div>
<div class="visible-xs">
<div class="socile">
	<ul>
		<li><a href="http://www.facebook.com/last2lines" target="_new"><i class="fa fa-facebook"></i></a></li>
		<li><a href="http://www.twitter.com/last2lines" target="_new"><i class="fa fa-twitter" ></i></a></li>
		<li><a href="#myModal" role="button" data-toggle="modal" title="Contact Last2Lines"><i class="fa fa-info-circle"></i></a></li>
		
	</ul>
									
</div>

</div>
	
</div>
</div>
						<div class="span1">
							<a id="gototop" class="gototop pull-right" href="#"><i class="icon-angle-up"></i></a>
						</div>
						
				
					</div>
				</div>

	
		
	

			</footer> <!-- /#footer -->
<!-- Modal Window -->
<!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Contact Last2Lines</h3>
            </div>
            <div class="modal-body">
                <h4>For any queries/issues please contact us at <a href="mailto:contact@last2lines.com">contact@last2lines.com</a></h4>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-warning" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<!-- Modal Window -->
		
        <script src="js/plugins.js"></script>
        
        <script src="js/main.js"></script>
        <script src="js/animations.min.js"></script>
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Counters -->
	<script src="js/jquery.countTo.js"></script>
        <script src="js/lightbox.min.js"></script>
        <script src="js/smoothscroll.js"></script>
        <script src="js/visible.min.js"></script>
        <script src="js/jquery.nav.js"></script>
	 

    </body>
</html>

