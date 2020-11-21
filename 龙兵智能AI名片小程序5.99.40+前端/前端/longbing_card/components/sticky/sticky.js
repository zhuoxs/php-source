Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _StyleHelper = require("../../libs/StyleHelper.js"), _StyleHelper2 = _interopRequireDefault(_StyleHelper);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Component({
    behaviors: [],
    properties: {
        scrollTop: {
            type: Number,
            observer: function(e) {
                this.setFixed();
            }
        },
        customStyle: {
            type: Object | String
        },
        top: {
            type: Number | String,
            value: 0
        }
    },
    options: {
        multipleSlots: !0
    },
    data: {
        fixed: !1,
        fakerStyle: "",
        selfTop: 0
    },
    ready: function() {
        this.setData({
            selfCustomStyle: _StyleHelper2.default.getPlainStyle(this.data.customStyle),
            fakerStyle: _StyleHelper2.default.getMergedPlainStyles([ this.data.customStyle, {
                top: this.data.top
            } ]),
            selfTop: Number(this.data.top)
        });
    },
    methods: {
        setFixed: function() {
            var t = this;
            wx.createSelectorQuery().in(this).select(".ui-sticky").boundingClientRect(function(e) {
                t.setData({
                    fixed: e.top - t.data.selfTop < 0
                });
            }).exec();
        }
    }
});