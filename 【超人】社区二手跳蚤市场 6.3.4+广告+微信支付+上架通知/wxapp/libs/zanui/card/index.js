Component({
    options: {
        multipleSlots: !0
    },
    externalClasses: [ "card-class" ],
    properties: {
        useThumbSlot: {
            type: Boolean,
            value: !1
        },
        useDetailSlot: {
            type: Boolean,
            value: !1
        },
        thumb: String,
        price: String,
        title: String,
        btnText: String,
        num: String,
        desc: String,
        status: String
    }
});