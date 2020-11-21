function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

Component({
    properties: {
        firstText: {
            type: String
        },
        dataList: {
            type: Array
        }
    },
    methods: {
        richEditorTextarea: function(t) {
            console.log(t), 0 === parseInt(t.currentTarget.id) ? this.setData({
                firstText: t.detail.value
            }) : this.setData(_defineProperty({}, "dataList[" + (parseInt(t.currentTarget.id) - 1) + "].text", t.detail.value)), 
            this.triggerEvent("okEvent", {
                dataList: this.data.dataList,
                firstText: this.data.firstText
            });
        },
        richEditorAddImg: function(t) {
            var i = this;
            wx.chooseImage({
                count: 1,
                success: function(t) {
                    var e = {
                        img: t.tempFilePaths[0],
                        temp: !0,
                        text: ""
                    }, a = i.data.dataList;
                    a.splice(i.data.imgIndex, 0, e), console.log(a), i.setData({
                        dataList: a
                    }), i.triggerEvent("okEvent", {
                        dataList: i.data.dataList,
                        firstText: i.data.firstText
                    });
                }
            });
        },
        richEditorTextareaBlur: function(t) {
            this.setData({
                imgIndex: parseInt(t.currentTarget.id)
            });
        },
        richEditorImg: function(t) {
            var a = parseInt(t.currentTarget.id), i = this;
            wx.showActionSheet({
                itemList: [ "删除" ],
                success: function(t) {
                    if (0 == t.tapIndex) {
                        var e = i.data.dataList;
                        "" != e[a].text ? 0 === a ? (i.setData({
                            firstText: i.data.firstText + e[a].text
                        }), e.splice(a, 1)) : e[a - 1].text = e[a - 1].text + e[a].text : e.splice(a, 1), 
                        i.setData({
                            dataList: e
                        });
                    }
                }
            }), this.triggerEvent("okEvent", {
                dataList: this.data.dataList,
                firstText: this.data.firstText
            });
        }
    }
});