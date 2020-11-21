var app = getApp();
var image = '';
//20180426 @淡蓝海寓 
var util = require('../../../resource/js/utils/util.js');
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
    disabled:false,
    sendtitle: "发送"
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    //设置首页背景色和字体颜色
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    var that = this;
    var goods_id = options.id;      //获取商品id
    var visa_id = options.visa_id;  //获取签证id
    var url = wx.getStorageSync('url'); //获取url
    if (goods_id != null && goods_id != '' && goods_id != 'undefined' && goods_id != undefined) {
      //从商品详情页面跳转过来,将页面固定在结伴行发布页面
      //查询该商品详情
      app.util.request({
        'url': 'entry/wxapp/GoodsDeatil',
        'cachetime': '0',
        data: {
          gid: goods_id
        },
        success(res) {
          console.log(res.data)
          that.setData({
            url: url,
            goId: 1, //设置发布页面为结伴行
            goods: res.data,
            goods_id: goods_id,
          })
        }
      })
    } else if (visa_id != null && visa_id != '' && visa_id != undefined) {
      //从签证页面跳转过来,将页面固定在结伴行页面
      //获取签证详情
      app.util.request({
        'url': 'entry/wxapp/GetVisaDetail',
        'cachetime': '0',
        data: {
          visa_id: visa_id
        },
        success(res) {
          console.log(res.data)
          that.setData({
            url: url,
            goId: 1, //设置发布页面为结伴行
            goods: res.data,
            visa_id: visa_id
          })
        }
      })
    }
  },
  //自定义方法
  /**
   * 切换导航栏
   */
  orderTab: function (e) {
    wx.switchTab({
      url: '../../publishInfo/publish/publishTxt',
    })
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
          //console.log(that.data.content+"---");
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
  //20180426 @淡蓝海寓 发布结伴行内容
  gowithformSubmit: function (e) {
    var that = this;
    var formdata = e.detail.value;
    var that = this;
    var uurl = app.util.url("entry/wxapp/Toupload") + "&m=" + app.siteInfo.mname;
    var uimg = that.data.pics;
    var gowithtime = that.data.gowithtime;
    var goods_id = that.data.goods_id;
    var visa_id = that.data.visa_id;
    //必须有商品id和签证id
    if (!goods_id && !visa_id){
      wx.showToast({
        title: '结伴行需要选择一个旅游或者签证哦！！！',
        icon: 'none',
      })
      wx.switchTab({
        url: '../../product/index/index',
      })
      return false;
    }

    if (!formdata.gowithline) {
      wx.showToast({
        title: '写个路线名吧！！！',
        icon: 'none',
      })
      return false;
    }
    if (gowithtime == "年/月/日") {
      wx.showToast({
        title: '加下日期吧！！！',
        icon: 'none',
      })
      return false;
    }
    if (!formdata.gowithcontent) {
      wx.showToast({
        title: '写点内容吧！！！',
        icon: 'none',
      })
      return false;
    }
    //增加一个提示上传中层，以免用户在没有上传玩图片就退出页面
    wx.showLoading({
      title: '内容发布中，需要点时间，请稍后...',
      mask: true
    })
    //先提交写的内容到服务器在上传图片
    var user_id = wx.getStorageSync("users").id;
    that.setData({
      disabled:true,
      sendtitle: "稍后"
    })
    app.util.request({
      url: "entry/wxapp/PublishGoWith",
      cachetime: "0",
      data: {
        user_id: user_id,
        uniacid: app.siteInfo.uniacid,
        content_time: gowithtime,
        content_route: formdata.gowithline,
        content: formdata.gowithcontent,
        goods_id:goods_id,
        visa_id: visa_id
      },
      success: function (res) {
        console.log(res.data);
        var tcid = res.data;
        if (uimg.length > 0) {
          //上传图片
          var thetcid = { "tcid": tcid, "types": 1 };
          that.uploadimg({
            url: uurl,//这里是你图片上传的接口
            path: uimg//这里是选取的图片的地址数组
          }, thetcid);
        } else {
          //wx.hideLoading();//关闭加载层
          wx.showToast({
            title: '发布成功！！！',
            icon: 'success',
            success: function () {
              //注意switchTab（无法带参数）才能跳转tab的页面，navigateTo之类不行，
              app.globalData.aci = 1;//设置一个全局变量，过后需要清除该数据
              wx.switchTab({
                url: '../../interactive/interactiveMoving/interactiveMoving',
              })
            }
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
            //wx.hideLoading();//关闭加载层
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
    console.log(param);
    wx.uploadFile({
      url: data.url,
      filePath: data.path[i],
      name: 'file',//这里根据自己的实际情况改
      formData: param,//这里是上传图片时一起上传的数据
      success: (res) => {
        if (res.data == 1) {
          success++;//图片上传成功，图片上传成功的变量+1
        }
        console.log(res)
        //console.log(i);
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
              //注意switchTab（无法带参数）才能跳转tab的页面，navigateTo之类不行，
              app.globalData.aci = 1;//设置一个全局变量，过后需要清除该数据
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
  //发布结伴行内容
  toPublishGowith: function (e) {
    var that = this;
    wx.showToast({
      title: '该功能暂时关闭！',
      icon: 'none',
    })
    // var user_id = wx.getStorageSync('users').id;  //用户id
    // var content = this.data.content;            //结伴行内容
    // var content_time = this.data.content_time; //结伴行时间框内容
    // var content_route = this.data.content_route; //结伴行路线框内容
    // var goods_id = this.data.goods_id;          //关联商品id
    // var visa_id = this.data.visa_id;            //关联签证id
    // if (visa_id == '' && goods_id == '') {
    //   wx.showModal({
    //     title: '提示',
    //     content: '请关联商品之后再发布内容',
    //   })
    // } else if (visa_id != null && visa_id != '') {
    //   // that.uploadimg();
    //   var pic = this.data.imgAddr;
    //   // console.log(pic)
    //   // console.log('关联为为签证' + pic)
    //   //关联内容为签证
    //   app.util.request({
    //     'url': 'entry/wxapp/PublishGoWith',
    //     'cachetime': '0',
    //     data: {
    //       user_id: user_id,
    //       visa_id: visa_id,
    //       goods_id: goods_id,
    //       content: content,
    //       content_time: content_time,
    //       content_route: content_route,
    //       pic: pic,
    //       goods_type: 1     //后台保存结伴行内容标识,0表示普通商品,1表示签证
    //     },
    //     success(res) {
    //       console.log(res.data)
    //       //置空值
    //       that.setData({
    //         content: '',
    //         content_time: '',
    //         content_route: '',
    //         pics: [],
    //         goods_id: '',
    //         visa_id: ''
    //       })
    //       //发布成功之后跳转到发现页面
    //       wx.switchTab({
    //         url: '/fyly_sun/pages/interactive/interactiveMoving/interactiveMoving',
    //       })
    //     }
    //   })
    // } else if (goods_id != null && goods_id != '') {
    //   console.log('关联为商品' + pic)
    //   //关联内容为签证
    //   app.util.request({
    //     'url': 'entry/wxapp/PublishGoWith',
    //     'cachetime': '0',
    //     data: {
    //       user_id: user_id,
    //       goods_id: goods_id,
    //       visa_id: visa_id,
    //       content: content,
    //       content_time: content_time,
    //       content_route: content_route,
    //       pic: pic,
    //       goods_type: 0     //后台保存结伴行内容标识,0表示普通商品,1表示签证
    //     },
    //     success(res) {
    //       console.log(res.data)
    //       //置空值
    //       that.setData({
    //         content: '',
    //         content_time: '',
    //         content_route: '',
    //         pics: [],
    //         imgAddr: image,
    //         goods_id: '',
    //         visa_id: ''
    //       })
    //       //发布成功之后跳转到发现页面
    //       wx.switchTab({
    //         url: '/fyly_sun/pages/interactive/interactiveMoving/interactiveMoving',
    //       })
    //     }
    //   })
    // }


  }
})