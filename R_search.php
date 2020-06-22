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
<?php
    $name = $_POST['name'];
    $max = $_POST['maxcost'];
    $min =$_POST['mincost'];
		$country = $_POST['country'];
	  $city =$_POST['city'];
		$flag = 0;
    $resQ = "
		SELECT * FROM restaurant
			left outer join restaurantCost on restaurant.res_id1=restaurantCost.res_id
			join (select city.city_id, city_name as city, city.country_id, name as country from city join country on city.country_id = country.country_id)as Location
			on Location.city_id = resLocation_id
		";
    //echo $resQ;
    if($name || $max || $min || $country || $city){
      $resQ = $resQ.' WHERE ';
			$flag = 1;
    }
    if($name){
      $resQ = $resQ.'name like "%'.$name.'%" ';
			$flag = 0;
    }
    if($flag == 0 && $max){
      $resQ = $resQ.'and ';
			$flag = 1;
    }
    if($max){
      $resQ = $resQ.'fourPeople <= '.$max;
			$flag = 0;
    }
    if($flag == 0 && $min){
      $resQ = $resQ.' and ';
			$flag = 1;
    }
    if($min){
      $resQ = $resQ.' twoPeople >= '.$min;
			$flag = 0;
    }
		if($flag == 0 && $country){
			$resQ = $resQ.' and ';
			$flag = 1;
		}
		if($country){
      $resQ = $resQ.' country = "'.$country.'" ';
			$flag = 0;
    }
		if($flag == 0 && $city){
			$resQ = $resQ.' and ';
			$flag = 1;
		}
		if($city){
      $resQ = $resQ.' city = "'.$city.'" ';
			$flag = 0;
    }
    $resQ = $resQ." LIMIT 5;";
    //echo "<br>".$resQ;

    $resR = mysqli_query($conn, $resQ);

    while($res = mysqli_fetch_array($resR)){
   ?>

   <div class="elementR" id="R<?php echo $res['res_id1'];?>" style="padding:5px; margin:10px;height:290px; overflow:scroll">
     <div style="display:inline-block; width:100%">
     <b><?php echo $res['name'];?></b>
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
