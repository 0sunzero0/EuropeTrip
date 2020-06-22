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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="index.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDL8cZ69e-68xrki1OxWWFuLB5m9PCJoU0&libraries=places&callback=initMap"
></script>
<!-- ********************************************************* -->
<script>
	// This part is for only constructing the google maps.
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
		zoom:4,

	  };
	  map = new google.maps.Map(document.getElementById("googlemap"),mapProp);
	}
	var pathway = new Array;
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
		pathway.push(destination);
		var marker = new google.maps.Marker({
			position: destination,
			//map: new google.maps.Map(document.getElementById("googlemap"),marker),
			map: map,
			icon: {
				url: 'img/currentplace.png',
				scaledSize: new google.maps.Size(50, 50),
			},
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
<head>
	<style type="text/css">
	* {
	  font-family: "Inconsolata", sans-serif;
	}
	</style>
</head>
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

<button class="button-4" id="showLeft" style="position:fixed; top:100px; left:30px; z-index:3000;"><i class="fas fa-pen"></i> INFO</button>
<button  class="button-4" id="showRight" style="position:fixed; top:160px; left:30px; z-index:3000;"><i class="fas fa-map-marked-alt" style="z-index:343005"></i> MAPS</button>

<!-- Header with image -->
<header class="bgimg w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-middle w3-center">
    <span class="w3-text-white" style="font-size:50px;">우리가 떠나야 할 EU</span>
  </div>
</header>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

	<div class="w3-sand w3-grayscale w3-large">
	  <div class="w3-container" id="where" style="padding-bottom:32px;">
		  <div class="w3-content" style="max-width:700px">
	      <h5 class="w3-center w3-padding-48" style="margin-bottom:-20px;"><span class="w3-tag w3-wide">SEARCH</span></h5>
	      <div style="width:100%; height:auto; background-color:white; text-align:center; padding: 20px 0px;">
	        <form name = "searchForm" id="searchForm" class="form-horizontal">
	          <div class="form-group">
	            <label class="col-md-2 control-label">Filter</label>
	            <div class="col-md-3">
	              <select id = "selectFilter" class="form-control">
	                <!--<option>공항</option>-->
	                <option>관광지</option>
	                <option>식당</option>
	                <option>호텔</option>
	                <option>식당최대비용</option>
	                <option>식당최소비용</option>
	                <option>호텔최대비용</option>
	                <option>호텔최소비용</option>
	              </select>
	            </div>
	            <div class="col-md-4">
	              <input type="text" class="form-control" id="Fcontent" placeholder="필터 내용을 적어주세요~:)">
	            </div>
	            <div class="col-md-2" id = "addButton">
	              <input type="button" class="form-control" id="addFilter" value="필터 추가">
	            </div>
	          </div>
	          <div class = "form-group" id = "filterValue" style="text-align: left; padding-left: 30px;">
	            <input type="number" id="FilterCount" value="0" hidden>
	            <input type="button" class = "filter" id="Fairport" name = "airport" value="" hidden>
	            <input type="button" class = "filter" id="Ftourist" name = "tourist" value="" hidden>
	            <input type="button" class = "filter" id="Fhotel" name = "hotel" value="" hidden>
	            <input type="button" class = "filter" id="Frestaurant" name = "restaurant" value="" hidden>
	            <input type="button" class = "filter maxcost" id="FresMax" name = "restaurant" value="" hidden>
	            <input type="button" class = "filter maxcost" id="FhotelMax" name = "hotel" value="" hidden>
	            <input type="button" class = "filter mincost" id="FresMin" name = "restaurant" value="" hidden>
	            <input type="button" class = "filter mincost" id="FhotelMin" name = "hotel" value="" hidden>
	          </div>
	            <div class="form-group">
	              <label class="col-md-3 control-label">city & country</label>
	              <div class="col-md-3">
	                <input id="country" class="form-control" list="countries" placeholder ="country" onclick="this.value=''" onchange="country11=this.value;callCity(country11);">
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
	              </div>
	              <div class="col-md-3">
	                <input id="city" class="form-control" list="cities" placeholder ="city" onclick="this.value=''" onchange="city11=this.value;">
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
	              </div>
	              <div class="col-md-2">
					  <!-- 재홍 여기에 onclick 옵션 넣어서 클릭하면 지도 바뀌게 함-->
	                <input type="button" class="form-control" id="search" value="Search" onclick="Coordinate(city11)">
	              </div>
	            </div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

<!-- About Container -->
<div class="w3-container" id="about">
  <div class="w3-content" style="max-width:700px; margin-bottom:-300px;">
    <!--<h5 class="w3-center w3-padding-64" style="margin-bottom:-20px;"><span class="w3-tag w3-wide">MAPS</span></h5>-->
		<!--<div class="MAPS" id="googlemap" ></div>-->
    <!--<p><strong>Opening hours:</strong> everyday from 6am to 5pm.</p>
    <p><strong>Address:</strong> 15 Adr street, 5015, NY</p>-->
  </div>
</div>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2" style="height:400px; box-shadow: 5px 5px 5px gray; overflow:scroll;">
  <!--<h3>MAPS</h3>-->
	<div class="MAPS" id="googlemap" style=""></div>
  <!--<div class="MAPS" id="googlemap"></div>-->
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1" style="height:400px; box-shadow: 5px 5px 5px gray; overflow:scroll;">
  <h3><input id = "historyTitle" placeholder="여행 제목" style="background:none; border:none; margin-bottom:0;"></input><br>
	<input id = "night" placeholder="~박" style="background:none; border:none; font-size:15px; margin:0;">
	<input id = "day" placeholder="~일" style="background:none; border:none; font-size:15px; margin:0">
	<button id="infosubmit" style="float:right; color:black; font-size:20px; border-radius:8px; margin-top:7px;">저장</button></h3>
	<div id="list">
	<a class="added" style="font-size:13px;">
		<p style="margin:0;">[사용방법]<button class="remove" style="float:right; color:black;">x</button></p>
		<p style="margin:0;">원하는 여행지/호텔/레스토랑을 클릭하면 추가됩니다. <br>x를 누르면 사라집니다.</p>
	</a>

	</div>
	<script>
	//heeju
	$('#infosubmit').on('click', '', function() {
		var title = $("#historyTitle").val();
		var night = $("#night").val();
		var day = $("#day").val();
		console.log(title+ "(" +night+" : "+day+")");
		var ctitle = new Array();
		var comment = new Array();
		var subcategory = new Array();
		var category = new Array();
		var countChild = document.getElementById("list").childElementCount;
		console.log("hello1: "+ document.getElementById("list").childElementCount);
		var children = document.getElementById("list").childNodes;
		console.log("hello: "+ document.getElementById("list").childNodes);

		for(var i=0; i<countChild; i++){
			//console.log(document.getElementById("list").childNodes[i].nodeValue);
			console.log
		}
		//Data = {title: title, night: night, day: day, count: countChild, cTitle: ctitle, cComment:comment, cSubcategory: subcategory, cCategory:category, cTime: ctime};
		/*
    $.ajax({
      url:"info.php",
      method:"POST",
      data:Data,
      success:function(data){
        console.log("success");
				$("#list").html(data);
				//alert("전송되었습니다.");
        //window.location.href = "http://54.236.33.130/EuropeTrip/";
      }
    });*/
		alert("전송되었습니다.");
		$("#list").html("");
	});
	</script>
	<div id="elementL" style="display:none;">
	<a class="added" style="font-size:13px;">
			<p class="added1" style="margin:0;">[사용방법]<button class="remove" style="float:right; color:black;">x</button></p>
		<p class="added2" style="margin:0;">Eiffel tower</p>
		<p class="added3" style="display:none;"></p>
		<input placeholder="소요시간(hour)" type="number" style="height:20px; margin-bottom:5px; color:black;"/>
		<input placeholder="comment" style="width:500px; background:none; border:none; border-radius: 5px; border-bottom: solid 2px white; background: white; line-height:1px; margin-top:2px; color:black;">
	</a>
</div>
</nav>

<!-- Menu Container -->
<div class="w3-container" id="menu">
  <div class="w3-content" style="max-width:700px;">

    <!--<h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">THE RESULT</span></h5>-->

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
			// 재홍 latitude, lng select 쿼리에 추가.
				$touristQ = "SELECT tourist_id, tourist.name AS tn, touristLN.name AS tnL, features, image, latitude, lng FROM tourist JOIN touristLN using(tourist_id);";
				$touristR = mysqli_query($conn, $touristQ);
				while($tourist = mysqli_fetch_array($touristR)){
			 ?>
			 <div class="elementT" id="T<?php echo $tourist['tourist_id'];?>" style="padding:5px; margin:5px; height:120px; overflow:scroll">
				 <div style="display:inline-block; width:calc(100% - 100px);">
				 <b id="t_nameT<?php echo $tourist['tourist_id'];?>" ><?php echo $tourist['tnL'];?></b>
				 <p id="latT<?php echo $tourist['tourist_id'];?>" style="display:none"><?php echo $tourist['latitude'];?></p>
				 <p id="lngT<?php echo $tourist['tourist_id'];?>" style="display:none"><?php echo $tourist['lng'];?></p>
				 <script>
				 t_nameT<?php echo $tourist['tourist_id'];?>.onmouseover = function(){
					  document.getElementById('t_nameT<?php echo $tourist['tourist_id'];?>').innerHTML = "<?php echo $tourist['tn'];?>";
				 };
				 t_nameT<?php echo $tourist['tourist_id'];?>.onmouseleave = function(){
						document.getElementById('t_nameT<?php echo $tourist['tourist_id'];?>').innerHTML = "<?php echo $tourist['tnL'];?>";
				 };

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
		 <div class="elementH" id="H<?php echo $hotel['hotel_id'];?>" style="padding:5px; margin:10px; height:290px; overflow:scroll">
	       <div style="display:inline-block; width:100%">
	       <b id="h_nameH<?php echo $hotel['hotel_id'];?>"><?php echo $hotel['name'];?></b>
		   <p id="latH<?php echo $hotel['hotel_id'];?>" style="display:none"><?php echo $hotel['lat'];?></p>
		   <p id="lngH<?php echo $hotel['hotel_id'];?>" style="display:none"><?php echo $hotel['lng'];?></p>

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

	<div id="Restaurant" class="w3-container menu w3-padding-48 w3-card" style="height:500px; overflow:scroll;">
		<?php
			$resQ = "SELECT * FROM restaurant AS r JOIN city AS c ON c.country_id=r.resLocation_id LEFT OUTER JOIN restaurantCost ON res_id1=res_id WHERE c.country_id=c.city_id AND res_id1 IS NOT NULL LIMIT 5;";
			$resR = mysqli_query($conn, $resQ);
			while($res = mysqli_fetch_array($resR)){
		 ?>
		 <div class="elementR" id="R<?php echo $res['res_id1'];?>" style="padding:5px; margin:10px;height:290px; overflow:scroll">
			 <div style="display:inline-block; width:100%">
			 <b id="r_nameR<?php echo $res['res_id1'];?>"><?php echo $res['name'];?></b>
			 <p id="latR<?php echo $res['res_id1'];?>" style="display:none"><?php echo $res['lat'];?></p>
			 <p id="lngR<?php echo $res['res_id1'];?>" style="display:none"><?php echo $res['lng'];?></p>
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
<div style="margin-bottom:100px;"></div>
<div class="w3-panel w3-leftbar w3-light-grey" style="height:500px; overflow:scroll">
		<p style="margin-top:30px; margin-bottom:20px; text-align:center;"><b><i>"나이순 히스토리"</i></b></p>
 	<?php
	  $ordAgeQ = "SELECT * FROM history AS h,
	  history_category AS hc,
	  history_user AS hu,
	  user AS u
	  WHERE h.historyUser_id = hu.historyUser_id AND u.user_id = hu.user_id AND hc.category_id = h.category;";
	  $ordAgeR = mysqli_query($conn, $ordAgeQ);
		$historyId="";
		$same=0;
	  while($ordAge = mysqli_fetch_array($ordAgeR)){
			if(strcmp("".$historyId , "".$ordAge['historyUser_id'])!=0){
				$historyId=$ordAge['historyUser_id'];
				$same=0;
			}else{
				$same=1;
			}
			?>

		  <div class="historyAge" id="HA<?php echo $ordAge['history_id'];?>" style="padding:5px; margin:10px;">
		    <div style="display:inline-block; width:100%;">
		    <?php
		    if($ordAge['age']<20){
				if($same==0)echo "<b>(10대) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
				/*echo "<p>History order :", $ordAge['history_order'], "| Taken time: ", $ordAge['takentime'], " | ", $ordAge['nights'], " nights", $ordAge['days'], "days <br>";
		    echo "Where: ", $ordAge['title'], " | Kinds: ", $ordAge['content'], "<br></p>";*/
				//echo "<p>#$ordAge['history_order']<br>"
			}else if($ordAge['age'] >= 20 && $ordAge['age'] < 30){
				if($same==0)echo "<b>(20대) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
			}else if($ordAge['age'] >= 30 && $ordAge['age'] < 40){
				if($same==0)echo "<b>(30대) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
			}else ?>
		   </div>
		  </div>
			<hr style="border-top: 1px solid #a0a1a3;">

<?php }?>

</div>

<div class="w3-panel w3-leftbar w3-light-grey" style="height:500px; overflow:scroll">
		<p style="margin-top:30px; margin-bottom:20px; text-align:center;"><b><i>"성별순 히스토리"</i></b></p>
	<?php
	  $ordAgeQ = "SELECT * FROM history AS h,
	  history_category AS hc,
	  history_user AS hu,
	  user AS u
	  WHERE h.historyUser_id = hu.historyUser_id AND u.user_id = hu.user_id AND hc.category_id = h.category;";
		$historyId2="";
	  $ordAgeR = mysqli_query($conn, $ordAgeQ);
	  while($ordAge = mysqli_fetch_array($ordAgeR)){
			if(strcmp("".$historyId2 , "".$ordAge['historyUser_id'])!=0){
				$historyId2=$ordAge['historyUser_id'];
				$same=0;
			}else{
				$same=1;
			}
			?>
		  <div class="historyAge" id="HA<?php echo $ordAge['history_id'];?>" style="padding:5px; margin:10px;">
		    <div style="display:inline-block; width:100%">
		    <?php
		    if($ordAge['gender'] == "F"){
				if($same==0)echo "<b>(여자) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
			}else{
				if($same==0)echo "<b>(남자) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
			}?>
		   </div>
		  </div>
			<hr style="border-top: 1px solid #a0a1a3;">
<?php }?>
</div>

<div class="w3-panel w3-leftbar w3-light-grey" style="height:500px; overflow:scroll">
	<p style="margin-top:30px; margin-bottom:20px; text-align:center;"><b><i>"숙박일 히스토리"</i></b></p>
	<?php
	  $ordAgeQ = "SELECT * FROM history AS h,
	  history_category AS hc,
	  history_user AS hu,
	  user AS u
	  WHERE h.historyUser_id = hu.historyUser_id AND u.user_id = hu.user_id AND hc.category_id = h.category;";
		$historyId3="";
	  $ordAgeR = mysqli_query($conn, $ordAgeQ);
	  while($ordAge = mysqli_fetch_array($ordAgeR)){
			if(strcmp("".$historyId3 , "".$ordAge['historyUser_id'])!=0){
				$historyId3=$ordAge['historyUser_id'];
				$same=0;
			}else{
				$same=1;
			}
			?>
		  <div class="historyAge" id="HA<?php echo $ordAge['history_id'];?>" style="padding:5px; margin:10px;">
			<div style="display:inline-block; width:100%">
			<?php
			if($ordAge['days'] <= 15){
				if($same==0)echo "<b>(단기 투숙) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
			}else{
				if($same==0)echo "<b>(장기 투숙) 목적: ", $ordAge['historyUser_title'], "(", $ordAge['name'], ")</b><span style='float:right;'>","[",$ordAge['nights'], "박", $ordAge['days'], "일]</span><br>";
				echo "<p>#",$ordAge['history_order'],"<br>Taken time: ", $ordAge['takentime'],"시간<br>Where: ", $ordAge['title'], "[", $ordAge['content'], "] </p>";
			}?>
		   </div>
		  </div>
			<hr style="border-top: 1px solid #a0a1a3;">
<?php }?>
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
var lineSymbol = {
	path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
};

$(document).ready(function(e){
	$(document).on("click", ".elementT", function(){
		var spots = $(this);
		var tid = spots.attr("id");
		var tourLat = parseFloat($("#"+tid).find("#lat"+tid).html());
		var tourLng = parseFloat($("#"+tid).find("#lng"+tid).html());
	   	var tourpoint = {lat:tourLat, lng:tourLng};
		// 클릭 했을 때 지도에 여행지 마커가 없으므로 아래 if문 실행, 마커 생성.
		if(!spots.data('nmarker') && !(spots.data('narrow'))){
			spots.data('nmarker', new google.maps.Marker({
				position: pointer = new google.maps.LatLng(tourLat, tourLng),
				icon: {
					url: 'img/camera.png',
					scaledSize: new google.maps.Size(50, 50),
				},
				//center: pointer,
			}));
			pathway.push(tourpoint);
			spots.data('narrow', new google.maps.Polyline({
			   path: pathway,
			   icons:[{
				   icon: lineSymbol,
				   offset: '100%'
			   }],
			   //map: map
		   }));
		}
		// 이를 통해 새로운 마커를 생성하고, 아래 조건문으로 토글 시킬 수 있게 함
		var newmarker=spots.data('nmarker');
		var line = spots.data('narrow');
 	   //simply check the markers map-property to decide
 	   //if the marker has to be added or removed

 	   	if(newmarker.getMap()){
			pathway.pop();
 		 	spots.removeClass('current');
 		 	newmarker.setMap(null);
			line.setMap(null);
			map.setCenter(map);
 	   	}
 	   	else{
 		 	spots.addClass('current');
 		 	newmarker.setMap(map);
			line.setMap(map);
			map.setCenter(pointer);
 	  	}

			var info = ($("#"+tid).find("#t_name"+tid).html());
			$("#elementL").find(".added1").html("[여행지]<button class='remove' style='float:right; color:black;'>x</button>");
			$("#elementL").find(".added2").text(info.concat(count));
			$("#elementL").find(".added3").text(tid.replace("T",""));
			$('#list').append($("#elementL").html());
			count=count+1;
	});
//heeju
	$(document).on('click', '.remove', function() {
		//#list ''
		$(this).parents('.added').remove();
		count=count-1;
		//$(this).remove();
	});
	$(document).on("click", ".elementH", function(){
		var lodges = $(this);
		var id_h = lodges.attr("id");
		var hotelLat = parseFloat($("#"+id_h).find("#lat"+id_h).html());
		var hotelLng = parseFloat($("#"+id_h).find("#lng"+id_h).html());
	   	var hotelpoint = {lat:hotelLat, lng:hotelLng};
		// 클릭 했을 때 지도에 호텔 마커가 없으므로 아래 if문 실행, 마커 생성.
		if(!lodges.data('nmarkerH') && !(lodges.data('narrowH'))){
			lodges.data('nmarkerH', new google.maps.Marker({
				position: pointerH = new google.maps.LatLng(hotelLat, hotelLng),
				icon: {
					url: 'img/hotels.png',
					scaledSize: new google.maps.Size(50, 50),
				},
				//center: pointerH,
			}));
			pathway.push(hotelpoint);
			lodges.data('narrowH', new google.maps.Polyline({
			   path: pathway,
			   icons:[{
				   icon: lineSymbol,
				   offset: '100%'
			   }],
			   //map: map
		   }));
		}
		// 이를 통해 새로운 마커를 생성하고, 아래 조건문으로 토글 시킬 수 있게 함
		var newmarkerH = lodges.data('nmarkerH');
		var lineH = lodges.data('narrowH');
 	   //simply check the markers map-property to decide
 	   //if the marker has to be added or removed
 	   	if(newmarkerH.getMap()){
			pathway.pop();
 		 	lodges.removeClass('current');
 		 	newmarkerH.setMap(null);
			lineH.setMap(null);
			map.setCenter(map);
 	   	}
 	   	else{
 		 	lodges.addClass('current');
 		 	newmarkerH.setMap(map);
			lineH.setMap(map);
			map.setCenter(pointerH);
 	  	}

			var info2 = ($("#"+id_h).find("#h_name"+id_h).html());
			$("#elementL").find(".added1").html("[호텔]<button class=\"remove\" style=\"float:right; color:black;\">x</button>");
			$("#elementL").find(".added2").text(info2);
			$("#elementL").find(".added3").text(id_h.replace("H",""));
			$('#list').append($("#elementL").html());
	});
	$(document).on("click", ".elementR", function(){
		var cuisines = $(this);
		var id_r = cuisines.attr("id");
		var resLat = parseFloat($("#"+id_r).find("#lat"+id_r).html());
		var resLng = parseFloat($("#"+id_r).find("#lng"+id_r).html());
	   	var respoint = {lat:resLat, lng:resLng};
		// 클릭 했을 때 지도에 호텔 마커가 없으므로 아래 if문 실행, 마커 생성.
		if(!cuisines.data('nmarkerR') && !(cuisines.data('narrowR'))){
			cuisines.data('nmarkerR', new google.maps.Marker({
				position: pointerR = new google.maps.LatLng(resLat, resLng),
				icon: {
					url: 'img/restaurants.png',
					scaledSize: new google.maps.Size(50, 50),
				},
				//center: pointerR,
			}));
			pathway.push(respoint);
			cuisines.data('narrowR', new google.maps.Polyline({
			   path: pathway,
			   icons:[{
				   icon: lineSymbol,
				   offset: '100%'
			   }],
			   //map: map
		   }));
		}

		// 이를 통해 새로운 마커를 생성하고, 아래 조건문으로 토글 시킬 수 있게 함
		var newmarkerR = cuisines.data('nmarkerR');
		var lineR = cuisines.data('narrowR');
 	   //simply check the markers map-property to decide
 	   //if the marker has to be added or removed
 	   	if(newmarkerR.getMap()){
			pathway.pop();
 		 	cuisines.removeClass('current');
 		 	newmarkerR.setMap(null);
			lineR.setMap(null);
			map.setCenter(map);
 	   	}
 	   	else{
 		 	cuisines.addClass('current');
			lineR.setMap(map);
 		 	newmarkerR.setMap(map);
			map.setCenter(pointerR);
 	  	}
			var info3 = ($("#"+id_r).find("#r_name"+id_r).html());
			$("#elementL").find(".added1").html("[레스토랑]<button class=\"remove\" style=\"float:right; color:black;\">x</button>");
			$("#elementL").find(".added2").text(info3);
			$("#elementL").find(".added3").text(id_r.replace("R",""));
			$('#list').append($("#elementL").html());
	});
});
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
		var count=-3;
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
