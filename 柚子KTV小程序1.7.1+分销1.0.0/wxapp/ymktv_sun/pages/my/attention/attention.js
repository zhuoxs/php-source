var app = getApp();

Page({
    data: {
        peraonal: [ {
            headerimgsrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152349920201_medium.jpg",
            name: "小白",
            time: "2015-10-10",
            findimgsrcs: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152342845743_medium.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152341453956_medium.jpg" ],
            gender: "1",
            attention: "0",
            praisenum: "10",
            praisetatus: 0,
            commentnum: "11",
            commentnumtatus: 1,
            content: "唱歌吧！有人要一起的嘛2月21号 晚上8点"
        }, {
            headerimgsrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152349920201_medium.jpg",
            name: "小美",
            time: "2015-11-10",
            findimgsrcs: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152342845743_medium.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152341453956_medium.jpg" ],
            gender: "1",
            attention: "1",
            praisenum: "1",
            praisetatus: 0,
            commentnum: "121",
            commentnumtatus: 1,
            content: "我这有个麦霸有没有一起的"
        }, {
            headerimgsrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152349920201_medium.jpg",
            name: "小葵",
            time: "2015-11-10",
            findimgsrcs: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152342845743_medium.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152341453956_medium.jpg" ],
            gender: "2",
            attention: "0",
            praisenum: "1",
            praisetatus: 0,
            commentnum: "121",
            commentnumtatus: 1,
            content: "下班一起去唱歌的有没有"
        }, {
            headerimgsrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152349920201_medium.jpg",
            name: "小葵",
            time: "2015-11-10",
            findimgsrcs: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152342845743_medium.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152341453956_medium.jpg" ],
            gender: "1",
            attention: "1",
            praisenum: "1",
            praisetatus: 1,
            commentnum: "121",
            commentnumtatus: 1,
            content: "下班一起去唱歌的有没有"
        } ]
    },
    onShow: function() {
        var m = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Userattention",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                m.setData({
                    attention: t.data
                });
            }
        });
    },
    attention: function(t) {
        var m = this, e = t.currentTarget.dataset.index, i = m.data.attention, n = wx.getStorageSync("openid"), a = i[e].attention_id;
        console.log(n), console.log(a), 0 == i[e].isfollow ? i[e].isfollow = 1 : i[e].isfollow = 0, 
        app.util.request({
            url: "entry/wxapp/Follow",
            cachetime: "0",
            data: {
                user_id: n,
                openid: a
            },
            success: function(t) {
                console.log(t.data), m.setData({
                    attention: i
                });
            }
        });
    }
});