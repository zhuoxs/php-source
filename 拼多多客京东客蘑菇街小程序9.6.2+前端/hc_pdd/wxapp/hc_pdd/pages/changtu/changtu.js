var app = getApp();

Page({
    data: {
        title: "tom",
        mob: 0,
        toView: "inToView3",
        yun: [ {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            }, {
                img: "../../resource/images/1_06.jpg"
            } ]
        } ]
    },
    onLoad: function(g) {},
    tiao: function() {
        wx.navigateTo({
            url: "../../component/pages/redbag/redbag?outuser_id=" + app.globalData.user_id + "&hb_id=" + this.data.hb_id
        });
    }
});