<?php 

	include_once('./config/database.php');
	include('../php_jwt/src/JWT.php');


	use \Firebase\JWT\JWT;


	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Heders, Authorization, X-Requested-With");


	$databaseConn = new Database();
	$conn = $databaseConn->getConnection();

	$data = json_decode(file_get_contents("php://input"));

	$jwt = null;
	$secret_key = "MY_SECRET_KEY";

	$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

	$arr = explode(" ", $authHeader);
	$jwt = $arr[1];

	if ($jwt) {
		
		try {
			
			$decode = JWT::decode($jwt, $secret_key, $array('HS256'));

			http_responose_code(200);
			//header("Location: dashboard.php");
			echo json_encode(array(
					"message" => "Access Granted",
					"error" => $e->getMessage()
					));

		} catch (Exception $e) {

			http_response_code(401);

			echo json_encode(array(
					"message" => "Access DENIED"
					));
		}
	}


 ?>