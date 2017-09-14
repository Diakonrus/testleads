$(document).on('click','#send_button_api',function(){
    var forms = $('form').serialize();
    var code = $('#code').val();

    $.ajax({
        url: $('#request_bar_1').val(),
        type: $('#request_verb').val(),
        dataType: "json",
        headers: {
            'code': code
        },
        data: forms,
        success: function (data) {
            console.log(data);
            var response = '';
            $.each( data, function( i, vals ) {
                response += '<ul>';

                response += i+':';
                if (typeof(vals) === 'string' || typeof(vals) === 'number'){
                    response += vals;
                } else {
                    $.each( vals, function( index, val ){
                        if (typeof(val) === 'string'){
                            response += '<li>'+index+':'+val+'</li>';
                        } else if (val!=null) {
                            $.each( val, function( index_2, val_2 ){

                                if (typeof(val_2) === 'string'){
                                    response += '<li>'+index_2+':'+val_2+'</li>';
                                } else if (val_2!=null) {
                                    $.each( val_2, function( index_3, val_3 ){
                                        response += '<li>'+index_3+':'+val_3+'</li>';
                                    });
                                }
                            });
                        }
                        response += '<BR>';
                    });
                }


                response += '</ul>';
            });



            $('#response').empty().append(response);

        }
    });



    return false;
});