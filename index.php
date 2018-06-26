<?php
$top_level="../";
require_once $top_level . "/netzv/ini/" . "settings.php";

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>NetZV - Spontanansök spontanare.</title>
		<?php
		/*	Metadata */
		var_dump($metadata);
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
	<body class="w3-theme-l5" id="myPage">
		<!--script src="/js/fb-sdk.js"></script-->
		<?php include $top_level . $folder_inc . $file_nav; ?>

		<!-- Team Container -->
		<section class="w3-container w3-center w3-white" id="team">
			<div class="w3-padding-32">
				<h2>NetZV</h2>
				<p>Vill hjälpa dig spontansöka mer spontant med mobilitet.</p>
			</div>
		</section>

		<!-- Work Row -->
		<!--div class="w3-row-padding w3-padding-64 w3-theme-l1" id="work">

			<div class="w3-quarter">
				<h2>Forms</h2>
				<p>Du kan använda formuläret för att lägga till folk till mitt Team.</p>
			</div>

			<!--div class="w3-half w3-right"-->
			<!--div class="w3-threequarter">
				<div>
					<form class="w3-container w3-card-4 w3-padding-16 w3-white" action="/action_page.php" target="_blank">
						<div class="w3-section w3-half">
							<input class="w3-input" type="text" name="first_name" required />
							<label>Förnamn</label>
							<input class="w3-input" type="text" name="last_name" required />
							<label>Efternamn</label>
						</div>
						<div class="w3-section w3-half">
							<input class="w3-input" type="tel" name="phone" required pattern="[+0-90-9]{3}?[0-9]{2,4}\s*?[-]?\s*?[0-9]{2,3}\s?[0-9]{1,3}\s*?[0-9]{2}?" />
							<label>Telefon. yyy-xxx xx xx</label>
							
							<input class="w3-input" type="email" name="email" required />
							<label>Email</label>
						</div>
						<div class="w3-content">
							<div class="w3-onethird w3-right">
								<button type="submit" class="w3-button w3-hover-khaki w3-green w3-round-large w3-margin-right">Add</button>
								<button type="reset" class="w3-button w3-red w3-section">Återställ</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div-->
	</body>
</html>
