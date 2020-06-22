$(document).ready(function(){
  //var count = 0;
  var t_name = "";
  var h_name = "";
  var h_maxcost = "";
  var h_mincost = "";
  var r_name = "";
  var r_maxcost = "";
  var r_mincost = "";
  $("#addFilter").click(function(){
    var select = $("#selectFilter option:selected").val();
    console.log("값: "+select);
    var content = $("#Fcontent").val();

    if(content && $.isNumeric(content)){
      if(select == "식당최대비용"){
        console.log(select);
        document.getElementById("FresMax").value = "식당비용 (~"+content+")";
        r_maxcost = content;
        $("#FresMax").show();
        //var childNode = '<input type="button" class = "filter maxcost" id="restaurant" name = "'+content+'" value="식당비용 (~'+content+')">';
      }else if(select == "식당최소비용"){
        console.log(select);
        document.getElementById("FresMin").value = "식당비용 ("+content+"~)";
        r_mincost = content;
        $("#FresMin").show();
        //var childNode = '<input type="button" class = "filter mincost" id="restaurant" name = "'+content+'" value="식당비용 ('+content+'~)">';
      }else if(select == "호텔최대비용"){
        console.log(select);
        document.getElementById("FhotelMax").value = "호텔비용 (~"+content+")";
        h_maxcost = content;
        $("#FhotelMax").show();
        //var childNode = '<input type="button" class = "filter maxcost" id="hotel" name = "'+content+'" value="호텔비용 (~'+content+')">';
      }else if(select == "호텔최소비용"){
        console.log(select);
        document.getElementById("FhotelMin").value = "호텔비용 ("+content+"~)";
        h_mincost = content;
        $("#FhotelMin").show();
        //var childNode = '<input type="button" class = "filter mincost" id="hotel" name = "'+content+'" value="호텔비용 ('+content+'~)">';
      }
      //count++;
      //$("#filterValue").append(childNode);
    }else if(content){
      if(select == "관광지"){
        //count++;
        console.log(select);
        document.getElementById("Ftourist").value = "관광지 ("+content+" 포함)";
        t_name = content;
        $("#Ftourist").show();
        //var childNode = '<input type="button" class = "filter" id="tourist" name = "'+content+'" value="관광지 ('+content+' 포함)">';
      }else if(select == "식당"){
        //count++;
        console.log(select);
        document.getElementById("Frestaurant").value = "식당 ("+content+" 포함)";
        r_name = content;
        $("#Frestaurant").show();
        //var childNode = '<input type="button" class = "filter" id="restaurant" name = "'+content+'" value="식당 ('+content+' 포함)">';
      }else if(select == "호텔"){
        //count++;
        console.log(select);
        document.getElementById("Fhotel").value = "호텔 ("+content+" 포함)";
        h_name = content;
        $("#Fhotel").show();
        //var childNode = '<input type="button" class = "filter" id="hotel" name = "'+content+'" value="호텔 ('+content+' 포함)">';
      }else{
        alert("비용은 숫자로 적어야 추가가 가능합니다!!ㅎㅎ");
      }
      //$("#filterValue").append(childNode);
    }else{
      alert("값을 적어야 필터 추가가 가능합니다!!");
    }
    document.getElementById("Fcontent").value = "";
    //console.log($("#FilterCount").val());
    //document.getElementById("FilterCount").value = count;
  });

  $("#search").click(function(){
    var country = document.getElementById("country").value;
    var city = document.getElementById("city").value;
    var Data1 = {name: t_name, country: country, city: city}; //tourist
    var Data2 = {name: h_name, maxcost: h_maxcost, mincost: h_mincost, country: country, city: city}; //hotel
    var Data3 = {name: r_name, maxcost: r_maxcost, mincost: r_mincost, country: country, city: city}; //rest
    console.log(Data1);
    console.log(Data2);
    console.log(Data3);
    $.ajax({
      url:"T_search.php",
      method:"POST",
      data:Data1,
      success:function(data){
        console.log("success");
        $('#Tourism').html(data);
      }
    });
    $.ajax({
      url:"H_search.php",
      method:"POST",
      data:Data2,
      success:function(data){
        console.log("success");
        $('#Hotel').html(data);
      }
    });
    $.ajax({
      url:"R_search.php",
      method:"POST",
      data:Data3,
      success:function(data){
        console.log("success");
        $('#Restaurant').html(data);
      }
    });
  });
});

$(document).on("click", ".filter", function(){
    console.log("hehe");
    $(this).hide();
    id = $(this).attr("id");
    /*
    if(select == "식당최대비용"){
      }else if(select == "식당최소비용"){
      }else if(select == "호텔최대비용"){
      }else if(select == "호텔최소비용"){
      }else if(select == "관광지"){
      }else if(select == "식당"){
      }else if(select == "호텔"){
      }*/
    document.getElementById(id).value = "";
  });
