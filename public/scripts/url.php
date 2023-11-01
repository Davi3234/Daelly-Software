<script>
    class URL {
        static GLOBAL_PREFIX_ROUTER = '<?= $GLOBALS['GLOBAL_PREFIX_ROUTER'] ?>'

        redirect(url) {
            if (!url.startsWith('/')) {
                url = `/${url}`
            }

            const baseUrl = URL.GLOBAL_PREFIX_ROUTER ? `/${URL.GLOBAL_PREFIX_ROUTER}${url}` : url

            window.location.href = baseUrl
        }
    }
</script>