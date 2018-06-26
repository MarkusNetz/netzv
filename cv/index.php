<?php
$top_level="../";
require_once $top_level . "ini/" . "settings.php";
$varJQueryModal="";
if( isset($_GET['userID']) && (isset($_GET['cvID']) || isset($_GET['newCv']) )){
	if( isset($_GET['newCv']) ){
		if( $_GET['newCv'] == "yes" ){
			$varJQueryModal="$('#newCvModal').hide();$('#newCvModal').show();";
		}
		elseif( $_GET['newCv'] == "add" ){
			var_dump($_POST);
			$dbConn->query("INSERT INTO t_user_has_cv(id_user, name, description) VALUES(:param_id_user,:param_cv_name,:param_cv_desc)");
			$dbConn->bind( ":param_id_user", $loggedInUser->getUserId() );
			$dbConn->bind( ":param_cv_name", filter_input(INPUT_POST, "beginCvName", FILTER_SANITIZE_STRING ) );
			$dbConn->bind( ":param_cv_desc", htmlspecialchars($_POST['beginCvDesc']) );
			$dbConn->execute();
			header("location: ./?userID=".filter_input(INPUT_GET, "userID", FILTER_VALIDATE_INT)."&cvID=".$dbConn->lastInsertId());
		}
	}
	else{
		$_GETcvID = filter_input(INPUT_GET, "cvID", FILTER_VALIDATE_INT);
		$_GETuserID = filter_input(INPUT_GET, "userID", FILTER_VALIDATE_INT);
	}
}
else{
	header("location: ../profile/");
}

include($top_level.$folder_class."elements.class.php");
$HtmlObjProps = new HtmlObjectProperties();

// CV | Delete items in CV
if(isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['actionID'])){
	$_GETactionID=filter_input(INPUT_GET, "actionID", FILTER_VALIDATE_INT);
	$sqlDelete="";
	// En specifierad typ måste finnas för önskad delete.
	if(isset($_GET['actionDelete'])) {
		if($_GET['actionDelete']=="edu"){
			$sqlDelete="DELETE FROM t_cv_educations WHERE id_education = :id_action_get AND id_cv = :id_cv_get";
		}
		elseif($_GET['actionDelete']=="work"){
			$sqlDelete="DELETE FROM t_cv_work_experience WHERE id_work_experience = :id_action_get AND id_cv = :id_cv_get";
		}
	}
	// Koll att sql-satsen är gjord.
	if(!empty($sqlDelete)){
		$dbConn->beginTransaction();
		$dbConn->query($sqlDelete);
		$dbConn->bind(":id_action_get", $_GETactionID);
		$dbConn->bind(":id_cv_get", $_GETcvID);
		if($dbConn->execute()){
			$dbConn->endTransaction();
			header("location: ./?userID=".$_GETuserID."&cvID=".$_GETcvID);
		}
		else{
			$dbConn->cancelTransaction();
		}
	}
}

// CV Formulär | Insert, Update for work experience and educations
if( isset($_POST['submitting'])){
	if(isset($_POST['submitType'])){
		if( strpos( $_POST['submitType'], 'Work') !== false){
			$rowCountWorkXP = filter_input(INPUT_POST, "rowCountWorkXP", FILTER_VALIDATE_INT);
			if(filter_has_var(INPUT_POST, "work_id"))
				$cv_work_id=filter_input(INPUT_POST, "work_id", FILTER_VALIDATE_INT);
			
			if( $_POST['submitType'] == "saveWork" )
			{
				$nrOfRowsInForm=$_POST['rowCountWorkXP']; // Total number of rows from form.
				$dbConn->beginTransaction();
				$sqlUpdateWorkRows="UPDATE t_cv_work_experience SET work_time = :work_time, start_date = :start_date, end_date = :end_date, employer = :work_employer, work_title= :work_title, work_description = :work_description WHERE id_work_experience = :id_work_experience";
				$dbConn->query( $sqlUpdateWorkRows );
				// Loop over all distinct work_ids from $_POST.
				foreach($_POST['row_work_id'] as $row_work_id){
					// Empty all strings.
					$save_work_title=$save_work_description=$save_work_employer=$save_start_date=$save_end_date=$save_current_work="";
					
					// Get $_POST-values.
					$save_work_title = filter_input( INPUT_POST, "work_title_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_time = filter_input( INPUT_POST, "work_time_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_employer = filter_input( INPUT_POST, "work_employer_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_description = htmlspecialchars($_POST["work_description_". $row_work_id]);
					$save_start_date = filter_input( INPUT_POST, "start_date_". $row_work_id );
					$save_end_date = filter_input( INPUT_POST, "end_date_". $row_work_id );
					if(isset($_POST['current_work_'. $row_work_id ])){
						$save_current_work = filter_input( INPUT_POST, "current_work_". $row_work_id );
					}
					if( (empty($save_end_date) && empty($save_current_work)) || (!empty($save_current_work) && $save_current_work == 1 ))
						$save_end_date="9999-12-31";
					
					// Bind-values
					$dbConn->bind( ":work_title", $save_work_title );
					$dbConn->bind( ":work_time", $save_work_time );
					$dbConn->bind( ":work_employer", $save_work_employer );
					$dbConn->bind( ":start_date", $save_start_date );
					$dbConn->bind( ":end_date", $save_end_date );
					$dbConn->bind( ":work_description", $save_work_description );
					$dbConn->bind( ":id_work_experience", $row_work_id );
					$dbConn->execute();
				}
				$dbConn->endTransaction();
			}
			elseif($_POST['submitType']=="addWork"){
				$sqlInsertWorkRow="INSERT INTO t_cv_work_experience (id_cv, work_time, start_date, end_date, employer, work_title, work_description) VALUES (:id_cv, :work_time, :start_date, :end_date, :work_employer, :work_title, :work_description)";
				$dbConn->query( $sqlInsertWorkRow );
				// empty strings.
				$save_work_title=$save_work_description=$save_work_employer=$save_start_date=$save_end_date=$save_current_work="";
				
				// Get values from $_POST.
				$save_work_title = filter_input( INPUT_POST, "work_title", FILTER_SANITIZE_STRING );
				$save_work_time = filter_input( INPUT_POST, "work_time", FILTER_SANITIZE_STRING );
				$save_work_employer = filter_input( INPUT_POST, "work_employer", FILTER_SANITIZE_STRING );
				$save_work_description = htmlspecialchars($_POST["work_description"]);
				$save_start_date = filter_input( INPUT_POST, "start_date" );
				$save_end_date = filter_input( INPUT_POST, "end_date" );
				if( isset( $_POST['current_work'] ) ){
					$save_current_work = filter_input( INPUT_POST, "current_work" );
				}
				if( (empty($save_end_date) && empty($save_current_work)) || (!empty($save_current_work) && $save_current_work == 1 ))
					$save_end_date="9999-12-31";
				
				$dbConn->bind( ":work_title", $save_work_title );
				$dbConn->bind( ":work_time", $save_work_time );
				$dbConn->bind( ":work_employer", $save_work_employer );
				$dbConn->bind( ":start_date", $save_start_date );
				$dbConn->bind( ":end_date", $save_end_date );
				$dbConn->bind( ":work_description", $save_work_description );
				$dbConn->bind( ":id_cv", $_GETcvID );
				$dbConn->execute();
			}
		}		
		/*
		 *	Skola/utbildningar
		 */
		elseif( strpos( $_POST['submitType'], "Edu") !== false){
			/*
				Uppdatera befintliga rader om utbildning/kurser
			*/
			if( $_POST['submitType'] == "saveEdu" )
			{
				$nrOfRowsInForm=$_POST['rowCountEdu']; // Total number of rows from form.
				$dbConn->beginTransaction();
				$sqlUpdateEduRows="UPDATE t_cv_educations SET edu_time = :edu_time, start_date = :start_date, end_date = :end_date, school = :edu_school, education_title= :edu_title, education_description = :edu_description WHERE id_education = :id_education";
				$dbConn->query( $sqlUpdateEduRows );
				// Loop over all distinct work_ids from $_POST.
				foreach($_POST['row_edu_id'] as $row_edu_id){
					// empty strings.
					$save_edu_time=$save_edu_title=$save_edu_description=$save_edu_school=$save_start_date=$save_end_date="";
					
					// Get values from $_POST.
					$save_edu_title = filter_input( INPUT_POST, "edu_title_".$row_edu_id, FILTER_SANITIZE_STRING );
					$save_edu_time = filter_input( INPUT_POST, "edu_time_".$row_edu_id, FILTER_SANITIZE_STRING );
					$save_edu_school = filter_input( INPUT_POST, "edu_school_".$row_edu_id, FILTER_SANITIZE_STRING );
					$save_edu_description = htmlspecialchars($_POST["education_description_".$row_edu_id]);
					$save_start_date = filter_input( INPUT_POST, "start_date_".$row_edu_id );
					if( empty( $_POST['end_date_'.$row_edu_id] ) )
						$save_end_date="9999-12-31";
					else
						$save_end_date = filter_input( INPUT_POST, "end_date_".$row_edu_id );
					
					// Bind-values
					$dbConn->bind( ":edu_title", $save_edu_title );
					$dbConn->bind( ":edu_school", $save_edu_school );
					$dbConn->bind( ":edu_time", $save_edu_time );
					$dbConn->bind( ":edu_description", $save_edu_description );
					$dbConn->bind( ":start_date", $save_start_date );
					$dbConn->bind( ":end_date", $save_end_date );
					$dbConn->bind( ":id_education", $row_edu_id );
					$dbConn->execute();
				}
				$dbConn->endTransaction();
				
			}
			/*
				Lägg till ny rad om utbildning/kurser.
			*/
			elseif( $_POST['submitType'] == "addEdu" ){
				$sqlInsertEduRow="INSERT INTO t_cv_educations (id_cv,edu_time, start_date, end_date,school, education_title, education_description) VALUES(:id_cv,:edu_time, :start_date, :end_date,:edu_school,:edu_title, :edu_description)";
				$dbConn->query( $sqlInsertEduRow );
				// empty strings.
				$save_edu_time=$save_edu_title=$save_edu_description=$save_edu_school=$save_start_date=$save_end_date="";
				
				// Get values from $_POST.
				$save_edu_title = filter_input( INPUT_POST, "edu_title", FILTER_SANITIZE_STRING );
				$save_edu_time = filter_input( INPUT_POST, "edu_time", FILTER_SANITIZE_STRING );
				$save_edu_school = filter_input( INPUT_POST, "edu_school", FILTER_SANITIZE_STRING );
				$save_edu_description = htmlspecialchars($_POST["education_description"]);
				$save_start_date = filter_input( INPUT_POST, "start_date" );
				if( empty($_POST['end_date']) )
					$save_end_date="9999-12-31";
				else
					$save_end_date = filter_input( INPUT_POST, "end_date" );
					
				$dbConn->bind( ":edu_time", $save_edu_time );
				$dbConn->bind( ":edu_title", $save_edu_title );
				$dbConn->bind( ":edu_school", $save_edu_school );
				$dbConn->bind( ":edu_description", $save_edu_description );
				$dbConn->bind( ":start_date", $save_start_date );
				$dbConn->bind( ":end_date", $save_end_date );
				$dbConn->bind( ":id_cv", $_GETcvID );
				$dbConn->execute();
			}
		}
		else{}
	}
}

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
	<body class="w3-light-grey" id="cvPresentation">
		<script src="/js/fb-sdk.js"></script>
		<?php // include $path_inc ."/". $file_nav; ?>
		
		<?php
		if(isset($_GET['newCv']) && !empty($varJQueryModal))
		{
		?>
		<div id="newCvModal" class="w3-modal">
			<div class="w3-modal-content">
				<div class="w3-container w3-blue">
					<h2 class="w3-panel">Skapa nytt cv</h2>
					<form method="post" action="./?userID=<?php echo $loggedInUser->getUserId(); ?>&newCv=add">
						<div class="w3-row-padding w3-mobile">
							<div class="w3-third">
							<h3>Ge ditt CV ett namn</h3>
							</div>
							<div class="w3-twothird">
								<p><input type="text" class="w3-large w3-input" name="beginCvName" id="beginCvName" /></p>
							</div>
						</div>
						
						<div class="w3-row-padding w3-mobile">
							<div class="w3-third">
							<h3>Beskriv detta CV</h3>
							</div>
							<div class="w3-twothird">
								<p><textarea type="text" class="w3-large w3-input" name="beginCvDesc" id="beginCvDesc" style="height:5em"></textarea></p>
							</div>
						</div>
					
						<div class="w3-row-padding w3-mobile w3-padding">
							<button type="submit" class="w3-btn w3-round w3-white">Fortsätt</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		</div>
		<!-- Page Container -->
		<div class="w3-content w3-margin-top" style="max-width:1400px;">
			<!-- The Grid -->
			<div class="w3-row-padding">
		  
				<!-- Left Column -->
				<div class="w3-third">
			
					<div class="w3-white w3-text-grey w3-card-4">
						<div class="w3-display-container">
							<img src="../images/netz/markus-netz-1.jpg" style="width:100%" alt="Avatar" />
							<div class="w3-display-bottommiddle w3-container w3-text-white w3-black w3-opacity w3-twothird w3-center">
								<h2 class="Toggle-CV-Business w3-xlarge"><a href="./card.php">Markus Netz</a></h2>
							</div>
						</div>
						
						<div class="w3-container">
							<p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i> Databasadministratör</p>
							<p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i> Stockholm, Sverige</p>
							<p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i> markus.netz.89@gmail.com</p>
							<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i> 073 - 362 90 96</p>
							<hr>

							<p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i><?php echo $myCurriculum->getHeaderSkills();?></b> <a href=''><i class='fa fa-pencil'></i></a></p>
							
								<?php
								echo $myCurriculum->getSkillsList($dbConn);
								?>
							<br />

							<p class="w3-large"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i><?php echo $myCurriculum->getHeaderLanguages();?></b></p>
							<?php
								echo $myCurriculum->getLangugesList($dbConn, $HtmlObjProps);
							?>
							<br />
						</div>
					</div><br />

			<!-- End Left Column -->
			</div>

			<!-- Right Column -->
			<div class="w3-twothird">
			
				<div class="w3-container w3-card w3-white w3-margin-bottom">
					<form id='formWork' action="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" method="post">
						
					<div class="w3-row w3-margin-top">
						<div class="w3-mobile w3-threequarter w3-col m12">
							<h2 class="w3-text-grey w3-margin-top">
								<i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
								<?php echo $myCurriculum->getHeaderWork();?>
							</h2>
						</div>
						
						<div class="w3-mobile w3-quarter w3-padding-top w3-margin-top w3-col m12">
			<?php	if( (isset($_GET['add']) && $_GET['add'] == "work") || (isset($_GET['edit']) && $_GET['edit'] == "work") ){ ?>
							<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" class="w3-button w3-col s6 m6 l2 w3-round w3-red">
								<i class="fa fa-ban"> Avbryt</i>
							</a>
							<button type="submit" name="submitting" class="w3-button w3-col s6 m6 l2 w3-round w3-light-green" value="formWork">
								<i class="fa fa-save"> Spara</i>
							</button>
			<?php	}
					else{	?>
							<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&edit=work#formWork" class="w3-button w3-col s6 m6 l2 w3-round w3-amber">
								<i class="fa fa-pencil-alt"> Ändra</i>
							</a>
							<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&add=work#formWork" class="w3-button w3-col s6 m6 l2 w3-round w3-light-green">
								<i class="fa fa-plus"> Lägg till</i>
							</a>
			<?php	}	?>
						</div>
					</div>
					<?php
					echo $myCurriculum->getWorkExperiencesList($dbConn,$HtmlObjProps);
					?>
					</form>
				</div>

				<div class="w3-container w3-card w3-white">
					<form id='formEdu' action="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" method="post">
					
					<div class="w3-row w3-margin-top">
						<div class="w3-mobile w3-threequarter w3-col m12">
							<h2 class="w3-text-grey w3-margin-top">
								<i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
								<?php echo $myCurriculum->getHeaderEducation();?>
							</h2>
						</div>
						
			<?php	if(1==1){ ?>
						<div class="w3-mobile w3-quarter w3-padding-top w3-margin-top w3-col m12">
			<?php	if( (isset($_GET['add']) && $_GET['add'] == "edu") || (isset($_GET['edit']) && $_GET['edit'] == "edu") ){ ?>
							<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" class="w3-button w3-col s6 m6 l2 w3-round w3-red">
								<i class="fa fa-ban"> Avbryt</i>
							</a>
							<button type="submit" name="submitting" class="w3-button w3-col s6 m6 l2 w3-round w3-light-green" value="formEdu">
								<i class="fa fa-save"> Spara</i>
							</button>
			<?php	}
					else{	?>
							<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&edit=edu#formEdu" class="w3-button w3-col s6 m6 l2 w3-round w3-amber">
								<i class="fa fa-pencil-alt"> Ändra</i>
							</a>
							<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&add=edu#formEdu" class="w3-button w3-col s6 m6 l2 w3-round w3-light-green">
								<i class="fa fa-plus"> Lägg till</i>
							</a>
			<?php	}	?>
						</div>
			<?php	}	?>
					</div>
					<?php
					echo $myCurriculum->getEducationsList($dbConn, $HtmlObjProps);
					?>
					</form>
				<!-- End Right Column -->
				</div>
			
			<!-- End Grid -->
			</div>
		  
		<!-- End Page Container -->
		</div>

		<footer class="w3-container w3-teal w3-center w3-margin-top">
			<p>Find me on social media.</p>
			<i class="fa fa-facebook-official w3-hover-opacity"></i>
			<i class="fa fa-instagram w3-hover-opacity"></i>
			<i class="fa fa-snapchat w3-hover-opacity"></i>
			<i class="fa fa-pinterest-p w3-hover-opacity"></i>
			<i class="fa fa-twitter w3-hover-opacity"></i>
			<i class="fa fa-linkedin w3-hover-opacity"></i>
			
		</footer>
		<script>
			$(document).ready(function(){
				
				<?php if(!empty($varJQueryModal)) echo $varJQueryModal;?>
				
				$("input[type='checkbox']").change( function(){
					if($(this).attr("data-checkToggleInput") ==1 ){
						var attr_row_id=$(this).attr("data-rowId");
						if ( $( this ).prop( "checked" ) ){
							$("#end_date_" + attr_row_id).prop("disabled", true);
							$("#end_date_" + attr_row_id).prop("required", false);
							$( this ).prop("required", true);
						}
						else{
							$("#end_date_" + attr_row_id).prop("disabled", false);
							$("#end_date_" + attr_row_id).prop("required", true);
							$( this ).prop("required", false);
						}
					}
				});
			});
		</script>
	</body>
</html>