$(document).on('change', '.isSold', function() {
    var id = $(this).data('id'); 
    var isChecked = $(this).is(':checked'); 
    $.ajax({
        type: "GET",
        url: '../property/sold',
        data: {
            id: id,
            is_sold: isChecked ? 1 : 0
        },
        dataType: "json",
        success: function(response) {
            if (response == 1) {
                toastr.success('Property status updated successfully!');
                
                var statusCell = $(this).closest('td');
                if (isChecked) {
                    statusCell.find('.badge').removeClass('text-bg-warning').addClass('text-bg-success').text('Sold');
                    console.log($('#soldModal'));
                    $('#soldModal').modal('show');
                } else {
                    statusCell.find('.badge').removeClass('text-bg-success').addClass('text-bg-warning').text('Available');
                }
            } else {
                toastr.error('Failed to update property status.');
            }
        }.bind(this), // Bind `this` to maintain context
        error: function(response) {
            console.log(response);
            toastr.error('An error occurred while updating the property status.');
        }
    });
});


$('#confirmSoldDHA360').on('click', function() {
    $('#ratingSection').show();  
});

$('#confirmNotDHA360').on('click', function() {
    $('#soldModal').modal('hide');  
});

//By Asim > Listens for star click event
const stars = document.querySelectorAll('#starRating .feedbackstar');
const reviewField = document.getElementById('reviewMessageField');

stars.forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.getAttribute('data-value');
        stars.forEach(s => {
            s.classList.remove('selected'); 
            if (s.getAttribute('data-value') <= rating) {
                s.classList.add('selected'); 
                s.style.color = '#a0af50'; 
            } else {
                s.style.color = 'gray'; 
            }
        });
        reviewField.style.display = 'block';
    });
});

//By Asim > Gathers user feedback and submits the data
document.getElementById('submitReview').addEventListener('click', function() {
    const userId = document.getElementById('authUserId').value;
    const rating = [...stars].filter(star => star.classList.contains('selected')).length;
    const reviewMessage = document.getElementById('reviewMessage').value;

    if (rating === 0) {
        toastr.error('Please select a star rating.');
        return;
    }
    $.ajax({
        url: '../agents/submit-feedback',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), 
            user_id: userId,
            rating: rating,               
            review: reviewMessage 
        },
        success: function(response) {
            toastr.success('Review submitted successfully!');
            $('#ratingSection').hide();
            $('#reviewMessageField').hide();
            $('#reviewMessage').val(''); // Reset review message field
            stars.forEach(s => {
                s.classList.remove('selected'); // Remove 'selected' class
                s.style.color = 'gray'; // Reset color
            });

            // Close the modal on successful submission
            $('#soldModal').modal('hide');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            toastr.error('Something went wrong. Please try again.'); 
        }
    });

    console.log('User ID:', userId);
    console.log('Rating:', rating);
    console.log('Review:', reviewMessage);
});