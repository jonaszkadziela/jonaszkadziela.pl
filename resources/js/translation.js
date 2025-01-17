function get(obj, path, defaultValue = undefined) {
    const travel = regexp => String.prototype.split
        .call(path, regexp)
        .filter(Boolean)
        .reduce((res, key) => (res !== null && res !== undefined ? res[key] : res), obj)

    const result = travel(/[,[\]]+?/) || travel(/[,[\].]+?/)

    return result === undefined || result === obj ? defaultValue : result
}

export function hasTranslation(translations, key) {
    return translations &&
        translations[Lang.getLocale()] !== undefined &&
        get(translations[Lang.getLocale()], key) !== undefined
}

export function getTranslation(translations, key) {
    if (hasTranslation(translations, key) === false) {
        return key
    }

    return get(translations[Lang.getLocale()], key)
}
