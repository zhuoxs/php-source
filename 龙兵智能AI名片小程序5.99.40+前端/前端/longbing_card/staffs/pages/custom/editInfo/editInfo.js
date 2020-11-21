var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        setCount: [ {
            name: "男"
        }, {
            name: "女"
        } ],
        count: -1,
        date: "",
        clientData: []
    },
    onLoad: function(t) {
        var e = this;
        console.log(t, "options为页面跳转所带来的参数"), _xx_util2.default.showLoading(), wx.hideShareMenu();
        var a = {};
        t.id && (a.id = t.id), t.fromstatus && (a.fromstatus = t.fromstatus), t.staff_id && (a.staff_id = t.staff_id), 
        e.setData({
            param: a,
            globalData: app.globalData
        }, function() {
            e.shuaxin(), _xx_util2.default.hideAll();
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        wx.showNavigationBarLoading(), t.setData({
            showClientSource: !1
        }, function() {
            t.shuaxin(1);
        });
    },
    shuaxin: function(u) {
        var s = this, t = {
            client_id: s.data.param.id
        }, e = s.data.param;
        e.staff_id && (t.staff_id = e.staff_id), _index.staffModel.getClientInfo(t).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = t.data;
                for (var a in e.info) "undefined" != e.info[a] && null != _typeof(e.info[a]) || (e.info[a] = "");
                var i = e.info.sex;
                i || (i = "-1");
                var n = e.share_str, o = {};
                if (-1 < n.indexOf("//XL:")) {
                    var r = n.split("//XL:");
                    o.clientSourceStr = r, o.clientSourceType = "group";
                }
                s.setData({
                    clientData: e,
                    count: i,
                    showClientSourceData: o,
                    date: e.info.birthday
                }), u && wx.stopPullDownRefresh();
            }
        });
    },
    listenerDatePickerSelected: function(t) {
        var e = t.detail.value;
        this.setData({
            date: e
        });
    },
    pickerSelected: function(t) {
        var e = t.detail.value;
        e && this.setData({
            count: e,
            "froms.sex": e
        });
    },
    blur_name: function(t) {
        var e = t.detail.value;
        e && this.setData({
            "froms.name": e
        });
    },
    switchChange: function(t) {
        if (this.data.param.fromstatus) return !1;
        t.detail.value && this.setData({
            "froms.is_mask": t.detail.value
        });
    },
    toEditInfo: function(t) {
        _index.staffModel.getEditClient(t).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && wx.showToast({
                icon: "none",
                title: "客户信息修改成功！",
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        wx.navigateBack();
                    }, 2e3);
                }
            });
        });
    },
    toJump: function(t) {
        var e = t.currentTarget.dataset.status;
        "toSource" == e ? this.setData({
            showClientSource: !0
        }) : "toClose" == e && this.setData({
            showClientSource: !1
        });
    },
    validate: function(t) {
        var e = t.phone, a = t.email, i = new _xx_util2.default.Validate();
        return _xx_util2.default.isEmpty(e) || i.add(e, "isMobile", "请填写11位手机号"), _xx_util2.default.isEmpty(a) || i.add(a, "isEmail", "请填写正确的邮箱地址"), 
        i.start();
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.formId, i = t.detail.target.dataset.status;
        if (_index.baseModel.getFormId({
            formId: a
        }), "toEditStaff" == i) {
            var n = t.detail.value;
            n.client_id = e.data.param.id;
            var o = e.data.count;
            for (var r in "-1" != o && "undefined" != o || (o = ""), n.sex = o, n.birthday = e.data.date, 
            n) "undefined" == n[r] && (n[r] = "");
            0 == n.is_mask ? n.is_mask = 0 : n.is_mask = 1;
            var u = this.validate(n);
            if (u) return void _xx_util2.default.showModal({
                content: u
            });
            e.toEditInfo(n);
        }
    }
});