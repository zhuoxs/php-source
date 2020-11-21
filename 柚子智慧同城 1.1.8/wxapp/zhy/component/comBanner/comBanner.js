var t = getApp(), e = require("../comFooter/dealfoot.js");

Component({
    properties: {
        banner: {
            type: Object,
            value: {
                list: [],
                root: ""
            },
            observer: function(t, a) {
                if (t) {
                    var r = e.dealFootNav(t.list, t.root, 1);
                    this.setData({
                        ban: r
                    });
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
    methods: {
        _onNavTap: function(e) {
            var a = getCurrentPages(), r = "/" + a[a.length - 1].route, n = e.currentTarget.dataset.index, o = this.data.ban[n].link;
            if (o) {
                var i = this.data.ban[n].typeid;
                o != r && "" != o && t.navTo(o + "?id=" + i);
            }
        },
        _onSearchTap: function() {
            t.navTo(this.data.searchLink);
        }
    }
});