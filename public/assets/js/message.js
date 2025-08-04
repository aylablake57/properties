//Done By Hamza Amjad
//Character counter, starts from zero, and limit should be 1500 for textArea, Message element
// document.addEventListener('DOMContentLoaded', function () {
//     const messageInput = document.getElementById('message');
//     const charCount = document.getElementById('charCount');
//     const maxLength = messageInput.getAttribute('maxlength');

//     messageInput.addEventListener('input', function () {
//         const currentLength = messageInput.value.length;
//         charCount.textContent = `${currentLength}/${maxLength}`;
//     });
//     //update counter on page load if ther is already context inside textarea
//     const initialLength = messageInput.value.length;
//     charCount.textContent = `${initialLength}/${maxLength}`;
// });
$('document').ready(function(){
    const $messageInput = $('#message');
    const $charCount = $('#charCount');
    const $messageCount = $messageInput.attr('maxLength');
    $messageInput.on('input', function(){
        var $currentMessage = $messageInput.val().length;
        console.log($currentMessage);
        $charCount.text(`${currentLength}/${$messageCount}`);
    })
    const initialLength = $messageCount.val().length;
    $charCount.text(`${currentLength}/${$messageCount}`);
});