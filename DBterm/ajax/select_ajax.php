<?php 
	include("database.php");

	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{
		$dept_name = $_POST["dept_name"];

		$query = "select course_id, course_name from course where dept_name = '$dept_name'";
		$result = pg_query($conn, $query) or die(pg_last_error());
		while($data = pg_fetch_assoc($result)){
			echo "<option value='".$data['course_id']."'>".$data['course_name']."(".$data['course_id'].")"."</option>";
		}
	}
 ?>