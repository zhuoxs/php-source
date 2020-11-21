var eatvisit = {
    eattabname: function(e, t) {
        return {
            color: "#8c8c8c",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#fff",
            list: [ {
                pagePath: "/yzhyk_sun/pages/index/index",
                jumptype: "redirect",
                selectedColor: "#f5ac32",
                selectedIconPath: "../../../../style/images/tab4.png",
                iconPath: "../../../../style/images/tab4.png",
                text: "到店",
                index: 0
            }, {
                pagePath: "/pages/plugin/eatvisit/life/life",
                selectedColor: "#f5ac32",
                jumptype: "navigator",
                selectedIconPath: "../../../../style/images/goodsSele.png",
                iconPath: "../../../../style/images/goods.png",
                text: "活动",
                index: 1
            }, {
                pagePath: "/pages/plugin/eatvisit/mycoupon/mycoupon",
                selectedColor: "#f5ac32",
                jumptype: "navigator",
                selectedIconPath: "../../resource/images/couponSelect.png",
                iconPath: "../../resource/images/coupon.png",
                text: "礼品",
                index: 2
            } ]
        };
    }
};

module.exports = eatvisit;