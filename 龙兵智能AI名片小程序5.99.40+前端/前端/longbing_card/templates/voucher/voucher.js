var _that = void 0, _userModel = void 0, _util = void 0;

function getVoucher(t, a, o, e) {
    _that = t, _userModel = a, _util = o;
    var u = e.detail, h = u.encryptedData, n = u.iv;
    if (h && n && (console.log(h, n), t.setPhoneInfo(h, n), _that.data.cardIndexData.coupon.id)) {
        var r = {
            to_uid: _that.data.paramData.to_uid,
            coupon_id: _that.data.cardIndexData.coupon.id
        };
        _userModel.getCoupon(r).then(function(t) {
            _util.hideAll(), _that.setData({
                "voucherStatus.status": "receive"
            }, function() {
                toShareVoucher();
            });
        });
    }
}

function setPhoneInfo(t, a) {
    var o = {
        encryptedData: t,
        iv: a,
        to_uid: getApp().globalData.to_uid
    };
    _baseModel.getPhone(o).then(function(t) {
        if (util.hideAll(), t.data) {
            var a = wx.getStorageSync("user");
            a.phone = t.data.phone, wx.setStorageSync("user", a);
        }
        getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
        _that.setData({
            "globalData.hasClientPhone": !0,
            "globalData.auth.authPhoneStatus": !0
        });
    });
}

function toGetCoupon(t, a, o) {
    _userModel = a, _util = o;
    var e = {
        to_uid: (_that = t).data.paramData.to_uid,
        coupon_id: _that.data.cardIndexData.coupon.id
    };
    _userModel.getCoupon(e).then(function(t) {
        _util.hideAll(), _that.setData({
            "voucherStatus.status": "receive"
        }, function() {
            toShareVoucher();
        });
    });
}

function toShareVoucher(t) {
    _that = t, wx.navigateTo({
        url: "/longbing_card/pages/voucher/voucher"
    });
}

function toBigVoucher(t) {
    (_that = t).setData({
        "voucherStatus.show": !0
    });
}

function toCloseVoucher(t) {
    "voulist" == (_that = t).data.currPage ? _that.setData({
        "voucherStatus.show": !1
    }) : _that.setData({
        "voucherStatus.show": -1
    }, setTimeout(function() {
        _that.setData({
            "voucherStatus.show": !1
        });
    }, 500));
}

module.exports = {
    getVoucher: getVoucher,
    toGetCoupon: toGetCoupon,
    toBigVoucher: toBigVoucher,
    toShareVoucher: toShareVoucher,
    toCloseVoucher: toCloseVoucher
};