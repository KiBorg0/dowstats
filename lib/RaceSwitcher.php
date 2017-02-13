<?php

class RaceSwitcher{
	function getRace($num){
	    switch($num){
	        case 1:
	            return _("Space Marines");
	            break;
	        case 2:
	            return _("Chaos Marines");
	            break;
	        case 3:
	            return _("Orks");
	            break;
	        case 4:
	            return _("Eldar");
	            break;
	        case 5:
	            return _("Imperial Guard");
	            break;
	        case 6:
	            return _("Necrons");
	            break;
	        case 7:
	            return _("Tau Empire");
	            break;
	        case 8:
	            return _("Sisters of Battle");
	            break;
	        case 9:
	            return _("Dark Eldar");
	            break;
	    }
	}

	function getRaceNum($race_text){
		switch($race_text){
			case _("Favorite race"):
				return 0;
				break;
			case _("Space Marines"):
				return 1;
				break;
			case _("Chaos Marines"):
				return 2;
				break;
			case _("Orks"):
				return 3;
				break;
			case _("Eldar"):
				return 4;
				break;
			case _("Imperial Guard"):
				return 5;
				break;
			case _("Necrons"):
				return 6;
				break;
			case _("Tau Empire"):
				return 7;
				break;
			case _("Sisters of Battle"):
				return 8;
				break;
			case _("Dark Eldar"):
				return 9;
				break;
		}
	}
}
?>