Page({
    data: {
        attentioned: !1,
        talent: {
            userImg: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            userName: "卡若不弃",
            userTime: "12月10日 距离2.6km",
            userSex: 0,
            userId: "123",
            talentImg: [ "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png" ],
            talentText: "世纪东方看水电费上课的飞机上课的房间上课的房间开始的九分裤世纪东方开始的减肥上课京东方",
            talentLove: 0,
            talentComment: 0
        }
    },
    onLoad: function(t) {},
    attention: function(t) {
        var n = this;
        console.log(!n.data.attentioned);
        var o = !n.data.attentioned;
        n.setData({
            attentioned: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});