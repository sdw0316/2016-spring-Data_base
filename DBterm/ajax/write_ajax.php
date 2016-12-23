<?php 
	include("database.php");

	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{
		if($_POST["mode"]==="insert"){
			$course_id = $_POST["course_id"];
			$sec_id = $_POST["sec_id"];
			$instructor_id = $_POST["instructor_id"];
			$semester = $_POST["semester"];
			$year = $_POST["year"];
			$account = $_POST["account"];
			$rate = $_POST["rate"];
			$comment = $_POST["comment"];

			$query = "INSERT INTO evaluation (course_id, sec_id, instructor_id, semester, year, account_id, rate, comment)";
			$query = $query. " VALUES('$course_id', '$sec_id', $instructor_id, $semester, $year, '$account', $rate, '$comment')";
		}
		else{
			$index = $_POST["index"];
			$rate = $_POST["rate"];
			$comment = $_POST["comment"];

			$query = "update evaluation set rate=$rate, comment='$comment' where index = $index";
		}

		$result = pg_query($conn, $query) or die("Could not innsert: ".pg_last_error());;
		/*처리 성공시 success return*/
		if($result){
			echo "success";
		}
	}
 ?>