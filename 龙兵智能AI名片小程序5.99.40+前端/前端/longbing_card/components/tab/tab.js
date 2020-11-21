function _defineProperty(e, t, i) {
    return t in e ? Object.defineProperty(e, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = i, e;
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _WxHelper = require("../../libs/WxHelper.js"), _WxHelper2 = _interopRequireDefault(_WxHelper), _MultiHelper = require("../../libs/MultiHelper.js"), _MultiHelper2 = _interopRequireDefault(_MultiHelper);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var ParentPath = "../tabs/tabs";

Component({
    properties: {},
    data: {
        selfStyle: "",
        index: -1,
        active: !1,
        width: 0,
        height: 0,
        parent: {},
        isParentInkBar: !1
    },
    relations: _defineProperty({}, ParentPath, {
        type: "parent"
    }),
    methods: {
        _init: function() {
            var t = this, i = this.getRelationNodes(ParentPath)[0];
            _WxHelper2.default.getComponentRect(this, ".ui-tab").then(function(e) {
                i._increaseWalkDistance(e), t.setData({
                    isParentInkBar: i.data.inkBar,
                    width: e.width,
                    height: e.height,
                    index: _MultiHelper2.default.getChildIndex(i, t)
                });
            });
        },
        handleTap: function() {
            this.getRelationNodes(ParentPath)[0].handleIndexChange(this.data.index, !1);
        }
    },
    ready: function() {
        this._init();
    }
});