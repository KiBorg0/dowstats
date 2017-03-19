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

function SendRaceStat(raceID) {
	//отправляю GET запрос и получаю ответ
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/allSortTable.php',//url адрес файла обработчика
        data:{'race':raceID,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#table-allStat').html(data);
			
		}
	});
}

//--------------------сортировка общей таблицы-----------------------

function player_name_input_keypress(e,raceID){
	raceID = raceID || 0;
	if(e.keyCode == 13){
		Search_player(raceID);
	}
}

function Search_player(raceID) {
	raceID = raceID || 0;
	//отправляю GET запрос и получаю ответ
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/allSortTable.php',//url адрес файла обработчика
		data:{'race':raceID,'allSort':'name',
		'playername': $('#player_name_input').val(),'lang':lang },//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#table-allStat').html(data);
		}
	});
}

function SortBy(sortType, raceID) {
	//отправляю GET запрос и получаю ответ
	raceID = raceID || 0;
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/allSortTable.php',//url адрес файла обработчика
		data:{'race':raceID,'allSort':sortType,'lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#table-allStat').html(data);
		}
	});
}

function SendAllStat() {
	//отправляю GET запрос и получаю ответ
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/allSortTable.php',//url адрес файла обработчика
		data:{'allSort':'top','lang':lang},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#table-allStat').html(data);
		}
	});
}

