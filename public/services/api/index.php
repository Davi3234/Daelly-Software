<?php

?>

<script>
    class API {
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

        static async performRequest(method = '', url = '', body = {}, headers = {}) {
            return {
                hello: "world"
            }
        }
    }
</script>