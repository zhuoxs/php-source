var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Component({
    properties: {
        fixBtn: {
            type: Object
        }
    },
    data: {},
    methods: {
        formSubmit: function(e) {
            var t = e.detail.formId;
            _index.baseModel.getFormId({
                formId: t
            });
            var r = _xx_util2.default.getFormData(e), i = r.url, o = r.method, a = r.delta, u = r.status;
            if ("toJumpUrl" == u) {
                if (a) return wx[o]({
                    delta: a
                }), !1;
                wx[o]({
                    url: i
                });
            }
            "toConfirm" == u && this.triggerEvent("fixBtnConfirm");
        }
    },
    ready: function() {
        console.log(getApp().globalData.isIphoneX), this.setData({
            isIphoneX: getApp().globalData.isIphoneX
        });
    }
});