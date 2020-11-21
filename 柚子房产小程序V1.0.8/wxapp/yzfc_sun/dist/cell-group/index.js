Component({
    relations: {
        "../cell/index": {
            type: "child",
            linked: function() {
                this._updateIsLastCell();
            },
            linkChanged: function() {
                this._updateIsLastCell();
            },
            unlinked: function() {
                this._updateIsLastCell();
            }
        }
    },
    data: {
        cellUpdateTimeout: 0
    },
    methods: {
        _updateIsLastCell: function() {
            var e = this;
            if (!(0 < this.data.cellUpdateTimeout)) {
                var t = setTimeout(function() {
                    e.setData({
                        cellUpdateTimeout: 0
                    });
                    var t = e.getRelationNodes("../cell/index");
                    if (0 < t.length) {
                        var a = t.length - 1;
                        t.forEach(function(t, e) {
                            t.updateIsLastCell(e === a);
                        });
                    }
                });
                this.setData({
                    cellUpdateTimeout: t
                });
            }
        }
    }
});