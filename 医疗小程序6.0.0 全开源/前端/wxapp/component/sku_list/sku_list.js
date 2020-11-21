Component({
    properties: {
        keArr: {
            type: Array,
            value: []
        }
    },
    data: {},
    methods: {
        detailClick: function(t) {
            var e = {
                id: t.currentTarget.dataset.id,
                title: t.currentTarget.dataset.data
            };
            this.triggerEvent("detailBtn", e);
        }
    }
});