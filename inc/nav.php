<!-- W3.CSS -->
<div class="w3-top">
	<!-- Medium and Large screen nav display. -->
	<div class="w3-bar w3-blue-gray w3-hide-small">
		<a href="/" class="w3-bar-item w3-button w3-mobile w3-hover-none w3-border-none w3-hover-white">Home</a>
		<a href="/profile" class="w3-bar-item w3-button w3-mobile w3-hover-none w3-border-none w3-hover-white">Min profil</a>
		
		<div class="w3-dropdown-hover">
			<button class="w3-button">Dropdown</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="#" class="w3-bar-item w3-button">Link 1</a>
			<a href="#" class="w3-bar-item w3-button">Link 2</a>
			<a href="#" class="w3-bar-item w3-button">Link 3</a>
			</div>
		</div>
		<div class="w3-right">
		<?php
			if($loggedInUser == null){
		?>
				<a href="/login" class="w3-bar-item w3-button w3-round w3-white w3-small w3-margin-8 w3-mobile w3-hover-none w3-border-none w3-hover-white w3-margin-right"><i class="fa fa-sign-in-alt"></i> Logga in</a>
				<a href="/registerAccount" class="w3-bar-item w3-button w3-round w3-white w3-small w3-margin-8 w3-mobile w3-hover-none w3-border-none w3-hover-white w3-margin-right"><i class="fa fa-user-plus"></i> Registrera konto</a>
		<?php
			}
			else{
		?>
				<a href="/logout" class="w3-bar-item w3-button w3-mobile w3-hover-none w3-border-none w3-hover-white w3-margin-8 w3-margin-right w3-round w3-white w3-small"><i class="fa fa-sign-out-alt"></i> Logga ut</a>
		<?php
			}
		?>
		</div>
	</div>
	
	<!-- Small screen nav display. -->
	<div class="w3-bar w3-blue-gray w3-hide-medium w3-hide-large w3-mobile w3-large">
		<a href="/" class="w3-bar-item w3-button w3-col s3 w3-green"><i class="fa fa-home"></i></a>
		<a href="/profile" class="w3-bar-item w3-button w3-col s3"><i class="fa fa-user"></i></a>
		<?php
		if($loggedInUser == null){
		?>
			<a href="/login/" class="w3-bar-item w3-button w3-col s3"><i class="fa fa-sign-in-alt"></i></a>
			<a href="/registerAccount/" class="w3-bar-item w3-button w3-col s3"><i class="fa fa-user-plus"></i></a>
		<?php
		}
		else{
		?>
			<a href="/logout" class="w3-bar-item w3-button w3-col s3"><i class="fa fa-sign-out-alt"></i></a>
		<?php
		}
		?>
	</div>
</div>
<div class="w3-block" style="margin-top:2.5em;">&nbsp;</div>