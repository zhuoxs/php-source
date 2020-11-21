var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Component({
    properties: {
        sharePanel: {
            type: Boolean
        },
        shareText: {
            type: String
        },
        shareUrl: {
            type: String
        }
    },
    data: {
        color: "#21bf34",
        isIphoneX: getApp().globalData.isIphoneX
    },
    methods: {
        toJump: function(e) {
            var t = _xx_util2.default.getData(e), a = t.status;
            t.type;
            "toShare" == a && this.setData({
                sharePanel: !1
            });
        },
        formSubmit: function(e) {
            var t = e.detail.formId;
            _index.baseModel.getFormId({
                formId: t
            });
            var a = _xx_util2.default.getFormData(e), r = a.url, i = (a.method, a.status), o = a.type;
            "toShare" == i && (this.setData({
                sharePanel: !1
            }), 2 == o && r && wx.navigateTo({
                url: r
            }));
        }
    }
});