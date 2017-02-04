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
                type:'get',
	            url: 'view/allGames.php',
	            data: {"startFrom" : startFrom},
            	response:'html',
	            /* что нужно сделать до отправки запрса */
	            beforeSend: function() {
		            /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */ 	
		            inProgress = true;
	            },
	            /* возвращаемый результат от сервера */
                success:function (data) {
                    $('#fight_result').append(data);
                    inProgress = false;
                    startFrom += 10;
                }
            });
        }
    });
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
			$('#fight_result').html(data);
		}
	});
}