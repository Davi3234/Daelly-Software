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

<button type="button" onclick="login()">Login</button>

<script>
    async function login() {
        await API.post('/auth/sign-in', {
            password: document.querySelector('input[name="password"]').value,
            email: document.querySelector('input[name="email"]').value
        })
    }
</script>