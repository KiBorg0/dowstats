//этот скрипт подключается к таблице с игроками 1х1
$("#sort_by_player").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'player',
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
		}
	});
});

$("#sort_by_allgames").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'allgames',
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
		}
	});
});

$("#sort_by_wins").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'wins',
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
		}
	});
});

$("#sort_by_pwins").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'pwins',
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
		}
	});
});

$("#sort_by_favrace").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'favrace',
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
		}
	});
});

$("#sort_by_mmr").click(function(){
	var request_type_info = $("#request_type_info").html();
	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'view/ajax1x1.php',//url адрес файла обработчика
		data:{'sort':'mmr',
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
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
		'request_type': request_type_info},//параметры запроса
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#result1x1').html(data);
		}
	});
}