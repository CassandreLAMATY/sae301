console.log('show-password.js loaded')

function showPassword(btn) {
    let password = document.getElementById('inputPassword')
    if (password.type === 'password') {
        password.type = 'text'
        btn.classList.add('show-password')
    } else {
        password.type = 'password'
        btn.classList.remove('show-password')
    }
}

