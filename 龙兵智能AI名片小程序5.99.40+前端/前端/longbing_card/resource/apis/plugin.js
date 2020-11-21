Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _xx_request = require("../js/xx_request.js");

exports.default = {
    getPayConfig: function(t) {
        return _xx_request.req.post("payqrConfig", t);
    },
    toPayQrPay: function(t) {
        return _xx_request.req.post("PayqrPay", t);
    },
    getPayGoods: function(t) {
        return _xx_request.req.post("payqrGoods", t);
    },
    getReserveCate: function(t) {
        return _xx_request.req.post("appointclassify", t);
    },
    getReserveList: function(t) {
        return _xx_request.req.post("appointproject", t);
    },
    getReserveDetail: function(t) {
        return _xx_request.req.post("appointdetail", t);
    },
    toReserveBook: function(t) {
        return _xx_request.req.post("appointbook", t);
    },
    getUserResList: function(t) {
        return _xx_request.req.post("appointlist", t);
    },
    getStaffResList: function(t) {
        return _xx_request.req.post("appointliststaff", t);
    },
    toResConfirm: function(t) {
        return _xx_request.req.post("appointcomplete", t);
    },
    toResCancel: function(t) {
        return _xx_request.req.post("appointcancel", t);
    },
    getResDetail: function(t) {
        return _xx_request.req.post("appointrecorddetail", t);
    },
    getArticleCate: function(t) {
        return _xx_request.req.post("inmarclassify", t);
    },
    getArticleList: function(t) {
        return _xx_request.req.post("inmararticle", t);
    },
    getMyArticle: function(t) {
        return _xx_request.req.post("inmarmyarticle", t);
    },
    getArticleDetail: function(t) {
        return _xx_request.req.post("inmararticledetail", t);
    },
    getArticleQr: function(t) {
        return _xx_request.req.post("articleqr", t);
    },
    toDelMyArticle: function(t) {
        return _xx_request.req.post("inmardelarticle", t);
    },
    toSyncMyNews: function(t) {
        return _xx_request.req.post("inmarsyncarticle", t);
    },
    toSyncMyArticle: function(t) {
        return _xx_request.req.post("inmarsyncmyarticle", t);
    },
    toArticleShare: function(t) {
        return _xx_request.req.post("articleshare", t);
    },
    toArticleImport: function(t) {
        return _xx_request.req.post("inmararticleimport", t);
    },
    getArticleUrl: function(t) {
        return _xx_request.req.post("articleurl", t);
    },
    getViewRecord: function(t) {
        return _xx_request.req.post("inmarviewdetail", t);
    },
    getUserRecord: function(t) {
        return _xx_request.req.post("inmarclientdetailed", t);
    },
    getUserRank: function(t) {
        return _xx_request.req.post("inmarrankclient", t);
    },
    getRankRecord: function(t) {
        return _xx_request.req.post("inmarstaffclientdetail", t);
    },
    getArticleRank: function(t) {
        return _xx_request.req.post("inmarrankarticle", t);
    },
    getArticleRankList: function(t) {
        return _xx_request.req.post("inmararticleextensiondetails", t);
    },
    toConfirmSync: function(t) {
        return _xx_request.req.post("inmarconfirmsync", t);
    },
    getEnrollCate: function(t) {
        return _xx_request.req.post("activityclassify", t);
    },
    getEnrollList: function(t) {
        return _xx_request.req.post("activitylist", t);
    },
    getEnrollDetail: function(t) {
        return _xx_request.req.post("activitydetail", t);
    },
    getEnrollSign: function(t) {
        return _xx_request.req.post("activitysign", t);
    },
    getMyEnrList: function(t) {
        return _xx_request.req.post("activitymy", t);
    },
    getEnrSignDetail: function(t) {
        return _xx_request.req.post("activitysigndetail", t);
    },
    getUserEnrForm: function(t) {
        return _xx_request.req.post("activityuserdetail", t);
    },
    getEnrFormItem: function(t) {
        return _xx_request.req.post("activitysignitem", t);
    },
    toAddEnroll: function(t) {
        return _xx_request.req.post("activityadd", t);
    }
};