// javascript functions for localstorage api

function localstorageRead(localstorage_name) {
    return JSON.parse(localStorage.getItem(localstorage_name))
}

function localstoragePush(localstorage_name, inserted_data) {
    let storage = JSON.parse(localStorage.getItem(localstorage_name));
    if (!storage) {
        storage = [];
    }
    storage.push(inserted_data);
    return localStorage.setItem(localstorage_name, JSON.stringify(storage))
}

function localstorageUnshift(localstorage_name, inserted_data) {
    let storage = JSON.parse(localStorage.getItem(localstorage_name));
    if (!storage) {
        storage = [];
    }
    storage.unshift(inserted_data);
    return localStorage.setItem(localstorage_name, JSON.stringify(storage))
}

function localstorageUpdate(localstorage_name, key, value, new_key, new_value) {
    let storage = JSON.parse(localStorage.getItem(localstorage_name));
    if (!storage) {
        storage = [];
    }
    storage.forEach(element => {
        if (element[key] === value) {
            element[new_key] = new_value;
        }
    });
    return localStorage.setItem(localstorage_name, JSON.stringify(storage))
}

function localstorageDelete(localstorage_name, del) {
    let storage = JSON.parse(localStorage.getItem(localstorage_name));
    if (!storage) {
        storage = [];
    }
    let target_index = storage.findIndex(del)
    if (target_index != -1) {
        storage.splice(target_index, 1)
        return localStorage.setItem(localstorage_name, JSON.stringify(storage))
    }
}
