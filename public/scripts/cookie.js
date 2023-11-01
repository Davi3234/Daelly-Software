class CookieClient {
    set(name, valor, days, isSession = false) {
        let validade = ""

        if (days && !isSession) {
            const date = new Date()

            const daysInMiliseconds = days * 24 * 60 * 60 * 1000
            date.setTime(date.getTime() + daysInMiliseconds)

            validade = "; expires=" + date.toUTCString()
        }

        document.cookie = name + "=" + (valor || "")  + validade + "; path=/"
    }
    
    get(name) {
        const nameCookie = name + "="
        const cookies = document.cookie.split(';')

        for(let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim()

            if (cookie.startsWith(name)) {
                return cookie.substring(nameCookie.length)
            }
        }

        return null
    }
    
    remove(name) {   
        document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
    }
}

class Cookie {
    static storageMemory = new CookieClient()

    constructor(config = { useMemory: false }) {
        this.config = config
    }

    set(name, value, exp) {
        return Cookie.getStorage().set(name, value, exp, this.config.useMemory)
    }

    get(name) {
        return Cookie.getStorage().get(name)
    }

    static getStorage() {
        return Cookie.storageMemory
    }
}