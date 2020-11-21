var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(n, o) {
            return function t(e, r) {
                try {
                    var a = u[e](r), i = a.value;
                } catch (e) {
                    return void o(e);
                }
                if (!a.done) return Promise.resolve(i).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                n(i);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        nowPageIndex: 1,
        color: "#30c574",
        tabbar: {
            color: "#838591",
            selectedColor: "#11c95e",
            backgroundColor: "#fff",
            borderStyle: "white",
            list: [ {
                pagePath: "/longbing_card/staffs/pages/article/index/index",
                text: "获客文章",
                iconPath: "icon-shejiwenzhang201",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/staffs/pages/article/import/import",
                text: "发文章",
                iconPath: "/longbing_card/resource/images/article/icon-fabu.png",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/staffs/pages/article/myself/myself",
                text: "我的文章",
                iconPath: "icon-wode",
                method: "redirectTo"
            } ]
        },
        showRule: 0,
        url: "",
        classify_id: "",
        classify_title: ""
    },
    onLoad: function(e) {
        var t = getApp().globalData, r = {
            logoImg: t.logoImg,
            isIphoneX: t.isIphoneX
        }, a = wx.getStorageSync("userid");
        this.setData({
            $gd: r,
            to_uid: a
        });
    },
    toSetUrl: function(e) {
        var t = _xx_util2.default.getValue(e);
        this.setData({
            url: t
        });
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), r = e.url, a = e.classify_id;
        return t.add(r, "isNoEmpty", "请粘贴您要分享的公众号文章链接"), t.add(r, "isUrl", "请粘贴正确的文章链接"), 
        t.add(a, "isNoEmpty", "选择文章分类"), t.start();
    },
    toImport: function() {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, i, n, o, u, l, s, d;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (r = (t = c).data, a = r.url, i = r.classify_id, n = r.to_uid, o = {
                        url: a,
                        classify_id: i
                    }, !(u = t.validate(o))) {
                        e.next = 7;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: u
                    }), e.abrupt("return");

                  case 7:
                    return _xx_util2.default.showLoading({
                        title: "文章解析中"
                    }), e.next = 10, _index.pluginModel.toArticleImport(o);

                  case 10:
                    l = e.sent, s = l.errno, d = l.data, _xx_util2.default.hideAll(), wx.navigateTo({
                        url: "/longbing_card/staffs/pages/article/detail/detail?id=" + d.id + "&uid=" + n + "&err=" + s
                    });

                  case 15:
                  case "end":
                    return e.stop();
                }
            }, e, c);
        }))();
    },
    toShowRule: function(e) {
        var t = _xx_util2.default.getData(e).type;
        this.setData({
            showRule: 0 == t ? 1 : 0
        });
    }
});