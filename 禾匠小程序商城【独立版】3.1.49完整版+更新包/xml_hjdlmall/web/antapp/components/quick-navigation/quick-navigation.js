if (typeof wx === 'undefined') var wx = getApp().core;
module.exports = {

    init: function(self) {
        var _this = this;
        _this.currentPage = self;
        _this.setNavi();

        if (typeof self.cutover === 'undefined') {

            self.cutover = function(e) {
                _this.cutover(e);
            }
        }
    },


    setNavi: function() {
        let self = this.currentPage;
        if(this.getCurrentPageUrl()=='pages/index/index'){
            self.setData({
                home_icon:true,
            })
        }
        getApp().getConfig(function (config) {
            var setnavi = config.store.quick_navigation;
            if (!setnavi.home_img) {
                setnavi.home_img = "/images/quick-home.png";
            }
            self.setData({
                setnavi: setnavi
            })
        })
    },

    getCurrentPageUrl: function(){
        var pages = getCurrentPages()    //获取加载的页面
        var currentPage = pages[pages.length-1]    //获取当前页面的对象
        var url = currentPage.route    //当前页面url
        return url
    },

    cutover: function() {
        var self = this.currentPage;
    
        var status = 0;
        self.setData({
            quick_icon: !self.data.quick_icon
        });


        let animationPlus = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        })
        let animationPic = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        });
        let animationcollect = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        });
        let animationTranspond = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        });
        let animationInput = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        });


        getApp().getConfig(function (config) {
        var store = self.data.store;
            var x = -55;
            if (self.data.quick_icon) {




                if (store['option'] && store['option']['wxapp'] && store['option']['wxapp']['pic_url']) {
                    animationInput.translateY(x).opacity(1).step();
                    x = x - 55;
                }
                if (store['show_customer_service'] && store['show_customer_service'] == 1 && store['service']) {
                    animationTranspond.translateY(x).opacity(1).step();
                    x = x - 55;
                }
                if (store['option'] && store['option']['web_service']) {
                    animationcollect.translateY(x).opacity(1).step();
                    x = x - 55;
                }

                if (store['dial'] == 1 && store['dial_pic']) {
                    animationPic.translateY(x).opacity(1).step();
                    x = x - 55;
                }



                animationPlus.translateY(x).opacity(1).step();
            } else {
                animationPlus.opacity(0).step();
                animationcollect.opacity(0).step();
                animationPic.opacity(0).step();
                animationTranspond.opacity(0).step();
                animationInput.opacity(0).step();
            }
            self.setData({
                animationPlus: animationPlus.export(),
                animationcollect: animationcollect.export(), 
                animationPic: animationPic.export(),
                animationTranspond: animationTranspond.export(),
                animationInput: animationInput.export(),
            });
        });
    }

    /*quickNavigation: function () {
        var status = 0;
        this.setData({
            quick_icon: !this.data.quick_icon
        })
        var store = this.data.store;
        var animationPlus = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        });

        var x = -55;
        if (!this.data.quick_icon) {
            animationPlus.translateY(x).opacity(1).step();
        } else {
            animationPlus.opacity(0).step();
        }
        this.setData({
            animationPlus: animationPlus.export(),
        });
    },*/
}