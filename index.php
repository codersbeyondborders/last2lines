<?php 
/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

  require_once(__DIR__."/includes/session.php");
  require_once(__DIR__."/includes/connection.php"); 
  require_once(__DIR__."/includes/functions.php");
 require_once(__DIR__."/includes/analyticstracking.php");

  //Total Count Of Authors
  $count = get_number_of_authors();
  $couplets = $count*2;

?>

<?php
//Get Active Chapter
$active_chapter = null;
$active_chapters = get_active_chapter();
if($active_chapters != false)
{
	foreach($active_chapters as $ac) {
	
		$active_chapter = $ac;

	}
}
$first2Couplets =null;
$first2Couplets = getFirst2Couplets($active_chapter['chapter_id']);



?>



<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Last2Lines is a medium to express and register a peaceful campaign using two lines of poetry.">
		
		<meta name="keywords" content="Last2Lines, L2L, Poem, Spoken poetry, Last Two Lines, Kashmir, Protest, Poetry, Campaign, Ghazal, Charity">
		
		<meta name="author" content="Abdul Wajid , Ubaid Darwaish">
        <title>Last2Lines</title>
		<!-- Style -->
        <link rel="stylesheet" href="css/main.css">
		<!-- Responsive -->
		<link rel="stylesheet" href="css/responsive.css">
        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
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
		<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. --> 
		<link rel="icon" href="favicon.png">
<div id="fb-root"></div>

<style>
	.video-container {
    overflow: hidden;
    position: relative;
    width:100%;
}

.video-container::after {
    padding-top: 56.25%;
    display: block;
    content: '';
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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
			<a href="index.php" class="navbar-brand header"><img src="img/logo.png" alt=""></a>
		  </div> <!-- /#navbar-header -->
		  <!-- Navigation -->
		  <div class="collapse navbar-collapse" id="navbar">
		    <ul class="nav pull-right navbar-nav" id="main_navigation_menu">
			  <li><a href="index.php#header">Home</a></li>
			  <li><a href="#about">About</a></li>
			  <li><a href="#currentCouplet">Poem</a></li>
			  <li><a href="#write">Write Now</a></li>
			  <li><a href="#submissionGuidelines">Guidelines</a></li>
			  <li><a href="fullPoem.php">Full Poem</a></li>
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


	  
	  <!-- Poetry Carousal -->
	  <section id="poetryCarousal">
	    <div class="container-full">
		  <div class="bm-remove animate" data-anim-type="fadeInLeft">
		    <div class="carousel slide" id="tweet-carousel">
			  <div class="carousel-inner">
			    <?php
  $handle = fopen("carousalPoem.txt", "r");
  
  if ($handle) {
    $counter=1;
	$slideNumber=1;
    while (($line = fgets($handle)) !== false) {
      $line = str_replace("\n", "", $line);
      $line = str_replace("\'", "'", $line);
	  if($counter ==1 || ($counter-1)%3==0){
	  echo "<div class=\"item"; 
	  if($counter ==1){echo " active";}
	  echo"\""; 
	  echo "id=\"slide{$slideNumber}";
	  echo"\">";
				 
				 echo" <br/><br/><br/><br/><br/><br/><br/><div class=\"container\" >
				    <div class=\"content text-center\" style=\"background:#111;opacity:0.6;border-radius:20px;padding:10px;\" >
					 ";
					  }
				if($counter%3==0){
				echo"<p class=\"poetName\">
					  <strong>{$line}</strong>
					  </p>";
				}else{
				echo"<p>{$line}</p>";

					  }
	$counter++;
				if(($counter-1)%3==0){
				echo "</div>
				  </div>
				</div>";}
	  
	  if($counter%4 == 0){
		$slideNumber=$slideNumber+1;
	  }
	  
	  
    }
    fclose($handle);
  }
?>
				
				
				
			  </div><!-- carousel-inner -->
			  <!-- Controls -->
			  <a class="left carousel-control" data-slide="prev" href="#tweet-carousel"><span class="icon-prev"></span></a>
			  <a class="right carousel-control" data-slide="next" href="#tweet-carousel"><span class="icon-next"></span></a>			
			</div><!-- /#TwitterCarousel -->
		  </div>
		  
		</div>
		
	  </section> <!-- /#poetryCarousel -->
	</header> <!-- /#header -->
	
	<!--Screen Test
	<h1 class="visible-xs">XS</h1>
  <h1 class="visible-sm">SM</h1>
  <h1 class="visible-md">MD</h1>
  <h1 class="visible-lg">LG</h1>
 
	-->

<!-- COUNTER -->
<div id="ourJourneySoFar" class="fh5co-counters" style="background-color:#f1e9e6;padding:0">
			<div class="container" style="background-color:#f1e9e6;">
				<div class="row to-animate">
					<div class="col-12 text-center">
						<h2 class="currentPoemTitle">
							
								<?php 
					   echo "\"" .
					  	$active_chapter['chapter_name'] 
					  	. "\"";
					  ?>
					</h2>
				</div>
					
					<div class="col-md-offset-2 col-md-3 text-center">
						
						<span class="fh5co-counter js-counter" data-from="1" data-to="1" data-speed="1000" data-refresh-interval="50" style="background:#333;font-size:85px;color:#FFF;">1</span>
						<span class="fh5co-counter-label" style="font-weight:bolder;color:#333">Voice</span>
					</div>
					
					<div class="col-md-3 text-center">
						<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo "{$count}";?>" data-speed="1000" data-refresh-interval="60" style="background:#333;font-size:85px;color:#FFF;"></span>
						<span class="fh5co-counter-label" style="font-weight:bolder;color:#333">Authors</span>
					</div>
					
					<div class="col-md-3  text-center">
						<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo "{$couplets}";?>" data-speed="1000" data-refresh-interval="60" style="background:#333;font-size:85px;color:#FFF;"></span>
						<span class="fh5co-counter-label" style="font-weight:bolder;color:#333">Lines</span>
					</div>
					
					
				</div>

				 <div class="text-center">
						<a style="padding:10px 20px;font-size:20px;font-weight:bold;background-color: #333;color: #fff;" class="btn" href="#write">Write Your Two Now</a>
				</div>
				
				
			</div>
		</div>
<!-- COUNTER -->
	
	<!-- about  -->
	<section id="about">
	  <div class="container-full">
	    <div class="container">
		  <div class="row bm-remove animate" data-anim-type="zoomInUp">
		    <div class="about_content">
			  <div class="col-md-12">
			    <div class="web_content">
				  <h1 class="text-center">ABOUT THE CAUSE</h1>
				  <br/>
				  <p><strong>Last2Lines</strong> is a medium to express and register a peaceful campaign using two lines of poetry. It is an unconventional method, first of its kind, where we contribute two lines of poetry for a cause, presently 
				  <strong><?php
				  //get_active_chapter_name();
				  echo $active_chapter['chapter_name'];
				  ?></strong>.
				  </p>
				  <p>
				  <?php
				  //get_active_chapter_summary();
				  echo $active_chapter['chapter_summary'];
				  ?>
				  
				  </p>
				  <!--<p><strong>Last2Lines</strong> attempts to give life to the words that are buried deep inside your heart, silenced and choked, too afraid to surface and the words that bring hope, spread love and make peace. So take a moment to listen to your heart and write down the two lines that it echoes back to you.</p>
				  <p>Let us all contribute our two lines towards creating the longest poem ever with exceptional confluence of authors, unified with one vision of peace: <strong>let’s write while we last.</strong></p>-->
				  <br/>
				  <div class="video-container" style="padding:40px;"><iframe width="560" height="315" src="https://www.youtube.com/embed/0TlOwAluQj8?si=FmCrs7C3BWHZHTP5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>
				  <br/><br/>
				  <div class="text-center">
				    
				    <a style="background:#000000;border: none;" class="btn" href="#submissionGuidelines">Guidelines</a>
						
						&nbsp;
						
						<a style="background:#FFFFFF;color:#000000;border: none;" class="btn" href="#learnMore">Learn More</a>
						
						<br/>
						<br/>

						<a style="background:#ce1126;border: none;" class="btn" href="#write">Write Now</a>
						
						&nbsp;
						
						<a style="background:#007a3d;border: none;" class="btn" href="https://last2lines.com/fullPoem.php" target="_new">Read Poem</a>
						
						
						<br/>
						<br/>
					
					</div>
				  
				  <br/>
				  <br/>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section> <!-- /about  -->
	<!-- poemSummary -->
	<div id="poemSummary">
	  <div id="poemSummaryBG" style="background:#000;color:#fff;">
	    <div id="currentCouplet" class="container-full">
		  <div class="container">
		    <div class="row bm-remove animate" data-anim-type="fadeInRight">
			  <div class="col-md-12 text-center">
			    <div class="">
			    	<h1 class="text-center" style="margin-bottom: 30px;">
			    		CURRENT POEM
			    	</h1>

				  <h2 class="currentPoemTitle">
				  <span style="border-bottom: 1px dashed #fff;"><?php
				  //get_active_chapter_name();
				  echo '"' . $active_chapter['chapter_name'] . '"';
				  ?>
					</span>
				  </h2>
				  <br/>
				  <br/>
				  <div class="currentPoem">
				    <p><?php
				  //get_active_chapter_line1();
				  
				  echo str_replace("\\", "", $first2Couplets[0]['line1']);
				  //echo $active_chapter['line1'];
				  ?></p>
					<p><?php
				  //get_active_chapter_line2();
				  echo str_replace("\\", "", $first2Couplets[0]['line2']);
				  //echo $active_chapter['line2'];
				  ?>
					</p><h4><span class="">( <?php
				  //get_active_chapter_name1();
				  echo str_replace("\\", "", $first2Couplets[0]['name']);
				  //echo $active_chapter['name1'];
				  ?> )</span>
					</h4>
				  </div>
				  <br/>
				  <div class="currentPoem">
				    <p><?php
				  //get_active_chapter_line3();
				  echo str_replace("\\", "", $first2Couplets[1]['line1']);
				  //echo $active_chapter['line3'];
				  ?></p>
					<p><?php
				  //get_active_chapter_line4();
				  echo str_replace("\\", "", $first2Couplets[1]['line2']);

				  //echo $active_chapter['line4'];
				  ?>
					  </p><h4><span class="">( <?php
				  //get_active_chapter_name2();
				  echo str_replace("\\", "", $first2Couplets[1]['name']);

				  //echo $active_chapter['name2'];
				  ?> )</span>
					</h4>
				  </div>
				  <div class="text-center dotDotDot currentPoem">
				    <h2>.</h2>
					<h2>.</h2>
					<h2>.</h2>
					<!-- Read Poem -->
<?php

$lastCoupletFileName = "lastCouplet".$active_chapter['chapter_id'].".txt";
//$lastCoupletFileName = "lastCouplet.txt";
  $handle = fopen($lastCoupletFileName, "r");
  
  if ($handle) {
    $counter=1;
    while (($line = fgets($handle)) !== false) {
      $line = str_replace("\n", "", $line);
	  if($counter%3 == 0) {
		echo "<h4><span class=\"\">"."( ".str_replace("\\", "",htmlspecialchars($line)).")</span></h4><br/>";
		}else if($counter%2 == 0) {
			echo "<p>".str_replace("\\", "",htmlspecialchars($line))."</p>";
		}else{
			echo "<p>".str_replace("\\", "",htmlspecialchars($line))."</p>";
		}
		
	  $counter++;
    }
    fclose($handle);
  }
?>
                  <br/>
				  <div class="">
				    <a href="#write" style="color:#fff;font-size:24px;">
			          <h4 class=""><i class="fa fa-plus" aria-hidden="true"></i> Add Your <strong>Two Lines</strong> To The Poem
				        <span class=""><br/>(Your Name)</span>
				      </h4>
				    </a>
				    <br/>
				  </div>
				</div>
			  </div>
			  <div class="col-md-12 text-center">
			    <div class="">
				  <div class="">
				    <a href="#write" class="btn btn-green">Enter</a>
				  </div>
				</div>
			  </div>
		    </div>
		  </div>
		</div>
	  </div> 
    </div>
	<!-- /#poemSummary -->
	<!-- footer top -->
	<div class="red-triangle"></div>
	<footer id="write" >
	  <div class="container-full" style="background-color:#007a3d !important;">
	    <div class="container">
		  <div class="row bm-remove animate" data-anim-type="bounceIn">
		    <div class="footer-text
			  <?php
			    if(isset($_SESSION['tokenTest']))
				  if($_SESSION['tokenTest'] == 'correctToken')
				    echo 'hidden';
			  ?>">
			  <h1 style="color:#FFF;">Write Your LAST TWO LINES</h1>
			  <p style="color:#FFF;">and contribute in weaving the longest piece of poetry on <?php echo '<strong>"' . $active_chapter['chapter_name'] . '</strong>"';?></p>
			</div>
	        <form class="col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8
			  <?php  
			    if(isset($_SESSION['tokenTest']))
				  if($_SESSION['tokenTest'] == 'correctToken')
				    echo 'hidden';?>" id="coupletForm" action="" method="POST">
                <label for="authorName" class="control-label">Name</label>
                <div>
				  <input type="text" name="authorName" class="form-control" placeholder="e.g. Jane Doe" 
				  <?php 
				    if(isset($_SESSION['authorName'])) {
					  echo "value=\"{$_SESSION['authorName']}\"";
				    }
				  ?>required>
				</div>
				<div class="messageContainer"></div>
                <br/>
				<label for="authorEmail" class="control-label">Email</label>
                <div>
				  <input type="email" name="authorEmail" class="form-control" placeholder="e.g. jane_doe@gmail.com"
				  <?php 
				    if(isset($_SESSION['authorEmail'])){
					  echo "value=\"{$_SESSION['authorEmail']}\"";
				    }
					?>required>
				</div>
				<div class="messageContainer"></div>
                <br/>
				<label for="line1" class="control-label">First Verse</label>
                <div>
                  <input type="text" name="line1" class="form-control" placeholder="e.g. <?php
				  //get_active_chapter_line1();
				  echo $first2Couplets[0]['line1'];
				  //echo $active_chapter['line1'];
				  ?>" 
				  <?php 
				    if(isset($_SESSION['authorLineOne'])) {
					  echo "value=\"{$_SESSION['authorLineOne']}\"";
					}
					?>required>
				</div>
				<div class="messageContainer"></div>
                <br/>
				<label for="line2" class="control-label">Second Verse</label>
                <div>
                  <input type="text" name="line2" class="form-control" placeholder="e.g. <?php
				  //get_active_chapter_line2();
				  echo $first2Couplets[0]['line2'];
				  //echo $active_chapter['line2'];
				  ?>" 
				  <?php 
				    if(isset($_SESSION['authorLineTwo'])) {
					  echo "value=\"{$_SESSION['authorLineTwo']}\"";
				    }
				  ?>required/>
			    </div>
				<div class="messageContainer"></div>	
				  <div class="checkbox">
				    <label>
				      <input type="checkbox" required value="YES" name="tnc">I have read and agree to the <a href="tnc.php" target="_new" title="Terms And Conditions" style="color:#000;">Terms and Conditions.</a>
				    </label>
				</div>
               <div class="footer-text">
			     <br/>
			     <input type="submit" value="Submit" name="newUsersubmit" id="newUsersubmit" class="btn btn-red"/>
			</div>
		  </form>
		  <div class="col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
		    <div class="output"></div>
		  </div>

		  <?php
		    $afterTokenMsg0 = "<div class=\"col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8\">
		<h4 class=\"text-danger\"><i class=\"fa fa-exclamation-circle text-danger\" aria-hidden=\"true\"></i> Answer is required</h4>
	</div>";
			$afterTokenMsg1 = "<div class=\"col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8 text-center\">
		<h1 class=\"text-success\"><i class=\"fa fa-check-square text-success\" aria-hidden=\"true\"></i> Thank you for your last two lines.</h1>
		<p>Your couplet has reached our editor's desk. It will be published within 24 hours after moderation. <br/>Please visit us again.</p>
		
		<p>You can also help us spread awareness about our poetry campaign by sharing this <a href=\"https://www.youtube.com/watch?v=a-gAJCvJXfc\" target=\"_new\">introductory video</a>.</p>
	</div>";
			$afterTokenMsg2 = "<div class=\"col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8 text-center\">
		<h4 class=\"text-danger\"><i class=\"fa fa-exclamation-circle text-danger\" aria-hidden=\"true\"></i> Wrong Answer!!  Please try again.</h4>
	</div>";
	
		    if(isset($_SESSION['tokenTest'])) {
			  if($_SESSION['tokenTest'] == 'noToken') {
			    echo $afterTokenMsg0;
			  }else if($_SESSION['tokenTest'] == 'correctToken') {
			    echo $afterTokenMsg1;
		      }else if($_SESSION['tokenTest'] == 'wrongToken') {
			    echo $afterTokenMsg2;
		      } else {
			    echo "";
		      }
		      $_SESSION['tokenTest'] ='';
			}
	      ?>
	      </div>
	    </div>
	  </div>
	</footer> <!-- write -->

	<?php
	  $_SESSION['tokenTest'] = '';
	  $_SESSION['authorName'] = '';
	  $_SESSION['authorEmail'] = '';
	  $_SESSION['authorLineOne'] = '';
	  $_SESSION['authorLineTwo'] = '';
	?>

	<!-- Submission Guidelines-->
	<div id="submissionGuidelines">
	  <div class="container-full">
	    <div class="container">
		  <div class="row to-animate">
		    <div class="col-md-12 text-center">
			  <h1 class="to-animate">SUBMISSION GUIDELINES</h1>
			</div>
			<div class="col-md-12">
			  <div class="to-animate">
			    <br/>
				<ul>
				
				<?php
				$str = $active_chapter['guidelines'];
				$arr = explode(PHP_EOL, $str);
				for($i=0 ; $i<sizeof($arr);$i++){
					echo "<li><p><i class=\"fa fa-arrow-right\"></i>&nbsp;&nbsp;";
					echo $arr[$i];
					echo "</p></li>";
				}
				?>
				
				</ul>
			  </div>
			</div>
			
			<!--Example Code commented for now bcz of no example available 
			<div class="col-md-12">
			  <h3>Example :</h3>
			  <div class="text-center to-animate">
				<?php
				//echo "<img class=\"img-thumbnail img-responsive\"src=\"img/Example{$active_chapter['chapter_id']}.png\"/>";
				?>
				</div>
			</div>
			-->
  <div class="text-center">
			<a class="btn btn-green" href="#write">Lets Write Now</a>
</div>
		  </div>
		</div>
	</div>
</div>	
<!-- Submission Guidelines-->

<!-- DONATE  -->
	<section id="learnMore">
	  <div class="container-full" style="color:#222 !important;">
	    <div class="container">
		  <div class="row bm-remove animate" data-anim-type="zoomInUp">
		    <div class="about_content">
			  <div class="col-md-12">
			    <div class="web_content">
				  <h1 class="text-center">KNOW MORE ABOUT THE CAUSE</h1>
				  <br/>

					<p class="text-center">The Gaza conflict is a long-standing and complex struggle, primarily between Israel and Hamas, the Palestinian militant group controlling the Gaza Strip. The Israeli-Palestinian conflict is characterized by intermittent periods of violence, including wars, airstrikes, and skirmishes, often triggered by territorial disputes, historical claims, and differing political objectives.</p>

					<p class="text-center">Israel, aiming to protect its citizens from Hamas rocket attacks and seeking to counter-terrorism, has imposed blockades on Gaza. This has severely impacted the lives of Palestinians in Gaza, leading to humanitarian crises, including limited access to essential resources, high unemployment, and poor living conditions.</p>

					<p class="text-center">Efforts toward peace and resolution have been ongoing through various diplomatic initiatives and peace agreements, yet a lasting solution to the conflict still needs to be discovered. The situation is multifaceted, involving historical, political, and humanitarian dimensions, making reaching a comprehensive and lasting resolution challenging.</p>				  

					<br/>

					<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/yBjMbe24Vu0?si=AchYV4E7PWf8SlVS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>

				  

				  <br/>
				  <div class="text-center">
				    <a class="btn btn-green" href="https://www.aljazeera.com/news/2023/10/9/whats-the-israel-palestine-conflict-about-a-simple-guide" target="_new">Learn More&nbsp;></a>
				  </div>

				  <!-- MORE  -->
				  <!--
					<section id="more-about">
	  					<div class="col-md-12">
						    <div class="web_content">
							  <br/>
							  <hr/>							  
							  <div class="col-sm-10">
							  	<h3 class="">More About The Project</h3>
							  	 <p>The Rwenzori Center for Research and Advocacy (RCRA) is a Ugandan not-for-profit organization founded in 2010. Working in partnership with global donors, civil society and local communities, the RCRA is working on building the Grace Community Hospital in Uganda. The not-for-profit hospital aims at providing state-of-the-art medical care to its patients. The particular focus is the care of children and women, especially regarding maternity.
							   	<br/>
							   	For more details, please visit <a href="https://www.rcra-uganda.org/" target="_new" title="https://www.rcra-uganda.org/">www.rcra-uganda.org</a>	
							   	</p>
							  </div>
							  <div class="col-sm-2">
							  	<a href="https://www.rcra-uganda.org/" target="_new" title="https://www.rcra-uganda.org/"><img style="width:150px;height:120px;" src="img/RCRA-logo.jpg"/></a>
							  </div>
							  
							</div>
					  	</div>
					</section> 
				-->

					<!-- MORE  -->
				  
				  
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section> <!-- /DONATE  -->

	


<!-- COUNTER -->
<div id="ourJourneySoFar" class="fh5co-counters" style="background-color:#f1e9e6;">
			<div class="container">
				<div class="text-center" >
					<h1 class="col-md-12" style="color:#333;">SPREAD THE WORD</h1>
					
					<!--facebook-->
<div class="fb-share-button" data-href="http://www.last2lines.com" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.last2lines.com%2F&amp;src=sdkpreparse">Share</a></div>		
					<br/><br/>
					<!--Twitter-->
					<span class=""><a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="Let us contribute two lines of poetry for a cause, let’s write while we last:" data-url="http://www.last2lines.com/" data-via="last2lines" data-hashtags="L2L" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
					</span>
					
				</div>
			</div>
		</div>
<!-- COUNTER -->


			<!-- footer -->
			<footer id="footer">
				<div class="container-full">
					<div class="container">
						<div class="bm-remove animate" data-anim-type="fadeInDownLarge">
							<div class="col-md-12 text-center">
							
<div class="hidden-xs">
			
				<br/>
				<div class="">
				<a href="index.php"><strong>Home</strong> </a><a href="privacyPolicy.php"> | Privacy Policy | </a><a href="tnc.php"> T&amp;C</a>
				
				</div>				
			
		
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
<br/>
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
<br/>Photo courtesy: <a href="http://www.facebook.com/abdulbasitparray" target="_new" title="Abdul Basit">Abdul Basit</a></p>

-->
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
<!-- Modal Window For Contact Info -->

<div id="myModal" class="modal fade" style="color:#333;">
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
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<!-- Modal Window for contact info-->


		<script src="js/vendor/jquery-1.10.2.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
		<script src="js/formScript.js"></script>
		<script src="js/bootstrapValidator.min.js"></script>
    </body>
</html>
