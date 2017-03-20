<?php

class Steam{
	public static function get_avatar_url_by_id($id){

		$urljson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=AFD51FA6F2FE61F87BACE4D28391AF04&steamids=" . $id);
		$data = (array) json_decode($urljson)->response->players[0];
		$steam_avatar = $data["avatarmedium"];
		return $steam_avatar;
	}

	public static function get_big_avatar_url_by_id($id){

		$urljson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=AFD51FA6F2FE61F87BACE4D28391AF04&steamids=" . $id);
		$data = (array) json_decode($urljson)->response->players[0];
		$steam_avatar = isset($data["avatarfull"])?$data["avatarfull"]:'';
		return $steam_avatar;
	}
	public static function get_status($id){

		$urljson = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=AFD51FA6F2FE61F87BACE4D28391AF04&steamids=" . $id);
		$data = (array) json_decode($urljson)->response->players[0];
		if($data["personastate"]==1)
			if($data["gameid"]==9450)
				return true;
		return false;
	}

}

?>