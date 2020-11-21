var _create = require("../common/create");

(0, _create.create)({
    props: {
        disabled: {
            type: Boolean,
            observer: function() {
                var e = this.getRelationNodes("../tabs/index")[0];
                e && e.updateTabs();
            }
        },
        title: {
            type: String,
            observer: function() {
                var e = this.getRelationNodes("../tabs/index")[0];
                e && (e.setLine(), e.updateTabs());
            }
        }
    },
    relations: {
        "../tabs/index": {
            type: "ancestor"
        }
    },
    data: {
        inited: !1,
        active: !1
    }
});