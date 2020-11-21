var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Component({
    properties: {
        tabbar: {
            type: Object
        },
        type: {
            type: String
        },
        nowPageIndex: {
            type: String
        },
        isIphoneX: {
            type: Boolean
        }
    },
    data: {},
    methods: {
        formSubmit: function(t) {
            var e = _xx_util2.default.getFormData(t), r = e.url, i = e.method, u = e.type, a = e.curr, o = e.index, n = e.text, p = t.detail.formId;
            this.triggerEvent("tabJump", {
                url: r,
                method: i,
                type: u,
                curr: a,
                index: o,
                text: n,
                formId: p
            });
        }
    },
    ready: function() {
        this.setData({
            isIphoneX: getApp().globalData.isIphoneX
        });
    }
});