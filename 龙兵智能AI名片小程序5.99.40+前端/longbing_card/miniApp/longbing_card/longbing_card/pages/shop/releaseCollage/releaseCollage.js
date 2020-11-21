var app = getApp(); 
var timerLeftTime;
Page({
  data: {
    globalData: {},
    bgStatus: false,
    shareStatus: false
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu(); 
    var paramData = {};
    if (options.id) {
      paramData.detailID = options.id
    } 
    if (options.collage_id) {
      paramData.collage_id = options.collage_id
    }
    if (options.to_uid) {
      paramData.to_uid = options.to_uid;
      app.globalData.to_uid = options.to_uid
    }
    if (options.from_id) {
      paramData.from_id = options.from_id;
      app.globalData.from_id = options.from_id
    }
    if (options.status) {
      paramData.status = options.status
    }
    if (options.sharestatus) {
      paramData.sharestatus = options.sharestatus
    }
    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })



    console.log(options,that,"releaseCollage   /////////////////  options")
    that.getProductDetail(); 
    wx.hideLoading();
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏 
    clearInterval(timerLeftTime);
  },
  onUnload: function () {
    // 页面关闭 
    clearInterval(timerLeftTime);
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    wx.showNavigationBarLoading();
    that.getProductDetail();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function (res) {
    // 用户点击右上角分享
    var that = this;
    var tmpData = that.data.paramData;

    if (res.from === 'button') {
      // console.log("来自页面内转发按钮");
    }
    else {
      // console.log("来自右上角转发菜单");
    }

    return {
      title: that.data.detailData.name,
      path: '/longbing_card/pages/shop/releaseCollage/releaseCollage?id='+ tmpData.detailID +'&collage_id='+ tmpData.collage_id + '&to_uid=' +  tmpData.to_uid + '&from_id=' + wx.getStorageSync("userid") +'&status=toPay&sharestatus=fromshare',
      imageUrl: that.data.detailData.cover_true,
    };

  },
  getProductDetail: function () {
    var that = this;
    console.log(that.data.paramData.to_uid, "app.globalData.to_uid") 
    app.util.request({
      'url': 'entry/wxapp/ShopGoodsDetail',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        goods_id: that.data.paramData.detailID,
        to_uid: that.data.paramData.to_uid
      },
      success: function (res) {
        console.log("entry/wxapp/goodsDetail ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;

          let {name,collage_count,cover2,qr} = tmpData;
          let shareParamObj = {name,collage_count,cover2,qr}; 
          that.setData({
            shareParamObj:shareParamObj,
            detailData: tmpData,
          },function(){ 
            that.getCollageList();
          })
          // that.getCurrentCheckIdAndPrice();
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getCollageList: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopcollagelist',
      'cachetime': '30',
     
      'method': 'POST',
      'data': {
        goods_id: that.data.paramData.detailID
      },
      success: function (res) {
        console.log("entry/wxapp/shopcollagelist ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          var dateUtil = new app.util.date();
          var tmpTimes;

          var tmpCollageData = {}
          for (let i in tmpData) {
            if (that.data.paramData.collage_id == tmpData[i].id) {
              tmpCollageData = tmpData[i]
            }
          }
          tmpData = tmpCollageData

          console.log(tmpData,"////////////////////////****tmpData")
       
          var tmpTime = tmpData.left_time;
          timerLeftTime = setInterval(() => { 
            tmpTime = tmpTime - 1;
            let day = parseInt(tmpTime / 24 / 60 / 60);
            day = day > 0 ? day + '天 ' : '';
            tmpTimes = day + dateUtil.dateToStr('HH:mm:ss', dateUtil.longToDate(tmpTime * 1000));

            that.setData({
              tmpTimes: tmpTimes
            });
          }, 1000);


          var tmpCheckUser = [];
          if (tmpData.users) {
            for (let i in tmpData.users) {
              tmpCheckUser.push(tmpData.users[i].id)
            }
          }
          if (tmpData.own) {
            tmpCheckUser.push(tmpData.own.id)
          }

          console.log(tmpCheckUser,"************///")


          for (let i in tmpCheckUser) {
            if (wx.getStorageSync("userid") == tmpCheckUser[i]) {
              that.setData({
                'paramData.status': 'toShare'
              })
            }
          }

          console.log(tmpData,"//////////////////******collageList")

          let {price,people} = tmpData;
          let shareParamObj2 =  {price,people}; 
          that.setData({
            shareParamObj2:shareParamObj2, 
            collageList: tmpData
          })

          // ,function(){
          //   wx.navigateTo({
          //     url: '/longbing_card/pages/shop/collageShare/collageShare'
          //   })
          // }
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcollagelist ==> fail ==> ", res)
      }
    })
  }, 
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    if (status == 'toCopyright' || status == 'toJumpIndex') {
      app.util.goUrl(e)
    } else if (status == 'toShare') {
      console.log("邀请好友拼单")
      that.setData({
        bgStatus: true,
        shareStatus: true
      });
    } else if (status == 'toCheckShare') {
      var num = e.currentTarget.dataset.num;
      if (num == 1) {
        console.log('发送给朋友');
      } else if (num == 2) {
        console.log('生成海报'); 
        wx.navigateTo({
          url: '/longbing_card/pages/shop/collageShare/collageShare'
        })
      } else if (num == 3) {
        console.log('取消');
      }
      that.setData({
        bgStatus: false,
        shareStatus: false
      });

    } else if (status == 'toJoinCollage') {
      console.log("一键拼单")

      var tmpCollage = that.data.collageList;
      var tmpData = that.data.detailData;

      for (let i in tmpData.spe_price) {
        if (tmpCollage.spe_price_id == tmpData.spe_price[i].id) {
          tmpData.stock = tmpData.spe_price[i].stock
        }
      }

      that.setData({
        detailData: tmpData
      })

      var tmpCarList = {
        count_price: tmpCollage.number * tmpCollage.price,
        tmp_trolley_ids: tmpData.id,
        dataList: [
          {
            name: tmpData.name,
            number: tmpCollage.number,
            goods_id: tmpData.id,
            cover_true: tmpData.cover_true,
            freight: tmpData.freight,
            spe: that.data.spe_text,
            price2: tmpCollage.price,
            stock: tmpData.stock,
            collage_id: tmpCollage.id
          }
        ],
      };
      wx.setStorageSync("storageToOrder", tmpCarList);

      let tmp_path = '/longbing_card/pages/shop/car/toOrder/toOrder?status=' + status;
      if(that.data.paramData.sharestatus == 'fromshare'){
        tmp_path = tmp_path + '&sharestatus=fromshare'
      }
      console.log("dddddddddddddd",tmp_path) 
      wx.navigateTo({
        url: tmp_path
      })
    }
  }
})