(function() {
	/*
	
	script for the updater web app for ECHO HvZT team at UW
	this file must be included for updater.php to work properly
	
	Author: Rose Beede
	
	*/
	
	window.onload = function() {
		var dead = document.getElementById("dead");
		dead.onclick = showDate;
		
		var alive = document.getElementById("alive");
		alive.onclick = hideDate;
		deathDateVisible(dead);
		
		var add_stun = document.getElementById("add_stun");
		var stuns = document.getElementById("stuns");
		add_stun.onclick = addCount_stun; //passing a parameter isn't working :( 
		
		var add_eaten = document.getElementById("add_eaten");
		var eaten = document.getElementById("eaten");
		add_eaten.onclick = addCount_eaten;
	}
	
	function deathDateVisible(dead) {
		if (dead.checked) {
			showDate();
		}
	}
	
	function showDate() { 
		var time_of_death = document.getElementById("time_of_death");
		time_of_death.style.display = "inline";
	}
	
	function hideDate() { 
		var time_of_death = document.getElementById("time_of_death");
		time_of_death.style.display = "none";
		
		/*
		var day = getElementById("deathdate");
		var dayoptions = day.querySelectAll("option");
		dayoptions[0].selected = "selected";
		for (var i = 1; i < dayoptions.length, i++) {
			dayoptions[i].removeAttribute("selected");
		}
		
		var ampm = getElementById("am/pm");
		*/
	}
	
	function addCount_stun() {
		var currentCount = parseInt(stuns.placeholder);
		stuns.placeholder = currentCount + 1;
		stuns.value = stuns.placeholder;
	} 
	//these functions should be one function, but when I try to pass parameters 
	//it executes immediately
	function addCount_eaten() {
		var currentCount = parseInt(eaten.placeholder);
		eaten.placeholder = currentCount + 1;
		eaten.value = eaten.placeholder;
	}

	
})();