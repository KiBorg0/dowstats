<?php

class NickDecode{

		

	public static function hexToStr($hex){
	    $string='';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $string .= chr(hexdec($hex[$i].$hex[$i+1])) ;
	    }

	    return $string;
	}


	public static function StrToHex($string){
	    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
	}

	public static function decodeNick($name){
		return NickDecode::hexToStr($name);
	}

	public static function codeNick($name){
		return NickDecode::StrToHex($name);
	}

}

?>