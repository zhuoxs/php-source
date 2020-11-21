var _create = require("../common/create"), _transition = require("../mixins/transition");

(0, _create.create)({
    mixins: [ (0, _transition.transition)(!0) ],
    props: {
        name: {
            type: String,
            value: "fade"
        }
    }
});