var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        Unchanged: [],
        lists: [],
        addsInput: "",
        clickIndex: "0"
    },
    oftenLabel: function() {
        var e = this;
        _index.staffModel.getOftenLabel().then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                Unchanged: t.data
            });
        });
    },
    Labels: function() {
        var e = this, t = {
            target_id: e.data.param.id
        }, a = e.data.param;
        a.staff_id && (t.staff_id = a.staff_id), _index.staffModel.getLabels(t).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                lists: t.data
            });
        });
    },
    onLoad: function(t) {
        _xx_util2.default.showLoading(), wx.hideShareMenu();
        var e = {
            id: t.id,
            fromstatus: t.fromstatus,
            staff_id: t.staff_id
        };
        this.setData({
            globalData: app.globalData,
            param: e
        }), this.oftenLabel(), this.Labels(), _xx_util2.default.hideAll();
    },
    return1: function(t) {
        this.data.addsInput ? this.getInsertLabel() : wx.navigateBack({
            delta: 1
        });
    },
    bindinput: function(t) {
        this.setData({
            addsInput: t.detail.value
        });
    },
    bindbulr: function(t) {
        this.getInsertLabel();
    },
    blur_addsInput: function(t) {
        this.getInsertLabel();
    },
    getInsertLabel: function() {
        var e = this, a = this;
        if (!a.data.addsInput) return wx.showToast({
            icon: "none",
            title: "请填写标签!",
            duration: 2e3
        }), !1;
        var t = {
            target_id: a.data.param.id,
            label: a.data.addsInput
        };
        _index.staffModel.getInsertLabel(t).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && (a.setData({
                addsInput: ""
            }), a.Labels(), e.oftenLabel());
        });
    },
    lableclick: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            clickIndex: e
        });
    },
    lableclick2: function(t) {
        var e = this, a = t.currentTarget.dataset.name, i = e.data.param.id;
        _index.staffModel.getInsertLabel({
            target_id: i,
            label: a
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.toGetLabels(i);
        });
    },
    reduce: function(t) {
        var i = this, e = i.data.param.id, a = i.data, n = a.lists, l = a.Unchanged, d = _xx_util2.default.getData(t), s = d.id, r = d.lableid;
        _index.staffModel.getDelLabel({
            id: s,
            target_id: e
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                for (var e in n) n[e].lable_id == r && n.splice(e, 1);
                for (var a in l) l[a].id == r && l.splice(a, 1);
                i.setData({
                    lists: n,
                    Unchanged: l
                });
            }
        });
    },
    toGetLabels: function(t) {
        var e = this;
        _index.staffModel.getLabels({
            target_id: t
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                lists: t.data
            });
        });
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), wx.stopPullDownRefresh(), this.oftenLabel(), this.Labels();
    }
});