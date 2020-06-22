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
session_start();
if(!isset($_POST['is_ajax'])) exit;
if(!isset($_POST['email'])) exit;
if(!isset($_POST['password'])) exit;
$is_ajax=$_POST['is_ajax'];
$user_id = $_POST['email'];
$user_pw = $_POST['password'];
$members = [
        'user2'=>['id'=>'0', 'pw'=>'1234', 'name'=>'박이팔'],
        'user3'=>['id'=>'0', 'pw'=>'1234', 'name'=>'최삼칠'],
];
//$members = array();

$sql="SELECT * FROM user;";
$sql_exe= mysqli_query($conn, $sql);
while($exe = mysqli_fetch_array($sql_exe)){
  $email = $exe['email'];
  $password = $exe['password'];
  $name = $exe['name'];
	$id = $exe['user_id'];

	$members[$email]['id']=$id;
  $members[$email]['pw']=$password;
  $members[$email]['name']=$name;
}

$_SESSION['id'] = $members[$user_id]['id'];
$_SESSION['name'] = $members[$user_id]['name'];

if(!$is_ajax) exit;
if(!isset($members[$user_id])) exit;
if($members[$user_id]['pw'] != $user_pw) exit;
setcookie('user_id',$members[$user_id]['id']);
setcookie('user_name',$members[$user_id]['name']);
echo "success";
?>
