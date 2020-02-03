<?php 
include_once('./config/database.php');

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");




$firstname = "";
$lastname = "";
$email = "";
$password = "";
$conn = null;

$databaseConn = new Database();
$conn = $databaseConn->getConnection();

$data = json_decode(file_get_contents("php://input"));




$firstname = $data->firstname;
$lastname = $data->lastname;
$email = $data->email;
$password = $data->password;

$hash_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));


$query = "INSERT INTO users (firstname, lastname, email, password) ";
$query .= "VALUES ('$firstname', '$lastname', '$email', '$hash_password')";

$result = mysqli_query($conn, $query);

if ($result) {
	
	http_response_code(200);

	echo json_encode(array("message" => "User Registered Successfully"));

} else {

	http_response_code(400);
	echo json_encode(array("message" => "Failed Registration"));

}





 ?>