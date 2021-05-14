$( document ).ready(function() {
    $('#select').on('change',function(){
        var selectValor = $(this).val();
        if (selectValor == 'Documento') {
                $('.enlace').addClass('oculto');
                $('.documento').removeClass('oculto');
        }else if(selectValor == 'Enlace') {
            $('.documento').addClass('oculto');
            $('.enlace').removeClass('oculto');
        } else{
            $('.documento').addClass('oculto');
            $('.enlace').addClass('oculto');
        }
    });
});

