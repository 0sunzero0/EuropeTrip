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
	/*로그인!!*/
?>
<!DOCTYPE html>
<html>
<title>우리가 떠나야 할 EU</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="about.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDL8cZ69e-68xrki1OxWWFuLB5m9PCJoU0&libraries=places&callback=initMap"
></script>
<script src="https://use.fontawesome.com/926fe18a63.js"></script>

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

<!-- Add article -->
<article class="post">
<div class="container">

	<h1>우리가 떠나야 할 EU에 대해서</h1>
  <br>
	<p>우리가 떠나야 할 EU는 사용자들에게 기존과 차별화된 사용자 경험을 제공하고 여행 목적지와 관련된 숙식, <br>명소, 공항 정보 등 모든 것을 검색 한 번으로 직관적인 여행 계획 수립에 도움을 주는 서비스입니다.</p>
  <p>또 현재 전세계적인 코로나 팬데믹 사태로 인해 유럽 여행을 가고자 하였으나 불가피하게 취소할 수 밖에 없었던 사람들에게도 소소한 만족과 경험을 대신하여 줄 것입니다. </p>

  <p>최근에는 국외 데이터 센터를 활용해 국내 뿐만 아니라 해외에도 서비스를 제공하고 있습니다.</p>

</div>
</article>


<article class="post">
<div class="container">

	<div class="contact-wrap">
		<div class="contact">
			<span class="fa fa-phone"></span>
			<h2>전화</h2>
			<a href="tel:00012345678">000-1234-5678</a>
		</div>

		<div class="contact">
			<span class="fa fa-envelope"></span>
			<h2>이메일</h2>
			<a href="mailto:contact@logger.nett">contact@EuropeTrip.net</a>
		</div>
	</div>

</div>
</article>

<!-- Add article -->
<aside class="history">
<div class="container">
	<div class="photo"></div>
	<div class="text">
		<h2>History</h2>
		<table>
		<tr>
			<th>2020년 3월</th>
			<td>우리가 떠나야 할 EU 설립<br>우리가 떠나야 할 EU 서비스 제안서 제출</td>
		</tr>
		<tr>
			<th>2020년 4월</th>
			<td>유럽 여행에 대한 검색 서비스를 제공을 위한 <br>플랫폼 설계<br>서비스를 실행할 서버 구축<br>Data 수집 및 전문적인 검색 서비스를 제공할 수 있는 Database 구축<br>서비스를 위한 front page design 기초 설계</td>
		</tr>
		<tr>
			<th>2020년 5월</th>
			<td>Database 정규화<br>해킹 피해 최소화를 위해 우리가 떠나야 할 EU 서비스 <br>보안 강화 및 Database 재구축<br>검색 서비스 제공을 위한 웹페이지 구축</td>
		</tr>
		<tr>
			<th>2020년 6월</th>
      <td>DB에 데이터 추가에 따른 인터페이스 수정<br>우리가 떠나야 할 EU 서비스 시작</td>
		</tr>
		</table>
	</div>
</div>
</aside>



<!-- End page content -->
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
document.getElementById("myLink").click();

	var miminum_size=800;
  $(document).ready(function(){
		$("#op_toggle").click(function(){
			$("#optionList").slideToggle("slow");
			var a=$("#op_toggle").text();
			if(a=='-')
				$("#op_toggle").html("+");
			else {
					$("#op_toggle").html("-");
			}
		});
  });
	var op1=document.getElementById("option1");
	var op2=document.getElementById("option2");

	function changeoption1(op){
		if(op==1){
			op2.style.display='none';
			op1.style.display='block';
		}
		else{
			op1.style.display='none';
			op2.style.display='block';
		}
	}

	var pr=document.getElementsByClassName("positiveR");
	var nr=document.getElementsByClassName("negativeR");
	function changeoption2(op){
		if(op==1){
			for( var i = 0; i < nr.length; i++ )
				nr[i].style.display='none';
			for( var i = 0; i < pr.length; i++ )
				pr[i].style.display='block';
		}
		else{
			for( var i = 0; i < nr.length; i++ )
				nr[i].style.display='block';
			for( var i = 0; i < pr.length; i++ )
				pr[i].style.display='none';
		}
	}

	var count=3;
	$(document).ready(function(){
		$("#tourism").change(function(){
			if($("#tourism").is(":checked")){
					count++;
					 $('.result#tourism').css('display', 'block');
			 }else{
				 if(count==1){
					 alert("최소 하나의 결과 옵션은 남겨 두어야합니다.");
					 $("input#tourism").prop("checked", true);
				 }
				 else{
				 count--;
					 $('.result#tourism').css('display', 'none');
				}
			 }
			 if($(window).width()>=miminum_size){
				 if(count==3){
					 $('.result').css('width', '33.33%');
				 }
				 else if(count==2){
					 $('.result').css('width', '50%');
				 }
				 else{
					 $('.result').css('width', '100%');
				 }
		 	}
		});
		$("#hotel").change(function(){
			if($("#hotel").is(":checked")){
				count++;
				$('.result#hotel').css('display', 'block');
			 }else{
				 if(count==1){
					 alert("최소 하나의 결과 옵션은 남겨 두어야합니다.");
					 $("input#hotel").prop("checked", true);
				 }
				 else{
				 count--;
					 $('.result#hotel').css('display', 'none');
				}
			 }
			 if($(window).width()>=miminum_size){
				 if(count==3){
					 $('.result').css('width', '33.33%');
				 }
				 else if(count==2){
					 $('.result').css('width', '50%');
				 }
				 else{
					 $('.result').css('width', '100%');
				 }
		 	}
		});
		$("#restaurant").change(function(){
			if($("#restaurant").is(":checked")){
					count++;
					 $('.result#restaurant').css('display', 'block');
			 }else{
				 if(count==1){
					 alert("최소 하나의 결과 옵션은 남겨 두어야합니다.");
					 $("input#restaurant").prop("checked", true);
				 }
				 else{
				 count--;
					 $('.result#restaurant').css('display', 'none');
				}
			 }
			 if($(window).width()>=miminum_size){
				 if(count==3){
					 $('.result').css('width', '33.33%');
				 }
				 else if(count==2){
					 $('.result').css('width', '50%');
				 }
				 else{
					 $('.result').css('width', '100%');
				 }
		 	}
		});
	});

	$(window).resize(
		function resizeResult(){
			if($(window).width()>=miminum_size){
				if(count==3){
					$('.result').css('width', '33.33%');
				}
				else if(count==2){
					$('.result').css('width', '50%');
				}
				else{
					$('.result').css('width', '100%');
				}
			}
			else{
				$('.result').css('width', '100%');
			}
		}
	);
	function changeStyle(style){
		var tg=document.getElementById("stylesheet");
		tg.href=("./style"+style+".css")
	}

</script>

</body>
</html>
