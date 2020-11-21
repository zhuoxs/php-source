var app = getApp();

Page({
    data: {
        spindex: 0,
        arrow: !0,
        page: 1,
        limit: 10,
        searchTxt: ""
    },
    onLoad: function(a) {
        this.getData();
    },
    getData: function() {
        var o = this, a = "", t = "";
        switch (o.data.spindex) {
          case "1":
            a = "create_time", t = "desc";
            break;

          case "2":
            a = "price", o.data.arrow && (t = "desc");
            break;

          case "3":
            a = "sales_num", t = "desc";
        }
        var s = o.data.page, e = o.data.limit, r = {
            cat_id: 0,
            orderfield: a,
            ordertype: t,
            page: s,
            limit: e,
            key: o.data.searchTxt,
            lid: 2
        };
        app.ajax({
            url: "Cgoods|getCatGoodses",
            data: r,
            success: function(a) {
                a.data;
                var t = o.data.goods;
                if (1 == s) t = a.data; else for (var e in a.data) t.push(a.data[e]);
                o.setData({
                    goods: t,
                    img_root: a.other.img_root,
                    count: a.other.count,
                    show: !0
                }), o.pageCount();
            }
        });
    },
    spTap: function(a) {
        var t = a.currentTarget.dataset.index, e = this, o = e.data.arrow;
        e.setData({
            nomore: !1
        }), 2 == t ? e.setData({
            spindex: t,
            arrow: !o
        }) : e.setData({
            spindex: t,
            arrow: !0
        }), wx.pageScrollTo({
            scrollTop: 0,
            duration: 400
        }), e.setData({
            page: 1
        }), e.getData(), e.pageCount();
    },
    addPage: function() {
        var a = this, t = a.data.page;
        a.setData({
            page: ++t
        }), a.getData();
    },
    pageCount: function() {
        var a = this, t = a.data.limit;
        a.data.count <= a.data.page * t && a.setData({
            nomore: !0
        });
    },
    onReachBottom: function() {
        this.data.nomore || this.addPage();
    },
    getSearch: function(a) {
        this.setData({
            searchTxt: a.detail.value,
            page: 1,
            limit: 10,
            nomore: !1
        }), this.getData();
    }
});