Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _xx_util = require("../xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

exports.default = {
    Page: {
        goUrl: function(e) {
            _xx_util2.default.goUrl(e);
        },
        goBack: function(e) {
            var t = _xx_util2.default.getData(e).delta;
            wx.navigateBack({
                delta: 1 * t || 1
            });
        },
        formSubmit: function(e) {
            var t = e.detail.formId;
            _index.baseModel.getFormId({
                formId: t
            });
        }
    }
};