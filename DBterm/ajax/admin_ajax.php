<?php 
	include("database.php");

	$conn = initDb();

	if(!($conn)){
		echo "Cannot connect to DB";
	}
	else{
		$mode = $_POST["mode"];
		/*db에 dept_name 추가*/
		if($mode === "dept"){
			$dept_name = $_POST["dept_name"];
			$query = "INSERT INTO department (dept_name)";
			$query = $query. " VALUES('$dept_name')";
			$result = pg_query($conn, $query) or die("Could not innsert: ".pg_last_error());

			if($result){
				echo "success";
			}
		}

		else if($mode === "inst"){
			$dept_name = $_POST["dept_name"];
			$instructor_name = $_POST["instructor_name"];

			$query = "INSERT INTO instructor (dept_name, instructor_name)";
			$query = $query. " VALUES('$dept_name', '$instructor_name')";
			$result = pg_query($conn, $query) or die("Could not innsert: ".pg_last_error());

			if($result){
				echo "success";
			}
		}

		else if($mode === "course"){
			$course_id = $_POST["course_id"];
			$course_name = $_POST["course_name"];
			$dept_name = $_POST["dept_name"];
			$credit = $_POST["credit"];

			$query = "INSERT INTO course (course_id, course_name, dept_name, credit)";
			$query = $query. " VALUES('$course_id', '$course_name', '$dept_name', '$credit')";
			$result = pg_query($conn, $query) or die("Could not innsert: ".pg_last_error());

			if($result){
				echo "success";
			}
		}

		else if($mode === "section"){
			$course_id = $_POST["course_id"];
			$sec_id = $_POST["section_id"];
			$instructor_id = $_POST["instructor_id"];
			$year = $_POST["year"];
			$semester = $_POST["semester"];

			$query = "INSERT INTO section (sec_id, course_id, year, semester)";
			$query = $query. " VALUES('$sec_id', '$course_id', $year, $semester)";
			$result = pg_query($conn, $query) or die("Could not innsert: ".pg_last_error());

			$query2 = "INSERT INTO teach (instructor_id, sec_id, course_id, year, semester)";
			$query2 = $query2. " VALUES($instructor_id, '$sec_id', '$course_id', $year, $semester)";
			$result2 = pg_query($conn, $query2) or die("Could not innsert: ".pg_last_error());

			if($result&&$result2){
				echo "success";
			}
		}
	}
 ?>