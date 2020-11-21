function tabbarinit() {
    return [ {
        current: 0,
        pagePath: "../index/index",
        text: "首页",
        iconPath: "../../resource/images/tabbar/index.png",
        selectedIconPath: "../../resource/images/tabbar/index_s.png"
    }, {
        current: 0,
        pagePath: "../seller/seller",
        text: "商家",
        iconPath: "../../resource/images/tabbar/seller.png",
        selectedIconPath: "../../resource/images/tabbar/seller_s.png"
    }, {
        current: 0,
        pagePath: "../fabu/fabu",
        text: "发布",
        iconPath: "../../resource/images/tabbar/fabu.png",
        selectedIconPath: "../../resource/images/tabbar/fabu.png"
    }, {
        current: 0,
        pagePath: "../circle/circle",
        text: "圈子",
        iconPath: "../../resource/images/tabbar/circle.png",
        selectedIconPath: "../../resource/images/tabbar/circle_s.png"
    }, {
        current: 0,
        pagePath: "../mine/mine",
        text: "我的",
        iconPath: "../../resource/images/tabbar/mine.png",
        selectedIconPath: "../../resource/images/tabbar/mine_s.png"
    } ];
}

function aaa(e, a) {
    var t;
    (console.log(1), console.log(e), console.log(2), 0 == e.data.key) ? ((t = [ {}, {}, {}, {}, {} ])[2].current = 0, 
    t[2].pagePath = "../fabu/fabu", t[2].text = e.data.db_name3, t[2].iconPath = a + e.data.pic_three, 
    t[2].selectedIconPath = a + e.data.pic_three1, t[3].current = 0, t[3].pagePath = "../circle/circle", 
    t[3].text = e.data.db_name4, t[3].iconPath = a + e.data.pic_four, t[3].selectedIconPath = a + e.data.pic_four1, 
    t[4].current = 0, t[4].pagePath = "../mine/mine", t[4].text = e.data.db_name5, t[4].iconPath = a + e.data.pic_five, 
    t[4].selectedIconPath = a + e.data.pic_five1) : ((t = [ {}, {}, {} ])[2].current = 0, 
    t[2].pagePath = "../mine/mine", t[2].text = e.data.db_name5, t[2].iconPath = a + e.data.pic_five, 
    t[2].selectedIconPath = a + e.data.pic_five1);
    return t[0].current = 0, t[0].pagePath = "../index/index", t[0].text = e.data.db_name1, 
    t[0].iconPath = a + e.data.pic_one, t[0].selectedIconPath = a + e.data.pic_one1, 
    t[1].current = 0, t[1].pagePath = "../seller/seller", t[1].text = e.data.db_name2, 
    t[1].iconPath = a + e.data.pic_tow, t[1].selectedIconPath = a + e.data.pic_tow1, 
    t;
}

function tabbarmain() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "tabdata", a = arguments[1], t = arguments[2], c = arguments[3], n = arguments[4], r = t, i = {};
    console.log(n);
    var o = aaa(c, n);
    o[a].iconPath = o[a].selectedIconPath, o[a].current = 1, i[e] = o, i.url = n, console.log(i), 
    r.setData({
        bindData: i
    });
}

module.exports = {
    tabbar: tabbarmain
};