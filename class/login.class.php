<?php
class SignIn{
	protected $user_Id;
	public $displayName;
	public $displayWorkTitle;
	public $displayMail;
	public $displayNumber;
	private $scodeErr;
	private $numberOfAttempts;
	
	// Constructor
	function __construct(){
		$this -> setNumberOfAttempts("10");
	}
	private function setScodeErr($value){
		$this -> scodeErr = $value;
	}
	
	private function getScodeErr(){
		return $this -> scodeErr;
	}
	private function setNumberOfAttempts($value){
		$this -> numberOfAttempts = $value;
	}
	
	private function getNumberOfAttempts(){
		return $this -> numberOfAttempts;
	}
	// Languages
	public function Login( $entryUser, $entryPhrase, $pdoDbConn ){
		$sqlSelectUser="SELECT uhl.id_user, uhl.passphrase, u.unique_hash, uhl.status_type FROM t_user_has_login uhl RIGHT JOIN t_users u USING(id_user) WHERE uhl.login = :user_login";
		$pdoDbConn->query( $sqlSelectUser );
		$pdoDbConn->bind(":user_login", $entryUser);  // Bind "$email" to parameter.
		$loginRow=$pdoDbConn->single();    // Execute the prepared query and return the first row of result.
		
		if( $loginRow == true) {
			if( $loginRow['status_type'] == "ok" ) {
				if( $this->CheckBrute($loginRow['id_user'], $pdoDbConn) == true) {
					// Do not continue with login. The account is currently blocked by too many failed login-attempts.
					$this -> SaveLoginAttempt( $loginRow['id_user'], "blocked", $pdoDbConn );
					return false;
				}
				
				if( password_verify($entryPhrase, $loginRow['passphrase']) ) {
					$this -> SaveLoginAttempt( $loginRow['id_user'], "ok", $pdoDbConn );
					
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					// XSS protection as we might print this value
					$user_id = preg_replace("/[^0-9]+/", "", $loginRow['id_user']);
					$_SESSION['user_id'] = $user_id;
					$_SESSION['login_string'] = hash('sha512', $loginRow['unique_hash'] . $user_browser);
					
					return true;
				}
			}
		}
		else{}
	}
	
	private function CheckBrute($user_id,$pdoDbConn){
		$this -> setScodeErr("pwderr");
		// Get timestamp of current time 
		$now = time();
		
		// All login attempts are counted from the past 30 seconds. 
		$valid_attempts_time = date("Y-m-d H:i:s",($now - (30)));

		$pdoDbConn->query("SELECT COUNT(l.login_time) logins FROM t_logins l JOIN t_login_codes lc ON lc.id_login_code = l.id_login_code WHERE l.id_user = :user_id AND l.login_time > :time_check AND lc.code = :param_scode");
		
		$pdoDbConn->bind(":user_id", $user_id);
		$pdoDbConn->bind(":time_check", $valid_attempts_time);
		$pdoDbConn->bind(":param_scode", $this-> getScodeErr());
		
		// Execute the prepared query.
		$nrOfAttempts=$pdoDbConn->single();
		
		if( $nrOfAttempts['logins'] > $this->getNumberOfAttempts() )
			return true;
		else{
			return false;
		}
	}
	
	private function SaveLoginAttempt($user_id=null, $login_code=null, $pdoDbConn){
		$clientIP = $_SERVER['REMOTE_ADDR'];
		$hostname = gethostbyaddr($clientIP);
		if(is_null($user_id)) {
			$pdoDbConn->query("INSERT INTO t_logins(id_user, ip, host, id_login_code) VALUES(:param_ip, :param_host, (SELECT id_login_code FROM t_login_codes WHERE code = :param_login_code))");
			$pdoDbConn->bind(":param_id_user", $user_id);
		}
		else {
			$pdoDbConn->query("INSERT INTO t_logins(ip, host, id_login_code) VALUES(:param_ip, :param_host, (SELECT id_login_code FROM t_login_codes WHERE code = :param_login_code))");
		}
		$pdoDbConn->bind(":param_ip", $clientIP);
		$pdoDbConn->bind(":param_host", $hostname);
		$pdoDbConn->bind(":param_login_code", $login_code);
		
		if($pdoDbConn->execute())
			return $pdoDbConn->lastInsertId();
		else
			return false;
	}
}
$ClassProcessLogin = new SignIn();