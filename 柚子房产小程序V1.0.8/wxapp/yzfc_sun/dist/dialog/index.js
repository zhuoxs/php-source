var defaultData = require("./data"), _f = function() {};

Component({
    properties: {},
    data: Object.assign({}, defaultData, {
        key: "",
        show: !1,
        showCustomBtns: !1,
        promiseFunc: {}
    }),
    methods: {
        handleButtonClick: function(t) {
            var e = t.currentTarget, a = (void 0 === e ? {} : e).dataset, o = void 0 === a ? {} : a, s = this.data.promiseFunc || {}, i = s.resolve, n = void 0 === i ? _f : i, r = s.reject, c = void 0 === r ? _f : r;
            this.setData({
                show: !1
            }), this.data.showCustomBtns ? n({
                type: o.type
            }) : "confirm" === o.type ? n({
                type: "confirm"
            }) : c({
                type: "cancel"
            });
        }
    }
});