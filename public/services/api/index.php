<?php

?>

<script>
    class API {
        static GLOBAL_PREFIX_ROUTER = '<?= $GLOBALS['GLOBAL_PREFIX_ROUTER'] ?>'

        static async get(url, body = {}, headers = {}) {
            const response = await API.performRequest('GET', url, body, headers)

            return response
        }

        static async post(url, body = {}, headers = {}) {
            const response = await API.performRequest('POST', url, body, headers)

            return response
        }

        static async put(url, body = {}, headers = {}) {
            const response = await API.performRequest('PUT', url, body, headers)

            return response
        }

        static async patch(url, body = {}, headers = {}) {
            const response = await API.performRequest('PATCH', url, body, headers)

            return response
        }

        static async delete(url, body = {}, headers = {}) {
            const response = await API.performRequest('DELETE', url, body, headers)

            return response
        }

        static async head(url, body = {}, headers = {}) {
            const response = await API.performRequest('HEAD', url, body, headers)

            return response
        }

        static async options(url, body = {}, headers = {}) {
            const response = await API.performRequest('OPTIONS', url, body, headers)

            return response
        }

        static async performRequest(method = '', url = '', body = {}, options = {}) {
            if (!url.startsWith('/')) {
                url = `/${url}`
            }

            const requestOptions = {
                method,
                params: {
                    router: url,
                    ...(options.params || {})
                },
                headers: {
                    "Content-Type": "application/json; charset=UTF-8",
                    ...(options.headers || {})
                }
            }

            const file = '';
            const baseUrl = API.GLOBAL_PREFIX_ROUTER ? `/${API.GLOBAL_PREFIX_ROUTER}${file}` : file

            if (method != "GET") {
                requestOptions['body'] = JSON.stringify(body)
            }

            const response = await fetch(`${baseUrl}?${this.converterObjectToQueryURL({ router: url, ...(options.params || {}) })}`, requestOptions).then(res => {
                try {
                    return (res || "{}").json()
                } catch (err) {
                    return (res || "{}").text()
                }
            }).then(res => res)

            return response
        }

        static converterObjectToQueryURL(obj) {
            let queryURL = Object.keys(obj).map(key => {
                const body = JSON.stringify(obj[key])

                return `${key}=${typeof obj[key] != "object" ? body.substring(1, body.length - 1) || "" : body}`
            }).join("&")

            return queryURL;
        }
    }
</script>