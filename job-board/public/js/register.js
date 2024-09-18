$(document).ready(function() {
    $('.role-btn').click(function() {
        var role = $(this).data('role');
        $('#selected-role').val(role);
        $('.role-btn').removeClass('active');
        $(this).addClass('active');
    });

    $('form').submit(function(event) {
        var role = $('#selected-role').val();
        var validRoles = ['employer', 'candidate', 'admin'];

        if (!validRoles.includes(role)) {
            alert('Please select a valid role.');
            event.preventDefault(); 
        }
        
        let password = $('#password').val();
        let passwordConfirm = $('#password_confirmation').val();

        if (password !== passwordConfirm) {
            event.preventDefault(); 
            alert('Passwords do not match.');
        }
    });

    $('#toggle-password').click(function() {
        let passwordField = $('#password');
        let type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#toggle-password-confirm').click(function() {
        let passwordFieldConfirm = $('#password_confirmation');
        let type = passwordFieldConfirm.attr('type') === 'password' ? 'text' : 'password';
        passwordFieldConfirm.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
});
