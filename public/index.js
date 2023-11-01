const APP = {
  apiServer: new Request({ target: "/api" }),
  apiClient: new Request({ target: "/client" }),
  storage: new LocalStorage({ useMemory: false }),
  cookie: new Cookie({ useMemory: false }),
  url: new URL(),
  ready: (...handlers) => {
    handlers.forEach((handler) => {
      if (typeof handler == "function") {
        handler();
      }
    });
  },
};
