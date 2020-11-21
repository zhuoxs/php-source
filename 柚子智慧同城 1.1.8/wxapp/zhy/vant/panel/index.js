(0, require("../common/component").VantComponent)({
    classes: [ "header-class", "footer-class" ],
    props: {
        desc: String,
        title: String,
        status: String,
        useFooterSlot: Boolean
    }
});