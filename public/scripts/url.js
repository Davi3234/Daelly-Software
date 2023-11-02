class URL {
    redirect(url) {
        if (!url.startsWith('/')) {
            url = `/${url}`
        }

        const baseUrl = GLOBAL_PREFIX_ROUTER ? `/${GLOBAL_PREFIX_ROUTER}${url}` : url

        window.location.href = baseUrl
    }
}