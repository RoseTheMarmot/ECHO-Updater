<?php 
/*
This generates the status update form for the ECHO HvZT at the UW team.

Author: Rose Beede

*/

include "agents_list.php"; 
//update agents_list.php to update what agents are in this app
//however, you will still need to create a new directory for the new agent

//-- gets cookie for last agent to update, if there is a cookie --
if (isset($_COOKIE["agent"])) {
	$agentset = $_COOKIE["agent"];	//get saved agent
	$fhandle = $agentset . "/current_stats.txt";
	$agent_data = file($fhandle); //get past data for saved agent
	/* example: 
	0 => dead
	1 => Thursday
	2 => 12:30
	3 => pm
	4 => 1 //stunns
	5 => 3 //eaten
	*/
}else {
	$agentset = ""; //so code later doesn't break when it looks for $agentset
	$agent_data = "";
}

?>

<!DOCTYPE html><html>
	<head>
		<meta charset="UTF-8">
		
		<title>ECHO TEAM - updater page</title>
		<link id="style" type="text/css" href="echo.css" rel="StyleSheet">
		<link type="text/css" href="updater.css" rel="StyleSheet">
		<script language="javascript" type="text/javascript" src="updater.js"></script>
	</head>
	
	<body>
		<div class="container">
		
		<h1>Official ECHO Report</h1>
		
		<form action="updater_processStuff.php" method="POST">
			
			
			<!-- ************************* Agent Menu ************************ -->
			
			<div id="select_agent">
				<strong>Agent:</strong>
				<select name="agent"> 
					<option></option>

					<?php  // --- fills in agent menu ---
					foreach ($agents as $agent => $agent_full) {
						?><option value="<?=$agent?>"<?php 
						if ( strcmp($agentset, $agent) == 0 ) { //makes agent selected based on cookie
							?> selected="selected"<?php
						}
						?>><?=$agent_full?></option><?php //for some reason this part remebers that last selection, even when cookie is deleted
					}
					?>
				</select>
			</div>
			
			
			<!-- ************************* Alive or Dead ************************ -->
			
			<fieldset id="alive_satus">
				<legend>Alive Status:</legend>
				
				<?php //check to see if dead in files
				$isdead = preg_match("/dead/", $agent_data[0]) ?>
				
				<label><input type="radio" name="alive_status" value="alive" id="alive" 
				<?php if ($isdead == false) {?> checked 
				<?php }else {};?>
				>Alive</label>
				
				<label><input type="radio" name="alive_status" value="dead" id="dead"
				<?php if ($isdead) {?> checked 
				<?php }else {};?>
				>Died</label>
				
				
				<!-- ************************* Time of Death ************************ -->
				
				<div id="time_of_death" style="display: none;"> <!--read from file and get status, if exists-->
					on 
					<select name="death_date" id="deathdate">
						<option value=""></option>	
					<?php 
						$days = array(
							"Monday",
							"Tuesday",
							"Wednesday",
							"Thursday",
							"Friday"
						);
						foreach($days as $day) { //fills in days menu
							?><option <?php
							if ( $agent_data[1] && preg_match("/".$day."/", $agent_data[1])) { //check to see day of death in files
								?>selected<?php
							}else {};?> 
							value=<?=$day?>><?=$day?></option><?php
						}?>	
					</select>
					
					at
					<?php
						$date_placeholder;
						if ( $agent_data[2] ) {
							$date_placeholder = $agent_data[2];
						}
						else {
							$date_placeholder = "example:12:30";
						}
					?>
					<input name="death_time" id="death_time" type="text" placeholder=<?=$date_placeholder?>>
					
					<?php
						$isam;
						if ( $agent_data[3] ) {
							$isam = preg_match("/am/", $agent_data[3]);
						}else {};
					?>
					
					<select name="am/pm" id="am/pm">
						<option value=""></option>
						
						<option value="am"
						<?php if ($isam) {?> selected="selected"
						<?php }else {};?>
						>am</option>
						
						<option value="pm"
						<?php if ($isam == false) {?> selected="selected"
						<?php }else {};?>
						>pm</option>
					</select>
					
				</div>
			</fieldset>
			
			
			<!-- ************************* Stuns ************************ -->
			
			<?php //check to see zombies stunned in files
				$stun_placeholder;
				if ( preg_match("/\d/", $agent_data[4]) ) {
					$stun_placeholder = $agent_data[4];
				}
				else {
					$stun_placeholder = "total stuns";
			}?>
				
			<fieldset id="before_death">
				<legend>Zombies Stunned:</legend>
				<input name="stuns" id="stuns" type="text" value="" placeholder=<?=$stun_placeholder?>>
				<button type="button" id="add_stun">+1</button>
			</fieldset>
			
			
			<!-- ************************* Eaten ************************ -->
			
			<?php //check to see brains eaten in files
				$eaten_placeholder;
				if ( preg_match("/\d/", $agent_data[5]) ) {
					$eaten_placeholder = $agent_data[5];
				}
				else {
					$eaten_placeholder = "total eaten";
			}?>
			
			<fieldset id="after_death">
				<legend>Brains Eaten:</legend>
				<input name="eaten" id="eaten" type="text" value="" placeholder=<?=$eaten_placeholder?>>
				<button type="button" id="add_eaten">+1</button>
			</fieldset>
			
			
			<div>
				<input type="submit" value="Save">
			</div>
			
		</form>
		
		<div>
			<a href="currentGame.php"><button>Cancel</button></a>
		</div>
		
		<div class="container">
	</body>
	
</html>