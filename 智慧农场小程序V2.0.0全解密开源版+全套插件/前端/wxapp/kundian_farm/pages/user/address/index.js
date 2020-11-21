var t = new getApp(), s = t.siteInfo.uniacid;

Page({
    data: {
        uid: "",
        region: [ "北京市", "北京市", "东城区" ],
        region_str: "",
        detail_add: "",
        showBox: !1,
        addList: [],
        editList: [],
        is_select: !1
    },
    onLoad: function(t) {
        var s = wx.getStorageSync("kundian_farm_uid");
        this.setData({
            uid: s,
            is_select: t.is_select || !1
        }), this.getAddressList();
    },
    getAddressList: function(e) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var a = this, d = this.data.uid;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "addressList",
                uniacid: s,
                uid: d
            },
            success: function(t) {
                a.setData({
                    addList: t.data.addList
                }), wx.hideLoading(), console.log(a.data.addList);
            }
        });
    },
    bindRegionChange: function(t) {
        var s = t.detail.value;
        this.setData({
            region_str: s[0] + " " + s[1] + " " + s[2]
        });
    },
    getLocation: function(t) {
        var s = this;
        wx.chooseLocation({
            success: function(t) {
                s.setData({
                    detail_add: t.address
                });
            }
        });
    },
    saveAddress: function(e) {
        wx.showLoading({
            title: "正在保存..."
        });
        var a = this, d = e.detail.value, i = d.phone, n = d.name, o = d.detail_add, c = e.detail.formId, r = this.data, u = r.region_str, l = r.uid, h = r.editList;
        "" != n ? "" != i ? "" != u && "" != o ? t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "saveAddress",
                operation: "add",
                region: u,
                address: o,
                phone: i,
                name: n,
                uid: l,
                uniacid: s,
                formId: c,
                id: h.id || ""
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function() {
                        0 == t.data.code && (a.setData({
                            showBox: !1
                        }), a.getAddressList());
                    }
                }), wx.hideLoading();
            }
        }) : wx.showToast({
            title: "请填写完整的地址",
            icon: "none"
        }) : wx.showToast({
            title: "请填写联系电话",
            icon: "none"
        }) : wx.showToast({
            title: "请填写收货姓名",
            icon: "none"
        });
    },
    changeDeafult: function(e) {
        var a = this, d = e.currentTarget.dataset, i = d.addid, n = d.isdefault, o = e.detail.value, c = this.data.uid;
        1 != n && t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                operation: "changeDefault",
                op: "saveAddress",
                id: i,
                is_default: o,
                uid: c,
                uniacid: s
            },
            success: function(t) {
                console.log(t), wx.showToast({
                    title: t.data.msg,
                    icon: "none"
                }), a.getAddressList();
            }
        });
    },
    handAdd: function(t) {
        var s = this;
        this.setData({
            showBox: !s.data.showBox,
            editList: [],
            detail_add: "",
            region_str: ""
        });
    },
    editAdd: function(t) {
        var s = this.data.addList, e = t.currentTarget.dataset.addid, a = [];
        s.map(function(t) {
            t.id == e && (a = t);
        }), this.setData({
            editList: a,
            detail_add: a.address,
            region_str: a.region,
            showBox: !0
        });
    },
    deleteAdd: function(e) {
        var a = this, d = e.currentTarget.dataset, i = d.addid, n = d.sub, o = this.data, c = o.uid, r = o.addList;
        wx.showModal({
            title: "提示",
            content: "确认要删除该地址吗？",
            success: function(e) {
                e.confirm && t.util.request({
                    url: "entry/wxapp/class",
                    data: {
                        control: "user",
                        operation: "deleteAdd",
                        op: "saveAddress",
                        id: i,
                        uid: c,
                        uniacid: s
                    },
                    success: function(t) {
                        wx.showToast({
                            title: t.data.msg,
                            icon: "none",
                            duration: 2e3,
                            success: function() {
                                r.splice(n, 1), a.setData({
                                    addList: r
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    wxAdd: function(e) {
        var a = this, d = a.data.uid;
        wx.chooseAddress({
            success: function(e) {
                t.util.request({
                    url: "entry/wxapp/class",
                    data: {
                        control: "user",
                        op: "saveAddress",
                        operation: "add",
                        region: e.provinceName + " " + e.cityName + " " + e.countyName,
                        address: e.detailInfo,
                        phone: e.telNumber,
                        name: e.userName,
                        uid: d,
                        uniacid: s
                    },
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            showCancel: !1,
                            success: function() {
                                0 == t.data.code && a.getAddressList();
                            }
                        });
                    }
                });
            }
        });
    },
    selectAddress: function(t) {
        var s = t.currentTarget.dataset.sub, e = this.data, a = e.addList, d = e.uid, i = a[s];
        wx.setStorageSync("selectAdd_" + d, i), wx.navigateBack({
            delta: 1
        });
    }
});