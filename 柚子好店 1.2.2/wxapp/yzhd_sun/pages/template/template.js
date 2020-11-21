function tabbarinit() {
    return [ {
        current: 0,
        pagePath: "../index/index",
        text: "精选",
        iconPath: "../../resource/images/index/jingxuan-1.png",
        selectedIconPath: "../../resource/images/index/jingxuan.png"
    }, {
        current: 0,
        pagePath: "../bestShops/bestShops",
        text: "好店",
        iconPath: "../../resource/images/index/haodian-1.png",
        selectedIconPath: "../../resource/images/index/haodian.png"
    }, {
        current: 0,
        pagePath: "../mine/mine",
        text: "我的",
        iconPath: "../../resource/images/index/wode-1.png",
        selectedIconPath: "../../resource/images/index/wode.png"
    }, {
        current: 0,
        pagePath: "../fansCard/fansCard",
        text: "粉丝卡",
        iconPath: "../../resource/images/index/fensika-1.png",
        selectedIconPath: "../../resource/images/index/fensika_s.png"
    } ];
}

function tabbarmain() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "tabdata", a = arguments[1], n = arguments[2], t = {}, i = tabbarinit();
    i[a].iconPath = i[a].selectedIconPath, i[a].current = 1, t[e] = i, n.setData({
        bindData: t
    });
}

module.exports = {
    tabbar: tabbarmain
};