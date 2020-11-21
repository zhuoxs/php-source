var t = getApp().requirejs("core");

Page({
    data: {
        yearShow: "",
        monthShow: "",
        json_arr: {},
        advaward: {},
        calendar: [],
        months: [],
        member: {},
        set: {},
        signinfo: {},
        dateHidden: 1,
        orderday: "",
        sum: "",
        credit: "",
        loading: !1,
        loaded: !1
    },
    toSignrecord: function(t) {
        wx.navigateTo({
            url: "records"
        });
    },
    toDate: function(t) {
        this.setData({
            dateHidden: !this.data.dateHidden
        });
    },
    onLoad: function(t) {
        t = t || {}, this.getList();
    },
    getList: function() {
        var a = this;
        t.loading(), this.setData({
            loading: !0
        }), t.get("changce/sign/get_list", {
            year: a.data.yearShow,
            month: a.data.monthShow
        }, function(e) {
            if (t.hideLoading(), !e.member) return t.alert(e.error), !1;
            a.setData({
                member: e.member,
                calendar: e.calendar,
                signinfo: e.signinfo,
                advaward: e.advaward,
                yearShow: a.data.yearShow ? a.data.yearShow : e.year,
                monthShow: a.data.monthShow ? a.data.monthShow : e.month,
                today: e.today,
                signed: e.signed,
                signoldtype: e.signoldtype,
                months: e.months,
                set: e.set,
                loading: !1,
                show: !0
            });
        });
    },
    reDatelist: function(t) {
        var a = this, e = t.currentTarget.dataset.year, n = t.currentTarget.dataset.month;
        a.setData({
            yearShow: e,
            monthShow: n,
            dateHidden: 1
        }), a.getList();
    },
    toSign: function(t) {
        this.dosign("");
    },
    oldSign: function(t) {
        var a = this, e = t.currentTarget.dataset.date;
        (a.data.yearShow != t.currentTarget.dataset.year || a.data.monthShow != t.currentTarget.dataset.month || a.data.today != t.currentTarget.dataset.day) && a.data.set.signold_price > 0 ? wx.showModal({
            title: "提示",
            content: a.data.set.textsignold + "需扣除" + a.data.set.signold_price + a.data.signoldtype + "，确定" + a.data.set.textsignold + "吗？",
            success: function(t) {
                t.confirm && a.dosign(e);
            }
        }) : a.data.yearShow == t.currentTarget.dataset.year && a.data.monthShow == t.currentTarget.dataset.month && a.data.today == t.currentTarget.dataset.day ? a.dosign("") : a.dosign(e);
    },
    dosign: function(a) {
        var e = this;
        t.post("changce/sign/dosign", {
            date: a
        }, function(a) {
            if (!a.success) return t.alert(a.error), !1;
            t.alert(a.message), e.getList();
        });
    },
    getCredit: function(a) {
        var e = this, n = a.currentTarget.dataset.day;
        t.post("changce/sign/doreward", {
            type: 1,
            day: n
        }, function(a) {
            if (!a.success) return t.alert(a.error), !1;
            t.alert(a.message), e.getList();
        });
    },
    phone: function(a) {
        t.phone(a);
    },
    tohome: function(t) {
        wx.reLaunch({
            url: "/pages/index/index"
        });
    }
});