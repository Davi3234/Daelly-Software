<?php
$render = getRender(__DIR__);

echo 'Login';

?>
<?= line() ?>
<label for="input-email">Email: </label>
<input type="text" name="email" id="input-email">
<?= line() ?>
<label for="input-password">Password: </label>
<input type="text" name="password" id="input-password">
<?= line() ?>

<button type="button" name="bt-login">Login</button>

<script>
    APP.ready(() => {
        async function login() {
            const response = await APP.apiServer.post('/auth/sign-in', {
                password: document.querySelector('input[name="password"]').value,
                email: document.querySelector('input[name="email"]').value
            })

            if (response.ok) {
                const responseSaveToke = await APP.apiClient.post('/auth/sign-in/save', { token: response.value.token })

                if (responseSaveToke.ok) {
                    APP.url.redirect('/home')
                }
            }
        }

        document.querySelector('button[name="bt-login"]').addEventListener('click', () => login())
    })
</script>