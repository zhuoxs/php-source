Page({
    data: {
        date: "2017-12-14",
        array1: [ "外科", "骨科", "神经科", "儿科", "内科" ],
        array2: [],
        doctor: [ {
            id: 0,
            list: [ {
                name: "王花花",
                money: 5
            }, {
                name: "小关",
                money: 15
            }, {
                name: "石天慧",
                money: 25
            }, {
                name: "倩文",
                money: 35
            }, {
                name: "晴雯",
                money: 45
            } ]
        }, {
            id: 1,
            list: [ {
                name: "李斌",
                money: 5
            }, {
                name: "小胖",
                money: 15
            }, {
                name: "盐水",
                money: 25
            }, {
                name: "闫帅",
                money: 35
            }, {
                name: "老杨",
                money: 45
            } ]
        }, {
            id: 2,
            list: [ {
                name: "张三",
                money: 5
            }, {
                name: "李四",
                money: 15
            }, {
                name: "王五",
                money: 25
            }, {
                name: "赵六",
                money: 35
            }, {
                name: "胡七",
                money: 45
            } ]
        }, {
            id: 3,
            list: [ {
                name: "小明",
                money: 5
            }, {
                name: "小花",
                money: 15
            }, {
                name: "小亮",
                money: 25
            }, {
                name: "小丽",
                money: 35
            }, {
                name: "小李",
                money: 45
            } ]
        }, {
            id: 4,
            list: [ {
                name: "张三",
                money: 5
            }, {
                name: "李四",
                money: 15
            }, {
                name: "王五",
                money: 25
            }, {
                name: "赵六",
                money: 35
            }, {
                name: "胡七",
                money: 45
            } ]
        } ],
        monery: [],
        monerynum: "",
        radioIndex: 1,
        indexx: null
    },
    bindPickerChange1: function(n) {
        for (var e = this, a = n.detail.value, o = e.data.doctor, m = e.data.array2, t = e.data.monery, i = 0; i < o.length; i++) if (a == o[i].id) for (var r = o[i].list, y = 0; y < r.length; y++) m.push(r[y].name), 
        t.push(r[y].money);
        e.setData({
            index: n.detail.value,
            array2: m,
            monery: t
        });
    },
    radio: function(n) {
        this.setData({
            radioIndex: n.detail.value
        });
    },
    bindPickerChange2: function(n) {
        var e = n.detail.value, a = this.data.monery;
        this.setData({
            indexx: e,
            monerynum: a[e]
        });
    },
    formsubmit: function(n) {
        console.log(n.detail.value);
        n.detail.value;
        wx.request({
            url: ".php"
        });
    },
    onLoad: function(n) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});