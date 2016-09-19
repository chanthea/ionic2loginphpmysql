<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$conn = new mysqli("localhost", "textkhmernews", "Excellent0", "khmernews");

	//http://stackoverflow.com/questions/18382740/cors-not-working-php
	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }


    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
	if (isset($postdata)) {
		$request = json_decode($postdata);
		$username = $request->username;
		$password = $request->password;

		if ($password != "" && $username != "") {
			//echo "Server returns: " . $username . "Password is :" . $password;
			
			/*$arr=array();
			
			$st="select * from subnews order by SubID desc limit 10";
			$qr=$conn->query($st);
			while($row=$qr->fetch_assoc()){
				$arr[]=$row;
			}
			echo json_encode($arr);*/

			$sel = $conn->prepare("SELECT adminID FROM admin WHERE adminName=? AND adminPass=?");
			$sel->bind_param("ss", $username, $password);
		    $sel->execute();
            $result = $sel->get_result();
		    $numrow=$result->num_rows;
		    if($numrow !== 1){
		      header('HTTP/1.1 401 Unauthorized', true, 401);
		    }
				
			
			
			
		}
		else {
			header('HTTP/1.1 401 Unauthorized', true, 401);
		}
	}
	else {
		echo "Not called properly with username parameter!";
	}
?>