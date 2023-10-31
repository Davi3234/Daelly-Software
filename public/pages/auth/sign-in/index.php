<?php
$render = getRender(__DIR__);

echo 'Login';

?>
<?= line() ?>
<label for="input-username">Username: </label>
<input type="text" name="username" id="input-username">
<?= line() ?>
<label for="input-email">Email: </label>
<input type="text" name="email" id="input-email">
<?= line() ?>
<label for="input-password">Password: </label>
<input type="text" name="password" id="input-password">
<?= line() ?>

<button type="button" onclick="create()">Create</button>
<button type="button" onclick="list()">List</button>

<script>
    async function create() {
        await API.post('/users/create', {
            username: document.querySelector('input[name="username"]').value,
            password: document.querySelector('input[name="password"]').value,
            email: document.querySelector('input[name="email"]').value
        })
    }
    async function list() {
        await API.get('/users')
    }
</script>