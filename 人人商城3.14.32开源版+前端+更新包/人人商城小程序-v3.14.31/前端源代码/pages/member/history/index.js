var t = getApp(), a = t.requirejs("core");

t.requirejs("foxui"), Page({
    data: {
        icons: t.requirejs("icons"),
        page: 1,
        loading: !1,
        loaded: !1,
        isedit: !1,
        isCheckAll: !1,
        checkObj: {},
        checkNum: 0,
        list: []
    },
    onLoad: function(a) {
        t.url(a), this.getList();
    },
    onShow: function() {
        var a = t.getCache("isIpx"), e = this;
        console.error(a), a ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        });
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList();
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    getList: function() {
        var t = this;
        t.setData({
            loading: !0
        }), a.get("member/history/get_list", {
            page: t.data.page
        }, function(a) {
            var e = {
                loading: !1,
                loaded: !0,
                total: a.total,
                pagesize: a.pagesize,
                show: !0
            };
            a.list.length > 0 && (e.page = t.data.page + 1, e.list = t.data.list.concat(a.list), 
            a.list.length < a.pagesize && (e.loaded = !0)), t.setData(e);
        });
    },
    itemClick: function(t) {
        var e = this, i = a.pdata(t).id, s = a.pdata(t).goodsid;
        if (e.data.isedit) {
            var c = e.data.checkObj, n = e.data.checkNum;
            c[i] ? (c[i] = !1, n--) : (c[i] = !0, n++);
            var o = !0;
            for (var l in c) if (!c[l]) {
                o = !1;
                break;
            }
            e.setData({
                checkObj: c,
                isCheckAll: o,
                checkNum: n
            });
        } else wx.navigateTo({
            url: "/pages/goods/detail/index?id=" + s
        });
    },
    btnClick: function(t) {
        var e = this, i = t.currentTarget.dataset.action;
        if ("edit" == i) {
            c = {};
            for (var s in this.data.list) c[this.data.list[s].id] = !1;
            e.setData({
                isedit: !0,
                checkObj: c,
                isCheckAll: !1
            });
        } else if ("delete" == i) {
            var c = e.data.checkObj, n = [];
            for (var s in c) c[s] && n.push(s);
            if (n.length < 1) return;
            a.confirm("删除后不可恢复，确定要删除吗？", function() {
                a.post("member/history/remove", {
                    ids: n
                }, function(t) {
                    e.setData({
                        isedit: !1,
                        checkNum: 0,
                        page: 0,
                        list: []
                    }), e.getList();
                });
            });
        } else "finish" == i && e.setData({
            isedit: !1,
            checkNum: 0
        });
    },
    checkAllClick: function() {
        var t = !this.data.isCheckAll, a = this.data.checkObj, e = {
            isCheckAll: t,
            checkObj: a
        };
        for (var i in a) e.checkObj[i] = !!t;
        e.checkNum = t ? this.data.list.length : 0, this.setData(e);
    }
});