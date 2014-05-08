<?php
/*
This generates a layout of the current game stats for ECHO HvZT team at UW. 
It takes information from a current_stats.txt file in each agent folder and displays that info.

Author: Rose Beede

*/

include "agents_list.php";
//to update the number of agents shown, update agents list
//however, you will still need to create a new directory for the agent


//------------------------site admin changes this-----------------------
$game = "Fall 2013"
//----------------------------------------------------------------------

?>

<!DOCTYPE html><html>
	<head>
		<meta charset="UTF-8">
		
		<title>ECHO TEAM - HvZT Game <?=$game?></title>
		<link id="style" type="text/css" href="echo.css" rel="StyleSheet">
		<link type="text/css" href="updater.css" rel="StyleSheet">
	</head>

	<body>
		<div class="container">
			<h1>Currents Stats</h1>
			<h2>HvZT UW <?=$game?></h2>
			
			<a id="updatebutton" href="updater.php"><button>Update Stats</button></a>
			
			<table>
				<tr id="tableHead">
					<td>Agent</td>
					<td>Status</td> <!--death and date of death-->
					<td>Death Time</td>
					<td>Stuns</td>
					<td>Eaten</td>
				</tr>
				
				<?php //fills in table
					foreach($agents as $shortname => $longname) {
						$fname = $shortname . "/current_stats.txt";
						$status = "alive";
						$deathTime = "";
						$stuns = 0;
						$eaten = 0;
						if (file_exists($fname)) { 
							$current_stats = file_get_contents($fname);
							$stats = explode("\n", $current_stats);
							//print_r($stats); //for development
							if ($stats[0]) {
								$status = $stats[0]; 
								if ($stats[1]) {
									$deathTime = $stats[1];
								}
								if ($stats[2]) { //stats3 double checked in updater.js
									$deathTime = $deathTime . ", " . $stats[2] . " " . $stats[3];
								}
							}
							if ($stats[4]) {
								$stuns = $stats[4];
							}
							if ($stats[5]) {
								$eaten = $stats[5];
							}
						}
						?>
						<tr id=<?=$shortname?>>
							<td><?=$longname?></td>
							<td><?=$status?></td> <!--death and date of death, maybe little boxes of each day-->
							<td><?=$deathTime?></td>
							<td><?=$stuns?></td>
							<td><?=$eaten?></td>
						</tr>
						<?php
					}
				?>
				<!--all current stats, get from current game .txt file-->
			</table>
		</div>
	</body>
	
</html>