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
?>

<div id="optionhr" style="padding: 10px; position:fixed; background-color : #535454; right:30px; color:white;">
<input name="reviewType" type="radio" value="positive" onchange="changeoption2(1)" checked> positive Review<br>
<input name="reviewType" type="radio" onchange="changeoption2(2)" value="negative"> Negative Review<br>
</div>
<!--<hr style="border-top: 1px solid #a0a1a3;">-->
<?php
  $name = $_POST['name'];
  $max = $_POST['maxcost'];
  $min =$_POST['mincost'];
	$country = $_POST['country'];
  $city =$_POST['city'];
	$flag = 0;
	?>
	<script>console.log("<?php echo $name?>")</script>
	<?php
  // 재홍 latitude, lng select 쿼리에 추가.
  $hotelQ = "
	SELECT * FROM hotel join hotelCost_test on hotel.hotel_id=hotelCost_test.hotelcost_id
	join (select city.city_id, city_name as city, city.country_id, name as country from city join country on city.country_id = country.country_id)as Location
	on hotel.city = Location.city";
//echo $hotelQ."<br>";
  if($name || $max || $min || $country || $city){
		//echo "1";
    $hotelQ = $hotelQ.' WHERE ';
		$flag = 1;
  }
  if($name){
		//echo "2";
    $hotelQ = $hotelQ.'hotel.name like "%'.$name.'%" ';
		$flag = 0;
  }
  if($flag == 0 && $max){
		//echo "3";
    $hotelQ = $hotelQ.'and ';
		$flag = 1;
  }
  if($max){
		//echo "4";
    $hotelQ = $hotelQ.'ensuite <= '.$max.' ';
		$flag = 0;
  }
  if($flag == 0 && $min){
		//echo "5";
    $hotelQ = $hotelQ.'and ';
		$flag = 1;
  }
  if($min){
		//echo "6";
    $hotelQ = $hotelQ.'singlebed <= '.$min.' ';
		$flag = 0;
  }
	if($flag == 0 && $country){
		$hotelQ = $hotelQ.' and ';
		$flag = 1;
	}
	if($country){
		$hotelQ = $hotelQ.' country = "'.$country.'" ';
		$flag = 0;
	}
	if($flag == 0 && $city){
		$hotelQ = $hotelQ.' and ';
		$flag = 1;
	}
	if($city){
		$hotelQ = $hotelQ.' Location.city = "'.$city.'" ';
		$flag = 0;
	}
  $hotelQ = $hotelQ." LIMIT 5;";
	//echo $hotelQ;

  $hotelR = mysqli_query($conn, $hotelQ);

  while($hotel = mysqli_fetch_array($hotelR)){
 ?>
 <div class="elementH" id="H<?php echo $hotel['hotel_id'];?>" style="padding:5px; margin:10px; height:290px; overflow:scroll">
   <div style="display:inline-block; width:100%">
   <b><?php echo $hotel['name'];?></b>
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
