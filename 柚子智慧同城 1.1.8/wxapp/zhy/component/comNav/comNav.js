var t = getApp(), a = require("../comFooter/dealfoot.js");

Component({
    properties: {
        nav: {
            type: Object,
            value: [],
            observer: function(t, e) {
                if (t) {
                    var n = a.dealFootNav(t.list, t.root, 1);
                    this._dealData(n);
                }
            }
        },
        height: {
            type: [ String, Number ],
            value: 340
        },
        showSearch: {
            type: Boolean,
            value: !1
        },
        searchLink: {
            type: String,
            value: ""
        }
    },
    data: {},
    attached: function() {},
    methods: {
        _dealData: function(t) {
            for (var a = t, e = [], n = 0; n < a.length; n += 10) e.push(a.slice(n, n + 10));
            this.setData({
                na: e
            });
        },
        _onNavTap: function(a) {
            var e = getCurrentPages(), n = a.currentTarget.dataset.index, r = a.currentTarget.dataset.idx, o = this.data.na[n][r].link, i = "/" + e[e.length - 1].route, s = this.data.na[n][r].typeid;
            o != i && "" != o && t.navTo(o + "?id=" + s);
        },
        _onSearchTap: function() {
            t.navTo(this.data.searchLink);
        }
    }
});