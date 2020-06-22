<?php
$conn = mysqli_connect(
	'localhost',
	'dbuser',
	'mara2131@',
	'EuropeTrip',
	'3306');
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (!$conn->set_charset("utf8")) {
	//printf("utf8 문자 세트를 가져오다가 에러가 났습니다 : %s\n", $conn->error);
} else {
	//printf("현재 문자 세트 : %s\n", $conn->character_set_name());
	//한글 깨짐 방지 코드
}
//Data = {title: title, night: night, day: day, count: countChild, cTitle: title, cComment:comment, cSubcategory: subcategory, cCategory:category, ctime: time};
session_start();
$hUser_sql = "(SELECT AUTO_INCREMENT FROM information_schema.tables
WHERE table_name = 'history_user' AND table_schema = DATABASE( ))";
if(!$conn->query($hUser_sql)){
	echo "데이터 입력 실패".$conn->error;
}
$sql_exe= mysqli_query($conn, $hUser_sql);
while($exe = mysqli_fetch_array($sql_exe)){
	$hUser_id = $exe["AUTO_INCREMENT"];
}
$user_sql = "insert into history_user(user_id, nights, days, historyUser_title)
values ('".$_SESSION['id']."','".$POST["night"]."','".$POST["day"]."','".$POST["title"]."');";
//$user_sql = "insert into history_user(historyUser_id, user_id, nights, days, historyUser_title) values ('".$hUser_id."','2','3','4','hellofriend');";
//echo mysql_insert_id();
//$history_id = mysql_insert_id();
	//echo $user_sql."<br>last_id:".$history_id;
  //쿼리 실행하고
  if(!$conn->query($user_sql)){
    echo "데이터 입력 실패".$conn->error;
  }
	//$order = 0;
	for($i=0; $i<$_POST("count"); $i = $i+1){
		$user_sql = "insert into
		history(historyUser_id, history_order, takentime, title, comment, subcategory_id, categoty, checked)
		values ('".$hUser_id."','".($i+1)."','".$_POST["ctime"][i]."','".$_POST["cTitle"][i]."','".$_POST["cComment"][i]."','".$_POST["cSubcategory"][i]."','".$_POST["cCategory"][i]."', '1');";

	}
	if(!$conn->query($user_sql)){
	  echo "데이터 입력 실패".$conn->error;
	}

  //연결 끊고!
$conn->close();
/*if(!isset($_POST['is_ajax'])) exit;
if(!isset($_POST['email'])) exit;
if(!isset($_POST['password'])) exit;
*/
?>
