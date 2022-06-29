$(document).on('keyup', '#name', function(){
    $.ajax({
        url: route('create.slug'),
        type: "POST",
        data:{str:$(this).val()},
        success:function(response){
            $(document).find('#slug').val(response);
        }
    });
});