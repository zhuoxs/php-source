var api = require("./baseapi");

api.getCstoreGetStore = function(e) {
    return this.post("Cstore|getStore", e, 0, !1);
}, module.exports = api;