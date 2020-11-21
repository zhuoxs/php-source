Component({
    properties: {
        answerArr: {
            type: Array
        }
    },
    data: {},
    methods: {
        answerDetailClick: function(t) {
            console.log(t);
            var e = {
                id: t.currentTarget.dataset.id,
                p_id: t.currentTarget.dataset.data
            };
            this.triggerEvent("answer", e);
        }
    }
});