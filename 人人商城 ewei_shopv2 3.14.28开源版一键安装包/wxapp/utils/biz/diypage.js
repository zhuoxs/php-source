var e = getApp(), a = e.requirejs("jquery"), t = e.requirejs("core");

e.requirejs("foxui");

module.exports = {
    get: function(e, o, i) {
        t.get("diypage", {
            type: o
        }, function(o) {
            o.diypage = o.diypage || {};
            for (var r in o.diypage.items) "topmenu" == o.diypage.items[r].id && e.setData({
                topmenu: o.diypage.items[r]
            });
            var s = {};
            o.customer && (s.customer = o.customer), o.phone && (s.phone = o.phone), o.phonecolor && (s.phonecolor = o.phonecolor), 
            o.phonenumber && (s.phonenumber = o.phonenumber), o.customercolor && (s.customercolor = o.customercolor), 
            s && e.setData(s);
            var p = {
                loading: !1,
                pages: o.diypage.page,
                usediypage: !0,
                startadv: o.startadv
            };
            if (o.diypage.page && e.setData({
                diytitle: o.diypage.page.title
            }), 0 == o.error) {
                if (void 0 != o.diypage.items) {
                    var d = [];
                    if (a.each(o.diypage.items, function(a, i) {
                        if (d.push(i.id), "topmenu" == i.id) {
                            if (2 == i.style.showtype) {
                                r = 78 * Math.ceil(i.data.length / 4);
                                e.setData({
                                    topmenuheight: r
                                });
                            } else {
                                var r = 78;
                                e.setData({
                                    topmenuheight: r
                                });
                            }
                            if (e.setData({
                                topmenu: i,
                                istopmenu: !0
                            }), void 0 == i.data[0]) s = ""; else {
                                s = i.data[0].linkurl;
                                t.get("diypage/getInfo", {
                                    dataurl: s
                                }, function(a) {
                                    i.data[0].data = a.goods.list, p.diypages = o.diypage, p.topmenuDataType = a.type, 
                                    e.setData(p);
                                });
                            }
                        } else if ("tabbar" == i.id) if (void 0 == i.data[0]) s = ""; else {
                            var s = i.data[0].linkurl;
                            t.get("diypage/getInfo", {
                                dataurl: s
                            }, function(a) {
                                i.data[0].data = a.goods.list, i.type = a.type, void 0 !== i.data[0].data ? i.data[0].data.length == a.goods.count && (i.data[0].showmore = !0) : i.data[0].showmore = !1, 
                                p.diypages = o.diypage, p.tabbarDataType = a.type, p.tabbarData = a.goods, e.setData(p);
                            });
                        }
                    }), wx.setNavigationBarTitle({
                        title: p.pages.title
                    }), wx.setNavigationBarColor({
                        frontColor: p.pages.titlebarcolor,
                        backgroundColor: p.pages.titlebarbg
                    }), i && i(o), -1 != d.indexOf("topmenu") || -1 != d.indexOf("tabbar")) return;
                    p.diypages = o.diypage, e.setData(p);
                }
                wx.setNavigationBarTitle({
                    title: p.pages.title
                }), wx.setNavigationBarColor({
                    frontColor: p.pages.titlebarcolor,
                    backgroundColor: p.pages.titlebarbg
                }), i && i(o);
            } else e.setData({
                diypages: !1,
                loading: !1
            });
        });
    }
};