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

	/*로그인!!*/
  session_start();
  $_SESSION['user_id'] = $user_id;
  $_SESSION['user_name'] = $members[$user_id]['name'];
?>
<!DOCTYPE html>
<html>
<title>우리가 떠나야 할 EU</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="index.js"></script>
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
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
                <input type="button" class="form-control" id="search" value="Search">
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<h1>tourism</h1>
<div id = "Tourism"></div>
<h1>hotel</h1>
<div id = "Hotel"></div>
<h1>restaurant</h1>
<div id = "Restaurant"></div>
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

    $("#addFilter").click(function(){
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
