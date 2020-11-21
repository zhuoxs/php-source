Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _xx_request = require("../js/xx_request.js");

exports.default = {
    getFormId: function(e) {
        return _xx_request.req.post("formid", e);
    },
    getOverview: function(e) {
        return _xx_request.req.post("BossOverview", e);
    },
    getRankClients: function(e) {
        return _xx_request.req.post("BossRankClients", e);
    },
    getRankOrder: function(e) {
        return _xx_request.req.post("BossRankOrder", e);
    },
    getRankInteraction: function(e) {
        return _xx_request.req.post("BossRankInteraction", e);
    },
    getRankRate: function(e) {
        return _xx_request.req.post("BossRankRate", e);
    },
    getClients: function(e) {
        return _xx_request.req.post("BossClients", e);
    },
    getClientList: function(e) {
        return _xx_request.req.post("clientList", e);
    },
    getAi: function(e) {
        return _xx_request.req.post("BossAiV2", e);
    },
    getStaffNumber: function(e) {
        return _xx_request.req.post("BossStaffNumber", e);
    },
    getStaffEchart: function(e) {
        return _xx_request.req.post("bossstaffnineanalysis", e);
    },
    getStaffView: function(e) {
        return _xx_request.req.post("aiTime", e);
    },
    getStaffFollow: function(e) {
        return _xx_request.req.post("followList", e);
    }
};