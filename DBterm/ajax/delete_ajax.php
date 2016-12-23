<?php 
	include("database.php");

	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{
		$index = $_POST["index"];
		$query = "delete from evaluation where index = $index";
		$result = pg_query($conn, $query) or die(pg_last_error());
		if($result){
			echo "success";
		}
	}
 ?>