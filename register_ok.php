<?php
$conn = mysqli_connect(
	'localhost',
	'dbuser',
	'mara2131@',
	'EuropeTrip',
	'3306');
	if (!$conn->set_charset("utf8")) {
		//printf("utf8 문자 세트를 가져오다가 에러가 났습니다 : %s\n", $conn->error);
	} else {
		//printf("현재 문자 세트 : %s\n", $conn->character_set_name());
		//한글 깨짐 방지 코드
	}
  $is_ajax=$_POST['is_ajax'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $name=$_POST['name'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];

    /*echo $email;
    echo $password;
    echo $name;
    echo $age;
    echo $gender;*/
/*
if(!isset($is_ajax)) exit;
if(!isset($email)) exit;
if(!isset($password)) exit;
if(!isset($name)) exit;
if(!isset($age)) exit;
if(!isset($gender)) exit;*/
$members = [];
$sql2="SELECT * FROM user;";
$sql_exe= mysqli_query($conn, $sql2);
while($exe = mysqli_fetch_array($sql_exe)){
  $emailO = $exe['email'];
  if(strcmp($email, $emailO) == 0) exit;
  //echo $email."<br>";
  //echo $emailO."<br>";
}

$sql = "insert into user
  (name, age, gender, password, email) values ('".$name."','".$age."','".$gender."','".$password."','".$email."');";
  //쿼리 실행하고
  if(!$conn->query($sql)){
    echo "데이터 입력 실패".$conn->error;
  }
  //연결 끊고!
$conn->close();
setcookie('email',$email);
echo "success";
?>
