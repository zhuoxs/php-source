var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: {
            page: 1,
            total_page: 1,
            list: [],
            refresh: !1,
            loading: !0
        },
        tagType: []
    },
    onLoad: function(t) {
        var a = this;
        wx.hideShareMenu(), a.setData({
            globalData: app.globalData,
            "dataList.refresh": !1
        }, function() {
            a.toGetLabelList();
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            "dataList.page": 1,
            "dataList.refresh": !0
        }, function() {
            wx.showNavigationBarLoading(), t.toGetLabelList();
        });
    },
    toSearchCardBlur: function() {
        this.setData({
            toSearchCard: !1
        });
    },
    toSearchCard: function(t) {
        var a = t.detail.value;
        this.setData({
            cardSearchKey: a
        });
    },
    toSearchCardConfirm: function() {
        var t = this;
        t.setData({
            refreshCardList: !0
        }, function() {
            t.toGetLabelList();
        });
    },
    toGetLabelList: function() {
        var e = this, t = e.data, a = t.cardSearchKey, i = t.dataList, r = t.tagType, s = {};
        a && (s.keyword = a), i.refresh || _xx_util2.default.showLoading(), _index.staffModel.getLabelList(s).then(function(t) {
            for (var a in _xx_util2.default.hideAll(), console.log("getLabelList ==>", t.data), 
            i.list = t.data, i.refresh = !1, i.loading = !1, i.page = 1, i.total_page = 1, i.list) r.push(0);
            e.setData({
                dataList: i,
                tagType: r
            });
        });
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t), i = e.status, r = e.type, s = e.index;
        if ("toSearchCardFocus" == i) a.setData({
            toSearchCard: !0
        }); else if ("toJumpUrl" == i) {
            if ("toSend" == r) if (!a.data.check_lable_count) return wx.showModal({
                title: "",
                content: "请选择将要进行群发的标签组！",
                success: function(t) {
                    t.confirm;
                }
            }), !1;
            _xx_util2.default.goUrl(t);
        } else if ("toCheckTag" == i) {
            var l = a.data, o = l.tagType, n = l.dataList, u = 0;
            0 == r && (u = 1), o[s] = u;
            var d = 0, c = "", f = "";
            for (var h in o) 1 == o[h] && (d += o[h], c += n.list[h].lable_id + ",", f += n.list[h].name + "(" + n.list[h].count + ")，");
            c = c.slice(0, -1), f = f.slice(0, -1), a.setData({
                tagType: o,
                check_lable_count: d,
                check_lable_id: c,
                check_lable_name: f
            });
        }
    }
});