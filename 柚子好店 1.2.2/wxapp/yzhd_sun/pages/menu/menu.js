var app = getApp();

Page({
    data: {
        showJian: !0,
        buyNum: 0,
        openGroup: !0,
        openBook: !0,
        openComment: !0,
        currentIndex: 0,
        foodName: [ "菜品分类", "菜品分类", "菜品分类", "菜品分类", "菜品分类", "菜品分类", "菜品分类" ],
        renshu: [ "1-2人", "3-5人", "6-8人", "9-10人", "11-20人", "21人+" ],
        timeList: [ "00:00", "00:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30", "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30" ],
        num: 5,
        light: "",
        kong: "",
        starMap: [ "非常差", "差", "一般", "好", "非常好" ],
        star: 0
    },
    jiaTap: function(t) {
        console.log(t);
        var o = this, e = t.currentTarget.dataset.id, a = o.data.is_vip, n = t.currentTarget.dataset.addindex, r = o.data.menuInfo, s = o.data.shopcart;
        if (2 == a || "2" == a) var i = t.currentTarget.dataset.current_price - 0; else i = t.currentTarget.dataset.fans_price - 0;
        var c = t.currentTarget.dataset.cnumber, u = t.currentTarget.dataset.cname, d = wx.getStorageSync("openid");
        console.log(a), console.log(i), c++, console.log(c), app.util.request({
            url: "entry/wxapp/AddShopCartNum",
            cachetime: "0",
            data: {
                cnumber: c,
                id: e,
                price: i,
                cname: u,
                openid: d,
                bid: o.data.storeID
            },
            success: function(t) {
                console.log(t);
                var e = r[o.data.currentIndex].goods_list[n].number - 0 + 1;
                r[o.data.currentIndex].goods_list[n].number = e;
                var a = s.allprice - 0 + i;
                console.log(a), a = a.toFixed(2), console.log(a), s.allprice = a, o.setData({
                    menuInfo: r,
                    shopcart: s
                }), 1 == t.data.data && o.onShow();
            }
        });
    },
    jianTap: function(t) {
        var o = this, e = t.currentTarget.dataset.id, a = o.data.is_vip, n = t.currentTarget.dataset.addindex, r = o.data.menuInfo, s = o.data.shopcart;
        if (2 == a || "2" == a) var i = t.currentTarget.dataset.current_price - 0; else i = t.currentTarget.dataset.fans_price - 0;
        var c = t.currentTarget.dataset.cnumber, u = t.currentTarget.dataset.cname, d = wx.getStorageSync("openid");
        console.log(i), c--, console.log(c), app.util.request({
            url: "entry/wxapp/ReduceShopCartNum",
            cachetime: "0",
            data: {
                cnumber: c,
                id: e,
                price: i,
                cname: u,
                openid: d,
                bid: o.data.storeID
            },
            success: function(t) {
                console.log(t);
                var e = r[o.data.currentIndex].goods_list[n].number - 0 - 1;
                console.log(e), r[o.data.currentIndex].goods_list[n].number = e, console.log(r);
                var a = s.allprice - 0 - i;
                s.allprice = a.toFixed(2), console.log(s), o.setData({
                    menuInfo: r,
                    shopcart: s
                }), 1 == t.data.data && o.onShow();
            }
        });
    },
    shopJia: function(t) {
        var e = t.currentTarget.dataset.id, a = this;
        t.currentTarget.dataset.index;
        console.log(t), app.util.request({
            url: "entry/wxapp/shopJia",
            cachetime: "0",
            data: {
                id: e,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), 1 == t.data.data && a.onShow();
            }
        });
    },
    shopJian: function(t) {
        var e = t.currentTarget.dataset.id, a = this;
        t.currentTarget.dataset.index;
        console.log(t), app.util.request({
            url: "entry/wxapp/shopJian",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), 1 == t.data.data && a.onShow();
            }
        });
    },
    onLoad: function(t) {
        console.log(t);
        var a = this;
        a.setData({
            currentType: t.currentType,
            storeID: t.storeID,
            orderno: t.orderno
        }), a.diyWinColor(), a.dateSel(), wx.getStorage({
            key: "url",
            success: function(t) {
                console.log(t), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/isvip",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), a.setData({
                    is_vip: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBranchDetail",
            cachetime: "0",
            data: {
                bid: t.storeID
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                wx.setNavigationBarTitle({
                    title: e.name
                }), a.setData({
                    shopInfo: e,
                    shopJoinNum: t.data.data.recommend_num
                }), 1 == e.is_open_book && a.setData({
                    openBook: !1
                }), 1 == e.is_open_comment && a.setData({
                    openComment: !1
                }), 1 == e.is_open_group && a.setData({
                    openGroup: !1
                }), a.diyWinColor();
            }
        });
    },
    statusType: function(t) {
        2 == t.currentTarget.dataset.index && "undefined" == this.data.orderno ? wx.showModal({
            title: "提示",
            content: "请从订单页面处进入评论",
            showCancel: !1
        }) : this.setData({
            currentType: t.currentTarget.dataset.index
        });
    },
    foodClick: function(t) {
        console.log(t), this.setData({
            currentIndex: t.currentTarget.dataset.index
        });
    },
    goBuyGoods: function(t) {
        wx.navigateTo({
            url: "../dapai-Qg/dapai-Qg?gid=" + t.currentTarget.dataset.gid + "&&bid=" + t.currentTarget.dataset.bid + "&&buyType=3&&title=大牌抢购"
        });
    },
    selRenshuTap: function(t) {
        console.log(t), this.setData({
            currRenshu: t.currentTarget.dataset.index,
            currNum: t.currentTarget.dataset.num
        });
    },
    selDateTap: function(t) {
        console.log(t), this.setData({
            currDate: t.currentTarget.dataset.index,
            currSelDate: t.currentTarget.dataset.date
        });
    },
    selTimeTap: function(t) {
        this.setData({
            currTime: t.currentTarget.dataset.index,
            currSelTime: t.currentTarget.dataset.time
        });
    },
    weizhiType: function(t) {
        this.setData({
            currentWeizhi: t.currentTarget.dataset.index,
            currSelWeizhi: t.currentTarget.dataset.weizhi
        });
    },
    goDingzuoMes: function(t) {
        var e = this.data.currDate, a = this.data.zzArr[e] + " " + this.data.currSelTime;
        this.data.currNum ? this.data.currSelDate ? this.data.currSelTime ? this.data.currSelWeizhi ? wx.navigateTo({
            url: "../dingzuoMes/dingzuoMes?currSelDate=" + this.data.currSelDate + "&&currSelTime=" + this.data.currSelTime + "&&currNum=" + this.data.currNum + "&&currSelWeizhi=" + this.data.currSelWeizhi + "&&postLaterData=" + a + "&&storeID=" + this.data.storeID
        }) : wx.showModal({
            title: "提示",
            content: "请选择用餐位置",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请选择用餐时间",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请选择用餐日期",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请选择用餐人数",
            showCancel: !1
        });
    },
    myChooseStar: function(t) {
        console.log(t);
        var e = parseInt(t.target.dataset.star) || 0;
        this.setData({
            star: e
        }), console.log(this.data.star);
    },
    deterTap: function(t) {
        console.log(this.data.star), 0 < this.data.star ? (wx.showToast({
            title: "评价成功",
            icon: "success",
            duration: 2e3
        }), this.setData({
            hideStarBox: !0
        })) : wx.showToast({
            title: "请评价星级",
            icon: "none",
            duration: 2e3
        });
    },
    commentTap: function(t) {
        console.log(t), this.setData({
            comments: t.detail.value
        });
    },
    formSubmit: function(t) {
        console.log(t);
    },
    pushCommentTap: function(t) {
        var e = this, a = wx.getStorageSync("users"), o = wx.getStorageSync("openid");
        console.log(a), console.log(o), console.log(e.data.orderID), console.log(e.data.comments), 
        console.log(e.data.storeID), console.log(e.data.star), console.log(e.data.orderno), 
        app.util.request({
            url: "entry/wxapp/comment",
            cachetime: "0",
            data: {
                bid: e.data.storeID,
                msg: e.data.comments,
                score: e.data.star,
                openid: o,
                order_id: e.data.orderno
            },
            success: function(t) {
                console.log(t), wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "../index/index"
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        console.log(e.data), app.util.request({
            url: "entry/wxapp/GetBranchCategory",
            cachetime: "0",
            data: {
                bid: e.data.storeID,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), e.setData({
                    menuInfo: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetShopCart",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid"),
                bid: e.data.storeID
            },
            success: function(t) {
                console.log(t), e.setData({
                    shopcart: t.data.data
                });
            }
        }), "undefined" != e.data.orderno && (console.log(e.data), e.setData({
            openComment: !1
        }));
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        var e = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: e.color,
            backgroundColor: e.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        });
    },
    dateSel: function(t) {
        var e = new Date(), a = new Date();
        a.setDate(e.getDate() + 30);
        for (var o = [], n = [], r = [ "日", "一", "二", "三", "四", "五", "六" ]; 0 <= a.getTime() - e.getTime(); ) {
            var s = e.getFullYear();
            console.log(s);
            var i = 1 == (e.getMonth() + 1).toString().length ? "0" + (e.getMonth() + 1).toString() : e.getMonth() + 1, c = 1 == e.getDate().toString().length ? "0" + e.getDate() : e.getDate(), u = r[e.getDay()];
            o.push(i + "." + c + "周" + u), n.push(s + "-" + i + "-" + c), e.setDate(e.getDate() + 1);
        }
        o[0] = "今天" + o[0].slice(6, 6), o[1] = "明天" + o[1].slice(6, 6), o[2] = "后天" + o[2].slice(6, 6), 
        console.log(o), console.log(n), this.setData({
            dateArr: o,
            zzArr: n
        });
    },
    seeCart: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e), console.log(t), this.onShow();
    },
    deleteCart: function(a) {
        var o = this;
        wx.showModal({
            title: "提示",
            content: "是否确认清空购物车？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/DeleteCart",
                    cachetime: "0",
                    data: {
                        bid: o.data.storeID
                    },
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "清空成功！"
                        });
                        var e = a.currentTarget.dataset.statu;
                        o.util(e), setTimeout(function() {
                            o.onShow();
                        }, 1e3);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    buyToShop: function(t) {
        var e = this.data.storeID;
        console.log(e);
        var a = t.currentTarget.dataset.allprice - 0, o = this.data.shopcart;
        console.log(o), console.log(a), a <= 0 || !a ? wx.showToast({
            title: "请选择商品",
            icon: "none"
        }) : (wx.setStorageSync("shopcart", o), wx.navigateTo({
            url: "../toPayOrder/toPayOrder?buyType=5"
        }));
    },
    close: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e), this.onShow();
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("700rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    }
});