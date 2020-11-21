// yzkm_sun/pages/myFabu/myFabu.js
// var fabuData=[];
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    yh_id: '',
    fabuData: [
      {
        headerImg: 'http://oydnzfrbv.bkt.clouddn.com/touxiang.png',
        name: '那棵树看起来真生气了',
        contents: '厦门市有什么好吃的吗可以推荐给我推荐给我？求推荐求介绍求推荐求介绍...',
        contentImgs: ['http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png', 'http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png'],
        address: '厦门市集美区杏林湾营运中心9号楼正面',
        date: '2018-04-09 18:00',
        see: '2018',
        zan: "04",
        conmm: '24'
      },
      {
        headerImg: 'http://oydnzfrbv.bkt.clouddn.com/touxiang.png',
        name: '那棵树看起来真生气了',
        contents: '厦门市有什么好吃的吗可以推荐给我推荐给我？求推荐求介绍求推荐求介绍...',
        contentImgs: ['http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png', 'http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png'],
        address: '厦门市集美区杏林湾营运中心9号楼正面',
        date: '2018-04-20 18:00',
        see: '2018',
        zan: "04",
        conmm: '24'
      }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    console.log(options)
    console.log(that.data.fabuData)
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.getStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    })
    // 用户openid转id   
    var openid = wx.getStorageSync('openid');//用户openid
    console.log(openid)
    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res.data);
        that.setData({
          yh_id: res.data.id,
        })
        wx.setStorageSync('user_id', res.data.id);
      }
    })

    that.diyWinColor();

  },

  // 跳转圈子详情页面
  toCircleDetails(e) {
      console.log('跳转我的发布详情页id')
      console.log(e)
      var myfabu_id = e.currentTarget.dataset.id;
      app.util.request({
        'url': 'entry/wxapp/Quan_sc',
        data: {
          fabu_yh_id: myfabu_id,
        },
        success: function (res) {
          console.log('判断收藏的圈子是否已删除');
          console.log(res);
          if (res.data.dele_sta == 2) {
            wx.showToast({
              title: '该收藏已被删除或下架',
              icon: 'none',
            })
            return false;
          }

          wx.navigateTo({
            url: '../circle/details/details?id=' + myfabu_id,
          })
        }
      })     
      // wx.navigateTo({
      //   url: '../circle/details/details?id=' + myfabu_id,
      // })
      // wx.navigateTo({
      //   url: './details/details',
      // })
  },
  // 点赞点击事件
  praise(e) {
    var that = this
    console.log('圈子说说id')
    console.log(e.currentTarget.dataset.id)
    var idx = e.currentTarget.dataset.idx;
    var fabu_id = that.data.list[idx].id;

    var user_id = wx.getStorageSync('user_id');//用户openid
    that.diyWinColor();
    app.util.request({
      url: 'entry/wxapp/Tickle_qz',
      data: {
        openid: user_id,
        fabu_id: fabu_id,
      },
      success: function (res) {
        console.log('圈子点赞数据信息');
        console.log(res);
        if (res.data == 1) {
          that.setData({
            ['list[' + idx + '].praise']: that.data.list[idx].praise - 0 + 1
          })
        }
      }
    })
  },
  // 删除发布内容方法
  delete(e) {
    var that=this;
    console.log('删除评论内容')
    console.log(e)
    app.util.request({
      url: 'entry/wxapp/Delete_myfabu',
        data: {
          zx_id: e.currentTarget.dataset.id
        },
      success: function (res) {
        wx.showModal({
          title: '提示',
          content: '确定要删除该内容？',
          success: function (res) {
            if (res.confirm) {
              console.log('用户点击确定')
              console.log('删除返回数据');
              console.log(res.data);
              wx.showToast({
                title: '删除成功',
              })
              // 延时调用刷新页面
              setTimeout(function () {
                that.onShow()
              }, 2000)

            } else if (res.cancel) {
              console.log('用户点击取消')
            }
          }
        })
      },
      fail:function(res){
        wx.showToast({
          title: '删除失败',
        })
      }
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function (e) {
    var that = this
    // 获取我的发布信息
    console.log('11111111111111')
    // setTimeout(function () { 
      var user_id = wx.getStorageSync('user_id')//用户ID
      // console.log(user_id)
    // }, 500)

    app.util.request({
      url: 'entry/wxapp/Publish_mine',
      data: {
        yh_id: user_id
      },
      success: function (res) {
        console.log('查看我的发布信息');
        console.log(res.data);
        that.setData({
          list: res.data,
        })
      }
    })
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },
  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '我的发布',
    })
  },
})