var e = getApp(), t = e.requirejs("jquery"), a = e.requirejs("core");

e.requirejs("foxui"), module.exports = {
    get: function(e, i, o) {
        a.get("diypage", {
            type: i
        }, function(i) {
            i.diypage = i.diypage || {};
            for (var r in i.diypage.items) "topmenu" == i.diypage.items[r].id && e.setData({
                topmenu: i.diypage.items[r]
            });
            e.setData({
                customer: i.customer,
                phone: i.phone,
                phonecolor: i.phonecolor,
                phonenumber: i.phonenumber,
                customercolor: i.customercolor
            });
            var p = {
                loading: !1,
                pages: i.diypage.page,
                usediypage: !0,
                startadv: i.startadv
            };
            if (i.diypage.page && e.setData({
                diytitle: i.diypage.page.title
            }), 0 == i.error) {
                if (void 0 != i.diypage.items) {
                    var s = [];
                    if (t.each(i.diypage.items, function(t, o) {
                        if (s.push(o.id), "topmenu" == o.id) {
                            if (2 == o.style.showtype) r = 78 * Math.ceil(o.data.length / 4), e.setData({
                                topmenuheight: r
                            }); else {
                                var r = 78;
                                e.setData({
                                    topmenuheight: r
                                });
                            }
                            e.setData({
                                topmenu: o,
                                istopmenu: !0
                            }), void 0 == o.data[0] ? g = "" : (g = o.data[0].linkurl, a.get("diypage/getInfo", {
                                dataurl: g
                            }, function(t) {
                                o.data[0].data = t.goods.list, p.diypages = i.diypage, p.topmenuDataType = t.type, 
                                e.setData(p);
                            }));
                        } else if ("tabbar" == o.id) if (void 0 == o.data[0]) g = ""; else {
                            var g = o.data[0].linkurl;
                            a.get("diypage/getInfo", {
                                dataurl: g
                            }, function(t) {
                                o.data[0].data = t.goods.list, o.type = t.type, p.diypages = i.diypage, p.tabbarDataType = t.type, 
                                p.tabbarData = t.goods, e.setData(p);
                            });
                        }
                    }), wx.setNavigationBarTitle({
                        title: p.pages.title
                    }), wx.setNavigationBarColor({
                        frontColor: p.pages.titlebarcolor,
                        backgroundColor: p.pages.titlebarbg
                    }), o && o(i), -1 != s.indexOf("topmenu") || -1 != s.indexOf("tabbar")) return;
                    p.diypages = i.diypage, e.setData(p);
                }
                wx.setNavigationBarTitle({
                    title: p.pages.title
                }), wx.setNavigationBarColor({
                    frontColor: p.pages.titlebarcolor,
                    backgroundColor: p.pages.titlebarbg
                }), o && o(i);
            } else e.setData({
                diypages: !1,
                loading: !1
            });
        });
    }
};