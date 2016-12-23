<?php 
	/*만약 로그인 상태라면 main으로*/
	session_start();
	if(isset($_SESSION["id"])){
		header('Location: ./main.php');
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>로그인 페이지</title>
	<link rel="stylesheet" href="./css/common.css">
	<style>
	</style>
</head>
<body>
	<div id="content">
		<div class="login_wrap">
			<form action="./login.php" method="POST">
				<div class="logo">
					<h1>수강평가, 가자고 어서!</h1>
				</div>
				<div class="lnput_wrap">
					<input type="text" id="id" name="id" placeholder="아이디"><br>
					<input type="password" id="pwd" name="pwd" placeholder="패스워드">
				</div>
				<div class="btn_wrap">
					<button id="submit" type="button">로그인</button><br>
					<button type="button" onclick="location.href = './register.php'">회원가입</button>
				</div>
			</form>
		</div>
	</div>
	<script src="./js/jquery-1.12.4.min.js"></script>
	<script>
		var id;
		var pwd;
		var btn = $("#submit");

		/*input checker*/
		function submitCheck(){
			if(id.val() === "" || pwd.val() === "")
				return false;
			else
				return true;
		}

		/*register account by using AJAX*/
		function doSubmit(){
			id = $("#id");
			pwd = $("#pwd");

			if(!submitCheck()){
				alert("입력 양식이 맞지 않습니다!");
			}
			else{
				var form = {
					id : id.val(),
					pwd : pwd.val(),
				}
				/*AJAX requeset*/
				$.ajax({
            		type : 'POST',
					url : './ajax/login_ajax.php',
					datatype : 'json',
            		data: form,
            		/*response*/
            		success:function(data){
            			if(data ==="success"){
            				location.href = "./main.php"
            			}
            			else{
            				alert("login 실패, 아이디와 패스워드를 다시 입력하세요");
            			}
            		}
				});
			}
		}
		
		btn.on("click",doSubmit);
		$(document).on("keydown",function(event){
			if(event.keyCode === 13){
				doSubmit();
			}
		});
	</script>
</body>
</html>