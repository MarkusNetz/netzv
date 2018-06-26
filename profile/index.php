<?php
$top_level="../";
require_once $top_level."ini/settings.php";

if( $loggedInUser != null && !isset($_GET['userId']) )
{
	// No specific action. The user is logged in and has not requested another user. Continue with showing the logged in users profile.
}
else{
	if(isset($_GET['userId'])){
		$_GETuserId=filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);
	}
	else{
		header("location ". $top_level);
	}
}

?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<title>Min personliga profil - NetZV</title>
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<?php
		/*	Metadata */
		echo $metadata;
		
		/*	W3.CSS */
		echo $w3_css;
		echo $w3_theme;
		
		/*	Fonts */
		echo $font_awesome;
		echo $font_roboto;
		
		/*	BOOTSTRAP */
		// echo $bootstrap_css;
		// echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body class="w3-theme-l5" id="profilePage">
		<script src="/js/fb-sdk.js"></script>
		<?php include $top_level . $folder_inc . $file_nav; ?>
		
		<!-- Team Container -->
		<section class="w3-container w3-center w3-white" id="profilePresentation">
			<div class="w3-padding-16 w3-row">
				<h2><span class="w3-bottombar w3-border-teal"><?php if(isset($loggedInUser)){ echo $loggedInUser->getDisplayName();} ?></span></h2>
			</div>
			
			<div class="w3-padding-16 w3-row">
				<div class="w3-third">
					<h1>Min historia <i class="fa fa-"></i></h1>
					<p>Lorem ipsum ....</p>
				</div>
				<div class="w3-third">
					<h1>Mina karriärsmål <i class="fa fa-"></i></h1>
					<p>Lorem ipsum ....</p>
				</div>
				<div class="w3-third">
					<h1>Min framtidsvision <i class="fa fa-"></i></h1>
					<p>Lorem ipsum ....</p>
				</div>
			</div>
		</section>
		
		<!-- CV-section -->
		<section class="w3-container w3-padding-32 w3-center w3-row" id="curriculum">
			<?php
			if(isset($loggedInUser))
				echo $loggedInUser->getListOfCvs();
			?>
			<a href="../cv/?userID=<?php echo $loggedInUser->getUserId();?>&newCv=yes">
				<div class="w3-quarter w3-card w3-border-big w3-white w3-padding-16 w3-hover-green w3-display-container" style="min-height:11.25em; border:3px dashed black">
				<span class="w3-button w3-white w3-yellow w3-display-middle">Skapa nytt CV</span>
				</div>
			</a>
		</section>

		<!-- Footer -->
		<footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
			<h4>Follow Us</h4>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Facebook"><i class="fa fa-facebook"></i></a>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Twitter"><i class="fa fa-twitter"></i></a>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-google-plus"></i></a>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-instagram"></i></a>
			<a class="w3-button w3-large w3-teal w3-hide-small" href="javascript:void(0)" title="Linkedin"><i class="fa fa-linkedin"></i></a>
			<p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>

			<div style="position:relative;bottom:100px;z-index:1;" class="w3-tooltip w3-right">
				<span class="w3-text w3-padding w3-teal w3-hide-small">Go To Top</span>   
				<a class="w3-button w3-theme" href="#myPage"><span class="w3-xlarge">
				<i class="fa fa-chevron-circle-up"></i></span></a>
			</div>
		</footer>
	</body>
</html>