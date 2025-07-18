jQuery(document).ready(function ($) {

    const $popupTitle = $('.clp-popup-title');

    // Open popup and show Login by default
    $('.clp-open-popup').on('click', function (e) {
        e.preventDefault();
        $('.clp-popup').fadeIn();
        $('.clp-login').show();
        $('.clp-register, .clp-forgot').hide();
        $popupTitle.text('Login');
    });

    // Close popup
    $('.clp-popup .close').on('click', function () {
        $('.clp-popup').fadeOut();
    });

    // Detect login form submit
    $('.clp-login-form form').on('submit', function () {
        setTimeout(() => {
            location.reload();
        }, 1000); // Wait a second for cookies to be set, then reload
    })

    // Show Register form
    $('.clp-show-register').on('click', function (e) {
        e.preventDefault();
        $('.clp-login').hide();
        $('.clp-register').show();
        $('.clp-forgot').hide();
        $popupTitle.text('Register');
    });

    // Show Login form
    $('.clp-show-login').on('click', function (e) {
        e.preventDefault();
        $('.clp-login').show();
        $('.clp-register, .clp-forgot').hide();
        $popupTitle.text('Login');
    });

    // Show Forgot Password form
    $('.clp-show-forgot').on('click', function (e) {
        e.preventDefault();
        $('.clp-login, .clp-register').hide();
        $('.clp-forgot').show();
        $popupTitle.text('Forgot Password');
    });

    // AJAX Logout
    $(document).on('click', '.clp-ajax-logout', function (e) {
        e.preventDefault();

        $.post({
            url: clp_ajax.ajax_url,
            data: {
                action: 'clp_ajax_logout'
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                }
            }
        });
    });

    // AJAX Forgot Password
    $('#clp-forgot-form').on('submit', function (e) {
        e.preventDefault();
        const email = $('#clp_forgot_email').val();

        $.post({
            url: clp_ajax.ajax_url,
            data: {
                action: 'clp_forgot_password',
                email: email
            },
            success: function (response) {
                if (response.success) {
                    alert('Password reset link sent. Please check your email.');
                    $('.clp-forgot').hide();
                    $('.clp-login').show();
                    $popupTitle.text('Login');
                } else {
                    alert(response.data || 'Error processing request.');
                }
            }
        });
    });
});
