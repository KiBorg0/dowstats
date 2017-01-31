(function (window, $) {
	'use strict';

	// Cache document for fast access.
	var document = window.document;


	/************** LightBox *********************/

	window.onload = function()
	{
		SendAllStat();
		SendAllStat1x1();
		
	}

	



})(window, jQuery);

function SendAllStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'all'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
				SortAllStatByPercent();
				// SortAllStatByName();
			}
		});
	}

	function SendSmStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
				
			}
		});
	}

	function SendChaosStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'2'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendOrkStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'3'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendEldStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'4'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendIGStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'5'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendNecronStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'6'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendTauStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'7'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendSistersOfBattleStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'8'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendDEStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'9'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}



	//-----------1x1--------------запросы 1х1 -------------


	function SendAllStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'all1x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendSmStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'11x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendChaosStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'21x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendOrkStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'31x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendEldStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'41x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendIGStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'51x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendNecronStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'61x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendTauStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'71x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendSistersOfBattleStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'81x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendDEStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'91x1':'1'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	//--------------------сортировка общей таблицы-----------------------

	function player_name_input_keypress(e){
		if(e.keyCode == 13){
			Search_player();
		}
	}

	function Search_player() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'name',
			'playername': $('#player_name_input').val() },//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByName() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'name'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByAllGames() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'games'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByWin() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'win'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByPercent() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'percent'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByAPM() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'apm'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByFavRace() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'favRace'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
	}

	function SortAllStatByAllGamesTime() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/allSortTable.php',//url адрес файла обработчика
			data:{'allSort':'allGamesTime'},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
    }
