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
$name = $_POST['t_name'];
$name = "hello";
// 재홍 latitude, lng select 쿼리에 추가.
echo $name;
echo $
if(name){
$touristQ = 'SELECT
tourist_id, tourist.name AS tn, touristLN.name AS tnL, features, image, latitude, lng
FROM tourist JOIN touristLN using(tourist_id) where tourist.name like "%'.name.'%" limit 2;';
echo $touristQ;
echo "yes";
}else{
  $touristQ = "SELECT tourist_id, tourist.name AS tn, touristLN.name AS tnL, features, image, latitude, lng FROM tourist JOIN touristLN using(tourist_id) limit 2;";
	echo $touristQ;
	echo "no";
}>?
  <script>console.log("<?echo $touristQ;");?></script>
  <?php
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
