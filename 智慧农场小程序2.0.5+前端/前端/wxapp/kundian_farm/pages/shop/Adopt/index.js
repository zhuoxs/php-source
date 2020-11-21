var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        Adopt: [],
        currentImg: "",
        currentStyle: 3,
        showName: 0,
        setData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1,
        cardCur: 0
    },
    onLoad: function(r) {
        var n = this, e = (wx.getStorageSync("kundian_farm_uid"), wx.getStorageSync("kundian_farm_setData")), i = r.is_tarbar || !1, s = wx.getStorageSync("kundianFarmTarbar");
        n.setData({
            tarbar: s,
            is_tarbar: i,
            setData: e,
            currentStyle: e.animal_list_style ? e.animal_list_style : 3
        }), wx.showLoading({
            title: "玩命加载中"
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "animal",
                op: "index",
                uniacid: t
            },
            success: function(a) {
                var t = a.data.animalData, r = t[0].animal_src;
                n.setData({
                    Adopt: t,
                    currentImg: r,
                    showName: 1 == e.animal_name_show ? 1 : 0
                }), wx.hideLoading();
            }
        }), a.util.setNavColor(t);
    },
    cardSwiper: function(a) {
        var t = a.detail.current, r = this.data.Adopt;
        this.setData({
            cardCur: t,
            currentImg: r[t].animal_src
        });
    },
    onShow: function(a) {
        var t = wx.getStorageSync("kundianFarmTarbar");
        this.setData({
            tarbar: t
        });
    },
    Adopt: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../AdoptRules/index?aid=" + t
        });
    }
});