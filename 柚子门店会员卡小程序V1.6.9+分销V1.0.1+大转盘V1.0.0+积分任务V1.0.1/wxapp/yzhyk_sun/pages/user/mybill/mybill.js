var app = getApp();

Page({
    data: {
        navTile: "我的账单",
        billList: [],
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
        var i = new Date(), e = i.getFullYear(), n = i.getMonth(), l = a.data.multiArray, u = a.data.multiIndex;
        if (l[0][0] < e) {
            for (var d = e - l[0][0], o = 0; o < d; o++) l[0].push(parseInt(l[0][0]) + o + 1);
            console.log(l), u[0] = l.length;
        }
        u[1] = n, a.setData({
            multiArray: l,
            multiIndex: u,
            oldMultiIndex: u,
            curYear: e
        }), this.getData();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, a = e.data.multiArray[0][e.data.multiIndex[0]], i = e.data.multiArray[1][e.data.multiIndex[1]], n = e.data.pageIndex + 1;
        app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetBills",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    year: a,
                    month: i,
                    page: n
                },
                success: function(t) {
                    for (var a = e.data.billList, i = 0; i < t.data.list.length; i++) a.push(t.data.list[i]);
                    e.setData({
                        billList: a
                    }), t.data.length < 10 && wx.showToast({
                        title: "没有更多数据了~",
                        icon: "none"
                    });
                }
            });
        });
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
        var a = this.data.multiIndex;
        this.setData({
            oldMultiIndex: a
        }), this.getData();
    },
    dataCancel: function(t) {
        this.setData({
            multiIndex: this.data.oldMultiIndex
        });
    },
    getData: function() {
        var a = this, i = a.data.curYear, e = a.data.multiArray[1][a.data.multiIndex[1]];
        app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetBills",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    year: i,
                    month: e
                },
                success: function(t) {
                    a.setData({
                        amount1: parseFloat(t.data.info.amount1).toFixed(2),
                        amount2: parseFloat(t.data.info.amount2).toFixed(2),
                        billList: t.data.list,
                        pageIndex: 1
                    });
                }
            });
        });
    }
});