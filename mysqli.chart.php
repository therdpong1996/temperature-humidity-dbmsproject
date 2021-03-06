<?php
		
	header('Access-Control-Allow-Origin: *');

	$_DB['host'] = 'localhost';
	$_DB['username'] = ''; //username connect database
	$_DB['password'] = ''; //password connect database
	$_DB['database'] = ''; //tablename database

	$conn = mysqli_connect($_DB['host'], $_DB['username'], $_DB['password'], $_DB['database']);
	mysqli_set_charset($conn,"utf8");
	
	$result['temp'] = array();
	$result['time'] = array();
	$result['humi'] = array();


	$data = mysqli_query($conn, "SELECT time FROM ( SELECT * FROM log_datas ORDER BY time DESC LIMIT 10 ) sub ORDER BY id ASC");
	while ($d = mysqli_fetch_assoc($data)) {
		$result['lasttime'] = $d['time'];
		array_push($result['time'], date('H:i:s d/m/Y', $d['time']));
	}

	if ($_POST['temp'] == "true" and $_POST['humi'] == "false") {
	
		$data = mysqli_query($conn, "SELECT temp FROM ( SELECT * FROM log_datas ORDER BY time DESC LIMIT 10 ) sub ORDER BY id ASC");
		while ($d = mysqli_fetch_assoc($data)) {
			array_push($result['temp'], $d['temp']);
		}

	}elseif($_POST['temp'] == "false" and $_POST['humi'] == "true"){

		$data = mysqli_query($conn, "SELECT humi FROM ( SELECT * FROM log_datas ORDER BY time DESC LIMIT 10 ) sub ORDER BY id ASC");
		while ($d = mysqli_fetch_assoc($data)) {
			array_push($result['humi'], $d['humi']);
		}

	}

	echo json_encode($result);