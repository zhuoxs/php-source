Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _xx_request = require("../js/xx_request.js");

exports.default = {
    getEditStaffV2: function(e) {
        return _xx_request.req.post("EditStaffV2", e);
    },
    getCollectionList: function(e) {
        return _xx_request.req.post("cardsV2", e);
    },
    getCardIndexData: function(e) {
        return _xx_request.req.post("cardV5", e);
    },
    getCardShow: function(e) {
        return _xx_request.req.get("cardshowv2", e);
    },
    getCardAfter: function(e) {
        return _xx_request.req.post("cardafterv2", e);
    },
    getEditPraiseStatus: function(e) {
        return _xx_request.req.post("thumbs", e);
    },
    getForwardRecord: function(e) {
        return _xx_request.req.post("Forward", e);
    },
    getCopyRecord: function(e) {
        return _xx_request.req.post("copyRecord", e);
    },
    getShareRecord: function(e) {
        return _xx_request.req.post("record", e);
    },
    getShareInfo: function(e) {
        return _xx_request.req.post("getShare", e);
    },
    getCodeRecord: function(e) {
        return _xx_request.req.post("customQrRecordInsert", e);
    },
    getShopTypes: function(e) {
        return _xx_request.req.post("ShopTypesV2", e);
    },
    getShopList: function(e) {
        return _xx_request.req.post("ShopGoods", e);
    },
    getShopSearch: function(e) {
        return _xx_request.req.post("ShopSearch", e);
    },
    getShopSearchRecord: function(e) {
        return _xx_request.req.post("ShopSearchRecord", e);
    },
    getShopGoodsDetail: function(e) {
        return _xx_request.req.post("ShopGoodsDetail", e);
    },
    getShopCollageList: function(e) {
        return _xx_request.req.post("shopcollagelist", e);
    },
    getShopAddTro: function(e) {
        return _xx_request.req.post("ShopAddTrolley", e);
    },
    getShopUpTro: function(e) {
        return _xx_request.req.post("ShopUpdateTrolley", e);
    },
    getShopDelTro: function(e) {
        return _xx_request.req.post("ShopDelTrolley", e);
    },
    getShopMyTrolley: function(e) {
        return _xx_request.req.post("ShopMyTrolley", e);
    },
    getProductOrder: function(e) {
        return _xx_request.req.post("shopplaceorder", e);
    },
    getOnlyOrder: function(e) {
        return _xx_request.req.post("shopplaceorder2", e);
    },
    getCollageOrder: function(e) {
        return _xx_request.req.post("shopstartcollage", e);
    },
    getJoinCollageOrder: function(e) {
        return _xx_request.req.post("shopjoincollage", e);
    },
    getNewsList: function(e) {
        return _xx_request.req.post("timeline", e);
    },
    getThumbs: function(e) {
        return _xx_request.req.post("timelineThumbs", e);
    },
    getComment: function(e) {
        return _xx_request.req.post("timelineComment", e);
    },
    getNewThumbsComment: function(e) {
        return _xx_request.req.post("timelineNew", e);
    },
    getTimeLineDetail: function(e) {
        return _xx_request.req.post("timelineDetail", e);
    },
    getModular: function(e) {
        return _xx_request.req.post("modularV2", e);
    },
    getModularInfo: function(e) {
        return _xx_request.req.post("modularInfo", e);
    },
    getModularList: function(e) {
        return _xx_request.req.post("modularList", e);
    },
    getModularForm: function(e) {
        return _xx_request.req.post("modularform", e);
    },
    getPosterType: function(e) {
        return _xx_request.req.post("postertypeV3", e);
    },
    getMyPoster: function(e) {
        return _xx_request.req.post("myposter", e);
    },
    getSavePoster: function(e) {
        return _xx_request.req.post("insertposter", e);
    },
    getTagsList: function(e) {
        return _xx_request.req.post("tags", e);
    },
    getTagsClick: function(e) {
        return _xx_request.req.post("tagsclick", e);
    },
    getAddDeleteTags: function(e) {
        return _xx_request.req.post("tagsset", e);
    },
    getAddressList: function(e) {
        return _xx_request.req.post("shopmyaddress", e);
    },
    getAddDefault: function(e) {
        return _xx_request.req.post("ShopAddressDefault", e);
    },
    getAddAddress: function(e) {
        return _xx_request.req.post("shopAddAddress", e);
    },
    getDelAddress: function(e) {
        return _xx_request.req.post("shopdeladdress", e);
    },
    getShopCollNum: function(e) {
        return _xx_request.req.post("shopcollagenumber", e);
    },
    getShopColl: function(e) {
        return _xx_request.req.post("shopmycollage", e);
    },
    getShopMyOrder: function(e) {
        return _xx_request.req.post("shopmyorder", e);
    },
    getShopOrderDetail: function(e) {
        return _xx_request.req.post("shopmyorderdetail", e);
    },
    getShopCancelOrder: function(e) {
        return _xx_request.req.post("shopcancelorder", e);
    },
    getShopDelOrder: function(e) {
        return _xx_request.req.post("shopdelorder", e);
    },
    getShopEndOrder: function(e) {
        return _xx_request.req.post("shopendorder", e);
    },
    getShopRefund: function(e) {
        return _xx_request.req.post("Refund", e);
    },
    getOrderRefund: function(e) {
        return _xx_request.req.post("orderapplirefund", e);
    },
    getOrderCancelRefund: function(e) {
        return _xx_request.req.post("ordercancelrefund", e);
    },
    getWxPay: function(e) {
        return _xx_request.req.post("Pay", e);
    },
    getCouponAll: function(e) {
        return _xx_request.req.post("couponall", e);
    },
    getCoupon: function(e) {
        return _xx_request.req.post("couponget", e);
    },
    getCouponList: function(e) {
        return _xx_request.req.post("couponlist", e);
    },
    getCouponQr: function(e) {
        return _xx_request.req.post("couponqr", e);
    },
    getSouponshop: function(e) {
        return _xx_request.req.post("couponshop", e);
    },
    getCouponTest: function(e) {
        return _xx_request.req.post("coupon/test", e);
    },
    getMyEarning: function(e) {
        return _xx_request.req.post("sellingprofit", e);
    },
    getEarning: function(e) {
        return _xx_request.req.post("sellingcashdetail", e);
    },
    getDistribution: function(e) {
        return _xx_request.req.post("sellingwater", e);
    },
    getCommission: function(e) {
        return _xx_request.req.post("sellingwateruser", e);
    },
    getWithdraw: function(e) {
        return _xx_request.req.post("sellingcash", e);
    },
    getWithdrawList: function(e) {
        return _xx_request.req.post("sellingcashrecord", e);
    }
};