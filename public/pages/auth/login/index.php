<?php
$render = getRender(__DIR__);

echo 'Login';

?>

<script>
    setTimeout(() => {
        API.post('/auth/login', {username: 'Dan Ruan', password: '123'})
    }, 1000*2)
</script>