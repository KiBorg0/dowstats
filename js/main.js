(function (window, $) {
	'use strict';

	// Cache document for fast access.
	var document = window.document;


	/************** LightBox *********************/

	window.onload = function()
	{
		// console.log('язык', lang);
		SendAllStat();
		SendAllStat1x1();
		
	}

	



})(window, jQuery);

function SendAllStat() {
		//отправляю GET запрос и получаю ответ

		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'all','lang':lang},//параметры запроса
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
            data:{'race':'1','lang':lang},//параметры запроса
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
            data:{'race':'2','lang':lang},//параметры запроса
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
            data:{'race':'3','lang':lang},//параметры запроса
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
            data:{'race':'4','lang':lang},//параметры запроса
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
            data:{'race':'5','lang':lang},//параметры запроса
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
            data:{'race':'6','lang':lang},//параметры запроса
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
            data:{'race':'7','lang':lang},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result').html(data);
			}
		});
	}

	function SendSOBStat() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax.php',//url адрес файла обработчика
            data:{'race':'8','lang':lang},//параметры запроса
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
            data:{'race':'9','lang':lang},//параметры запроса
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
			data:{'request_type':'0','lang':lang},//параметры запроса
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
			data:{'request_type':'1','lang':lang},//параметры запроса
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
			data:{'request_type':'2','lang':lang},//параметры запроса
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
			data:{'request_type':'3','lang':lang},//параметры запроса
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
			data:{'request_type':'4','lang':lang},//параметры запроса
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
			data:{'request_type':'5','lang':lang},//параметры запроса
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
			data:{'request_type':'6','lang':lang},//параметры запроса
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
			data:{'request_type':'7','lang':lang},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#result1x1').html(data);
			}
		});
	}

	function SendSOBStat1x1() {
		//отправляю GET запрос и получаю ответ
		$.ajax({
			type:'get',//тип запроса: get,post либо head
			url:'view/ajax1x1.php',//url адрес файла обработчика
			data:{'request_type':'8','lang':lang},//параметры запроса
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
			data:{'request_type':'9','lang':lang},//параметры запроса
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
			'playername': $('#player_name_input').val(),'lang':lang },//параметры запроса
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
			data:{'allSort':'name','lang':lang},//параметры запроса
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
			data:{'allSort':'all','lang':lang},//параметры запроса
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
			data:{'allSort':'win','lang':lang},//параметры запроса
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
			data:{'allSort':'percent','lang':lang},//параметры запроса
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
			data:{'allSort':'apm','lang':lang},//параметры запроса
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
			data:{'allSort':'favRace','lang':lang},//параметры запроса
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
			data:{'allSort':'allGamesTime','lang':lang},//параметры запроса
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				$('#table-allStat').html(data);
			}
		});
    }
