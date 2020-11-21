Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _mpExtend = require("mp-extend.js"), _mpExtend2 = _interopRequireDefault(_mpExtend), _mpData = require("mp-data.js"), _mpData2 = _interopRequireDefault(_mpData), _mpMethod = require("mp-method.js"), _mpMethod2 = _interopRequireDefault(_mpMethod);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

(0, _mpExtend2.default)(_mpData2.default), (0, _mpExtend2.default)(_mpMethod2.default), 
exports.default = {
    App: _mpExtend2.default.App,
    Page: _mpExtend2.default.Page,
    Component: _mpExtend2.default.Component
};