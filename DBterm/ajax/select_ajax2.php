<?php 
	include("database.php");

	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{
		$dept_name = $_POST["dept_name"];

		$query = "select instructor_id, instructor_name from instructor where dept_name = '$dept_name'";
		$result = pg_query($conn, $query) or die(pg_last_error());
		while($data = pg_fetch_assoc($result)){
			echo "<option value='".$data['instructor_id']."'>".$data['instructor_name']."(".$data['instructor_id'].")"."</option>";
		}
	}
 ?>