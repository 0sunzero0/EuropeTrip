DB index.php
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
	//print_r($row["VERSION()"]);

	//TO DO for heeju
	/* city country 별로 다르게
	* airtport?
	* 검색 구현 -> LIMIT 삭제
	* 옵션 선택 추가
	* 레스토랑 데이터 전부 다 들어가게 하기
	* 디자인 넣기..
	*/
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
<title>DB Project</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" id="stylesheet" href="index.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
				dstLat = arrcity[i]['lat'];
				dstLng = arrcity[i]['lng'];
			}
		}
		console.log(dstLat+"     "+dstLng);
		var destination = {lat: dstLat, lng: dstLng};

		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(dstLat, dstLng),
			center: destination,

			map: map2 = new google.maps.Map(document.getElementById("googlemap"),marker),
		});
	}
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
</head>
<body>

<div class="header">
  <h2>유럽 여행</h2>
</div>

<div class="search">
  <div class="option">
    Option choose <button id="op_toggle">+</button>
    <div id="optionList">
			<div class="optionDiv">
				Q. 어떤 방법으로 검색하시겠습니까?<br>
				<input name="method" type="radio" value="city" onchange="changeoption1(1)" checked>도시 이름으로<br>
				<input name="method" type="radio" onchange="changeoption1(2)" value="airpot">공항 이름으로<br>
			</div>
			<div class="optionDiv">
				Q. 어떤 결과를 보기 원하십니까?<br>
				<input type="checkbox" id="tourism" checked>여행지
				<input type="checkbox" id="hotel" checked>호텔
				<input type="checkbox" id="restaurant" checked>레스토랑
				<br>
			</div>
    </div>
  </div><br>
  searching space

	<!--나라 + 도시로 찾기-->
  <form class ="search" id="option1">
		<span class="input_res">
	    <input id="country" class="info" list="countries" placeholder ="country" onchange="country11=this.value;callCity(country11);">
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
	    <input id="city" class="info" list="cities" placeholder ="city" onchange="city11=this.value;">
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
</script>

<div class="row">
  <div class="result" id="tourism" style="background-color:#aaa;"><b>Tourism</b>

    <?php
      $touristQ = "SELECT * FROM tourist;";
      $touristR = mysqli_query($conn, $touristQ);
      while($tourist = mysqli_fetch_array($touristR)){
     ?>
     <div class="elementT" style="border: solid 1px black; padding:5px; margin:5px; background:white; height:120px; overflow:scroll">
       <div style="display:inline-block; width:calc(100% - 100px);">
       <b><?php echo $tourist['name'];?></b>
       <div style="height:5px"></div>
       <?php echo $tourist['features'];?>
       </div>
       <div style="display:inline-block; float:right;">
       <img src="<?php echo $tourist['image'];?>" width=100px; height=100px; alt="Image" style="margin-top:3px;">
     </div>
     </div>
  <?php } ?>

  </div>
  <div class="result" id="hotel" style="background-color:#bbb;"><b>Hotel</b><br>
		<div>
		<input name="reviewType" type="radio" value="positive" onchange="changeoption2(1)" checked>positive Review<br>
		<input name="reviewType" type="radio" onchange="changeoption2(2)" value="negative">Negative Review<br>
	</div>
		<?php
      $hotelQ = "SELECT * FROM hotel join hotelCost_test on hotel.hotel_id=hotelCost_test.hotelcost_id LIMIT 5;";
      $hotelR = mysqli_query($conn, $hotelQ);
      while($hotel = mysqli_fetch_array($hotelR)){
     ?>
     <div class="elementH" style="border: solid 1px black; padding:5px; margin:5px; background:white; height:270px; overflow:scroll">
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
					 on hotelNegReview_test.hotel_name=hotel.name
					 where hotel_name='$hotelname' LIMIT 1";
					 $hotelreviewPR = mysqli_query($conn, $hotelreviewPQ);
					 while($hotelreviewP = mysqli_fetch_array($hotelreviewPR)){
					?>
					<p><?php echo $hotelreviewP['review_date'];?><br>
						<?php echo $hotelreviewP['review'];?>
					</p>
					<hr>
				<?php } ?>
			 </div>
			  <!--negative-->
			 <div class="negativeR" style="background:#debdb8; overflow:scroll; height:150px; width:100%; margin-top:15px; padding:5px; font-size:0.8em; display:none;">
				 <?php
				 $hotelname=$hotel['name'];
					$hotelreviewNQ = "SELECT * FROM hotelNegReview_test join hotel
					on hotelNegReview_test.hotel_name=hotel.name
					where hotel_name='$hotelname' LIMIT 5";
					$hotelreviewNR = mysqli_query($conn, $hotelreviewNQ);
					while($hotelreviewN = mysqli_fetch_array($hotelreviewNR)){
				 ?>
				 <p><?php echo $hotelreviewN['review_date'];?><br>
					 <?php echo $hotelreviewN['review'];?>
				 </p>
				 <hr>
			 <?php } ?>
			 </div>
       </div>
     </div>
  <?php } ?>
	</div>

  <div class="result" id="restaurant" style="background-color:#ccc;"><b>Restaurant</b>
		<?php
			$resQ = "SELECT * FROM restaurant left outer join restaurantCost on restaurant.res_id1=restaurantCost.res_id where restaurant.res_id1=308 LIMIT 5;";
			$resR = mysqli_query($conn, $resQ);
			while($res = mysqli_fetch_array($resR)){
		 ?>
		 <div class="elementH" style="border: solid 1px black; padding:5px; margin:5px; background:white; height:270px; overflow:scroll">
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
				 <hr>
			 <?php } ?>
			 </div>
			 </div>
		 </div>
		<?php } ?>



	</div>
</div>

<div class="footer">
  <p>21400749 천재홍 21500209 김혜영
    <br>21800412 신희주 21800669 정예은</p>
</div>

</body>
</html>

<script>
	var miminum_size=800;
  $(document).ready(function(){
    $("#op_toggle").click(function(){
      $("#optionList").slideToggle("slow");
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
