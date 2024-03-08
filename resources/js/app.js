require('./bootstrap');
$(document).ready(function() {
    // Add event listener for the toggle buttons
    $('.btn-toggle-comments').click(function() {
        var target = $(this).data('target');
        $(target).collapse('toggle');
    });
});