<?php
$top_level="../";
require_once $top_level . "ini/" . "settings.php";
// if(!filter_has_var(INPUT_GET,'userID') && !filter_has_var(INPUT_GET,'cvID')){
	// header("location: ../profile/");
// }

// echo "denna sökväg: ".$top_level.$folder_class.$file_class_cv.". Slut på sökväg.";
// include $top_level . $folder_class . "class_lib.php";
include $top_level . $folder_class . $file_class_cv;

$myCurriculum=new curriculum();


?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Curriculum Vitae</title>
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<?php
		/*	Metadata */
		echo $metadata;
		
		/*	W3.CSS */
		echo $w3_css;
		echo $w3_theme;
		
		/*	Fonts */
		echo $font_awesome;
		
		/*	BOOTSTRAP */
		// echo $bootstrap_css;
		// echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body class="w3-light-grey">
		<script src='/js/fb-sdk.js'></script
		<?php // include $path_inc ."/". $file_nav; ?>
		
		<!-- Page Container -->
		<div class="w3-content w3-margin-top">

			<!-- The Grid -->
			<div class="w3-row-padding">
		  
				<!-- Left Column -->
				<div class="w3-half">
					<div class="w3-sand w3-text-grey w3-card">
						<div class="w3-display-container" style="height: 31em;">
							<img class="" src="../images/netz/markus-netz-1.jpg" style="width:100%" alt="Avatar" />
							<div class="w3-display-bottommiddle w3-container w3-text-white w3-black w3-opacity">
								<h2 class="Toggle-CV-Business"><a href="./?userID=1&cvID=1">Markus Netz</a></h2>
							</div>
						</div>
					</div>
					<br />

				<!-- End Left Column -->
				</div>
				
				<!-- Right Column -->
				<div class="w3-half">
					<div class="w3-white w3-text-grey w3-card">
						<div class="w3-container" style="height: 31em;">
							<p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Databasadministratör</p>
							<p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>Nynäshamn, Sverige</p>
							<p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>markus.netz.89@gmail.com</p>
							<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>073 - 362 90 96</p>
							<br />
							<hr>
							<br />
							<p><i class="fa fa-linkedin fa-fw w3-margin-right w3-large w3-text-teal"></i><a href="https://www.linkedin.com/in/markus-netz/">linkedin.com/in/markus-netz</a></p>
							<p><i class="fa fa-facebook fa-fw w3-margin-right w3-large w3-text-teal"></i><a href="https://www.facebook.com/netz.markus">fb.com/markus.netz</a></p>
							<p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>markus.netz.89@gmail.com</p>
							<p><i class="fa fa-user-circle fa-fw w3-margin-right w3-large w3-text-teal"></i><a href="./?cvID=1&userID=1">Visa CV</a></p>
						</div>
					</div>
					<br />

					
				<!-- End Right Column -->
				</div>
				
			<!-- End The Grid Container -->
			</div>
			
		<!-- End Page Container -->
		</div>

		<!--footer class="w3-container w3-teal w3-center w3-margin-top">
			<p>Find me on social media.</p>
			<i class="fa fa-facebook-official w3-hover-opacity"></i>
			<i class="fa fa-instagram w3-hover-opacity"></i>
			<i class="fa fa-snapchat w3-hover-opacity"></i>
			<i class="fa fa-pinterest-p w3-hover-opacity"></i>
			<i class="fa fa-twitter w3-hover-opacity"></i>
			<i class="fa fa-linkedin w3-hover-opacity"></i>
		</footer-->

	</body>
</html>