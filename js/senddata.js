function isEmpty(str) {
    if (encodeURI(str).length  <  1)
   {
     alert("Введите, пожалуйста, Ваше имя!");
     contform.clientname.focus();
     return  false;
   } else return true;
}

function send()
{
str  =  contform.clientname.value;
   if (encodeURI(str).length  <  1)
   {
     alert("Введите, пожалуйста, Ваше имя!");
     contform.clientname.focus();
     return  false;
   }
str  =  contform.clientmail.value;
   if (encodeURI(str).length  <  1)
   {
     alert("Введите, пожалуйста, E-Mail!");
     contform.clientmail.focus();
     return  false;
   }
str  =  contform.clientcountry.value;
   if (encodeURI(str).length  <  1)
   {
     alert("Введите, пожалуйста, страну!");
     contform.clientcountry.focus();
     return  false;
   }
str  =  contform.clientphone.value;
   if (encodeURI(str).length  <  1)
   {
     alert("Введите, пожалуйста, телефон!");
     contform.clientphone.focus();
     return  false;
   }
str  =  contform.message.value;
   if (encodeURI(str).length  <  1)
   {
     alert("Введите, пожалуйста, сообщение!");
     contform.message.focus();
     return  false;
   }

 
var data = 'Господин '+ $('#clientname').val()+' E-mail: '+
            $('#clientmail').val() + ' Страна: '+$('#clientcountry').val()+
            'Телефон: '+ $('#clientphone').val()+ 'Сообщает :'+$('#message').val();
  // Отсылаем паметры
       $.ajax({
                type: "POST",
                url: "senddata.php",
                data: "data="+data,
                // Выводим то что вернул PHP
                success: function(html) {
 //предварительно очищаем нужный элемент страницы
                        $("#result").empty();
//и выводим ответ php скрипта
                        $("#result").append(html);
                }
        });

}
