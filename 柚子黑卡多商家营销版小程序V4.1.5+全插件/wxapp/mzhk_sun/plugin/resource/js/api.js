/*   time:2019-08-09 13:18:38*/
var api = require("./baseapi");
api.getCstoreGetStore = function(e) {
    return this.post("Cstore|getStore", e, 0, !1)
}, module.exports = api;