$(document).ready(function() {
    search_player_battles();

	/* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос. В самом начале даем ей значение false, т.е. запрос не в процессе выполнения */
	var inProgress = false;
	/* С какой статьи надо делать выборку из базы при ajax-запросе */
	var startFrom = 10;

    /* Используйте вариант $('#more').click(function() для того, чтобы дать пользователю возможность управлять процессом, кликая по кнопке "Дальше" под блоком статей (см. файл index.php) */
    $(window).scroll(function() {

        /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
	        $.ajax({
	            /* адрес файла-обработчика запроса */
	            url: 'view/allGamesPlayer.php',
	            /* метод отправки данных */
	            method: 'GET',
	            /* данные, которые мы передаем в файл-обработчик */
	            data: {'name': userName, 'request_type': request_type_info, "startFrom" : startFrom},
	            //тип возвращаемого ответа text либо xml
            	response:'text',
	            /* что нужно сделать до отправки запрса */
	            beforeSend: function() {
		            /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */
		            inProgress = true;
	            }
            /* что нужно сделать по факту выполнения запроса */
            }).done(function(data){

                /* Преобразуем результат, пришедший от обработчика - преобразуем json-строку обратно в массив */
                data = jQuery.html(data);

                /* Если массив не пуст (т.е. статьи там есть) */
                if (data.length > 0) {
                    $("#fight_result").append(data);
                    /* По факту окончания запроса снова меняем значение флага на false */
                    inProgress = false;
                    // Увеличиваем на 10 порядковый номер статьи, с которой надо начинать выборку из базы
                    startFrom += 10;
                }
            });
        }
    });
});


$("#search_player_battles").click(function(){
	alert(1);
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
	var player = $("#player_name_input").val();
	var request_type_info = $("#request_type_info").html();
	if(player=="")
		$.ajax({
			type:'get',
			url:'view/allGamesPlayer.php',
			data:{'name': userName,
			'request_type': request_type_info},//request_type пока не используется!
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				//$("#fight_result").html("");
				$('#fight_result').html(data);
			}
		});
	else
		$.ajax({
			type:'get',
			url:'view/allGamesPlayer.php',
			data:{'name': userName,
			'searchname': player,
			'request_type': request_type_info},//request_type пока не используется!
			response:'text',//тип возвращаемого ответа text либо xml
			success:function (data) {//возвращаемый результат от сервера
				//$("#fight_result").html("");
				$('#fight_result').html(data);
			}
		});
}