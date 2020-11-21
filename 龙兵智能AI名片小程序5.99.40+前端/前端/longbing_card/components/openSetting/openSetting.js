var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Component({
    properties: {
        scopeType: {
            type: String,
            value: ""
        },
        settingApp: {
            type: Object
        },
        settingText: {
            type: Object
        },
        isSetting: {
            type: Boolean,
            value: !1
        }
    },
    data: {
        contentList: {
            userLocation: [ "地理位置", "你的地理位置将用于选择地址" ],
            address: [ "通讯地址", "你的通讯地址将用于选择地址" ],
            record: [ "录音功能", "授权后方可正常使用录音功能" ],
            writePhotosAlbum: [ "保存到相册", "授权后方便你快速保存图片" ]
        },
        isSetting: !1
    },
    methods: {
        openSetting: function(t) {
            this.setData({
                isSetting: !1
            }), t.detail.authSetting["scope." + this.properties.scopeType] || wx.showToast({
                title: "授权失败，请授权后使用！",
                icon: "none"
            });
        },
        toJump: function(t) {
            var e = _xx_util2.default.getData(t);
            e.url, e.method;
            "toCancel" == e.status && this.setData({
                isSetting: !1
            });
        },
        formSubmit: function(t) {
            var e = t.detail.formId;
            _index.baseModel.getFormId({
                formId: e
            }).then(function(t) {});
            var i = _xx_util2.default.getFormData(t);
            i.url, i.method;
            "toCancel" == i.status && this.setData({
                isSetting: !1
            });
        }
    }
});