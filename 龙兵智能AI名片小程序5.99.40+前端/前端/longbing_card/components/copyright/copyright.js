var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Component({
    properties: {
        copyright: {
            type: Object
        }
    },
    data: {},
    methods: {
        previewImage: function(e) {
            var t = _xx_util2.default.getData(e).img;
            wx.previewImage({
                current: t,
                urls: [ t ]
            });
        },
        toCopyright: function(e) {
            _xx_util2.default.goUrl(e);
        }
    }
});