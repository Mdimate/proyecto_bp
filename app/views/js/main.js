const togglePasswordButton = document.getElementById('toggle-password');
const passwordField = document.getElementById('contraseña');

togglePasswordButton.addEventListener('click', function () {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
});
