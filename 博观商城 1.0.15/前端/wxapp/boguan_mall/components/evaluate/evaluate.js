Component({
    options: {
        multipleSlots: !0
    },
    behaviors: [],
    properties: {
        commentArray: {
            type: Object,
            value: ""
        }
    },
    data: {},
    methods: {
        ready: function() {
            this.setData({
                commentArray: this.data.commentArray
            });
        },
        previewImage: function(t) {
            var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.idx;
            wx.previewImage({
                urls: this.data.commentArray[e].image,
                current: this.data.commentArray[e].image[a]
            });
        }
    }
});