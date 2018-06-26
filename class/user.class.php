<?php
class LoggedInUser implements iMyCurriculums
{
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	protected $infoRegistered;
	protected $infoLastLogin;
	protected $userId;
	protected $listOfCvs;
	
	// Constructor
	function __construct( $pdoDbConn ){
		$this -> setUserId( $_SESSION['user_id'] );
		$this -> UserInformation( $pdoDbConn );
		$this -> MyCurriculums( $pdoDbConn );
	}
	
	// Languages
	public function setUserId($value){
		$this -> userId = $value;
	}
	public function getUserId(){
		return $this -> userId;
	}
	
	public function setDisplayName($name_user){
		$this -> displayName = $name_user;
	}
	public function getDisplayName(){
		return $this -> displayName;
	}
	public function setDisplayWorkTitle($value){
		$this -> displayWorkTitle = $value;
	}
	public function getDisplayWorkTitle(){
		return $this -> displayWorkTitle;
	}
	public function setDisplayMail($value){
		$this -> displayMail = $value;
	}
	public function getDisplayMail(){
		return $this -> displayMail;
	}
	protected function setInfoRegistered($value){
		$this -> infoRegistered=$value;
	}
	protected function getInfoRegistered(){
		return $this -> infoRegistered;
	}
	
	protected function setListOfCvs($value){
		$this -> listOfCvs=$value;
	}
	public function getListOfCvs(){
		return $this -> listOfCvs;
	}
	
	protected function UserInformation($pdoDbConn){
		$sqlGetUserInfo="SELECT name_first, name_last, registered FROM t_users WHERE id_user = :param_id_user";
		$pdoDbConn -> query( $sqlGetUserInfo );
		$pdoDbConn -> bind( ':param_id_user', $this -> getUserId() );
		$userInfoRow = $pdoDbConn -> single();
		if($userInfoRow == true){
			$this -> setDisplayName( $userInfoRow['name_first'] ." ". $userInfoRow['name_last'] );
			// $this -> setDisplayMail( $userInfoRow['registered'] );
			$this -> setInfoRegistered($userInfoRow['registered']);
		}
	}
	
	public function MyCurriculums( $pdoDbConn ){
		$cvList=null;
		$sqlGetCvRows="SELECT * FROM t_user_has_cv c WHERE c.id_user = :param_id_user";
		// var_dump($sqlGetCvRows);
		$pdoDbConn->query($sqlGetCvRows);
		$pdoDbConn->bind(":param_id_user", $this->getUserId());
		$resultCvRows=$pdoDbConn->resultSet();
		$r=1;
		$colorArr=array(1=>"khaki", 2=>"deep-orange", 3=>"amber", 4=>"blue-gray");
		foreach($resultCvRows as $cvRow){
			if($r==5)
				$r=1;
			$cvList.=
				"<div class='w3-quarter w3-card w3-".$colorArr[$r]." w3-padding-16' style='min-height:10em;'>"
					."<h3>". $cvRow['name'] ."</h3>"
					."<p>". $cvRow['description'] ."</p>"
					."<a class='w3-button w3-white w3-hover-blue' href='../cv/?userID=1&cvID=4'>Visa CV</a>"
				."</div>";
			$r++;
		}
		
		$this->setListOfCvs( $cvList );
	}
}



class RequestedProfile implements iMyCurriculums
{
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	protected $infoRegistered;
	protected $infoLastLogin;
	protected $userId;
	
	// Constructor
	function __construct($sentUserId, $pdoDbConn){
		$this -> setUserId( $sentUserId );
		$this -> UserInformation( $pdoDbConn );
	}
	
	// Languages
	public function setUserId( $value ){
		$this -> userId = $value;
	}
	public function getUserId(){
		return $this -> userId;
	}
	
	public function setDisplayName($name_user){
		$this -> displayName = $name_user;
	}
	public function getDisplayName(){
		return $this -> displayName;
	}
	public function setDisplayWorkTitle($value){
		$this -> displayWorkTitle = $value;
	}
	public function getDisplayWorkTitle(){
		return $this -> displayWorkTitle;
	}
	public function setDisplayMail($value){
		$this -> displayMail = $value;
	}
	public function getDisplayMail(){
		return $this -> displayMail;
	}
	protected function setInfoRegistered($value){
		$this -> infoRegistered=$value;
	}
	protected function getInfoRegistered(){
		return $this -> infoRegistered;
	}
	
	protected function UserInformation($pdoDbConn){
		$sqlGetUserInfo="SELECT CONCAT(name_first, ' ', name_last) fullName, name_first, name_last, registered FROM t_users WHERE id_user = :param_id_user";
		$pdoDbConn -> query( $sqlGetUserInfo );
		$pdoDbConn -> bind( ':param_id_user', $this -> getUserId() );
		$userInfoRow = $pdoDbConn -> single();
		if($userInfoRow == true){
			$this -> setDisplayName($userInfoRow['fullName']);
			$this -> setDisplayMail($userInfoRow['fullName']);
			$this -> setInfoRegistered($userInfoRow['registered']);
		}
	}
	public function MyCurriculums($pdoDbConn){
		$pdoDbConn->query("SELECT * FROM t_cv c WHERE c.id_user = :param_id_user");
		$pdoDbConn->bind(":param_id_user", $this->getUserId());
	}
}