$(document).on('submit', 'form#create-goal', function(e) {
    if ($('form#create-goal').parsley().isValid()) {
        $.ajax({
            url: route('goals.store'),
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                let result = JSON.parse(response);
                $('#messages').html(
                    '<div class="col-sm-12 mt-4 mb-0"> <div class="alert alert-success">' +
                    result.message +
                    '</div></div>'
                );
                $(document).find('form#create-goal').trigger('reset');
                setTimeout(() => {
                    window.location.href = route('front.services');
                }, 3000);
            },
            error: function(response) {
                $('#messages').html(
                    '<div class="col-sm-12"> <div class="alert alert-danger">' +
                    response.responseJSON.message +
                    '</div></div>'
                );
            }
        });
    }
    e.preventDefault();
});

$(function() {
    $(".col-md-4").slice(0, 3).show();
    $("body").on('click touchstart', '.load-more', function(e) {
        e.preventDefault();
        $(".col-md-4:hidden").slice(0, 3).slideDown();
        if ($(".col-md-4:hidden").length == 0) {
            $(".load-more").css('visibility', 'hidden');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1000);
    });
});

let counter = 1;
$(document).on('click', '#add_activity', function() {
    var newActivity = $(document).find('div.activity').html();
    $(document).find('.new-activities').append(newActivity);
    $(document).find('.new-activities .row:last').append(
        '<div class="col-sm-12"><a href="javascript:void(0);" class="text-danger remove" data-classid=' +
        counter + '> <i class="fa fa-minus"></i> Remove</a></div>');
    $(document).find('.new-activities .row:last').addClass('counter' + counter);
    counter++;
});

$(document).on('click', '.remove', function() {
    $(document).find('div.counter' + $(this).data('classid')).remove();
});