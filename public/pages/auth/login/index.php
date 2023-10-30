<?php
$render = getRender(__DIR__);

echo 'Login';

?>

<button type="button" onclick="create()">Create</button>
<button type="button" onclick="list()">List</button>

<script>
    async function create() {
        await API.post('/users/create', {username: 'Dan Ruan', password: '123', email: 'dan@gmail.com'})
    }
    async function list() {
        await API.get('/users')
    }
</script>