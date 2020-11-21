if (typeof wx === 'undefined') var wx = getApp().core;
module.exports = {
    currentPage: null,
    /**
     * 注意！注意！！注意！！！
     * 由于组件的通用，部分变量名称需统一，在各自引用的xxx.js文件需定义，并给对应变量赋相应的值
     * 以下变量必须定义并赋值
     * 
     * goods.pic_list  商品图片数组
     * goods.video_url 视频链接
     * 持续补充...
     */
    init: function (self) {
        var _this = this;
        _this.currentPage = self;

        if (typeof self.onGoodsImageClick === 'undefined') {
            self.onGoodsImageClick = function (e) {
                _this.onGoodsImageClick(e);
            }
        }
    },

    onGoodsImageClick: function (e) {
        var self = this.currentPage;
        var urls = [];
        var index = e.currentTarget.dataset.index;
        for (var i in self.data.goods.pic_list) {
            urls.push(self.data.goods.pic_list[i]);
        }

        getApp().core.previewImage({
            urls: urls, // 需要预览的图片http链接列表
            current: urls[index],
        });
    },
}