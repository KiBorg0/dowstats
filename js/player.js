window.onload = function()
	{
		$('.tabs').hide();
		if(window.location.hash) {
				// hash found
				var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
				$('#' + hash).show();
				
			} else {
				// No hash found
				$('#tab1').show();
			}
		

	}


function setLocationHash(curLoc){
  location.hash = curLoc;
}

function show_tab(tab_id) {
	$('.tabs').hide();
	$('#'+tab_id).show();
	setLocationHash(tab_id);
}