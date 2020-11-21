Page({
    data: {
        drugsArr: [ {
            img: "../images/active_01.png",
            title: "六味地黄丸",
            effect: "补血补气、降血压、乱七八糟",
            pic: "1980"
        }, {
            img: "../images/active_01.png",
            title: "六味地黄丸",
            effect: "补血补气、降血压、乱七八糟",
            pic: "1980"
        }, {
            img: "../images/active_01.png",
            title: "六味地黄丸",
            effect: "补血补气、降血压、乱七八糟",
            pic: "1980"
        } ],
        chooseScreen: [ {
            title: "滋补调养"
        }, {
            title: "滋补调养"
        }, {
            title: "滋补调养"
        }, {
            title: "滋补调养"
        }, {
            title: "滋补调养"
        } ],
        hidden: !0,
        hidden2: !0,
        hidden3: !0
    },
    onLoad: function(e) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
    },
    chooseDrugs: function(e) {
        console.log(e);
        var t = this.data.drugsArr;
        t[e.currentTarget.dataset.index].checked = !t[e.currentTarget.dataset.index].checked, 
        this.setData({
            drugsArr: t
        });
    },
    show: function() {
        this.setData({
            hidden: !1,
            hidden2: !0,
            hidden3: !0
        });
    },
    show2: function() {
        this.setData({
            hidden: !0,
            hidden2: !1,
            hidden3: !0
        });
    },
    show3: function() {
        this.setData({
            hidden: !0,
            hidden2: !0,
            hidden3: !1
        });
    },
    chooseScreen: function(e) {
        var t = this.data.chooseScreen;
        t[e.currentTarget.dataset.index].checked = !t[e.currentTarget.dataset.index].checked, 
        this.setData({
            chooseScreen: t
        });
    },
    close: function() {
        this.setData({
            hidden: !0,
            hidden2: !0,
            hidden3: !0
        });
    },
    tuijian: function() {
        var e = this.data.drugsArr;
        console.log(e);
        for (var t = [], n = 0, i = e.length; n < i; n++) {
            var o = {};
            e[n].checked && (o.img = e[n].img, o.name = e[n].title, t.push(o));
        }
        wx.setStorageSync("imgArr", t), setTimeout(function() {
            wx.navigateBack({
                delta: 1
            });
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