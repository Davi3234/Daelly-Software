<?php

echo 'Login'
?>

<script>
    API.post('/auth/login', {username: 'Dan Ruan', password: '123'})
</script>