Component({
    properties: {
        styles: {
            type: Number,
            value: 1
        },
        column: {
            type: Number,
            value: 1
        },
        radius: {
            type: Number,
            value: 0
        },
        lists: {
            type: Array,
            value: []
        }
    },
    methods: {
        navToPage: function(a) {
            var e = /^[0-9]+.?[0-9]*$/, n = a.currentTarget.dataset.linktype, i = a.currentTarget.dataset.linkparam;
            if (!e.test(n)) {
                if ("miniprogram" == n) {
                    var d = a.currentTarget.dataset.appid;
                    return void wx.navigateToMiniProgram({
                        appId: d
                    });
                }
                return i ? wx.navigateTo({
                    url: "/" + i
                }) : wx.navigateTo({
                    url: "/" + n
                }), !1;
            }
            1 == n ? i ? wx.navigateTo({
                url: "/kundian_farm/pages/land/landDetails/index?lid=" + i
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/land/landList/index"
            }) : 2 == n ? i ? wx.navigateTo({
                url: "/kundian_farm/pages/shop/AdoptRules/index?aid=" + i
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/shop/Adopt/index"
            }) : 3 == n ? wx.navigateTo({
                url: "/kundian_farm/pages/shop/integral/index/index"
            }) : 4 == n ? wx.navigateTo({
                url: "/kundian_farm/pages/HomePage/live/index"
            }) : 5 == n ? 0 != i && i ? wx.navigateTo({
                url: "/kundian_farm/pages/shop/prodeteils/index?goodsid=" + i
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/shop/index/index"
            }) : 6 == n ? i ? wx.navigateTo({
                url: "/kundian_farm/pages/shop/Group/proDetails/index?goods_id=" + i
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/shop/Group/index/index"
            }) : 7 == n ? i ? wx.navigateTo({
                url: "/kundian_farm/pages/shop/integral/exchangedetails/index?goods_id=" + i
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/shop/integral/exchange/index"
            }) : 8 == n ? i && 0 != i ? wx.navigateTo({
                url: "/kundian_farm/pages/information/article/index?aid=" + i
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/information/index/index"
            }) : 9 == n ? wx.navigateTo({
                url: "/kundian_farm/pages/user/coupon/index/index"
            }) : 10 == n ? wx.navigateTo({
                url: "/kundian_farm/pages/HomePage/issue/index"
            }) : 11 == n ? wx.navigateTo({
                url: "/kundian_farm/pages/shop/buyCar/index"
            }) : 12 == n ? wx.navigateTo({
                url: "/kundian_farm/pages/user/addCard/index"
            }) : 13 == n ? i && 0 != i ? wx.navigateTo({
                url: "/kundian_funding/pages/prodetail/index?pid=" + i
            }) : wx.navigateTo({
                url: "/kundian_funding/pages/index/index"
            }) : 14 == n ? i && 0 != i ? wx.navigateTo({
                url: "/kundian_active/pages/details/index?activeid=" + i
            }) : wx.navigateTo({
                url: "/kundian_active/pages/index/index"
            }) : 15 == n ? wx.navigateTo({
                url: "/kundian_game/pages/farm/index"
            }) : 16 == n && (i && 0 != i ? wx.navigateTo({
                url: "/kundian_pt/pages/details/index?goodsid=" + i
            }) : wx.navigateTo({
                url: "/kundian_pt/pages/index/index"
            }));
        }
    }
});