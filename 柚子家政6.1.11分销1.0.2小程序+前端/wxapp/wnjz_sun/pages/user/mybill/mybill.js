var app = getApp();

Page({
    data: {
        navTile: "我的账单",
        billList: [ {
            active: "预约下单_线上支付",
            money: "-30",
            time: "2018-05-05"
        }, {
            active: "门店买单_线下支付",
            money: "-30",
            time: "2018-05-05",
            state: 0
        }, {
            active: "充值余额",
            money: "+30",
            time: "2018-05-05"
        } ],
        multiArray: [ [ "2018" ], [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ] ],
        multiIndex: [ 0, 0 ],
        oldMultiIndex: [],
        amount1: 0,
        amount2: 0,
        pageIndex: 1
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = new Date(), n = e.getFullYear(), i = e.getMonth(), l = a.data.multiArray, d = a.data.multiIndex;
        if (l[0][0] < n) {
            for (var u = n - l[0][0], o = 0; o < u; o++) l[0].push(parseInt(l[0][0]) + o + 1);
            d[0] = l.length;
        }
        d[1] = i, a.setData({
            multiArray: l,
            multiIndex: d,
            oldMultiIndex: d
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("openid"), e = new Date().getFullYear(), n = a.data.multiArray[1][a.data.oldMultiIndex[1]];
        console.log(n), app.util.request({
            url: "entry/wxapp/CurrentMonthBill",
            cachetime: "0",
            data: {
                month: n,
                curYear: e,
                openid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    consumption: t.data.consumption,
                    rech: t.data.rech,
                    Detailed: t.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        t.data.multiArray[0][t.data.multiIndex[0]], t.data.multiArray[1][t.data.multiIndex[1]];
    },
    bindMultiPickerColumnChange: function(t) {
        var a = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        a.multiIndex[t.detail.column] = t.detail.value, a.time = this.data.multiArray[0][this.data.multiIndex[0]] + " " + this.data.multiArray[1][this.data.multiIndex[1]], 
        this.setData(a);
    },
    dataChange: function(t) {
        var a = this, e = wx.getStorageSync("openid"), n = new Date().getFullYear(), i = a.data.multiIndex, l = a.data.multiArray[1][i[1]];
        app.util.request({
            url: "entry/wxapp/CurrentMonthBill",
            cachetime: "0",
            data: {
                month: l,
                curYear: n,
                openid: e
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    consumption: t.data.consumption,
                    rech: t.data.rech,
                    Detailed: t.data.data,
                    oldMultiIndex: i
                });
            }
        });
    },
    dataCancel: function(t) {
        this.setData({
            multiIndex: this.data.oldMultiIndex
        });
    }
});