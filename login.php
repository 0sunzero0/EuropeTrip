<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel = "stylesheet" href="login.css">
    <title>LOGIN</title>
  </head>
  <body>
    <div id = "login_wrapper">
      <div id = "login">
        <h1>LOGIN PAGE</h1>
        <hr>
        <form id="form1" name="form1" action="login_ok.php" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">이메일 주소</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="이메일을 입력하세요">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">암호</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="암호">
          </div>

          <button type="submit" class="btn btn-default" id="submit">로그인</button>
          <button type="button" class="btn btn-default" id="register">회원가입 페이지로 가기</button>
        </form>
      </div>
    </div>
  </body>

</html>
<script>
$(document).ready(function() {
	$("#submit").click(function() {
		var action = $("#form1").attr('action');
		var form_data = {
			email: $("#exampleInputEmail1").val(),
			password: $("#exampleInputPassword1").val(),
			is_ajax: 1
		};
		$.ajax({
			type: "POST",
			url: action,
			data: form_data,
			success: function(response) {
				if(response == 'success') {
          alert("로그인에 성공했습니다.");
          $(location).attr('href', 'http://54.236.33.130/EuropeTrip/')
				}
				else {
          alert("로그인에 실패했습니다. 아이디나 비밀번호를 확인해주세요.");
				}
			}
		});
		return false;
	});
  $('#register').click(function(){
    $(location).attr('href', 'http://54.236.33.130/EuropeTrip/register.php');
  });
});
</script>
