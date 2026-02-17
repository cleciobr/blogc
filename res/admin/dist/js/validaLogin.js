$(document).ready(function(){

    $('#btn_login').click(function(){

        var campo_vazio = false;

        if($('#login').val() == ''){

            $('#login').css({'border-color': '#A94442'});

            campo_vazio = true;

        } else {

            $('#login').css({'border-color': '#CCC'});

        }

        if($('#senha').val() == ''){

            $('#senha').css({'border-color': '#A94442'});

            campo_vazio = true;

        } else {

        $('#senha').css({'border-color': '#CCC'});

        }

        if(campo_vazio) return false;

      });

});