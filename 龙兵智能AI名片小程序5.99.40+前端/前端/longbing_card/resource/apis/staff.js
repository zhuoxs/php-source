Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _xx_request = require("../js/xx_request.js");

exports.default = {
    getClientView: function(e) {
        return _xx_request.req.post("clientView", e);
    },
    getAiHeader: function(e) {
        return _xx_request.req.post("aiBehaviorHeader", e);
    },
    getAiOther: function(e) {
        return _xx_request.req.post("aiBehaviorOther", e);
    },
    getMessageList: function(e) {
        return _xx_request.req.post("chat", e);
    },
    getAddReply: function(e) {
        return _xx_request.req.post("AddReply", e);
    },
    getEditReply: function(e) {
        return _xx_request.req.post("EditReply", e);
    },
    getDelReply: function(e) {
        return _xx_request.req.post("DelReply", e);
    },
    getReplyList: function(e) {
        return _xx_request.req.post("ReplyList", e);
    },
    getSource: function(e) {
        return _xx_request.req.post("Source", e);
    },
    getChatId: function(e) {
        return _xx_request.req.post("chatId", e);
    },
    getMessages: function(e) {
        return _xx_request.req.post("messages", e);
    },
    getSendTemplate: function(e) {
        return _xx_request.req.post("SendTemplate", e);
    },
    getSendTemplateCilent: function(e) {
        return _xx_request.req.post("SendTemplateCilent", e);
    },
    getQuestion: function(e) {
        return _xx_request.req.post("question", e);
    },
    setQuestion: function(e) {
        return _xx_request.req.post("questionsub", e);
    },
    getRateTotal: function(e) {
        return _xx_request.req.post("turnoverRateTotal", e);
    },
    getLabels: function(e) {
        return _xx_request.req.post("Labels", e);
    },
    getInsertLabel: function(e) {
        return _xx_request.req.post("insertLabel", e);
    },
    getDelLabel: function(e) {
        return _xx_request.req.post("DeleteLabel", e);
    },
    getOftenLabel: function(e) {
        return _xx_request.req.post("oftenLabel", e);
    },
    getClientInfo: function(e) {
        return _xx_request.req.post("clientInfo", e);
    },
    getEditClient: function(e) {
        return _xx_request.req.post("editClient", e);
    },
    getDealDate: function(e) {
        return _xx_request.req.post("DealDate", e);
    },
    getRate: function(e) {
        return _xx_request.req.post("Rate", e);
    },
    getfollowInsert: function(e) {
        return _xx_request.req.post("followInsert", e);
    },
    getDeal: function(e) {
        return _xx_request.req.post("Deal", e);
    },
    getCancelDeal: function(e) {
        return _xx_request.req.post("CancelDeal", e);
    },
    getCheckDeal: function(e) {
        return _xx_request.req.post("CheckDeal", e);
    },
    getInterest: function(e) {
        return _xx_request.req.post("Interest", e);
    },
    getActivity: function(e) {
        return _xx_request.req.post("Activity", e);
    },
    getClientInteraction: function(e) {
        return _xx_request.req.post("clientInteraction", e);
    },
    getFollowUpdate: function(e) {
        return _xx_request.req.post("FollowUpdate", e);
    },
    getFollowDelete: function(e) {
        return _xx_request.req.post("FollowDelete", e);
    },
    getfirstTime: function(e) {
        return _xx_request.req.post("firstTime", e);
    },
    getSearchList: function(e) {
        return _xx_request.req.post("search", e);
    },
    getStarMark: function(e) {
        return _xx_request.req.post("msgstart", e);
    },
    getStarMarkList: function(e) {
        return _xx_request.req.post("startclient", e);
    },
    getLabelList: function(e) {
        return _xx_request.req.post("msglabel", e);
    },
    getLabelUserList: function(e) {
        return _xx_request.req.post("labeldetail", e);
    },
    getLabelEdit: function(e) {
        return _xx_request.req.post("labeledit", e);
    },
    getGroupSend: function(e) {
        return _xx_request.req.post("msgsend", e);
    },
    getGroupRecord: function(e) {
        return _xx_request.req.post("msgrecord", e);
    },
    getAdminRecord: function(e) {
        return _xx_request.req.post("msgadmin", e);
    },
    getCodeQr: function(e) {
        return _xx_request.req.post("releaseQrDetailV2", e);
    },
    getGroupPeople: function(e) {
        return _xx_request.req.post("groupPeople", e);
    },
    setGroupNum: function(e) {
        return _xx_request.req.post("SetGroupNumber", e);
    },
    getGroupRank: function(e) {
        return _xx_request.req.post("GroupRank", e);
    },
    getTurnoverRate: function(e) {
        return _xx_request.req.post("turnoverRate", e);
    },
    getInteraction: function(e) {
        return _xx_request.req.post("interaction", e);
    },
    getExtStatistics: function(e) {
        return _xx_request.req.post("extensionStatistics", e);
    },
    getReleaseQr: function(e) {
        return _xx_request.req.post("releaseQr", e);
    },
    getDelQr: function(e) {
        return _xx_request.req.post("DeleteQr", e);
    },
    getReleaseQrList: function(e) {
        return _xx_request.req.post("releaseQrList", e);
    },
    getAddTimeLine: function(e) {
        return _xx_request.req.post("releaseTimeline", e);
    },
    getDelTimeLine: function(e) {
        return _xx_request.req.post("DeleteTimeline", e);
    },
    getTimeLine: function(e) {
        return _xx_request.req.post("myTimeline", e);
    },
    getExtensions: function(e) {
        return _xx_request.req.post("extensions", e);
    },
    setExtension: function(e) {
        return _xx_request.req.post("extension", e);
    },
    getExtDetail: function(e) {
        return _xx_request.req.post("extensionDetailV2", e);
    },
    getStaffInfo: function(e) {
        return _xx_request.req.post("Staff", e);
    },
    getStaffCardInfo: function(e) {
        return _xx_request.req.post("StaffCard", e);
    },
    getUnread: function(e) {
        return _xx_request.req.post("Unread", e);
    },
    getFormIds: function(e) {
        return _xx_request.req.post("FormIds", e);
    },
    getOrderManage: function(e) {
        return _xx_request.req.post("stafforder", e);
    },
    getStaffCouponList: function(e) {
        return _xx_request.req.post("couponstafflist", e);
    },
    getCouponClean: function(e) {
        return _xx_request.req.post("couponclean", e);
    },
    getCouponUserList: function(e) {
        return _xx_request.req.post("coupongetlist", e);
    },
    toCheckPassword: function(e) {
        return _xx_request.req.post("shopwriteoff", e);
    },
    toDelPoster: function(e) {
        return _xx_request.req.post("myposterdel", e);
    },
    toAddMyShop: function(e) {
        return _xx_request.req.post("myshopadd", e);
    },
    toDelMyShop: function(e) {
        return _xx_request.req.post("myshopdel", e);
    },
    toGetOrderQr: function(e) {
        return _xx_request.req.post("shoporderqr", e);
    }
};