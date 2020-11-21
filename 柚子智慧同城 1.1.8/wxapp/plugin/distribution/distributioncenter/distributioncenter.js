/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var t = getApp();
t.Base({
    data: {
        extractable: 0
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(i) {
            t.setData({
                user: i
            }), t.onLoadData(i)
        }, "/plugin/distribution/distributioncenter/distributioncenter")
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        })
    },
    onLoadData: function(i) {
        var a = this;
        Promise.all([t.api.apiDistributionIsDistributionpromoter({
            user_id: this.data.user.id
        }), t.api.apiDistributionGetDistributionset({})]).then(function(t) {
            var i = a.data.extractable;
            i = (t[0].data.canwithdraw - t[0].data.freezemoney).toFixed(2), a.setData({
                show: !0,
                extractable: i,
                detail: t[0].data,
                info: t[1].data
            })
        }).
        catch (function(i) {
            t.tips(i.msg)
        })
    },
    onPosterTab: function() {
        var i = this;
        if (this.data.info.poster_pic && "" != this.data.info.poster_pic) if (wx.showLoading({
            title: "海报生成中..."
        }), this.data.posterUrl) wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        });
        else {
            var a = {
                link: "pages/home/home?s_id=" + this.data.user.id,
                width: 120
            };
            t.api.apiGetQRCode(a).then(function(t) {
                wx.showLoading({
                    title: "海报生成中..."
                }), i.setData({
                    posterinfo: {
                        delRoot: t.data.path,
                        bg: i.data.support.config.poster_goods ? t.other.img_root + i.data.support.config.poster_goods : "",
                        img: t.other.img_root + i.data.info.poster_pic,
                        avatar: i.data.user.avatar,
                        qr: t.other.img_root + t.data.path,
                        title: i.data.info.poster_title,
                        price: "长按发现更多惊喜",
                        name: i.data.user.nickname,
                        hot: "",
                        recommend: "特别为您推荐的小程序",
                        style: 2
                    },
                    loadImgKey: !0
                })
            }).
            catch (function(i) {
                t.tips(i.msg)
            })
        } else t.tips("没有商品封面图！")
    },
    createPoster: function(t) {
        var i = t.detail;
        this.setData({
            posterUrl: i.url
        }), wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        })
    },
    onDepositTap: function() {
        t.navTo("/base/deposit/deposit?page=1&id=" + this.data.shop.store.id)
    },
    onTeamTap: function() {
        t.navTo("/plugin/distribution/team/team")
    },
    onOrderTap: function() {
        t.navTo("/plugin/distribution/order/order")
    },
    withdrawal: function() {
        t.navTo("/plugin/distribution/withdrawal/withdrawal")
    },
    onCommissionTap: function() {
        t.navTo("/plugin/distribution/commission/commission")
    },
    onDetailTap: function() {
        t.navTo("/plugin/distribution/detail/detail")
    },
    onCommissiondetailTap: function() {
        t.navTo("/plugin/distribution/commissiondetail/commissiondetail")
    }
});