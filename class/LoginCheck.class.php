<?php
/*
** Logincheck-class functionality.
*/
class LoginCheck
{
	private $userBrowser;
	private $userId;
	private $loginString;
	private $loginCheck;
	
	function __construct(){
	}
	
	protected function setLoginString($value){
		$this -> loginString=$value;
	}
	protected function getLoginString(){
		return $this -> loginString;
	}
	
	protected function setLoginBrowser($value){
		$this -> userBrowser=$value;
	}
	protected function getLoginBrowser(){
		return $this -> userBrowser;
	}
	
	protected function setUserId($value){
		$this -> userId=$value;
	}
	protected function getUserId(){
		return $this -> userId;
	}
	
	protected function setLoginCheck($value){
		$this -> loginCheck=$value;
	}
	protected function getLoginCheck(){
		return $this -> loginCheck;
	}
	
	public function LoginCheck( $pdoDbConn ){
		// Check if all session variables are set 
		if ( isset($_SESSION['user_id'], $_SESSION['login_string']) ){
			return "<h1>hej</h1>";
			$this -> setUserId( $_SESSION['user_id'] );
			$this -> setLoginString( $_SESSION['login_string'] );
			$this -> setLoginBrowser( $_SERVER['HTTP_USER_AGENT'] );
	 
			$pdoDbConn->query( "SELECT unique_hash FROM t_users WHERE id_user = :param_id_user" );
			var_dump($_SESSION);
			// Bind "$user_id" to parameter. 
			$pdoDbConn->bind(':param_id_user', $this -> getUserId());
			$checkRow = $pdoDbConn->single();

			if ($checkRow == true){
				// If the user exists get variables from result.
				$this->setLoginCheck( hash('sha512', $checkRow['unique_hash'] . $this -> getLoginBrowser() ) );

				if ( hash_equals( $this -> getLoginString(), $this -> getLoginCheck() )) // Time-safe for hashes. From PHP 5.6.0
				{
					// Logged In!!!! 
					return true;
				}
				else {
					// Not logged in 
					return false;
				}
			}
			else {
				// Not logged in 
				return false;
			}
		}
		else {
			// Session data not properly set.
			return false;
		}
	}
}
$LoginCheck = new LoginCheck();