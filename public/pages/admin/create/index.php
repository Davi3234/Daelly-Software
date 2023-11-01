<?php
$render = getRender(__DIR__);

echo 'Create';

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

<button type="button" name="bt-create">Create</button>
<button type="button" name="bt-list">List</button>

<script>
    APP.ready(() => {
        async function create() {
            await APP.apiServer.post('/users/create', {
                username: document.querySelector('input[name="username"]').value,
                password: document.querySelector('input[name="password"]').value,
                email: document.querySelector('input[name="email"]').value
            })
        }
        async function list() {
            await APP.apiServer.get('/users')
        }

        document.querySelector('bt-create').addEventListener('click', () => create())
        document.querySelector('bt-list').addEventListener('click', () => list())
    })
</script>