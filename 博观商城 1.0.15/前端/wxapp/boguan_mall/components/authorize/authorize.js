Component({
    options: {
        multipleSlots: !0
    },
    behaviors: [],
    properties: {
        platform: {
            type: Object,
            value: ""
        },
        infoAuth: {
            type: Boolean,
            value: !0
        }
    },
    data: {},
    methods: {
        ready: function() {},
        onTab: function() {
            this.triggerEvent("cancelEvent");
        }
    }
});