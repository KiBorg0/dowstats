$(document).ready(function() {
	search_player_battles();
});


function player_name_input_keypress_battles(e){
	if(e.keyCode == 13){
		search_player_battles();
	}else if(e.keyCode == 8){
		$("#search_advice_wrapper").html("").show();
	}else if(e.keyCode == 16 || e.keyCode == 17|| e.keyCode == 9){
		//shift, ctrl and tab ignore
	}else{
		var player = $("#player_name_input").val();
		$.ajax({
			type:'get',
			url:'ajax/search_ajax.php',
			data:{'playername': player},
			response:'text',
			success:function (data) {
				var nicks = data.split(',');
				suggest_count = nicks.length;
				if(suggest_count > 0){
				  $(".autocomplete").autocomplete({
				    source: nicks
				  });
				}
			}
		});
	}
}

function search_player_battles(){
	$('#fight_result').html("идет поиск...");
	var player = $("#player_name_input").val();
	var request_type_info = $("#request_type_info").html();
	//формируем строку, в которой указываем какие чекбоксы типа игры были выбраны
	var checkboxes = $("#1x1_checkbox").prop("checked") + ";" + $("#2x2_checkbox").prop("checked") + ";" + $("#3x3_checkbox").prop("checked") + ";" + $("#4x4_checkbox").prop("checked");
	var selected_race = $("#race_option").val();

	$.ajax({
		type:'get',
		url:'view/allGames.php',
		data:{'playername': player,
		'type_checkboxes': checkboxes,//строка с выбором типа игры через ;
		'selected_race': selected_race},
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			//$("#fight_result").html("");
			$('#fight_result').html(data);
		}
	});
}