var app = getApp();

Component({
    properties: {
        reportArr: {
            type: Array
        }
    },
    data: {},
    methods: {
        reportDetailClick: function(t) {
            var r = {
                id: t.currentTarget.dataset.index
            };
            this.triggerEvent("reportDetail", r);
        }
    },
    ready: function() {}
});