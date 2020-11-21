Component({
    properties: {
        close: {
            type: Boolean,
            value: !0
        }
    },
    data: {},
    methods: {
        close: function() {
            this.triggerEvent("willClose");
        }
    }
});