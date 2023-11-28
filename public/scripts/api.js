class Request {
  constructor(config = { target: "/api" }) {
    this.config = config;
  }

  async get(url, body = {}, headers = {}) {
    const response = await this.performRequest("GET", url, body, headers);

    return response;
  }

  async post(url, body = {}, headers = {}) {
    const response = await this.performRequest("POST", url, body, headers);

    return response;
  }

  async put(url, body = {}, headers = {}) {
    const response = await this.performRequest("PUT", url, body, headers);

    return response;
  }

  async patch(url, body = {}, headers = {}) {
    const response = await this.performRequest("PATCH", url, body, headers);

    return response;
  }

  async delete(url, body = {}, headers = {}) {
    const response = await this.performRequest("DELETE", url, body, headers);

    return response;
  }

  async head(url, body = {}, headers = {}) {
    const response = await this.performRequest("HEAD", url, body, headers);

    return response;
  }

  async options(url, body = {}, headers = {}) {
    const response = await this.performRequest("OPTIONS", url, body, headers);

    return response;
  }

  async performRequest(method = "", url = "", body = {}, options = {}) {
    if (!url.startsWith("/")) {
      url = `/${url}`;
    }

    const requestOptions = {
      method: method.toUpperCase(),
      params: {
        router: url,
        ...(options.params || {}),
      },
      headers: {
        "Content-Type": "application/json; charset=UTF-8",
        ...(options.headers || {}),
        ...(APP.cookie.get("token") && {
          Authorization: "Bearer " + APP.cookie.get("token"),
        }),
      },
    };

    const baseUrl = GLOBAL_PREFIX_ROUTER ?
      `/${GLOBAL_PREFIX_ROUTER}${this.config.target}` :
      `${this.config.target}`;

    if (method != "GET") {
      requestOptions["body"] = JSON.stringify(body);
    }

    const response = await fetch(
      `${baseUrl}?${this.converterObjectToQueryURL({
        router: url,
        ...(options.params || {}),
      })}`,
      requestOptions,
    )
      .then(async (res) => {
        const data = await (res || "{}").text();

        try {
          return JSON.parse(data);
        } catch (err) {
          return data;
        }
      })
      .then((res) => res)
      .catch((err) => err);

    console.log({
      request: requestOptions,
      response,
    });

    return response;
  }

  converterObjectToQueryURL(obj) {
    let queryURL = Object.keys(obj)
      .map((key) => {
        const body = JSON.stringify(obj[key]);

        return `${key}=${typeof obj[key] != "object"
          ? body.substring(1, body.length - 1) || ""
          : body
          }`;
      })
      .join("&");

    return queryURL;
  }
}