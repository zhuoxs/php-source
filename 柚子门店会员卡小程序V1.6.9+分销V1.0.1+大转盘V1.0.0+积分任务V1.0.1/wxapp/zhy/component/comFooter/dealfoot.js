function dealFootNav(e, o, t) {
    if (e.length < 1 && 1 != t) var i = [ {
        img: "../../resource/images/footnav/a.png",
        imgh: "../../resource/images/footnav/ah.png",
        icon: "",
        txt: "首页",
        link: "/cysc_sun/pages/home/index/index",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    }, {
        img: "../../resource/images/footnav/b.png",
        imgh: "../../resource/images/footnav/bh.png",
        icon: "",
        txt: "分类",
        link: "/cysc_sun/pages/home/classify/classify",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    }, {
        img: "../../resource/images/footnav/d.png",
        imgh: "../../resource/images/footnav/dh.png",
        icon: "",
        txt: "购物车",
        link: "/cysc_sun/pages/home/shopcar/shopcar",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    }, {
        img: "../../resource/images/footnav/e.png",
        imgh: "../../resource/images/footnav/eh.png",
        icon: "",
        txt: "我的",
        link: "/cysc_sun/pages/home/my/my",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    } ]; else {
        i = [];
        for (var s = 0; s < e.length; s++) {
            var a = e[s].clickago_icon, p = e[s].clickafter_icon, n = e[s].pic, c = /https\:\/\//;
            c.test(a) || (a = o + a), c.test(p) || (p = o + p), c.test(n) || (n = o + n);
            var g = {
                img: a,
                imgh: p,
                icon: n,
                txt: e[s].title,
                link: e[s].url,
                path: e[s].path,
                appid: e[s].appid,
                types: e[s].link_type,
                typeid: e[s].url_typeid,
                choose: !1
            };
            i.push(g);
        }
    }
    return i;
}

module.exports = {
    dealFootNav: dealFootNav
};