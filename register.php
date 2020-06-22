<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel = "stylesheet" href="login.css">
    <title>REGISTER</title>
  </head>
  <body>
    <div id = "login_wrapper">
      <div id = "login">
        <h1>REGISTER PAGE</h1>
        <hr>
        <form id="form1" name="form1" action="register_ok.php" method="post">
          <div class="form-group">
            <label for="InputEmail">이메일 주소</label>
            <input type="email" class="form-control" id="InputEmail" name="email" placeholder="이메일을 입력하세요">
          </div>
          <div class="form-group">
            <label for="InputPassword">암호</label>
            <input type="password" class="form-control" name="password" id="InputPassword" placeholder="암호">
          </div>
          <div class="form-group">
            <label for="InputName">이름</label>
            <input type="text" class="form-control" name="name" id="InputName" placeholder="이름을 입력하세요">
          </div>
          <div class="form-group">
            <label for="InputAge">나이</label>
            <input type="number" class="form-control" name="age" id="InputAge" placeholder="나이를 입력하세요">
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="gender" id="W" value="W">
              여자
            </label>
            <label>
              <input type="radio" name="gender" id="M" value="M">
              남자
            </label>
          </div>

          <button type="submit" class="btn btn-default" id="submit">회원가입</button>
          <button type="button" class="btn btn-default" id="goLogin">로그인페이지로 가기</button>
        </form>
      </div>
    </div>
  </body>

</html>
<script>
$(document).ready(function(){

  $("#submit").click(function() {
    var action = $("#form1").attr('action');
    var form_data = {
      email: $("#InputEmail").val(),
      password: $("#InputPassword").val(),
      name:  $("#InputName").val(),
      age:  $("#InputAge").val(),
      gender: $('input[name="gender"]:checked').val(),
      is_ajax: 1,
    };
    console.log(form_data);
    $.ajax({
      type: "POST",
      url: action,
      data: form_data,
      success: function(response) {
        console.log(response);
        if(response == 'success') {
          alert("회원가입에 성공했습니다.");
          $(location).attr('href', 'http://54.236.33.130/EuropeTrip/login.php')
        }
        else {
          alert("회원가입에 실패했습니다. 중복된 아이디입니다.");
        }
      }
    });
    return false;
  });

  $('#goLogin').click(function(){
    $(location).attr('href', 'http://54.236.33.130/EuropeTrip/login.php');
  });
});
</script>
