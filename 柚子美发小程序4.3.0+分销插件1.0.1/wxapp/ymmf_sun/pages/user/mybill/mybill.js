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
        var i = new Date(), n = i.getFullYear(), e = i.getMonth(), l = a.data.multiArray, d = a.data.multiIndex;
        if (l[0][0] < n) {
            for (var u = n - l[0][0], o = 0; o < u; o++) l[0].push(parseInt(l[0][0]) + o + 1);
            d[0] = l.length;
        }
        d[1] = e, a.setData({
            multiArray: l,
            multiIndex: d,
            oldMultiIndex: d
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        t.data.multiArray[0][t.data.multiIndex[0]], t.data.multiArray[1][t.data.multiIndex[1]];
    },
    onShareAppMessage: function() {},
    bindMultiPickerColumnChange: function(t) {
        var a = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        a.multiIndex[t.detail.column] = t.detail.value, a.time = this.data.multiArray[0][this.data.multiIndex[0]] + " " + this.data.multiArray[1][this.data.multiIndex[1]], 
        this.setData(a);
    },
    dataChange: function(t) {
        var a = this.data.multiIndex;
        this.setData({
            oldMultiIndex: a
        });
    },
    dataCancel: function(t) {
        this.setData({
            multiIndex: this.data.oldMultiIndex
        });
    }
});