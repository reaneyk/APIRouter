<?php


error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


class Identity {

	var $c = NULL;

	var $connection = NULL; 
	
	function __construct(){
		$this->connection = new Mongo();
		$this->c = $this->connection->identity->users;

	}

	function search($query){
		$q = explode(' ', $query);

        $q0 = new MongoRegex("/^{$q[0]}/i");
		if(count($q) > 1){
            $q1 = new MongoRegex("/^{$q[1]}/i");

			$search = array(
				':or' => array(
					array('fname' => $q0),
					array('lname' => $q1),
					//array('username' => $q0),
					//rray('username' => $q1),
				)
			);
		} else {
			$search = array(
				':or' => array(
					array('fname' => $q0),
					array('lname' => $q0),
					array('username' => $q0),
				),
			);  
		}
		$tmp = $this->c->find($search);

		//echo '<pre>';
		header("Content-type: application/json");
		echo json_encode(iterator_to_array($tmp));
		//echo '</pre>';
	}

	function getByUsername($username){
		header("Content-type: application/json");
		echo json_encode($this->c->findOne(array('username' => $username)));
	}
	
	function getPhotoByUsername($username) {
		header("Content-type: image/jpeg");
   		$img = file_get_contents("user-photos/$username.jpg", FILE_BINARY);
		header("Content-Length: ".strlen($img));
		echo $img;
	}

}

function router(){
	$ident = new Identity();

	if(isset($_GET['q'])){
		$request_path = strtok($_SERVER['REQUEST_URI'], '?');
   	 	$base_path_len = strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/'));
    		// Unescape and strip $base_path prefix, leaving q without a leading slash.
    		$path = substr(urldecode($request_path), $base_path_len + 1);

		$parsed = filter_var_array(explode('/', trim($path, '/')), FILTER_SANITIZE_STRING);
		if(count($parsed) > 1 ){
			switch($parsed[0]) {
				case 'search':
					$ident->search($parsed[1]);
				break;
				
				case 'users':
					if($parsed[1] == 'by_username' && count($parsed) == 3){
						$ident->getByUsername($parsed[2]);
					}
				break;
				case 'photo':
					if($parsed[1]){
						$ident->getPhotoByUsername($parsed[1]);
					}
				break;
			}
		}
	}
}
router();

?>
