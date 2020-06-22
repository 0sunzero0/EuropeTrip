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
?>

<?php
$name = $_POST['name'];
$country = $_POST['country'];
$city =$_POST['city'];
$flag = 0;
// 재홍 latitude, lng select 쿼리에 추가.
$touristQ = "
SELECT tourist_id, tourist.name AS tn, touristLN.name AS tnL, features, image, latitude, lng FROM tourist
JOIN touristLN using(tourist_id)
join (select city.city_id, city_name as city, city.country_id, name as country from city join country on city.country_id = country.country_id)as Location
on tourist.tourLocation_id = Location.city_id";

if($name || $country || $city){
	$touristQ = $touristQ.' WHERE ';
	$flag = 1;
}
if($name){
	$touristQ = $touristQ.'(tourist.name like "%'.$name.'%" or touristLN.name like "%'.$name.'%")';
	$flag = 0;
}
if($flag == 0 && $country){
	//echo "3";
	$touristQ = $touristQ.'and ';
	$flag = 1;
}
if($country){
	$touristQ = $touristQ.' Location.country like "'.$country.'" ';
	$flag = 0;
}
if($flag == 0 && $city){
	$touristQ = $touristQ.' and ';
	$flag = 1;
}
if($city){
	$touristQ = $touristQ.' Location.city = "'.$city.'" ';
	$flag = 0;
}
  $touristR = mysqli_query($conn, $touristQ);

  while($tourist = mysqli_fetch_array($touristR)){
 ?>
 <div class="elementT" id="T<?php echo $tourist['tourist_id'];?>" style="padding:5px; margin:5px; height:120px; overflow:scroll">
   <div style="display:inline-block; width:calc(100% - 100px);">
   <b id="t_name<?php echo $tourist['tourist_id'];?>"><?php echo $tourist['tnL'];?></b><br>
   <p id="latT<?php echo $tourist['tourist_id'];?>" style="display:none"><?php echo $tourist['latitude'];?></p>
   <p id="lngT<?php echo $tourist['tourist_id'];?>" style="display:none"><?php echo $tourist['lng'];?></p>
   <script>
   t_name<?php echo $tourist['tourist_id'];?>.onmouseover = function(){
      document.getElementById('t_name<?php echo $tourist['tourist_id'];?>').innerHTML = "<?php echo $tourist['tn'];?>";
   };
   t_name<?php echo $tourist['tourist_id'];?>.onmouseleave = function(){
      document.getElementById('t_name<?php echo $tourist['tourist_id'];?>').innerHTML = "<?php echo $tourist['tnL'];?>";
   };
   // 그리고 여기서 click을 했을 때 해당 row가 가지고 있을 lat, lng에 대한 마커를 생성함
   // 근데 이걸 function coordinate으로 옮겨야 할지는 두고봐야함.


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
