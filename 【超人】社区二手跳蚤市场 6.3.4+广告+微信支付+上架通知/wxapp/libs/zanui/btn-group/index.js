function updateBtnChild() {
    var t = this.getRelationNodes("../btn/index");
    if (0 < t.length) {
        var i = t.length - 1;
        t.forEach(function(t, n) {
            t.switchLastButtonStatus(n === i);
        });
    }
}

Component({
    relations: {
        "../btn/index": {
            type: "child",
            linked: function() {
                updateBtnChild.call(this);
            },
            linkChange: function() {
                updateBtnChild.call(this);
            },
            unlinked: function() {
                updateBtnChild.call(this);
            }
        }
    }
});