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
	$sql = "SELECT VERSION()";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);

	session_start();
	if (isset($_REQUEST['logout'])) {
      unset($_SESSION['id']);
			unset($_SESSION['name']);
  }
?>
<!DOCTYPE html>
<html>
<title>우리가 떠나야 할 EU</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="myPage.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<body>
<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s3">
      <a href="./index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s3">
      <a href="./about.php" class="w3-button w3-block w3-black">ABOUT</a>
    </div>
    <div class="w3-col s3">
      <a href="./myPage.php" class="w3-button w3-block w3-black">MYPAGE</a>
    </div>
    <div class="w3-col s3">
			<?php if(!isset($_SESSION['id'])): ?>
        <a class='w3-button w3-block w3-black' href='login.php'>LOGIN</a>
      <?php else: ?>
        <form method="post"><input class='w3-button w3-block w3-black' type="submit" name="logout" id="customBtn2" value="LOGOUT" /></form>
      <?php endif ?>
    </div>
  </div>
</div>

<!-- Header with image -->
<header class="bgimg w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-middle w3-center">
    <span class="w3-text-white" style="font-size:50px;">우리가 떠나야 할 EU</span>
  </div>
</header>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

  <div class="w3-container" id="menu">
    <div class="w3-content" style="max-width:700px">

      <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">MYPAGE</span></h5>

      <div class="w3-row w3-center w3-card w3-padding">
        <a href="javascript:void(0)" onclick="openMenu(event, 'Eat');" id="myLink">
          <div class="w3-col s6 tablink">Personal Info</div>
        </a>
        <a href="javascript:void(0)" onclick="openMenu(event, 'Drinks');">
          <div class="w3-col s6 tablink">Trip story</div>
        </a>
      </div>

      <div id="Eat" class="w3-container menu w3-padding-48 w3-card" style="height:400px; overflow:scroll;">
				<?php
					$userQ = "SELECT * FROM user WHERE user_id =".(string)$_SESSION['id'].";" ;
					//echo "SELECT * FROM user WHERE email = $_SESSION['id'];";
					$userR = mysqli_query($conn, $userQ);
					$user = mysqli_fetch_array($userR);
				?>

        <h5 style="margin:0;">Name</h5>
        	<?php echo "<p class=\"w3-text-grey\" style='margin:0'>", $user['name'], "</p><br>";?>
        <h5 style="margin:0;">Age</h5>
				<?php echo "<p class=\"w3-text-grey\" style='margin:0'>", $user['age'], "</p><br>";?>
        <h5 style="margin:0;">Gender</h5>
				<?php echo "<p class=\"w3-text-grey\" style='margin:0'>", $user['gender'], "</p><br>";?>
        <h5 style="margin:0;">Email</h5>
				<?php echo "<p class=\"w3-text-grey\" style='margin:0'>", $user['email'], "</p><br>";?>
      </div>



			<div id="Drinks" class="w3-container menu w3-padding-48 w3-card" style="height:400px; overflow:scroll;">
					<?php
						$user_id= $_SESSION['id'];

					  $user_historyQ = "SELECT * FROM history AS h,
					  history_category AS hc,
					  history_user AS hu,
					  user AS u
					  WHERE u.user_id =".(string)$user_id." AND h.historyUser_id = hu.historyUser_id AND u.user_id = hu.user_id AND hc.category_id = h.category;";
					  $user_historyR = mysqli_query($conn, $user_historyQ);?>
						<?php
					  while($user_history = mysqli_fetch_array($user_historyR)){ ?>

							<div class="histoy">
								<h5 style="margin:0;">Title</h5>
								<p class="w3-text-grey" style="margin:0;"><?php echo $user_history['historyUser_title'];?></p><br>

								<h5 style="margin:0;">History order</h5>
								<p class="w3-text-grey" style="margin:0;"><?php echo $user_history['history_order'];?></p><br>

								<h5 style="margin:0;">Taken time</h5>
								<p class="w3-text-grey" style="margin:0;"><?php echo $user_history['takentime'];?> | <?php echo $user_history['nights'];?>nights <?php echo $user_history['days'];?>days</p><br>

								<h5 style="margin:0;">Where</h5>
								<p class="w3-text-grey" style="margin:0;"><?php echo $user_history['title'];?></p><br>

								<h5 style="margin:0;">Kinds</h5>
								<p class="w3-text-grey" style="margin:0;"><?php echo $user_history['content'];?></p>
							</div>
							<hr style="border-top: 1px solid #a0a1a3;">

				<?php }?>

      </div>
    </div>
  </div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-48 w3-large">
	<p style="font-size:10px">21400749 천재홍 21500209 김혜영
	    <br>21800412 신희주 21800669 정예은<br><br>
		교수님! 데이터베이스 에이쁠 주세요! </p>
  <!--<p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>-->
</footer>

<script>
// Tabbed Menu
function openMenu(evt, menuName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("menu");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-dark-grey", "");
  }
  document.getElementById(menuName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-dark-grey";
}

</script>

</body>
</html>
