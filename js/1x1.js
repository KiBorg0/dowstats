(function (window, $) {
	'use strict';

	// Cache document for fast access.
	var document = window.document;


	/************** LightBox *********************/

	window.onload = function()
	{
		SendAllStat();
	}

	


})(window, jQuery);

function SendAllStat() {
	//отправляю GET запрос и получаю ответ
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'race':0,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
}

function SendRaceStat(raceID) {
	//отправляю GET запрос и получаю ответ
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'/view/ajax1x1.php',//url адрес файла обработчика
        data:{'race':raceID,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
			
		}
	});
}


//этот скрипт подключается к таблице с игроками 1х1
$("#sort_by_player").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'name',
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
});

$("#sort_by_allgames").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'allgames',
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
});

$("#sort_by_wins").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'wins',
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
});

$("#sort_by_pwins").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'pwins',
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
});

$("#sort_by_favrace").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'favrace',
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
});

$("#sort_by_mmr").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'mmr',
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
});

$("#search_player").click(function(){
	search_player1x1();
});

function player_name_input_keypress1x1(e){
	if(e.keyCode == 13){
		search_player1x1();
	}
}

function search_player1x1(){
	var player = $("#player_name_input").val();
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'playername': player,
		'race': request_type_info,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result').html(data);
		}
	});
}