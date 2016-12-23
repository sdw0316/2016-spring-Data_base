<?php 
	session_start();

	include("database.php");
	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{		
		$id = $_POST["id"];
		$pwd = $_POST["pwd"];
		$query = "SELECT * FROM account WHERE account_id = '$id' and password = '$pwd'";
		$result = pg_query($conn, $query);
		$row = pg_num_rows($result);

		/*한놈 가져오면 login 가능함*/
		if($row === 1){
			$data = pg_fetch_assoc($result);
			$_SESSION["id"] = $id;
			$_SESSION["pwd"] = $pwd;
			$_SESSION["nick"] = $data["user_name"];
			echo "success";
		}
	}
 ?>