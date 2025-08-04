// By Asfia
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// For admin notification by Asim
$(document).on('click', '.mark-as-read-user', function () {
    let notificationId = $(this).data('id');
    console.log()
    let route = $(this).data('route');
    $.ajax({
        url: route,
        method: 'GET',
        success: function (response) {
            $('#notification-' + notificationId).removeClass('unread').addClass('read');
            $('#notification-' + notificationId).find('.unread-indicator').remove();

            let badge = $('#badge');
            let count = parseInt(badge.text()) - 1;

            let isAlreadyMarked = response.isAlreadyMarked;
            console.log(count);
            if (!isAlreadyMarked) {
                if (count > 0) {
                    badge.text(count);
                } else {
                    badge.text('0');
                }
            }
            // Add the "No notifications to show" message
            if ($('#notification-list li').length === 0) {
                $('#notification-list').append(`
                        <li class="dropdown-item" id="no-notification">
                            No notifications to show
                        </li>
                    `);
            }
        }

    });
});

$(document).on('click', '#clear-all-notifications', function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).data('route'),
        method: 'GET',
        success: function (response) {
            $('#notification-list .notification-scroll').empty();
            let badge = $('#badge');
            badge.text('0');
            $('#clear-all-notifications').addClass('d-none');

            $('#notification-list .notification-scroll').html(`
                <li class="dropdown-item" id="no-notification">
                    No notifications to show
                </li>
            `);
        },
        error: function (xhr, status, error) {
            console.error("Error clearing notifications:", error);
        }
    });
});