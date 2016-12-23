<?php 
	function initDB(){
		$host = "localhost";
		$dbname = "postgres";
		$user = "dowon";
		$pwd = "dowon";
		$dbconn = pg_connect("host=".$host." dbname=".$dbname." user=".$user." password=".$pwd) 
			or die("Could not connect: ".pg_last_error());
		return $dbconn;
	}

?>