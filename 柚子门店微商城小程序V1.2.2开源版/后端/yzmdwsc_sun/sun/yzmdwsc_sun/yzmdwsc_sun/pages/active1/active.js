// yzmdwsc_sun/pages/active/active.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '动态',
    banner: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png',
    dynamicList:[
      {
        name:'柚子鲜花店',
        uthumb:"http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png",
        cont:'红玫瑰 送花对象 朋友、恋人、家人红玫瑰 送花对象 朋友、恋人、家人红玫瑰 送花对象 朋友、恋人、家人红玫瑰 送花对象 朋友、恋人、家人',
        imaArr: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768182.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png'],
        goods:[
          {
            id:'1',
            title:'红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰',
            src:"http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png",
            price:'60.00',
            oldPrice:'100.00'
          }
        ],
        good: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', ],
        comment:[
          {
            name:'墨纸墨纸',
            comment:'你好你好你好你好你好你好你好你好你好你好你好你好你好你好'
          },
          {
            name: '墨纸',
            comment: '你好你好'
          },
        ],
        times:'24小时',
        goodsStatu:0,/**0是未点赞 1已点赞 */
      },
      {
        name: '柚子鲜花店',
        uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png",
        cont: '红玫瑰 送花对象 朋友、恋人、家人',
        imaArr: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768182.png'],
        goods: [
          {
            id: '',
            title: '红玫瑰',
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png",
            price: '60.00',
            oldPrice: '100.00'
          }
        ],
        good: [],
        comment: [
          {
            name: '墨纸',
            comment: '你好你好'
          }
        ],
        times: '24小时',
        goodsStatu: 0,/**0是未点赞 1已点赞 */
      }
    ],
    inputShowed:false,
    comment:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    app.editTabBar();  /**渲染tab */
    var that = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    var tab = wx.getStorageSync('tab');
    this.setData({
      current: options.currentIndex,
      tab: tab,
    })
    
    wx.getUserInfo({
      success: function (res) {
        that.setData({
          uthumb: res.userInfo.avatarUrl,
          nickname: res.userInfo.nickName
        })
      }
    })
  },
  
  //底部链接
  goTap: function (e) {
    console.log(e);
    var that = this;
    that.setData({
      current: e.currentTarget.dataset.index
    })

    if (that.data.current == 0) {
      wx.redirectTo({
        url: '../index/index?currentIndex=' + 0,
      })
    };
    if (that.data.current == 1) {
      wx.redirectTo({
        url: '../shop/shop?currentIndex=' + 1,
      })
    };
    if (that.data.current == 2) {
      wx.redirectTo({
        url: '../active/active?currentIndex=' + 2,
      })
    };
    if (that.data.current == 3) {
      wx.redirectTo({
        url: '../carts/carts?currentIndex=' + 3,
      })
    };
    if (that.data.current == 4) {
      wx.redirectTo({
        url: '../user/user?currentIndex=' + 4,
      })
    };

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
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
  /***点赞 */
  clickGood(e){
    var that=this;
    const dynamicList = that.data.dynamicList;
    var statu = e.currentTarget.dataset.statu;
    var index = e.currentTarget.dataset.index;
    
    if (statu ==0){
      dynamicList[index].goodsStatu=1;
    }else{
      dynamicList[index].goodsStatu = 0;
    }
    that.setData({
      dynamicList: dynamicList
    })
  },
  /**点击图标评论 */
  toMsg(e){
    var that = this;
    const dynamicList = that.data.dynamicList;
    var index = e.currentTarget.dataset.index;

    that.setData({
      inputShowed: true,
      commIndex:index/**需要评论的数组下标 */
    })
  },
  /**失去焦点          发送评论 */
  loseFocus(e){
    var that = this;
    var dynamicList = that.data.dynamicList
    var commIndex = that.data.commIndex;/**需要评论的数组下标 */
    var comment = that.data.comment;/*** 获取评论内容*/
    console.log(commIndex + 'comment: ' + comment )
    var comObj={}/**对象 */


    comObj.name = that.data.nickname;
    comObj.comment=comment;
    (dynamicList[commIndex].comment).push(comObj)

    that.setData({
      dynamicList: dynamicList,
      comment:'',/**成功后comment要为空 */
      inputShowed: false
    })
    
  },
  /**获取评论 */
  comment(e){
    this.setData({
      comment:e.detail.value
    })
  },
  toGoodsdet(e) {
    wx: wx.navigateTo({
      url: '../index/goodsDet/goodsDet',
    })
  },

})