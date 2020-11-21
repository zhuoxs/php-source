function isValidUrl(t) {
    return /(ht|f)tp(s?):\/\/([^ \\/]*\.)+[^ \\/]*(:[0-9]+)?\/?/.test(t);
}

module.exports = {
    isValidUrl: isValidUrl
};