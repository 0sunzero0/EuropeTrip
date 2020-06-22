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
	//$_SESSION['id'].":".$_SESSION['name'];
?>
<!DOCTYPE html>
<html>
<title>우리가 떠나야 할 EU</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" type="text/css" href="component.css?d" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDL8cZ69e-68xrki1OxWWFuLB5m9PCJoU0&libraries=places&callback=initMap"
></script>
<script>
	//initial value
	var city11;
	var country11;
	var dstLat;
	var dstLng;
	<?php
		$citysql="SELECT * FROM city;";
		$citysql_exe= mysqli_query($conn, $citysql);
		$countrysql="SELECT * FROM country;";
		$countrysql_exe= mysqli_query($conn, $countrysql);
	?>
	// 나중에 search 버튼 클릭했을 때 새로고침 안하기 위해 미리 배열로 저장해놓음
	var arrcity = [<?php while($cityAll = mysqli_fetch_array($citysql_exe)){
						echo json_encode($cityAll).",";
					}?>
				];
	var arrcountry = [<?php while($countryAll = mysqli_fetch_array($countrysql_exe)){
						echo json_encode($countryAll).",";
					}?>
				];
	console.log(arrcity);
	console.log(arrcountry);
	// Coordinate function은 search 버튼 클릭 했을 때 해당 시티의 좌표를 마커로 출력해주는 역할
	function Coordinate(city11){
		for(var i=0; i<arrcity.length; i++){
			if(arrcity[i]['city_name']==city11){
				dstLat = Number(arrcity[i]['lat']);
				dstLng = Number(arrcity[i]['lng']);
			}
		}
		console.log(dstLat+"     "+dstLng);
		var destination = {lat: dstLat, lng: dstLng};
		moveMap(dstLat, dstLng);
		var marker = new google.maps.Marker({
			position: destination,
			//map: new google.maps.Map(document.getElementById("googlemap"),marker),
			map: map
		});

	}
	//google.maps.event.addDomListener(window, "load", Coordinate);

	function callCity(country11){
		var cityoption = document.getElementById("cities");
		cityoption.innerHTML="";
		for(var i =0; i<arrcountry.length; i++){
			if(arrcountry[i]["name"]==country11){
				for(var j=0; j<arrcity.length; j++){
					if(arrcountry[i]["country_id"]==arrcity[j]["country_id"]){
						var str = "<option value="+arrcity[j]['city_name']+"></option>";
						cityoption.innerHTML+=str;
					};
				};
			};
		};
	}
</script>

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
      <a href="./index.php#menu" class="w3-button w3-block w3-black">MYPAGE</a>
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

<button class="button-4" id="showLeft" style="position:fixed; top:100px; left:30px; z-index:3000;"><i class="fas fa-pen"></i> INFO</button>
<button  class="button-4" id="showRight" style="position:fixed; top:160px; left:30px; z-index:3000;"><i class="fas fa-map-marked-alt" style="z-index:343005"></i> MAPS</button>

<button class="button-5" id="loginO" style="position:fixed; top:100px; right:30px; z-index:3000; display:block;">
환영합니다<br>
<? echo $_SESSION['name'];?>님!
</button>
<button class="button-5" id="loginX" style="position:fixed; top:100px; right:30px; z-index:3000; font-size:0.5em; display:none;">
로그인 후 더 다양한<br>
서비스를 이용하실 수 있습니다
</button>
<script>
if(<? echo $_SESSION['name'];?>==''){
	alert("he");
	$('#loginO').css('display', 'block');
	$('#loginX').css('display', 'none');
}
else{
	alert("no");
	$('#loginX').css('display', 'block');
	$('#loginO').css('display', 'none');
}

</script>

<!-- Header with image -->
<header class="bgimg w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-middle w3-center">
    <span class="w3-text-white" style="font-size:50px;">우리가 떠나야 할 EU</span>
  </div>
</header>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

	<!-- 검색 -->
	<div class="w3-container" id="where" style="padding-bottom:32px;">
	  <div class="w3-content" style="max-width:700px">
	    <h5 class="w3-center w3-padding-48" style="margin-bottom:-20px;"><span class="w3-tag w3-wide">SEARCH</span></h5>
	    <!--<p>Find us at some address at some place.</p>
	    <img src="https://www.w3schools.com/w3images/map.jpg" class="w3-image" style="width:100%">
	    <p><span class="w3-tag">FYI!</span> We offer full-service catering for any event, large or small. We understand your needs and we will cater the food to satisfy the biggerst criteria of them all, both look and taste.</p>
	    <p><strong>Reserve</strong> a table, ask for today's special or just send us a message:</p>
	    <form action="https://www.w3schools.com/action_page.php" target="_blank">-->

			<!--
	      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Name" required name="Name"></p>
	      <p><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="How many people" required name="People"></p>
	      <p><input class="w3-input w3-padding-16 w3-border" type="datetime-local" placeholder="Date and time" required name="date" value="2017-11-16T20:00"></p>
	      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Message \ Special requirements" required name="Message"></p>
	      <p><button class="w3-button w3-black" type="submit">SEND MESSAGE</button></p>-->
				<div style="width:100%; height:auto; background-color:white; text-align:center; padding: 20px 0px;">
					<div class="option">
				    Option choose <button id="op_toggle" style="height:30px;">+</button>
				    <div id="optionList">
							<div class="optionDiv">
								Q. 어떤 방법으로 검색하시겠습니까?<br>
								<input name="method" type="radio" value="city" onchange="changeoption1(1)" checked>도시 이름으로<br>
								<input name="method" type="radio" onchange="changeoption1(2)" value="airpot">공항 이름으로<br>
							</div>
							<div class="optionDiv" style="display:none;">
								Q. 어떤 결과를 보기 원하십니까?<br>
								<input type="checkbox" id="tourism" checked>여행지
								<input type="checkbox" id="hotel" checked>호텔
								<input type="checkbox" id="restaurant" checked>레스토랑
								<br>
							</div>
				    </div>
				  </div><br>
				  <b>Searching Space</b><br>
					<!--나라 + 도시로 찾기-->
				  <form class ="search" id="option1">
						<span class="input_res">
					    <input id="country" class="info" list="countries" placeholder ="country" onclick="this.value=''" onchange="country11=this.value;callCity(country11);">
					    <datalist id="countries">
				        <?php
				          $countryQ = "SELECT * FROM country;";
				          $countryR = mysqli_query($conn, $countryQ);
				          while($country = mysqli_fetch_array($countryR)){
				            $countryId=$country['country_id'];
				         ?>
				         <option value=<?php echo $country['name']; ?>>
				        <?php } ?>
				        <?php
				          $countryLNQ = "SELECT * FROM countryLN;";
				          $countryLNR = mysqli_query($conn, $countryLNQ);
				          mysqli_query ($countryLNR,"set names utf8");
				          while($countryLN = mysqli_fetch_array($countryLNR)){
				         ?>
				         <option value=<?php echo $countryLN['name'];//지금 한글 깨짐 ?>>
				        <?php } ?>
					    </datalist>
						</span>
						<span class="input_res">
					    <input id="city" class="info" list="cities" placeholder ="city" onclick="this.value=''" onchange="city11=this.value;">
					    <datalist id="cities">
				        <?php
				          //$cityQ = "SELECT * FROM city right outer join country using(country_id) where name = 'Switzerland';";
				          //$con = 'Switzerland';
				          //$cityQ = "SELECT * FROM city right outer join country using(country_id) where name = '$con';";
				          $cityQ = "SELECT * FROM city;";
				          $cityR = mysqli_query($conn, $cityQ);
				          while($city = mysqli_fetch_array($cityR)){
				         ?>
				         <option value=<?php echo $city['city_name']; ?> >
				        <?php } ?>
				        <?php
				          //$cityQ = "SELECT * FROM city right outer join country using(country_id) where name = 'Switzerland';";
				          //$con = 'Switzerland';
				          //$cityQ = "SELECT * FROM city right outer join country using(country_id) where name = '$con';";
				          $cityLNQ = "SELECT * FROM cityLN;";
				          $cityLNR = mysqli_query($conn, $cityLNQ);
				          while($city = mysqli_fetch_array($cityLNR)){
				         ?>
				         <option value=<?php echo $city['name']; ?>>
				        <?php } ?>
					    </datalist>
						</span>
						<span class="input_res">
				    	<button id="search" type ="button" onclick="Coordinate(city11)">Search</button>
						</span>
				  </form>
					<!--나라 + 공항으로 찾기-->
					<form class="search" id="option2">
						<span class="input_res">
							<input id="country" class="info" list="countries" placeholder ="country">
							<datalist id="countries">
				        <?php
				          $countryQ = "SELECT * FROM country;";
				          $countryR = mysqli_query($conn, $countryQ);
				          while($country = mysqli_fetch_array($countryR)){
				            $countryId=$country['country_id'];
				         ?>
				         <option value=<?php echo $country['name']; ?>>
				        <?php } ?>
				        <?php
				          $countryLNQ = "SELECT * FROM countryLN;";
				          $countryLNR = mysqli_query($conn, $countryLNQ);
				          mysqli_query ($countryLNR,"set names utf8");
				          while($countryLN = mysqli_fetch_array($countryLNR)){
				         ?>
				         <option value=<?php echo $countryLN['name'];//지금 한글 깨짐 ?>>
				        <?php } ?>
							</datalist>
						</span>
						<span class="input_res">
							<input id="airport" class="info" list="airports" placeholder ="airport">
							<datalist id="airports">
								<option value="공항1">
								<option value="공항2">
								<option value="공항3">
								<option value="공항4">
							</datalist>
						</span>
						<span class="input_res">
							<button id="search" type ="button" onclick="">Search</button>
						</span>

					</form>
				</div>
	    </form>
	  </div>
	</div>

<!-- About Container -->
<div class="w3-container" id="about">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-64" style="margin-bottom:-20px;"><span class="w3-tag w3-wide">MAPS</span></h5>
    <!--<p>The Cafe was founded in blabla by Mr. Smith in lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    <p>In addition to our full espresso and brew bar menu, we serve fresh made-to-order breakfast and lunch sandwiches, as well as a selection of sides and salads and other good stuff.</p>-->
    <!--<img src="https://www.w3schools.com/w3images/coffeeshop.jpg" style="width:100%;max-width:1000px" class="w3-margin-top">
		<br><br>-->
		<div class="MAPS" id="googlemap" ></div>
		<br><br>
		<script>
		var map;
		function initMap() {
		  var mapProp= {
			center:new google.maps.LatLng(51.508742, -0.120850),
			zoom:5,
		  };
		  map = new google.maps.Map(document.getElementById("googlemap"),mapProp);
		}
		function moveMap(lat, lng) {
		  var mapProp= {
			center:new google.maps.LatLng(lat, lng),
			zoom:5,
		  };
		  map = new google.maps.Map(document.getElementById("googlemap"),mapProp);
		}
		</script>
    <!--<p><strong>Opening hours:</strong> everyday from 6am to 5pm.</p>
    <p><strong>Address:</strong> 15 Adr street, 5015, NY</p>-->
  </div>
</div>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2" style="height:400px; box-shadow: 5px 5px 5px gray;">
  <h3>MAPS</h3>
  <a href="#">Celery seakale</a>
  <a href="#">Dulse daikon</a>
  <a href="#">Zucchini garlic</a>
  <a href="#">Catsear azuki bean</a>
  <!--<div class="MAPS" id="googlemap"></div>-->
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1" style="height:400px; box-shadow: 5px 5px 5px gray;">
  <h3>INFO</h3>
  <a href="#">Celery seakale</a>
  <a href="#">Dulse daikon</a>
  <a href="#">Zucchini garlic</a>
  <a href="#">Catsear azuki bean</a>
</nav>

<!-- Menu Container -->
<div class="w3-container" id="menu">
  <div class="w3-content" style="max-width:700px;">

    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">THE RESULT</span></h5>

    <div class="w3-row w3-center w3-card w3-padding">
      <a href="javascript:void(0)" onclick="openMenu(event, 'Tourism');" id="myLink">
        <div class="w3-col s6 tablink">Tourism</div>
      </a>
      <a href="javascript:void(0)" onclick="openMenu(event, 'Hotel');">
        <div class="w3-col s6 tablink">Hotel</div>
      </a>
			<a href="javascript:void(0)" onclick="openMenu(event, 'Restaurant');">
				<div class="w3-col s6 tablink">Restaurant</div>
			</a>
    </div>

    <div id="Tourism" class="w3-container menu w3-padding-48 w3-card" style="height:500px; overflow:scroll;">
			<?php
				$touristQ = "SELECT tourist_id, tourist.name AS tn, touristLN.name AS tnL, features, image FROM tourist JOIN touristLN using(tourist_id);";
				$touristR = mysqli_query($conn, $touristQ);
				while($tourist = mysqli_fetch_array($touristR)){
			 ?>
			 <div class="elementT" style="padding:5px; margin:5px; height:120px; overflow:scroll">
				 <div style="display:inline-block; width:calc(100% - 100px);">
				 <b id="t_name<?php echo $tourist['tourist_id'];?>"><?php echo $tourist['tnL'];?></b><br>
				 <script>

				 t_name<?php echo $tourist['tourist_id'];?>.onmouseover = function(){
					  document.getElementById('t_name<?php echo $tourist['tourist_id'];?>').innerHTML = "<?php echo $tourist['tn'];?>";
				 };
				 t_name<?php echo $tourist['tourist_id'];?>.onmouseleave = function(){
						document.getElementById('t_name<?php echo $tourist['tourist_id'];?>').innerHTML = "<?php echo $tourist['tnL'];?>";
				 };

				 // 재홍 여기서 tourist lat, lng을 넘길 것임
				 window.onload = function(){
					 var tAttraction = document.getElementById('Tourism');

					 // Attraction 객체에 onclink 이벤트 속성 연결
					 tAttraction.onclick = function() {
						 //

					 }
				 }
				 </script>
				 <div style="height:5px"></div>
				 <?php echo $tourist['features'];?>
				 </div>
				 <div style="display:inline-block; float:right;">
				 <img src="<?php echo $tourist['image'];?>" width=100px; height=100px; alt="No Image" style="margin-top:3px;">
			  </div>
			 </div>
			 	<hr style="border-top: 1px solid #a0a1a3;">
		<?php } ?>

    </div>

    <div id="Hotel" class="w3-container menu w3-padding-48 w3-card" style="height:500px; overflow:scroll;">
			<div id="optionhr" style="padding: 10px; position:fixed; background-color : #535454; right:30px; color:white;">
			<input name="reviewType" type="radio" value="positive" onchange="changeoption2(1)" checked> positive Review<br>
			<input name="reviewType" type="radio" onchange="changeoption2(2)" value="negative"> Negative Review<br>
		</div>
		<!--<hr style="border-top: 1px solid #a0a1a3;">-->
			<?php
	      $hotelQ = "SELECT * FROM hotel join hotelCost_test on hotel.hotel_id=hotelCost_test.hotelcost_id LIMIT 5;";
	      $hotelR = mysqli_query($conn, $hotelQ);
	      while($hotel = mysqli_fetch_array($hotelR)){
	     ?>
	     <div class="elementH" style="padding:5px; margin:10px; height:270px; overflow:scroll">
	       <div style="display:inline-block; width:100%">
	       <b><?php echo $hotel['name'];?></b>
	       <div style="height:5px"></div>
	       singlebed - <?php echo $hotel['singlebed'];?>원<br>
				 doublebed - <?php echo $hotel['doublebed'];?>원<br>
				 ensuite - <?php echo $hotel['ensuite'];?>원<br>

				 <!--positive-->
				 <div class="positiveR" style="background:#d5eded; overflow:scroll; height:150px; width:100%; margin-top:15px; padding:5px; font-size:0.8em;">
						<?php
						$hotelname=$hotel['name'];
						 $hotelreviewPQ = "SELECT * FROM hotelPosReview_test join hotel
						 on hotelPosReview_test.hotel_name=hotel.name
						 where hotel_name='$hotelname' LIMIT 10";
						 $hotelreviewPR = mysqli_query($conn, $hotelreviewPQ);
						 while($hotelreviewP = mysqli_fetch_array($hotelreviewPR)){
						?>
						<p><?php echo $hotelreviewP['review_date'];?><br>
							<?php echo $hotelreviewP['review'];?>
						</p>
						<hr style="border-top: 1px solid #a0a1a3;">
					<?php } ?>
				 </div>
				  <!--negative-->
				 <div class="negativeR" style="background:#debdb8; overflow:scroll; height:150px; width:100%; margin-top:15px; padding:5px; font-size:0.8em; display:none;">
					 <?php
					 $hotelname=$hotel['name'];
						$hotelreviewNQ = "SELECT * FROM hotelNegReview_test join hotel
						on hotelNegReview_test.hotel_name=hotel.name
						where hotel_name='$hotelname' LIMIT 10";
						$hotelreviewNR = mysqli_query($conn, $hotelreviewNQ);
						while($hotelreviewN = mysqli_fetch_array($hotelreviewNR)){
					 ?>
					 <p><?php echo $hotelreviewN['review_date'];?><br>
						 <?php echo $hotelreviewN['review'];?>
					 </p>
					 <hr style="border-top: 1px solid #a0a1a3;">
				 <?php } ?>
				 </div>
	       </div>
	     </div>
			 	<hr style="border-top: 1px solid #a0a1a3;">
	  <?php } ?>
    </div>
    <!--<img src="https://www.w3schools.com/w3images/coffeehouse2.jpg" style="width:100%;max-width:1000px;margin-top:32px;">-->

	<div id="Restaurant" class="w3-container menu w3-padding-48 w3-card">
		<?php
			$resQ = "SELECT * FROM restaurant left outer join restaurantCost on restaurant.res_id1=restaurantCost.res_id LIMIT 5;";
			$resR = mysqli_query($conn, $resQ);
			while($res = mysqli_fetch_array($resR)){
		 ?>
		 <div class="elementH" style="padding:5px; margin:10px;height:270px; overflow:scroll">
			 <div style="display:inline-block; width:100%">
			 <b><?php echo $res['name'];?></b>
			 <div style="height:5px"></div>
			 twoPeople - <?php echo $res['twoPeople'];?>원<br>
			 threePeople - <?php echo $res['threePeople'];?>원<br>
			 fourPeople - <?php echo $res['fourPeople'];?>원<br>
			 <div style="background:#ebead3; overflow:scroll; height:150px; width:100%; margin-top:15px; padding:5px; font-size:0.8em;">
				 <?php
				 $resId=$res['res_id1'];
					$resreviewQ = "SELECT * FROM restaurantReview
					where revRes_id='$resId' LIMIT 5";
					$resreviewR = mysqli_query($conn, $resreviewQ);
					while($resreview = mysqli_fetch_array($resreviewR)){
				 ?>
				 <p><?php echo $resreview['review_date'];?><br>
					 <?php echo $resreview['review'];?>
				 </p>
				 <hr style="border-top: 1px solid #a0a1a3;">
			 <?php } ?>
			 </div>
			 </div>
		 </div>
		 <hr style="border-top: 1px solid #a0a1a3;">
		<?php } ?>
	</div>
	</div>
</div>

<div class="w3-panel w3-leftbar w3-light-grey">
	<p><i>나이순 히스토리</i></p>
</div>

<div class="w3-panel w3-leftbar w3-light-grey">
	<p><i>성별순 히스토리</i></p>
</div>

<div class="w3-panel w3-leftbar w3-light-grey">
	<p><i>몇박몇일 히스토리</i></p>
</div>

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
		$('#showLeft').click(function () {
						$('#cbp-spmenu-s2').css('z-index','1000');
						$('#cbp-spmenu-s1').css('z-index','1005');
					});
		$('#showRight').click(function () {
					$('#cbp-spmenu-s2').css('z-index','1005');
					$('#cbp-spmenu-s1').css('z-index','1000');
					});
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

	var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		menuRight = document.getElementById( 'cbp-spmenu-s2' );
		showLeft.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
		};
		showRight.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( menuRight, 'cbp-spmenu-open' );
		};
</script>
<script src="classie.js"></script>

</body>
</html>
