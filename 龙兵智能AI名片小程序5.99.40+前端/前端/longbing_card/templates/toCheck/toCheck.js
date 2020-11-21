var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Component({
    properties: {
        checkInd: {
            type: String,
            value: ""
        },
        qr: {
            type: String,
            value: ""
        }
    },
    data: {
        checkInd: -1
    },
    methods: {
        toJump: function(e) {
            var t = _xx_util2.default.getData(e);
            t.url, t.method;
            "toCancel" == t.status && this.setData({
                checkInd: -1
            });
        }
    }
});