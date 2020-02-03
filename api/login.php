<?php include('../includes/header.php'); ?>


<?php 

	include_once('./config/database.php');
	include('../php_jwt/src/JWT.php');

	use \Firebase\JWT\JWT;

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Heders, Authorization, X-Requested-With");

	$email = '';
	$password = '';

	$databaseConn = new Database();
	$conn = $databaseConn->getConnection();

	$data = json_decode(file_get_contents("php://input"));

	$email = $data->email;
	$password = $data->password;


	$user_query = "SELECT user_id, firstname, lastname, password FROM `users` WHERE email = '$email'";
	$user_result = mysqli_query($conn, $user_query);

	if (!$user_result) {
		die("QUERY FAILED" . mysqli_error($conn));
	}

	$num_row = mysqli_num_rows($user_result);

	if ($num_row > 0) {
		
		while ($row = mysqli_fetch_assoc($user_result)) {
			
			$id = $row['user_id'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$db_password = $row['password'];
		}

		if (password_verify($password, $db_password)) {
			
			$secret_key = "MY_SECRET_KEY"; //this is used to sign the JWT payload
			$issuer_claim = "LOCALHOST"; //issuer application
			$audience_claim = "THE_AUDIENCE";
			$issued_date_claim = time(); // timestamp of token
			$not_before_claim = $issued_date_claim + 10; //not valid before 10sec
			$expire_claim = $issued_date_claim + 60; //expires after 60sec
			$token = array(
				"iss" => $issuer_claim,
				"aud" => $audience_claim,
				"iat" => $issued_date_claim,
				"nbf" => $not_before_claim,
				"exp" => $expire_claim,
				"data" => array(

					"id" => $id,
					"firstname" => $firstname,
					"lastname" => $lastname,
					"email" => $email

						));


			http_response_code(200);

			$jwt = JWT::encode($token, $secret_key);
			echo json_encode(
					array(
						"message" => "Successful Login",
						"jwt" => "$jwt",
						"email" => $email,
						"expiredAt" => $expire_claim

					));	


		} else {

			http_response_code(401);
			echo json_encode(array("message" => "Login Failed"));

		}



	} else {

		http_response_code(404);
		echo json_encode(array("message" => "No User Registered Yet"));

	}




 ?>

 <?php include('../includes/footer.php') ?>