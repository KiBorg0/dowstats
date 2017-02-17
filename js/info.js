/* С какой статьи надо делать выборку из базы при ajax-запросе */
var startFrom = 10;

$(document).ready(function() {
	search_info()
	/* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос. В самом начале даем ей значение false, т.е. запрос не в процессе выполнения */
	var inProgress = false;

    /* Используйте вариант $('#more').click(function() для того, чтобы дать пользователю возможность управлять процессом, кликая по кнопке "Дальше" под блоком статей (см. файл index.php) */
    $(window).scroll(function() {

        /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
	        $.ajax({
                type:'get',
	            url: 'view/info.php',
	            data: {"startFrom" : startFrom},
            	response:'html',
	            /* что нужно сделать до отправки запрса */
	            beforeSend: function() {
		            /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */ 	
		            inProgress = true;
	            },
	            /* возвращаемый результат от сервера */
                success:function (data) {
                    $('#info_result').append(data);
                    inProgress = false;
                    startFrom += 10;
                }
            });
        }
    });
});

function search_info(){
	startFrom = 10;
	$('#info_result').html("search...");
	$.ajax({
		type:'get',
		url:'view/info.php',
		data:{},
		response:'text',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('#info_result').html(data);
		}
	});
}