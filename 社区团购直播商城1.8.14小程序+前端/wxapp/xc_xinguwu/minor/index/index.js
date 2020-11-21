var _Page;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        curIndex: 1,
        curIndex1: 1,
        indicatorDots: !0,
        autoplay: !0,
        interval: 4e3,
        duration: 800,
        swiperCurrent: 0,
        pagesize: 10,
        list: []
    },
    toLink: function(t) {
        var a = t.currentTarget.dataset.link;
        "" != a && wx.navigateTo({
            url: a
        });
    },
    toDetail: function(t) {
        var a = this.data.curIndex, e = this.data.curIndex1, i = t.currentTarget.id;
        "presell" == a ? wx.navigateTo({
            url: "/xc_xinguwu/pages/detail/detail?id=" + i
        }) : 1 == e ? wx.navigateTo({
            url: "/xc_xinguwu/pages/detail/detail?id=" + i
        }) : 2 == e ? wx.navigateTo({
            url: "/xc_xinguwu/pages/limitDetail/limitDetail?id=" + i
        }) : 3 == e ? wx.navigateTo({
            url: "/xc_xinguwu/pages/bargainDetail/bargainDetail?id=" + i + "&staus=1"
        }) : 4 == e && wx.navigateTo({
            url: "/xc_xinguwu/pages/groupdetail/groupdetail?id=" + i
        });
    },
    selectedAttr: function(t) {
        var a, e = t.currentTarget.dataset.index;
        this.setData((_defineProperty(a = {}, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].sub.attred", e), 
        _defineProperty(a, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].sub.img", this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].attrs[e].img), 
        _defineProperty(a, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].sub.price", this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].attrs[e].price), 
        _defineProperty(a, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].sub.num", 1), 
        a));
    },
    addCount: function(t) {
        var a = this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.num;
        a >= this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].attrs[this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.attred].stock ? app.look.alert("库存不足") : (a += 1, 
        this.setData(_defineProperty({}, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].sub.num", a)));
    },
    minusCount: function(t) {
        var a = this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.num;
        1 != a && (a -= 1, this.setData(_defineProperty({}, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].sub.num", a)));
    },
    showBuy: function(t) {
        var a = t.currentTarget.dataset.index;
        if ("presell" == this.data.curIndex) wx.navigateTo({
            url: "/xc_xinguwu/pages/detail/detail?id=" + this.data.list[this.data.curIndex][this.data.curIndex1].list[a].id
        }); else if ("sport" == this.data.curIndex) ; else if (1 == this.data.curIndex1) {
            this.setData(_defineProperty({
                listIndex: a
            }, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + a + "].topBuy", !0));
            var e = {
                currentTarget: {
                    dataset: {
                        index: Object.keys(this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].attrs)[0]
                    }
                }
            };
            this.selectedAttr(e);
        } else 2 == this.data.curIndex1 ? wx.navigateTo({
            url: "/xc_xinguwu/pages/limitDetail/limitDetail?id=" + this.data.list[this.data.curIndex][this.data.curIndex1].list[a].id
        }) : 3 == this.data.curIndex1 ? wx.navigateTo({
            url: "/xc_xinguwu/pages/bargainDetail/bargainDetail?staus=1&id=" + this.data.list[this.data.curIndex][this.data.curIndex1].list[a].id
        }) : 4 == this.data.curIndex1 && wx.navigateTo({
            url: "/xc_xinguwu/pages/groupdetail/groupdetail?id=" + this.data.list[this.data.curIndex][this.data.curIndex1].list[a].id
        });
    },
    closeModel: function(t) {
        this.setData(_defineProperty({}, "list." + this.data.curIndex + "." + this.data.curIndex1 + ".list[" + this.data.listIndex + "].topBuy", !1));
    },
    showChange: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.goods;
        e[a].topChange = !0, this.setData({
            goods: e
        });
    },
    closeChange: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.goods;
        e[a].topChange = !1, this.setData({
            goods: e
        });
    },
    changeNav: function(t) {
        var a = t.currentTarget.dataset.index, e = "live" == a ? "0" : "1";
        if (this.setData({
            curIndex: a,
            curIndex1: e
        }), app.look.istrue(this.data.list[a])) ; else {
            var i = this;
            app.util.request({
                url: "entry/wxapp/minor",
                showLoading: !0,
                data: {
                    op: "loadData",
                    curIndex: i.data.curIndex,
                    curIndex1: i.data.curIndex1,
                    page: 1,
                    pagesize: i.data.pagesize
                },
                success: function(t) {
                    var a, e = t.data;
                    e.data.list && i.setData((_defineProperty(a = {}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".list", e.data.list), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".page", 1), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !1), 
                    a));
                },
                fail: function(t) {
                    var a;
                    app.look.alert(t.data.message), i.setData((_defineProperty(a = {}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".list", []), 
                    _defineProperty(a, "list" + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !0), 
                    a));
                }
            });
        }
    },
    changeSnav: function(t) {
        var a = t.currentTarget.dataset.index;
        if (this.setData({
            curIndex1: a
        }), app.look.istrue(this.data.list[this.data.curIndex][a])) ; else {
            var i = this;
            app.util.request({
                url: "entry/wxapp/minor",
                showLoading: !0,
                data: {
                    op: "loadData",
                    curIndex: i.data.curIndex,
                    curIndex1: i.data.curIndex1,
                    page: 1,
                    pagesize: i.data.pagesize
                },
                success: function(t) {
                    var a, e = t.data;
                    e.data.list && i.setData((_defineProperty(a = {}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".list", e.data.list), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".page", 1), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !1), 
                    a));
                },
                fail: function(t) {
                    var a;
                    app.look.alert(t.data.message), i.setData((_defineProperty(a = {}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !0), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".list", []), 
                    a));
                }
            });
        }
    },
    swiperChange: function(t) {
        var a = t.detail.current;
        this.setData({
            swiperCurrent: a
        });
    }
}, "swiperChange", function(t) {
    var a = t.detail.current;
    this.setData({
        swiperCurrent: a
    });
}), _defineProperty(_Page, "addCart", function(t) {
    if (this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub) {
        var e = this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].id, i = this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.attred, a = wx.getStorageSync("cars") || [], d = !1;
        a && (a.forEach(function(t, a) {
            t.id == e && t.attr == i && (d = !0, wx.showToast({
                title: "该商品已经在购物车中",
                icon: "none"
            }));
        }), d) || (a.push({
            id: e,
            num: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.num,
            price: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.price,
            attr: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.attred,
            cid: 1
        }), wx.setStorage({
            key: "cars",
            data: a,
            success: function() {
                wx.showToast({
                    title: "已加入购物车"
                });
            }
        }), this.setData({
            "tabBar.number": a.length
        }));
    } else wx.showToast({
        title: "请选择" + t.currentTarget.dataset.property,
        icon: "none"
    });
}), _defineProperty(_Page, "buyNow", function(t) {
    if (this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub) {
        var a = [], e = [];
        a.push({
            id: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].id,
            img: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].bimg,
            num: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.num,
            price: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.price,
            name: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].name,
            attr: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.attred,
            attr_name: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].attr_name,
            weight: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].weight
        }), e = {
            content: a,
            totalPrice: (parseFloat(this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.price) * parseInt(this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.num)).toFixed(2),
            totalNum: this.data.list[this.data.curIndex][this.data.curIndex1].list[this.data.listIndex].sub.num,
            cid: 1
        }, e = JSON.stringify(e), e = encodeURIComponent(e), wx.navigateTo({
            url: "/xc_xinguwu/pages/submit/submit?order=" + e
        });
    } else wx.showToast({
        title: "请选择" + t.currentTarget.dataset.property,
        icon: "none"
    });
}), _defineProperty(_Page, "onLoad", function() {
    var i = this;
    wx.setNavigationBarTitle({
        title: app.globalData.webset.webname
    });
    var t = [], a = [], e = [], d = [];
    app.globalData.webset.home_club_label_bgcolour && t.push("background-color:" + app.globalData.webset.home_club_label_bgcolour), 
    app.globalData.webset.home_club_label_fontcolour && t.push("color:" + app.globalData.webset.home_club_label_fontcolour), 
    app.globalData.webset.home_club_label_actbgcolour && a.push("background-color:" + app.globalData.webset.home_club_label_actbgcolour), 
    app.globalData.webset.home_club_label_actfontcolour && a.push("color:" + app.globalData.webset.home_club_label_actfontcolour), 
    app.globalData.webset.home_club_label_attrcolour && e.push("color:" + app.globalData.webset.home_club_label_attrcolour), 
    app.globalData.webset.home_club_label_actattrcolour && d.push("color:" + app.globalData.webset.home_club_label_actattrcolour), 
    this.setData({
        labelsstyles: t.join(";"),
        actlabels: a.join(";"),
        attrstyles: e.join(";"),
        actattrstyles: d.join(";")
    }), app.util.request({
        url: "entry/wxapp/minor",
        showLoading: !1,
        data: {
            op: "index"
        },
        success: function(t) {
            var a = t.data;
            a.data.ppt && i.setData({
                ppt: a.data.ppt
            }), a.data.special && i.setData({
                special: a.data.special
            }), a.data.ad && i.setData({
                ad: a.data.ad
            }), i.setData({
                club_label_1: a.data.club_label_1 ? a.data.club_label_1 : null,
                voucher: a.data.voucher ? a.data.voucher : null,
                club_label_2: a.data.club_label_2 ? a.data.club_label_2 : null,
                curIndex: a.data.club_label_1 ? a.data.club_label_1[0].id : "presell"
            }), app.util.request({
                url: "entry/wxapp/minor",
                showLoading: !1,
                data: {
                    op: "loadData",
                    curIndex: i.data.curIndex,
                    curIndex1: i.data.curIndex1,
                    page: 1,
                    pagesize: i.data.pagesize
                },
                success: function(t) {
                    var a, e = t.data;
                    e.data.list && i.setData((_defineProperty(a = {}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".list", e.data.list), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".page", 1), 
                    _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !1), 
                    a));
                },
                fail: function(t) {
                    app.look.alert(t.data.message), i.setData(_defineProperty({}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !0));
                }
            });
        }
    }), app.club, wx.getLocation({
        success: function(t) {
            i.setData({
                longitude: t.longitude,
                latitude: t.latitude
            }), app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                data: {
                    op: "getdefaultclub",
                    longitude: t.longitude,
                    latitude: t.latitude,
                    page: 1,
                    pagesize: 1
                },
                success: function(t) {
                    t.data.data && (i.setData({
                        club: t.data.data
                    }), app.club = t.data.data);
                },
                fail: function() {}
            });
        },
        fail: function(t) {
            console.log("定位失败");
        }
    });
}), _defineProperty(_Page, "onGotUserInfo", function(t) {
    app.look.getuserinfo(t, this);
}), _defineProperty(_Page, "onReady", function() {
    var t = {};
    t.sq_bg = app.module_url + "resource/wxapp/community/sq-bg.png", this.setData({
        images: t,
        webset: app.globalData.webset
    }), app.look.accredit(this), app.look.footer(this);
}), _defineProperty(_Page, "get_voucher", function(t) {
    var a = this, e = t.currentTarget.dataset.index, i = this.data.voucher, d = i[e].id;
    wx.showLoading({
        title: "领取中"
    }), 2 != i[e].status ? 1 == i[e].numlimt && i[e].num <= 0 ? wx.showToast({
        title: "已取完"
    }) : app.util.request({
        url: "entry/wxapp/index",
        showLoading: !1,
        method: "POST",
        data: {
            op: "get_voucher",
            id: d
        },
        success: function(t) {
            wx.showToast({
                title: t.data.message
            }), i.splice(e, 1), a.setData({
                voucher: i
            });
        }
    }) : wx.showToast({
        title: "已领取"
    });
}), _defineProperty(_Page, "sortsvoucher", function(t) {
    for (var a = [], e = [], i = 0, d = t.length; i < d; i++) 1 == t[i].status ? a.push(t[i]) : e.push(t[i]);
    return a.concat(e);
}), _defineProperty(_Page, "onShow", function() {
    null != app.club && this.setData({
        club: app.club
    });
    var r = this;
    app.util.request({
        url: "entry/wxapp/index",
        showLoading: !1,
        method: "POST",
        data: {
            op: "mycard"
        },
        success: function(t) {
            var n = t.data.data.mycard || [];
            !function t() {
                if (app.look.istrue(r.data.voucher)) {
                    for (var a = r.data.voucher, e = 0, i = a.length; e < i; e++) {
                        a[e].status = 1;
                        for (var d = 0, s = n.length; d < s; d++) a[e].id == n[d].voucherid && (a[e].status = 2);
                    }
                    r.setData({
                        voucher: r.sortsvoucher(a)
                    });
                } else setTimeout(function() {
                    t();
                }, 100);
            }();
        }
    });
}), _defineProperty(_Page, "onReachBottom", function() {
    if (this.data.list[this.data.curIndex] && this.data.list[this.data.curIndex][this.data.curIndex1] && !this.data.list[this.data.curIndex][this.data.curIndex1].loadend) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/minor",
            showLoading: !1,
            data: {
                op: "loadData",
                curIndex: i.data.curIndex,
                curIndex1: i.data.curIndex1,
                page: i.data.list[i.data.curIndex][i.data.curIndex1].page + 1,
                pagesize: i.data.pagesize
            },
            success: function(t) {
                var a, e = t.data;
                e.data && e.data.list && i.setData((_defineProperty(a = {}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".list", i.data.list[i.data.curIndex][i.data.curIndex1].list.concat(e.data.list)), 
                _defineProperty(a, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".page", i.data.list[i.data.curIndex][i.data.curIndex1].page + 1), 
                a));
            },
            fail: function(t) {
                app.look.alert(t.data.message), i.setData(_defineProperty({}, "list." + i.data.curIndex + "." + i.data.curIndex1 + ".loadend", !0));
            }
        });
    }
}), _defineProperty(_Page, "onPageScroll", function(t) {
    app.look.floatIcon(this, t);
}), _defineProperty(_Page, "onShareAppMessage", function(t) {
    wx.showShareMenu({
        withShareTicket: !0
    });
    var a = "", e = "";
    if (app.look.istrue(app.globalData.webset.webname) && (e = app.globalData.webset.webname), 
    "menu" == t.from) return a = "/" + this.route, {
        title: e,
        path: "/xc_xinguwu/pages/base/base?share=" + (a = encodeURIComponent(a)) + "&userid=" + app.globalData.userInfo.id,
        imageUrl: "",
        success: function(t) {
            wx.showToast({
                title: "转发成功"
            });
        },
        fail: function(t) {}
    };
}), _Page));