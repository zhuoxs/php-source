var n = require("../common/component"), i = require("../mixins/transition");

(0, n.VantComponent)({
    mixins: [ (0, i.transition)(!0) ],
    props: {
        name: {
            type: String,
            value: "fade"
        }
    }
});