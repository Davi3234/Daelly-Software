const DEFAULT_LOCAL_STORAGE_OPTIONS = {
  useMemoryWhenLocalNotEnable: true,
  useMemory: false,
};

class LocalStorageMemory {
  static storage = [];

  constructor() {}

  setItem(key, value) {
    this.removeItem(key);
    this.addItem(key, value);
  }

  getItem(keyName) {
    const itemByKeyName = this.getItemByKeyName(keyName);

    return itemByKeyName;
  }

  clear() {
    LocalStorageMemory.storage.splice(0, LocalStorageMemory.storage.length);
  }

  removeItem(keyName) {
    const indexItemByKeyName = this.getIndexItemByKeyName(keyName);

    if (indexItemByKeyName < 0) {
      return;
    }

    LocalStorageMemory.storage.splice(indexItemByKeyName, 1);
  }

  key(indexItem) {
    const itemByIndex = this.getItemByKeyIndex(indexItem);

    return itemByIndex;
  }

  get length() {
    return LocalStorageMemory.storage.length;
  }

  addItem(key, value) {
    LocalStorageMemory.storage.push({ key, value });
  }

  getItemByKeyName(keyName) {
    const itemByKeyName =
      LocalStorageMemory.storage.find((item) => item.key == keyName)?.value ||
      null;

    return itemByKeyName;
  }

  getItemByKeyIndex(indexItem) {
    const itemByIndex = LocalStorageMemory.storage[indexItem]?.value || null;

    return itemByIndex;
  }

  getIndexItemByKeyName(keyName) {
    const itemByKeyName = LocalStorageMemory.storage.findIndex(
      (item) => item.key == keyName,
    );

    return itemByKeyName;
  }
}

class LocalStorage {
  static storageMemory = new LocalStorageMemory();
  static storageLocal = localStorage;

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
    if (!this.options.useMemory || !this.options.useMemoryWhenLocalNotEnable) {
      return LocalStorage.storageLocal;
    }

    return LocalStorage.storageMemory;
  }
}

const storage = new LocalStorage({ useMemory: false });
