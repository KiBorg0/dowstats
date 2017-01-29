<?php
class RaceSwitcher{
	function getRace($num){
		switch($num){
			case 1:
				return "Космодесант";
				break;
			case 2:
				return "Хаос";
				break;
			case 3:
				return "Орки";
				break;
			case 4:
				return "Эльдары";
				break;
			case 5:
				return "Имперская гвардия";
				break;
			case 6:
				return "Некроны";
				break;
			case 7:
				return "Империя Тау";
				break;
			case 8:
				return "Сёстры битвы";
				break;
			case 9:
				return "Темные эльдары";
				break;
		}
	}

	function getRaceNum($race_text){
		switch($race_text){
			case "Любая раса":
				return 0;
				break;
			case "Космодесант":
				return 1;
				break;
			case "Хаос":
				return 2;
				break;
			case "Орки":
				return 3;
				break;
			case "Эльдары":
				return 4;
				break;
			case "Имперская гвардия":
				return 5;
				break;
			case "Некроны":
				return 6;
				break;
			case "Империя Тау":
				return 7;
				break;
			case "Сёстры битвы":
				return 8;
				break;
			case "Темные эльдары":
				return 9;
				break;
		}
	}
}
?>