<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>회원 가입</title>
	<link rel="stylesheet" href="./css/common.css">
	<script src="./js/jquery-1.12.4.min.js"></script>
	<style>
	</style>
</head>
<body>
	<div id="content">
		<div class="login_wrap">
			<form action="./account.php">
				<div class="logo">
					<h1>회원가입, 하자고 어서!</h1>
				</div>
				<div class="lnput_wrap">
					<input type="text" id="id" name="id" placeholder="아이디"><br>
					<input type="password" id="pwd" name="pwd" placeholder="패스워드"><br>
					<input type="text" id="nick" name="nick" placeholder="별명">
				</div>
				<div class="btn_wrap">
					<button id="submit" type="button">회원가입</button><br>
				</div>
			</form>
		</div>
	</div>
	<script>
		var id;
		var pwd;
		var nick;
		var btn = $("#submit");

		/*input checker*/
		function submitCheck(){
			if(id.val() === "" || pwd.val() === "" || nick.val() === "")
				return false;
			else
				return true;
		}

		/*register account by using AJAX*/
		function doSubmit(){
			id = $("#id");
			pwd = $("#pwd");
			nick = $("#nick");

			if(!submitCheck()){
				alert("입력 양식이 맞지 않습니다!");
			}
			else{
				var form = {
					id : id.val(),
					pwd : pwd.val(),
					nick : nick.val()
				}
				/*AJAX requeset*/
				$.ajax({
            		type : 'POST',
					url : './ajax/account_ajax.php',
					datatype : 'json',
            		data: form,
            		/*response*/
            		success:function(data){
            			if(data === "success"){
            				alert("회원 가입 성공!");
            				location.href = "./index.php"
            			}
            			else{
            				alert(data);
            			}
            		}
				});
			}
		}
		
		btn.on("click",doSubmit);
	</script>
</body>
</html>