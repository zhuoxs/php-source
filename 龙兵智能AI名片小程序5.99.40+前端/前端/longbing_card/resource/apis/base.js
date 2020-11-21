Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _xx_request = require("../js/xx_request.js");

exports.default = {
    toUpload: function(e) {
        return (0, _xx_request.uploadFile)("upload", e);
    },
    getLogin: function(e) {
        return _xx_request.req.post("inlogin", e);
    },
    getBind: function(e) {
        return _xx_request.req.post("binduser", e);
    },
    getCopyRecord: function(e) {
        return _xx_request.req.post("copyRecord", e);
    },
    getFormId: function(e) {
        return _xx_request.req.post("formid", e);
    },
    getConfig: function(e) {
        return _xx_request.req.post("configV4", e);
    },
    getInConfig: function(e) {
        return _xx_request.req.post("inconfig", e);
    },
    getUserPhone: function(e) {
        return _xx_request.req.post("UserPhone", e);
    },
    getPhone: function(e) {
        return _xx_request.req.post("phone", e);
    },
    getUserInfo: function(e) {
        return _xx_request.req.post("userinfo", e);
    },
    getUpdateUserInfo: function(e) {
        return _xx_request.req.post("update", e);
    },
    getChatInfo: function(e) {
        return _xx_request.req.post("messageinfo", e);
    },
    getShareimg: function(e) {
        return _xx_request.req.get("getshareimg", e);
    },
    getReport: function(e) {
        return _xx_request.req.post("radarreport", e);
    }
};