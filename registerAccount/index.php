<?php
$top_level="../";
require_once $top_level."ini/settings.php";

if( $LoginCheck->LoginCheck($dbConn) == true )
{
	
	$loggedInUser = new loggedInUser($dbConn);
}
else
{
	header("location " . $top_level . "login/");
}

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Skapa nytt konto - NetZV</title>
		<meta name="google-signin-client_id" content="94719343879-eo9fi600ua8k99tbn4omr34f841cbp3b.apps.googleusercontent.com" redirect_uri="" />
		
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
	<body id="myPage" class="w3-theme-l5">
		<?php include $top_level . $folder_inc . $file_nav; ?>
		
		<!-- Contact Container -->
		<div class="w3-container w3-white">
			<div class="w3-padding-32">
				<div class="w3-content">
					<div class="w3-panel w3-green w3-center">
						<h2>Skapa nytt konto</h2>
					</div>
					<form class="w3-container" method="post" action="../inc/process_registration.php">
						<div class="w3-row-padding">
							<div class="w3-third">
								<input name="accFirstName" id="accFirstName" class="w3-leftbar w3-input w3-pale-green w3-border-green" style="width:100%;" type="text" required="required" />
								<label for="accFirstName" class="w3-opacity">Förnamn</label>
							</div>
							<div class="w3-third">
								<input name="accLastName" id="accLastName" class="w3-leftbar w3-input w3-pale-green w3-border-green" style="width:100%;" type="text" required="required" />
								<label for="accLastName" class="w3-opacity">Efternamn</label>
							</div>
							<div class="w3-third">
								<input name="accDateOfBirth" id="accDateOfBirth" class="w3-leftbar w3-input w3-pale-green w3-border-green" style="width:100%;" type="date" required="required" placeholder="" />
								<label for="accDateOfBirth" class="w3-opacity">Födelsedatum</label>
							</div>
						</div>
						
						<div class="w3-row-padding w3-margin-top">							
							<div class="w3-third">
								<select class="w3-leftbar w3-pale-green w3-select w3-medium w3-border-green" name="accContactType" id="accContactType">
									<option value="" disabled>Ange kontakt</option>
									<option value="1" selected>E-postadress</option>
								</select>
								<label class="w3-opacity" for="accContactEmail">&nbsp;</label>
							</div>
							<div class="w3-twothird">
								<input name="accEmail" id="accEmail" class="w3-leftbar w3-input w3-pale-green w3-border-green" type="email" required="required" />
								<label class="w3-opacity" for="accEmail">&nbsp;</label>
							</div>
						</div>
						
						<div class="w3-row-padding w3-margin-top">							
							<div class="w3-third">
								<select class="w3-leftbar w3-pale-green w3-select w3-medium w3-border-green" name="accContactType" id="accContactType">
									<option value="" disabled>Ange kontakt</option>
									<option value="2" selected>Mobilnummer</option>
								</select>
								<label class="w3-opacity" for="accContactType">&nbsp;</label>
							</div>
							<div class="w3-twothird">
								<input name="accContactInfo" id="accContactInfo" class="w3-leftbar w3-input w3-pale-green w3-border-green" type="text" required="required" />
								<label class="w3-opacity" for="accContactInfo">&nbsp;</label>
							</div>
						</div>
						
						<div class="w3-row-padding w3-margin-bottom">
							<div class="w3-quarter w3-text-dark-gray w3-leftbar w3-pale-blue w3-border-blue w3-margin-bottom">
								<p>Lösenordskrav:</p>
								<ul>
									<li>1 liten bokstav</li>
									<li>1 stor bokstav</li>
									<li>1 siffra</li>
									<li>1 av @ # $ % & </li>
								</ul>
							</div>
							
							<div class="w3-half w3-padding-top w3-margin-bottom">
								<input name="accPassOne" id="accPassOne" class="w3-leftbar w3-input w3-pale-green w3-border-green" type="password" required="required" placeholder="Minst fyra tecken långt" />
								<label for="accPassOne" class="w3-opacity">Önskat lösenord</label><br /><br />
							
								<input name="accPassTwo" id="accPassTwo" class="w3-leftbar w3-input w3-pale-green w3-border-green w3-amber" type="password" required="required" placeholder="Samma som föregående" />
								<label for="accPassOne" class="w3-opacity w3-label">Bekräfta lösenord</label>
								
							</div>
							
							<div class="w3-quarter">
								<input type="submit" class="w3-button w3-large w3-deep-purple w3-border w3-border-black w3-round w3-hover-black" name="submitNewAcc" value="Registrera" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
		$(document).ready(function(){
			
			$('#accPassOne, #accPassTwo').on('keyup', function (e) {
				var code = e.keyCode || e.which;
				if(code != 9){
					var pattern = /^.*(?=.{4,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
					if ( ( $("#accPassOne").val() == $("#accPassTwo").val()) && (pattern.test( $("#accPassOne").val() ) == true) )
					{	
						$('#accPassOne, #accPassTwo').html('Matching').removeClass('w3-border w3-border-red').addClass('w3-border w3-border-green');
					}
					else{
						$('#accPassOne, #accPassTwo').html('Not Matching').removeClass('w3-border w3-border-green').addClass('w3-border w3-border-red');
					}
				}
			});
		});
		</script>
	</body>
</html>
