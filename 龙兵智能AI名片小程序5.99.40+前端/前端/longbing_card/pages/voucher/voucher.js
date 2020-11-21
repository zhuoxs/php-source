var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {},
    onLoad: function(t) {
        var e = _xx_util2.default.getPage(-1).data.cardIndexData, a = e.coupon, u = e.to_uid;
        a.to_uid = u, this.setData({
            coupon: a,
            globalData: app.globalData
        });
    },
    onShareAppMessage: function(t) {
        var e = this.data.coupon, a = wx.getStorageSync("userid"), u = "/longbing_card/pages/index/index?to_uid=" + e.to_uid + "&from_id=" + a + "&currentTabBar=toCard";
        return console.log(u, "==> shar_path"), {
            title: e.title,
            path: u,
            imageUrl: "https://retail.xiaochengxucms.com/images/2/2019/01/mFL0pH86Fd8bsLS3HF98oIJeFdcs6F.png"
        };
    },
    toJump: function(t) {
        "toJumpUrl" == _xx_util2.default.getData(t).status && _xx_util2.default.goUrl(t);
    }
});