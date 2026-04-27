document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('togglePassword');
    const input = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const inputConfirmPassword = document.getElementById('passwordConfirm');
    const eyeIconConfirmPassword = document.getElementById('eyeIconConfirmPassword');

    if (!toggle || !input || !eyeIcon) return;

    toggle.addEventListener('click', function () {
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.className = 'bi bi-eye';
        } else {
            input.type = 'password';
            eyeIcon.className = 'bi bi-eye-slash';
        }
    });

    toggleConfirmPassword.addEventListener('click', function () {
        if (inputConfirmPassword.type === 'password') {
            inputConfirmPassword.type = 'text';
            eyeIconConfirmPassword.className = 'bi bi-eye';
        } else {
            inputConfirmPassword.type = 'password';
            eyeIconConfirmPassword.className = 'bi bi-eye-slash';
        }
    });
});