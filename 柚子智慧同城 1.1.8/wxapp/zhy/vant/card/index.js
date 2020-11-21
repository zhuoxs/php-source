var i = require("../mixins/link");

(0, require("../common/component").VantComponent)({
    classes: [ "num-class", "desc-class", "thumb-class", "title-class", "price-class", "origin-price-class" ],
    mixins: [ i.link ],
    props: {
        tag: String,
        num: String,
        desc: String,
        thumb: String,
        title: String,
        price: String,
        centered: Boolean,
        lazyLoad: Boolean,
        thumbLink: String,
        originPrice: String,
        thumbMode: {
            type: String,
            value: "aspectFit"
        },
        currency: {
            type: String,
            value: "¥"
        }
    },
    methods: {
        onClickThumb: function() {
            this.jumpLink("thumbLink");
        }
    }
});