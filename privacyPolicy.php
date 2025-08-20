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
		<title>Last2Lines: Privacy Policy</title>
        <meta name="description" content="">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		
		<!-- Style -->
        <link rel="stylesheet" href="css/main.css">
		
		<!-- Responsiv -->
		 <link rel="stylesheet" href="css/responsive.css">

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		
		<!-- Bootstrp -->
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
	background:#ffffff;
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
			  <h2 class="">Privacy Policy</h2>
			  <hr class="col-sm-4"/><br class="clear"/><br/>
<div id="privacyPolicy" class="">
<h3>How We Collect and Use Information</h3>
<br/>
<h4>We collect the following type of information about you:</h4>
<br/>
<p>We collect information which includes but may not be limited to, your email-id, name and couplet that you submit on our page. We neither recieve/store, nor do we require/seek the passwords to your respective email id's, under any circumstances. We only make your name and the respective couplet public, the email information is stored solely for the authentication.</p>

<h3>Analytics information:</h3>
<br/>
<p>We may directly collect analytics data, or use third-party analytics tools and services, to help us measure traffic and usage trends for the Service. These tools collect information sent by your browser or mobile device, including the pages you visit and other information that assists us in improving the Service. We collect and use this analytics information in aggregate form such that it cannot reasonably be manipulated to identify any particular individual user.</p>

<h3>Cookies information:</h3>
<br/>
<p>When you visit the Service, we may send one or more cookies — a small text file containing a string of alphanumeric characters — to your computer that uniquely identifies your browser in order for Last2Lines to know about how you use the Service (e.g., the pages you view, the links you click and other actions you take on the Service), and allow us to track your usage of the Service over time. A persistent cookie remains on your hard drive after you close your browser. Persistent cookies may be used by your browser on subsequent visits to the site. Persistent cookies can be removed by following your web browser’s directions. A session cookie is temporary and disappears after you close your browser. You can reset your web browser to refuse all cookies or to indicate when a cookie is being sent.</p>

<h3>Log file information:</h3><br/>
<p>Log file information is automatically reported by your browser or mobile device each time you access the Service. When you use our Service, our servers automatically record certain log file information. These server logs may include anonymous information such as your web request, Internet Protocol (“IP”) address, browser type, referring / exit pages and URLs, number of clicks and how you interact with links on the Service, domain names, landing pages, pages viewed, and other such information.</p>

<h3>Sharing of Your Information:</h3><br/>
<p>We will not rent or sell your information into third parties outside Last2Lines.</p>


<h3>What happens in the event of a change of control:</h3><br/>
<p>We may buy or sell/divest/transfer Las2Lines, or any combination of its products, services, and/or assets. Your information such as user names and email addresses, User Content and other user information related to the Service may be among the items sold or otherwise transferred in these types of transactions.We may also sell, assign or otherwise transfer such information in the course of corporate divestitures, mergers, acquisitions, bankruptcies, dissolutions, reorganizations, liquidations, similar transactions or proceedings involving all or a portion of Last2Lines.</p>


<h3>Instances where we are required to share your information:</h3><br/>
<p>Last2Lines will disclose your information where required to do so by law or subpoena or if we reasonably believe that such action is necessary to: <ul>
<li>(a) comply with the law and the reasonable requests of law enforcement;</li>
<li>(b) to enforce our Terms of Use or to protect the security, quality or integrity of our Service; and/or</li>
<li>(c) to exercise or protect the rights, property, or personal safety of Last2Lines, our Users, or others.
</li></ul>
</p>

<h3>Keeping your information safe:</h3><br/>
<p>Last2Lines cares about the security of your information, and uses commercially reasonable safeguards to preserve the integrity and security of all information collected through the Service. However, Last2Lines cannot ensure or warrant the security of any information you transmit to Last2Lines or guarantee that information on the Service may not be accessed, disclosed, altered, or destroyed.</p>



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
				<a href="index.php">Home </a><a href="privacyPolicy.php"> | <strong>Privacy Policy</strong> | </a><a href="tnc.php"> T&amp;C</a>
				
				
		
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
<a href="index.php">Home</a>
<br/>
<a href="privacyPolicy.php"><strong>Privacy Policy</strong></a>
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
<br/>Photo courtesy: <a href="http://www.facebook.com/basitparray" target="_new" title="Abdul Basit">Abdul Basit</a></p>
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
