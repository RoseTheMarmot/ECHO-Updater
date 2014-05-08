<?php
	/*
	
	This creates and updates the current_stats.txt files for ECHO HvZT team at UW
	this file must be included for updater.php to work properly
	
	Author: Rose Beede
	
	*/

	if (!$_POST["agent"]) {
		header("Location: updater.php");
		die();
	}
	
	//set cookie to remember agent name when next updating on same device
	setcookie("agent", $_POST["agent"], time() + (24 * 60 * 60 * 365));
	
	//update current_stats text file
	$agent = $_POST["agent"];
	$fname = $agent . "/current_stats.txt";
	$filecontents = ""; //new stuff to put in file
	
	if (file_exists($fname)) {
		$current_stats = explode("\n", file_get_contents($fname));

		if(isset($_POST["alive_status"])) {
			$current_stats[0] = $_POST["alive_status"];
		}else {};
		
		if (  preg_match("/dead/", $_POST["alive_status"]) ) {
			if($_POST["death_date"]) {
				$current_stats[1] = $_POST["death_date"];
			}else {};
			if($_POST["death_time"]) {
				$current_stats[2] = $_POST["death_time"];
			}else{};
			if($_POST["am/pm"]) {
				$current_stats[3] = $_POST["am/pm"];
			}else{};
		}else {
			$current_stats[1] = "";
			$current_stats[2] = "";
			$current_stats[3] = "";
		};
		
		if( preg_match("/\d/", $_POST["stuns"]) ) {
			$current_stats[4] = $_POST["stuns"];
		}else {};
		
		if( preg_match("/\d/", $_POST["eaten"]) ) {
			$current_stats[5] = $_POST["eaten"];
		}else {};
		
		$filecontents = implode("\n", $current_stats);
	}else { 
		//creates new file
		$filecontents = "" . $_POST["alive_status"] . "\n" .
						"" . $_POST["death_date"] . "\n" .
						"" . $_POST["death_time"] . "\n" .
						"" . $_POST["am/pm"] . "\n" .
						"" . $_POST["stuns"] . "\n" .
						"" . $_POST["eaten"];
	}
	
	//print_r($_POST); //for debugging
	
		
	$stats_handle = fopen($fname, "w"); //re-assign current_stats
	fwrite($stats_handle, $filecontents);
	fclose($stats_handle);
	
	//redirect to current game page
	header("Location: currentGame.php");
?>