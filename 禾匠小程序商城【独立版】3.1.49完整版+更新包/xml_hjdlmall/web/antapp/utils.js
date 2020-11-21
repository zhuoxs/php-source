if (typeof wx === 'undefined') var wx = getApp().hj;
var utils = {
    scene_decode: function (scene) {
        var _str = scene + "";
        var _str_list = _str.split(",");
        var res = {};
        for (var i in _str_list) {
            var _tmp_str = _str_list[i];
            var _tmp_str_list = _tmp_str.split(":");
            if (_tmp_str_list.length > 0 && _tmp_str_list[0]) {
                res[_tmp_str_list[0]] = _tmp_str_list[1] || null;
            }
        }
        return res;
    },
    objectToUrlParams: function (param, key, encode) {
        if (param == null)
            return '';
        var paramStr = '';
        var t = typeof (param);
        if (t == 'string' || t == 'number' || t == 'boolean') {
            paramStr += '&' + key + '=' + ((encode == null || encode) ? encodeURIComponent(param) : param);
        } else {
            for (var i in param) {
                var k = key == null ? i : key + (param instanceof Array ? '[' + i + ']' : '.' + i);
                paramStr += this.objectToUrlParams(param[i], k, encode);
            }
        }
        return paramStr;
    },
};
module.exports = utils;