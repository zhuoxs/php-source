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
                selectedIconPath: "/style/images/indexSele.png",
                iconPath: "/style/images/index.png",
                text: "首页",
                index: 0
            }, {
                pagePath: "/yzhyk_sun/plugin/eatvisit/life/life",
                selectedColor: "#f5ac32",
                jumptype: "navigator",
                selectedIconPath: "../../resource/images/activeSelect.png",
                iconPath: "../../resource/images/active.png",
                text: "活动",
                index: 1
            }, {
                pagePath: "/yzhyk_sun/plugin/eatvisit/mycoupon/mycoupon",
                selectedColor: "#f5ac32",
                jumptype: "navigator",
                selectedIconPath: "../../resource/images/couponSelect.png",
                iconPath: "../../resource/images/coupon.png",
                text: "优惠券",
                index: 2
            }, {
                pagePath: "/yzhyk_sun/pages/user/user",
                selectedColor: "#f5ac32",
                jumptype: "navigator",
                selectedIconPath: "../../resource/images/mySelect.png",
                iconPath: "../../resource/images/my.png",
                text: "我的",
                index: 3
            } ]
        };
    }
};

module.exports = eatvisit;