var app = getApp();
var image = '';
//20180426 @淡蓝海寓 
var util = require('../../../resource/utils/util.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    src: [],
    tab: 0,   //这个留下切换是达人圈还是结伴行，并且下面照片上传的次数限制也是这里+1的
    content: '', //用户发布输入的值
    contetn_time: '', //结伴行内容中的时间
    content_route: '', //结伴行内容中的路线
    goId: 0,
    showbox: 1,
    goods_id: '', //商品id
    visa_id: '', //签证id
    goods: '',
    pics: [],
    imgAddr: '',
    gowithtime: "年/月/日",
    thistime: util.formatTime,
    disabled: false,
    sendtitle: "发送",
    tabBarList: [
      {
        state: false,
        url: 'goIndex',
        publish: false,
        text: "训练",
        iconPath: "/byjs_sun/resource/images/indexFooter/index.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/index-1.jpg"
      },
      {
        state: false,
        url: 'goChargeIndex',
        publish: false,
        text: "充能量",
        iconPath: "/byjs_sun/resource/images/indexFooter/charge.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/charge-1.jpg"
      },
      {
        state: true,
        url: 'goPublishTxt',
        publish: true,
        text: "发布",
        iconPath: "/byjs_sun/resource/images/indexFooter/release.png",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/release.png"
      },
      {
        state: false,
        url: 'goFindIndex',
        publish: false,
        text: "发现",
        iconPath: "/byjs_sun/resource/images/indexFooter/find.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/find-1.jpg"
      },
      {
        state: false,
        url: 'goMy',
        publish: false,
        text: "我的",
        iconPath: "/byjs_sun/resource/images/indexFooter/my.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/my-1.jpg"
      }

    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that  = this 
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
    // 获取底部图标
    app.util.request({
      'url': 'entry/wxapp/Tab',
      'cachetime': 30,
      success: function (res) {
        var data1 = [{
          state: false,
          url: 'goIndex',
          publish: false,
          text: res.data.data.index,
          iconPath: res.data.data.indeximg,
          selectedIconPath: res.data.data.indeximgs,
        },
        {

          state: false,
          url: 'goChargeIndex',
          publish: false,
          text: res.data.data.coupon,
          iconPath: res.data.data.couponimg,
          selectedIconPath: res.data.data.couponimgs,
        },
        {
          state: true,
          url: 'goPublishTxt',
          publish: true,
          text: res.data.data.fans,
          iconPath: res.data.data.fansimg,
          selectedIconPath: res.data.data.fansimgs,
        },
        {
          state: false,
          url: 'goFindIndex',
          publish: false,
          text: res.data.data.find,
          iconPath: res.data.data.findimg,
          selectedIconPath: res.data.data.findimgs,
        },
        {
          state: false,
          url: 'goMy',
          publish: false,
          text: res.data.data.mine,
          iconPath: res.data.data.mineimg,
          selectedIconPath: res.data.data.mineimgs,
        },
        ]
        // 是否显示
        app.util.request({

          'url': 'entry/wxapp/SwitchBar',
          'cachetime': 0,
          success: function (res) {
            // console.log(res.data.is_fbopen+'sss')
            let is_fbopen = res.data.is_fbopen
            if (is_fbopen == "0") {
              data1.splice(2, 2)
              that.setData({
                tabBarList: data1
              })
            } else {
              that.setData({
                tabBarList: data1
              })
            }

          }
        })

      }
    })

    //设置首页背景色和字体颜色
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    
  },
  goIndex: function (e) {
    wx.redirectTo({
      url: '../../product/index/index'
    })
  },
  goChargeIndex: function (e) {
    wx.redirectTo({
      url: '../../charge/chargeIndex/chargeIndex'
    })
  },
  goPublishTxt: function (e) {
    wx.redirectTo({
      url: '../../publishInfo/publish/publishTxt'
    })
  },
  goFindIndex: function (e) {
    wx.redirectTo({
      url: '../../find/findIndex/findIndex'
    })
  },
  goMy: function (e) {
    wx.redirectTo({
      url: '../../myUser/my/my'
    })
  },
  //自定义方法
  /**
   * 切换导航栏
   */
  orderTab: function (e) {
    // let goId = Number(e.currentTarget.dataset.id);
    // this.setData({
    //   goId: goId,
    //   pics: []
    // })
  },
  //20180424 @淡蓝海寓 发布达人圈
  formSubmit: function (e) {
    var formdata = e.detail.value;
    var that = this;
    var uurl = app.util.url("entry/wxapp/TouploadTwo") + "&m=byjs_sun";
    var uimg = that.data.pics;
    /*
    var sign = app.util.getSign(c, arr);
    if (sign) {
      c = c + "&sign=" + sign;
    }*/
    //console.log(uurl);
    if (!formdata.push_text) {
      wx.showToast({
        title: '内容不能为空！！！',
        icon: 'none',
      })
      return false;
    }
    //增加一个提示上传中层，以免用户在没有上传玩图片就退出页面
    wx.showLoading({
      title: '内容发布中，请稍后...',
      mask: true
    })
    //先提交写的内容到服务器在上传图片
    var user_id = wx.getStorageSync("users").id;
    
    that.setData({
      disabled: true,
      sendtitle:"稍后"
    })
    app.util.request({
      url: "entry/wxapp/Addtalentcircle",
      cachetime: "0",
      data: {
        user_id: user_id,
        uniacid: app.siteInfo.uniacid,
        content: formdata.push_text
      },
      success: function (res) {
        var tcid = res.data;
        if (uimg.length > 0) {
          console.log(uimg);
          console.log(22222);
          //上传图片
          let thetcid = { "tcid": tcid };
          that.uploadimg({
            url: uurl,//这里是你图片上传的接口
            path: uimg//这里是选取的图片的地址数组
          }, thetcid);
        } else {
          wx.hideLoading();//关闭加载层
          wx.showToast({
            title: '发布成功！！！',
            icon: 'success',
            success: function () {
              //注意switchTab才能跳转tab的页面，navigateTo之类不行
              
            }
          })
          that.onload();
          wx.navigateTo({
            url: '../../find/findIndex/findIndex',
          })
        }
      },
      fail: function () {
        that.setData({
          disabled: false,
          sendtitle: "发送"
        })
        wx.showToast({
          title: '可能由于网络原因，发布失败，请重新发布！！！',
          icon: 'none',
          success: function () {
            wx.hideLoading();//关闭加载层
          }
        })
      }
    })

  },
  uploadimg: function (data, param) {//多张图片上传
    var that = this,
      i = data.i ? data.i : 0,//当前上传的哪张图片
      success = data.success ? data.success : 0,//上传成功的个数
      fail = data.fail ? data.fail : 0;//上传失败的个数
    console.log(JSON.stringify(param)+'这是上传图片事件参数');
    console.log(data.path+'进入上传图片')
    wx.uploadFile({
      url: data.url,
      filePath: data.path[i],
      name: 'file',//这里根据自己的实际情况改
      formData: param,//这里是上传图片时一起上传的数据
      success: (res) => {
        if (res.data == 1) {
          success++;//图片上传成功，图片上传成功的变量+1
        }
        console.log("tu11111111");
        console.log(res)
        console.log(i);
      },
      fail: (res) => {
        if (res.data == 2) {
          fail++;//图片上传失败，图片上传失败的变量+1
        }
        console.log('fail:' + i + "fail:" + fail);
      },
      complete: () => {
        //console.log(i);
        i++;//这个图片执行完上传后，开始上传下一张
        if (i == data.path.length) {   //当图片传完时，停止调用          
          console.log('执行完毕');
          wx.hideLoading();//关闭加载层
          wx.showToast({
            title: '发布成功！！！',
            icon: 'success',
            success: function () {
              //发布成功之后清除
              that.setData({
                pics: [],
                content: "",
                disabled: false,
                sendtitle: "发送"
              })
              //注意switchTab才能跳转tab的页面，navigateTo之类不行
              app.globalData.aci = "";//设置一个全局变量，过后需要清除该数据
              wx.switchTab({
                url: '../../interactive/interactiveMoving/interactiveMoving',
              })
            }
          })
        } else {//若图片还没有传完，则继续调用函数
          //console.log(i);
          data.i = i;
          data.success = success;
          data.fail = fail;
          that.uploadimg(data, param);
        }
      }
    });
  },
  //20180424 @淡蓝海寓 图片上传
  chooseImage: function () {//这里是选取图片的方法
    var that = this;
    let uimg = that.data.pics;
    //限定图片数量，只能9张
    if (uimg.length < 9) {
      wx.chooseImage({
        count: 9, // 允许上传图片数量，默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图(original)还是压缩图(compressed)，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册(album)还是相机(camera)，默认二者都有
        success: function (res) {
          // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
          uimg = uimg.concat(res.tempFilePaths);
          // console.log(uimg);
          that.setData({
            pics: uimg
          });
        }
      })
    } else {
      wx.showToast({
        title: '只允许上传9张图片！！！',
        icon: 'none',
      })
    }
  },
  //20180424 @淡蓝海寓 删除图片
  deleteImage: function (e) {
    var that = this;
    var imgData = this.data.pics;
    var tindex = e.currentTarget.dataset.index;
    imgData.splice(tindex, 1);
    this.setData({
      pics: imgData
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
  onShow: function () {
    this.onLoad();
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

  showData: function (e) {
    // console.log(this.data)
  },
  //获取用户发布结伴行的内容的时间
  contentTimeInput: function (e) {
    var that = this;
    var gowithtime = e.detail.value; //时间值
    that.setData({
      gowithtime: gowithtime
    })
  },
 


  
})