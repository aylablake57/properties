$(document).on('submit', '.user_login', function(event) {
    event.preventDefault();
    var fd = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '{{ url("login")}}',
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(response) {
            console.log(response);
            if (response.success == 1) {
                toastr.success(
                    response.msg,
                    '',
                    {          
                        timeOut: 1000,
                        fadeOut: 2000,
                        onHidden: function () {
                            location.href = '{{url("/")}}';
                        }
                    }
                );
            } else {
                toastr.error(response.msg);
            }
        },
        error: function(response) {
            console.log(response);
            toastr.error(response.msg);
        }
    });
});