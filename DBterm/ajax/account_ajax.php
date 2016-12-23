<?php 
	include("database.php");

	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{		
		$id = $_POST["id"];
		$pwd = $_POST["pwd"];
		$nick = $_POST["nick"];

		/*세 값이 입력 되었을시만 query 실행*/
		if(isset($id)&&isset($pwd)&&isset($nick)){
			$query = "INSERT INTO account (account_id, password, user_name)";
			$query = $query. " VALUES('$id','$pwd','$nick')";
			$result = pg_query($conn, $query) or die("Could not innsert: ".pg_last_error());;
			/*처리 성공시 success return*/
			if($result){
				echo "success";
			}
		}
	}
 ?>