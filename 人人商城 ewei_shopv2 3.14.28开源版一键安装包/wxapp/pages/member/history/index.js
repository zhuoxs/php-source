var t = getApp(), a = t.requirejs("core");

t.requirejs("foxui");

Page({
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
        var a = this;
        t.getCache("isIpx") ? a.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : a.setData({
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
            var i = {
                loading: !1,
                loaded: !0,
                total: a.total,
                pagesize: a.pagesize,
                show: !0
            };
            a.list.length > 0 && (i.page = t.data.page + 1, i.list = t.data.list.concat(a.list), 
            a.list.length < a.pagesize && (i.loaded = !0)), t.setData(i);
        });
    },
    itemClick: function(t) {
        var i = this, e = a.pdata(t).id, s = a.pdata(t).goodsid;
        if (i.data.isedit) {
            var c = i.data.checkObj, n = i.data.checkNum;
            c[e] ? (c[e] = !1, n--) : (c[e] = !0, n++);
            var o = !0;
            for (var d in c) if (!c[d]) {
                o = !1;
                break;
            }
            i.setData({
                checkObj: c,
                isCheckAll: o,
                checkNum: n
            });
        } else wx.navigateTo({
            url: "/pages/goods/detail/index?id=" + s
        });
    },
    btnClick: function(t) {
        var i = this, e = t.currentTarget.dataset.action;
        if ("edit" == e) {
            c = {};
            for (var s in this.data.list) c[this.data.list[s].id] = !1;
            i.setData({
                isedit: !0,
                checkObj: c,
                isCheckAll: !1
            });
        } else if ("delete" == e) {
            var c = i.data.checkObj, n = [];
            for (var s in c) c[s] && n.push(s);
            if (n.length < 1) return;
            a.confirm("删除后不可恢复，确定要删除吗？", function() {
                a.post("member/history/remove", {
                    ids: n
                }, function(t) {
                    i.setData({
                        isedit: !1,
                        checkNum: 0,
                        page: 0,
                        list: []
                    }), i.getList();
                });
            });
        } else "finish" == e && i.setData({
            isedit: !1,
            checkNum: 0
        });
    },
    checkAllClick: function() {
        var t = !this.data.isCheckAll, a = this.data.checkObj, i = {
            isCheckAll: t,
            checkObj: a
        };
        for (var e in a) i.checkObj[e] = !!t;
        i.checkNum = t ? this.data.list.length : 0, this.setData(i);
    }
});