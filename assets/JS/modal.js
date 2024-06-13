function openLoginModal() {
    event.preventDefault();
    var loginModal = document.getElementById('loginModal');
    loginModal.style.display = 'block';
}

function closeLoginModal() {
    event.preventDefault();
    var loginModal = document.getElementById('loginModal');
    loginModal.style.display = 'none';
}

function openRegisterModal() {
    event.preventDefault();
    closeLoginModal();
    var registerModal = document.getElementById('registerModal');
    registerModal.style.display = 'block';
}

function closeRegisterModal() {
    event.preventDefault();
    var registerModal = document.getElementById('registerModal');
    registerModal.style.display = 'none';
}

async function submitLoginForm(event) {
    event.preventDefault();

    var phoneNumber = document.getElementById('loginPhoneNumber').value;
    var password = document.getElementById('loginPassword').value;

    const response = await fetch('assets/php/modal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'login',
            Телефон: phoneNumber,
            Пароль: password
        })
    });

    const result = await response.text();
    alert(result);
    if (result.includes('Вход выполнен успешно')) {
        window.location.reload();
    }
}

async function submitRegisterForm(event) {
    event.preventDefault();

    var phoneNumber = document.getElementById('registerPhoneNumber').value;
    var password = document.getElementById('registerPassword').value;

    const response = await fetch('assets/php/modal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'register',
            Телефон: phoneNumber,
            Пароль: password
        })
    });

    const result = await response.text();
    alert(result);
    if (result.includes('Регистрация прошла успешно')) {
        window.location.reload();
    }
}

async function logout() {
    const response = await fetch('assets/php/modal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'logout'
        })
    });

    const result = await response.text();
    alert(result);
    if (result.includes('Выход выполнен успешно')) {
        window.location.reload();
    }
}
