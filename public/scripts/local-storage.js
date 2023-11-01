const DEFAULT_LOCAL_STORAGE_OPTIONS = {
  useMemory: false,
};

class LocalStorage {
  constructor(options = {}) {
    this.options = DEFAULT_LOCAL_STORAGE_OPTIONS;

    this.updateOptions(options);
  }

  createItem(key, value) {
    try {
      this.removeItem(key);
      this.getStorage().setItem(key, value || "");
      return true;
    } catch (err) {
      return false;
    }
  }

  updateItem(key, value) {
    try {
      this.removeItem(key);
      this.createItem(key, value);
      return true;
    } catch (err) {
      return false;
    }
  }

  removeItem(key) {
    try {
      this.getStorage().removeItem(key);
      return true;
    } catch (err) {
      return false;
    }
  }

  getItem(key) {
    try {
      const valueItem = this.getStorage().getItem(key);

      if (!valueItem) {
        return null;
      }

      return valueItem;
    } catch (err) {
      return null;
    }
  }

  clear() {
    try {
      this.getStorage().clear();
      return true;
    } catch (err) {
      return false;
    }
  }

  updateOptions(options = {}) {
    this.options = {
      useMemoryWhenLocalNotEnable:
        typeof options.useMemoryWhenLocalNotEnable == "undefined"
          ? DEFAULT_LOCAL_STORAGE_OPTIONS.useMemoryWhenLocalNotEnable
          : options.useMemoryWhenLocalNotEnable,
      useMemory:
        typeof options.useMemory == "undefined"
          ? DEFAULT_LOCAL_STORAGE_OPTIONS.useMemory
          : options.useMemory,
    };
  }

  getStorage() {
    if (!this.options.useMemory) {
      return sessionStorage;
    }

    return localStorage;
  }
}
