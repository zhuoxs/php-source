// yzkm_sun/pages/sjrz-Page/sjrz-Page.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    formId:'',
    template_withdrawal:'',
    rz_id:'',//期限id
    //付款金额
    fl_id:'',//分类id
    storein:[],//商家入驻期限
    store_fenlei:[],//商家分类
    latAndLong:'',//地址坐标
    stime:'00:00',
    etime:'23:59',
    items: [
      { name: 0, value:'刷卡支付' },
      { name: 1, value: '免费停车'},
      { name: 2, value: '免费wifi' },
      { name: 3, value: '禁止吸烟' },
      { name: 4, value:'提供包间' },
      { name: 5, value: '沙发休闲' },
    ],
    checkRadio: [],
    pics: [],
    pics2: [],
    pics3:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this
    var openid = wx.getStorageSync('openid');//用户openid
    that.diyWinColor();
    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        that.setData({
          comment_xqy: res.data,
        })
        wx.setStorageSync('user_id', res.data.id);
      }
    })
    // 商家分类列表
    app.util.request({
      url: 'entry/wxapp/Class_sj',
      success: function (res1) {
        console.log('商家分类数据');
        console.log(res1);
        for (var i = 0; i < res1.data.length; i++) {
          // var combine1 = res.data[i].tname ;
          that.data.store_fenlei.push(res1.data[i].tname);
          console.log(that.data.store_fenlei);
        }
        console.log(that.data.store_fenlei);
        that.setData({
          store_fenlei: that.data.store_fenlei,
          noDealData_fl: res1.data,
        })
        // wx.setStorageSync('user_id', res.data.id);
      }
    })
    // 商家入驻期限
    app.util.request({
      url: 'entry/wxapp/Day_rz',
      success: function (res) {
        console.log('商家入驻期限数据');
        console.log(res);
       for(var i=0;i<res.data.length;i++){
         var combine = res.data[i].duration+'天' + '/' +'￥' +res.data[i].money ;
         that.data.storein.push(combine);
         console.log(that.data.storein);
       }
       console.log(that.data.storein);
        that.setData({
          storein: that.data.storein,
          noDealData:res.data,
        })
        // wx.setStorageSync('user_id', res.data.id);
      }
    })
    //获取模板消息表的模板消息编号
    app.util.request({
      url: 'entry/wxapp/Mob_message',
      success: function (res) {
        console.log('模板消息数据');
        console.log(res);
        that.setData({
          template_withdrawal: res.data.template_withdrawal,
        })
      }
    })



    that.diyWinColor();
  },
// 入驻期限
  bindPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value);
    // 入驻
    var rz_id = this.data.noDealData[e.detail.value].id;
    var rz_money = this.data.noDealData[e.detail.value].money;
    console.log(rz_id);
    this.setData({
      index_qx: e.detail.value,
      rz_id: rz_id,
      rz_money: rz_money,
    })
  },
// 商家分类  
  bindPickerType: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    var fl_id = this.data.noDealData_fl[e.detail.value].tid;
    console.log(fl_id);
    this.setData({
      index_sj: e.detail.value,
      fl_id: fl_id,
    })
  },

  // form表单提交
  // publish(e){
  //   console.log('表单数据')
  //   console.log(e)
  // },
  // 选择店内设施
  checkboxChange: function (e) {
    var that=this
    // console.log('checkbox发生change事件，携带value值为：', e.detail.value)
    // wx.setStorageSync('sheshi', e.detail.value);
    var checkRadio_arr = e.detail.value;
    var checkRadio='';
    if (checkRadio_arr.length>0){
      for (var i = 0; i < checkRadio_arr.length;i++){
        checkRadio = checkRadio ? checkRadio + "," + checkRadio_arr[i] : checkRadio_arr[i];
      }
    }
    that.setData({
      checkRadio: checkRadio
    })
    console.log(checkRadio);
  },

  // 选择营业时间
  bindTimeChange: function (e) {

    console.log('picker发送选择改变，携带值为', e.detail.value)
    if (e.currentTarget.dataset.statu=="start"){
      this.setData({
        stime:e.detail.value
      })
    }else{
      this.setData({
        etime: e.detail.value
      })
    }
  },
  //20180424 @淡蓝海寓 发布达人圈
  // 确认提交
  publish: function (e) {
    // 延迟
    // setTimeout(function () { }, 500)
    console.log(e)   
    var finishMoney = this.data.noDealData[this.data.index_qx].money;//入驻期限金额
    console.log(finishMoney);
      var user_id = wx.getStorageSync('user_id');//用户user_id
      console.log(user_id)

      console.log('表单数据')
      console.log(e)
      var formdata = e.detail.value;
      var that = this;
      // var formId =e.detail.formId;
        that.setData({
          formId: e.detail.formId
        })      
      console.log(that.data.template_withdrawal)
      //var uurl = app.util.url("entry/wxapp/Toupload") + "&m=" + app.siteInfo.mname;
      var uurl = app.util.url("entry/wxapp/Toupload_sjlb") + "&m=yzkm_sun";//修改的地方
      var uurl2 = app.util.url("entry/wxapp/Toupload_sjlb2") + "&m=yzkm_sun";//修改的地方
      var uurl3 = app.util.url("entry/wxapp/Toupload_sjlb3") + "&m=yzkm_sun";//修改的地方

      var uimg = that.data.pics;//修改的地方
      var uimg2 = that.data.pics2;//修改的地方
      var uimg3 = that.data.pics3;//修改的地方
      console.log('表单上传的图片数据')
      console.log(uimg2)
      //商家模板id
      // if (that.data.template_withdrawal == '') {//修改的地方
      //   wx.showToast({
      //     title: '',
      //     icon: 'none',
      //   })
      //   return false;
      // }      
//商家名称
      if (e.detail.value.store_name == '') {//修改的地方
        wx.showToast({
          title: '商家名称不能为空',
          icon: 'none',
        })
        return false;
      }
//联系方式
      if (e.detail.value.phone == '') {//修改的地方
        wx.showToast({
          title: '商家联系方式不能为空',
          icon: 'none',
        })
        return false;
      }
//详细地址 
      if (e.detail.value.address == '') {//修改的地方
        wx.showToast({
          title: '商家地址不能为空',
          icon: 'none',
        })
        return false;
      }
//人均价格
      if (e.detail.value.averagePrice == '') {//修改的地方
        wx.showToast({
          title: '人均消费不能为空',
          icon: 'none',
        })
        return false;
      }      
    
//营业开始时间
      if (e.detail.value.start_time == '') {//修改的地方
        wx.showToast({
          title: '请选择营业开始时间',
          icon: 'none',
        })
        return false;
      }
//营业结束时间
      if (e.detail.value.over_time == '') {//修改的地方
        wx.showToast({
          title: '请选择营业结束时间',
          icon: 'none',
        })
        return false;
      }

//商家介绍
      if (e.detail.value.details == '') {//修改的地方
        wx.showToast({
          title: '请填写商家介绍',
          icon: 'none',
        })
        return false;
      }
//地理坐标
      if (e.detail.value.coordinate == '') {//修改的地方
        wx.showToast({
          title: '请选择地理坐标',
          icon: 'none',
        })
        return false;
      }     

      if (!formdata.push_text && uimg.length <= 0) {//修改的地方
        wx.showToast({
          title: '写点内容或者发张图片吧！！！',
          icon: 'none',
        })
        return false;
      }

      if (!formdata.push_text && uimg2.length <= 0) {//修改的地方
        wx.showToast({
          title: '写点内容或者发张图片吧！！！',
          icon: 'none',
        })
        return false;
      }






      var openid = wx.getStorageSync('openid');//用户openid
      app.util.request({
        url: 'entry/wxapp/Orderarr',
        'cachetime': '30',
        data: {
          openid: openid,
          // price: finishMoney,
          price: 0.01,
        },
        success: function (res5) {
          console.log(res5)
          // wx.setStorageSync('prepay_id', res.data.prepay_id);
          // 发送支付请求
          wx.requestPayment({
            'timeStamp': res5.data.timeStamp,
            'nonceStr': res5.data.nonceStr,
            'package': res5.data.package,
            'signType': 'MD5',
            'paySign': res5.data.paySign,
            success: function (res6) {
              console.log('支付数据')
              console.log(res6)
              wx.showToast({
                title: '支付成功',
                icon: 'success',
                duration: 2000
              })

              // var prepay_id = wx.getStorageSync('prepay_id');//用户prepay_id
              // console.log(prepay_id)
              var user_id = wx.getStorageSync('user_id');//用户user_id




              //增加一个提示上传中层，以免用户在没有上传玩图片就退出页面
              wx.showLoading({
                title: '内容发布中，请稍后...',
                mask: true
              })
              //先提交写的内容到服务器在上传图片
              var id = wx.getStorageSync('id');//用户id
              console.log('5555555555555555555555555555555555')
              that.setData({
                disabled: true,
                sendtitle: "稍后"
              })
              var user_id = wx.getStorageSync('user_id');//用户user_id
              console.log(that.data.rz_id);
              console.log(that.data.fl_id);
              app.util.request({
                url: "entry/wxapp/AddPhoto_sjrz",
                cachetime: "0",
                data: {
                  latitude: that.data.latitude,//暂时无用
                  longitude: that.data.longitude,//暂时无用
                  uimg: uimg,//l轮播图
                  uimg2: uimg2,//详情图
                  name: e.detail.value.name,//暂时无用
                  tel: e.detail.value.tel,//暂时无用
                  content: e.detail.value.content,//暂时无用 
                  id: id,//
                  store_name: e.detail.value.store_name,//商家名称
                  phone: e.detail.value.phone,//联系方式
                  address: e.detail.value.address,//详细地址 
                  averagePrice: e.detail.value.averagePrice,//人均价格
                  coordinate: that.data.latAndLong,//地理坐标
                  index_qx: that.data.rz_id,//  入驻期限id
                  index_sj: that.data.fl_id,// 商家分类id
                  checkRadio: that.data.checkRadio,//选中的设施
                  over_time: e.detail.value.over_time,//营业结束时间
                  start_time: e.detail.value.start_time,//营业开始时间
                  details: e.detail.value.details,//商家介绍
                  user_id: user_id,//申请入驻用户
                },
                success: function (res) {
                  console.log('发布数据请求')
                  console.log(res.data)
                  //return false;
                  wx.setStorageSync('tcid', res.data);//把这个参数存起来留给下一个添加的用  做数据返回*********
                  var tcid = res.data;
                  let thetcid = { "tcid": tcid };

                  // 这是轮播图的
                  if (uimg.length > 0) {
                    //上传图片
                    console.log('2222222222222222');
                    console.log(tcid);
                    that.uploadimg({//修改的地方
                      url: uurl,//这里是你图片上传的接口//修改的地方
                      path: uimg//这里是选取的图片的地址数组//修改的地方
                    }, thetcid);
                  }

                  // 这是详情图的
                  if (uimg2.length > 0) {//修改的地方
                    //上传图片
                    console.log('图片2******************');
                    console.log(tcid);
                    that.uploadimg2({
                      url: uurl2,//这里是你图片上传的接口//修改的地方
                      path: uimg2//这里是选取的图片的地址数组//修改的地方
                    }, thetcid);
                  } 
                  // 这是logo的
                  if (uimg3.length > 0) {//修改的地方
                    //上传图片
                    console.log('图片3******************');
                    console.log(tcid);
                    that.uploadimg3({
                      url: uurl3,//这里是你图片上传的接口//修改的地方
                      path: uimg3//这里是选取的图片的地址数组//修改的地方
                    }, thetcid);
                  } 
                  // console.log(e.detail.formId);
                  // 发送模板消息

                  app.util.request({
                    'url': 'entry/wxapp/AccessToken',
                    'cachetime': '0',
                    success: function (res1) {

                      console.log(that.data.template_withdrawal)
                      console.log(openid)
                      console.log(that.data.formId)
                      console.log(finishMoney)
                      console.log(user_id)
                      // console.log(that.data.gid)
                      app.util.request({
                        'url': 'entry/wxapp/Send_rz',
                        'cachetime': '0',
                        data: {
                          access_token: res1.data.access_token,//这是支付成功之后获取的参数
                          // template_id: '_B4PBnV2bbgacJKtc6yvsaxo6SXSZwPmbRGu8qw9iSk',
                          template_id: that.data.template_withdrawal,
                          page: "yzkm_sun/pages/index/index",
                          openid: openid,
                          form_id: that.data.formId,
                          money: finishMoney,
                          user_id: user_id,
                        },
                        success: function (res6) {
                          console.log(res6.data)

                        }
                      })
                    }
                  })
                          // 商家入驻跳转
                          wx.navigateTo({
                            url: '../mine/mine',
                          })
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
                },
              })



































            }
          })




        }
      })  








//...................................................................................................................................
    
  },
  // ----------------------------------上传图轮播图片----------------------------------
  // ----------------------------------上传图片1111111111111111111111111111111----------------------------------
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
          console.log('1111111111111')
          console.log(uimg)
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

        uploadimg: function (data, param) {//多张图片上传
          var that = this,
            i = data.i ? data.i : 0,//当前上传的哪张图片
            success = data.success ? data.success : 0,//上传成功的个数
            fail = data.fail ? data.fail : 0;//上传失败的个数
          console.log('这里是上传图片时一起上传的数据')
          console.log(param);
          wx.uploadFile({
            url: data.url,
            filePath: data.path[i],
            name: 'file',//这里根据自己的实际情况改
            formData: param,//这里是上传图片时一起上传的数据
                success: (res) => {
                  console.log('上传图片时的数据')
                  console.log(res);
                  if (res.data == 1) {
                    console.log(22222222222222222222222222222222222222222222222)
                    success++;//图片上传成功，图片上传成功的变量+1
                  }
                  console.log('图片上传成功后')
                  console.log(res)
                  console.log(i);
                },
                fail: (res) => {
                  if (res.data == 2) {
                    console.log(333333333333333333333333333333333333333333333333333)
                    fail++;//图片上传失败，图片上传失败的变量+1
                  }
                  console.log('上传失败')
                  console.log('fail:' + i + "fail:" + fail);
                },
            complete: () => {
              //console.log(i);
              i++;//这个图片执行完上传后，开始上传下一张
              if (i == data.path.length) {   //当图片传完时，停止调用          
                console.log('执行完毕');
                wx.hideLoading();//关闭加载层
                wx.showToast({
                  title: '已发送入驻申请！！！',
                  icon: 'success',
                  success: function () {
                    //入驻成功之后清除
                    that.setData({
                      pics: [],
                      content: "",
                      disabled: false,
                      sendtitle: "发送"
                    })
                    //注意switchTab才能跳转tab的页面，navigateTo之类不行
                    app.globalData.aci = "";//设置一个全局变量，过后需要清除该数据
                    //  延迟两秒跳转
                    // setTimeout(function () {
                    //   wx.navigateTo({
                    //     // url: '../circle/circle',
                    //   })
                    // }, 2000)
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

  // ----------------------------------上传商家详情图片----------------------------------
  // ----------------------------------上传图片----------------------------------
  //20180424 @淡蓝海寓 图片上传
  chooseImage2: function () {//这里是选取图片的方法
    var that = this;
    let uimg2 = that.data.pics2;
    //限定图片数量，只能9张
    if (uimg2.length < 9) {
      wx.chooseImage({
        count: 9, // 允许上传图片数量，默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图(original)还是压缩图(compressed)，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册(album)还是相机(camera)，默认二者都有
        success: function (res) {
          // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
          uimg2 = uimg2.concat(res.tempFilePaths);
          console.log('1111111111111222222222222222222')
          console.log(uimg2)
          //console.log(that.data.content+"---");
          that.setData({
            pics2: uimg2
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

  uploadimg2: function (data, param) {//多张图片上传
    var that = this,
      i = data.i ? data.i : 0,//当前上传的哪张图片
      success = data.success ? data.success : 0,//上传成功的个数
      fail = data.fail ? data.fail : 0;//上传失败的个数
    console.log('这里是上传图片时一起上传的数据2222222222222222')
    console.log(param);
    wx.uploadFile({
      url: data.url,
      filePath: data.path[i],
      name: 'file',//这里根据自己的实际情况改
      formData: param,//这里是上传图片时一起上传的数据
      success: (res) => {
        console.log('上传图片时的数据22222222222222222')
        console.log(res);
        if (res.data == 1) {
          console.log(22222222222222222222222222222222222222222222222)
          success++;//图片上传成功，图片上传成功的变量+1
        }
        console.log('图片上传成功后22222222222222')
        console.log(res)
        console.log(i);
      },
      fail: (res) => {
        if (res.data == 2) {
          console.log(333333333333333333333333333333333333333333333333333)
          fail++;//图片上传失败，图片上传失败的变量+1
        }
        console.log('上传失败2222222222222222')
        console.log('fail:' + i + "fail:" + fail);
      },
      complete: () => {
        //console.log(i);
        i++;//这个图片执行完上传后，开始上传下一张
        if (i == data.path.length) {   //当图片传完时，停止调用          
          console.log('执行完毕222222222222222');
          wx.hideLoading();//关闭加载层
          wx.showToast({
            title: '已发送入驻申请！！！',
            icon: 'success',
            success: function () {
              //入驻成功之后清除
              that.setData({
                pics2: [],
                content: "",
                disabled: false,
                sendtitle: "发送"
              })
              //注意switchTab才能跳转tab的页面，navigateTo之类不行
              app.globalData.aci = "";//设置一个全局变量，过后需要清除该数据
              //  延迟两秒跳转
              // setTimeout(function () {
              //   wx.navigateTo({
              //     // url: '../circle/circle',
              //   })
              // }, 2000)
            }
          })
        } else {//若图片还没有传完，则继续调用函数
          //console.log(i);
          data.i = i;
          data.success = success;
          data.fail = fail;
          that.uploadimg2(data, param);
        }
      }
    });
  },
  //20180424 @淡蓝海寓 删除图片
  deleteImage2: function (e) {
    var that = this;
    var imgData = this.data.pics;
    var tindex = e.currentTarget.dataset.index;
    imgData.splice(tindex, 1);
    this.setData({
      pics2: imgData
    })
  },

  chooseLoca(e){
    var that=this;
    wx.chooseLocation({
      success: function(res) {
        console.log(res)
        var latAndLong = res.longitude + ',' + res.latitude;
        that.setData({
          latAndLong: latAndLong,
        })
      },
    })
  },



  // ----------------------------------上传商家logo----------------------------------
  chooselogoImage: function () {
    var that = this;
    let uimg3 = that.data.pics3;
    //限定图片数量，只能9张
    if (uimg3.length < 1) {
      wx.chooseImage({
        count: 1, // 允许上传图片数量，默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图(original)还是压缩图(compressed)，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册(album)还是相机(camera)，默认二者都有
        success: function (res) {
          // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
          uimg3 = uimg3.concat(res.tempFilePaths);
          console.log('333333333333333333333333333333333333333333')
          console.log(uimg3)
          //console.log(that.data.content+"---");
          that.setData({
            pics3: uimg3
          });
        }
      })
    } else {
      wx.showToast({
        title: '只允许上传1张图片！！！',
        icon: 'none',
      })
    }  
  },
  uploadimg3: function (data, param) {//多张图片上传
    var that = this,
      i = data.i ? data.i : 0,//当前上传的哪张图片
      success = data.success ? data.success : 0,//上传成功的个数
      fail = data.fail ? data.fail : 0;//上传失败的个数
    console.log('这里是上传图片时一起上传的数据333333333333333')
    console.log(param);
    wx.uploadFile({
      url: data.url,
      filePath: data.path[i],
      name: 'file',//这里根据自己的实际情况改
      formData: param,//这里是上传图片时一起上传的数据
      success: (res) => {
        console.log('上传图片时的数据33333333333333')
        console.log(res);
        if (res.data == 1) {
          console.log(3333333333333333333333333333333333333)
          success++;//图片上传成功，图片上传成功的变量+1
        }
        console.log('图片上传成功后333333333333333333333333333')
        console.log(res)
        console.log(i);
      },
      fail: (res) => {
        if (res.data == 2) {
          console.log(333333333333333333333333333333333333333333333333333)
          fail++;//图片上传失败，图片上传失败的变量+1
        }
        console.log('上传失败3333333333333333333333333333333')
        console.log('fail:' + i + "fail:" + fail);
      },
      complete: () => {
        //console.log(i);
        i++;//这个图片执行完上传后，开始上传下一张
        if (i == data.path.length) {   //当图片传完时，停止调用          
          console.log('执行完毕3333333333333333333333');
          wx.hideLoading();//关闭加载层
          wx.showToast({
            title: '已发送入驻申请！！！',
            icon: 'success',
            success: function () {
              //入驻成功之后清除
              that.setData({
                pics3: [],
                content: "",
                disabled: false,
                sendtitle: "发送"
              })
              //注意switchTab才能跳转tab的页面，navigateTo之类不行
              //app.globalData.aci = "";//设置一个全局变量，过后需要清除该数据
              //  延迟两秒跳转
              // setTimeout(function () {
              //   wx.navigateTo({
              //     // url: '../circle/circle',
              //   })
              // }, 2000)
            }
          })
        } else {//若图片还没有传完，则继续调用函数
          //console.log(i);
          data.i = i;
          data.success = success;
          data.fail = fail;
          that.uploadimg3(data, param);
        }
      }
    });
  },
  //20180424 @淡蓝海寓 删除图片
  deleteImage3: function (e) {
    var that = this;
    var imgData = this.data.pics3;
    var tindex = e.currentTarget.dataset.index;
    imgData.splice(tindex, 1);
    this.setData({
      pics3: imgData
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
      title: '商家入驻',
    })
  },
})