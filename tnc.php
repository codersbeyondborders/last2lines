<?php
/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

?>
<?php
	require_once(__DIR__."/includes/session.php");
	require_once(__DIR__."/includes/connection.php"); 
	require_once(__DIR__."/includes/functions.php");
require_once(__DIR__."/includes/analyticstracking.php");

?>
<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Last2Lines is a medium to express and register a peaceful campaign/protest using two lines of poetry.">
		
		<meta name="keywords" content="Last2Lines, L2L, Last Two Lines, Kashmir, Protest, Poetry, Campaign, Ghazal, Valley">
		
		<meta name="author" content="Abdul Wajid , Ubaid Darwaish">
		<title>Last2Lines: Terms And Conditions</title>
        <meta name="description" content="">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		
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

<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. --> <link rel="icon" href="favicon.png">
<style>


#header .navbar-fixed-top{
	background: #2A3039;
	width: 100%;
	height: 70px;

}
#poemSummary{
	//background:url(img/1_1.jpg);
	background:#FFF;
}
#poemSummary .container-full{
	//margin-top:150px;
	background:#ffffff;
	//opacity:0.9;
	border-radius:20px;
}
#poemSummary{
color: #000000;
}


</style>
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
									
									<li class=""><a href="fullPoem.php">Full Poem</a></li>
									
									<li class="active dropdown" id="archivesDropdownMenu"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Archives <span class="caret"></span></a>
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
			<div class="">
				<div id="currentCouplet" class="container-full">
					<div class="container">
						<div class="bm-remove">
							<div class="">
          <br/><br/><br/><br/><br/>
		  <div class="poem">
			  <h2 class="">Terms And Conditions</h2>
			  <hr class="col-sm-4"/><br class="clear"/><br/>
<div class="">
<div id="tnc" class="">
<ol>
<li>This website is primarily about poetry and should not in any case be deemed as a political opinion of Last2Lines. Any inclination whatsoever towards or against any political school of thought, is contributors own opinion and imagination- and does not represent the opinion or affinity of Last2Lines.</li>
<br/>
<li>The copyright of each couplet remains with the author. However, authors by contributing, grant Last2Lines the right to publish and/or broadcast their couplet without any prior notice or approval. Last2Lines is the legal copyright holder of overall content on this website and same cannot be used for reprint or publish without the written consent from Last2Lines.</li>
<br/>
<li>The Last2Lines has the right to select,reject,edit,shorten, move or delete couplets wherever necessary to keep them within the policy guidelines.</li>
<br/>
<li>The submissions must belong to author (the one submitting); and should not be a copy/extract of someone else's work.</li>
<br/>
<li>The information on the webiste can be spontaneous, unproofed, unrevised and sometimes a work of fiction- a product of contributors imagination.  Although the moderators have made an effort that the infomration is not abusive, profane, rude or untrue, the  Last2Lines does not assume and hereby disclaim any liability to any party for any loss, damage, or disruption caused by errors or omissions, whether such errors or omissions result from negligence, accident, or any other cause.</li>
<br/>
<li>The moderators screen the submissions primarily for rhyme and not always for the message that it conveys, as such users are requested to not indulge in hate speech, which includes content that attacks people based on their race, ethnicity, national origin,political affiliation, religious affiliation, sexual orientation, sex, gender or gender identity, or serious disabilities or diseases. We rely on our community to report this content to us.</li>
<br/>
<li>The user will be solely responsible for his/her own submission, the Last2Lines does in no way endorse the content published on this website nor does it check the content for infringing someone else's copyright. If anyone brings a claim against us related to your submissions on Last2Lines, you will indemnify and hold Last2Lines harmless from and against all damages, losses, and expenses of any kind (including reasonable legal fees and costs) related to such claim. Although we provide rules for user submissions, we do not warrant the screening of submission against the same and are not responsible for the content user submits on Last2Lines.</li>
<br/>
<li>Last2Lines reserves the right to change the focus of this website, to shut it down, sell it or to change the terms of use at its own discretion.</li></ol>
</div>
</div>
</div><!--Poem-->
		
		
	
		 
						</div>
						
						</div>
		 
					</div>
				</div>
			</div> 
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
				<a href="index.php">Home </a><a href="privacyPolicy.php"> | Privacy Policy | </a><a href="tnc.php"> <strong>T&amp;C</strong></a>
				
				
		
		<div class="">
								<br/>
								<p class="">copyright &copy; <?php echo date('Y');?> <a href="index.php">Last2Lines.com</a>
								&nbsp;|&nbsp;All Rights Reserved.</p>
	<!--						
	<p class="">
		
		Combined work of&nbsp;<a href="#" target="_new" title="Ubaid Darwaish">Ubaid Darwaish</a> &amp; <a href="http://www.facebook.com/abdulwajid786" target="_new" title="Abdul Wajid">Abdul Wajid</a>
		<br/>Photo courtesy: <a href="http://www.facebook.com/basitparray" target="_new" title="Abdul Basit">Abdul Basit</a>
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
<a href="index.php">Home</a>
<br/>
<a href="privacyPolicy.php">Privacy Policy</a>
<br/>
<a href="tnc.php"><strong>T&amp;C</strong></a>
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
<br/>Photo courtesy: <a href="http://www.facebook.com/basitparray" target="_new" title="Abdul Basit">Abdul Basit</a>
</p>
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
						
<!--Go To Top-->
<div class="goToHeader">
	<a id="" class="pull-right" href="#header" title="Go To Top">
	<i class="fa fa-arrow-up"></i></a>
</div>
<!--Go To Top-->
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

    </body>
</html>
