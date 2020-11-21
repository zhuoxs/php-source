// yzmdwsc_sun/pages/carts/carts.js
const app = getApp()
var tempArray = [];
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '购物车',
    carts: [],
    totalPrice: 0,
    allSelect: false,
    noSelect: true,
    totalNum:0,
    fullPrice: '100',/**，满多少价格起送 */
    distribution: '3.00',/**配送费 */
    checked:false/**是否全选 *//**商品点击要做跳转 */
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
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
    //获取当前路径
    var pages = getCurrentPages() //获取加载的页面
    var currentPage = pages[pages.length - 1] //获取当前页面的对象
    var current_url = currentPage.route;
    console.log('当前路径为:' + current_url);
    that.setData({
      current_url: current_url,
    })
    var tab = wx.getStorageSync('tab');
    this.setData({
      current: options.currentIndex,
      tab: tab,
    })
    app.editTabBar();
     //----------------- 异步保存上传图片需要的网址-----------------------
    app.util.request({
      'url': 'entry/wxapp/Url2',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('url2', res.data)
      },
    })
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url',
      'cachetime': '0',
      success: function (res) {
        // ----------------------- 异步保存网址前缀-------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
  
  },

  
  //底部链接
  goTap: function (e) {
  //  console.log(e);
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
    var that = this;
    //--------获取购物车数据----------
    wx.getStorage({
      key: 'openid',
      success: function (res) {
        app.util.request({
          'url': 'entry/wxapp/GetShopCar',
          'cachetime': '0',
          data: {
            uid: res.data
          },
          success: function (res) {
            //   console.log(res)
            that.setData({
              shopcar: res.data.data
            })
            that.setData({
              checked: false,
              allSelect:0,
            })
            that.totalPrice();
          }
        })
      },
    })
   
    /*
    const carts = wx.getStorageSync('carts') || [];
    that.setData({
      carts: carts
    })
    var len = 0;
    for (var i = 0; i < carts.length; i++) {
      len += carts[i].num;
      that.setData({
        cartsLen: len
      })
    }*/
    
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
    console.log(12333)
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
  /** 单选*/
  bindCheckbox(e){ 
    var that=this;
    var index = e.currentTarget.dataset.index;
    var list = this.data.shopcar;
    var totalNum = this.data.totalNum;
    for (var i = 0; i < list.length; i++) {
      if (!list[i].check) {
        if (i == index) {
          list[i].check = list[i].id;
          totalNum++;
          this.setData({
            totalPrice: 0,
            totalNum: totalNum,
            shopcar: list
          })  
        }
      
      }else{
        if (i == index) {
            list[i].check = '';
            totalNum--;
            this.setData({
              totalPrice: 0,
              totalNum: totalNum,
              shopcar: list
            })  
        }
      }  
    }
    this.totalPrice();
    return 
    var index = e.currentTarget.dataset.index;
    var selected = that.data.shopcar[index].selected;
    var shopcar = that.data.shopcar;

    carts[index].selected = !selected;


    that.setData({
      shopcar: shopcar
    })
    wx.setStorageSync('carts', carts);
    that.totalPrice()
  },
  /***全选 */
  checkAll(e){
    var that=this;
    var list = this.data.shopcar;
    var all = this.data;
    var checked = e.currentTarget.dataset.checked;
    console.log(checked);
    that.setData({ 
      checked: checked,
    })
    if (!all.allSelect) {
      this.setData({
        totalPrice: 0,
        totalNum: list.length
      })
      all.allSelect = 1;
      for (var i = 0; i < list.length; i++) {
        if (list[i].no_stock!=1){
         list[i].check = 1;
        }
      } 
    }else{
      all.allSelect = '';
      for (var i = 0; i < list.length; i++) {
        list[i].check = '';
      }
      this.setData({
        totalPrice: 0,
        totalNum: 0
      })
    }
    var newList = list;
    //重新赋值，改变前端的选中状态 
    this.setData({
      shopcar: newList,
      allSelect: all.allSelect
    });
    this.totalPrice();

    return 
    var that=this;
    var checked = e.currentTarget.dataset.checked;
    const carts = wx.getStorageSync('carts') || [];
    if (checked){
      for (var i = 0; i < carts.length; i++){
        carts[i].selected = true;
      }
    }else{
      for (var i = 0; i < carts.length; i++) {
        carts[i].selected= false;
      }
    }
    that.setData({
      checked:checked,
      carts: carts
    })

    wx.setStorageSync('carts', carts);
    that.totalPrice()

  },
  /***加入购物车 */
  add(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var id = e.currentTarget.dataset.id;
    var list = this.data.shopcar;
    tempArray[parseInt(index)] = this.data.shopcar[parseInt(index)].price / this.data.shopcar[parseInt(index)].num;
    if (index !== "" && index != null) {
      if (list[parseInt(index)].num <10) {
        list[parseInt(index)].num++;
        this.setData({
          shopcar: list,
          totalPrice: 0
        })
        if (!tempArray[parseInt(index)]) {
          tempArray[parseInt(index)] = this.data.shopcar[parseInt(index)]["price"];
        }
        var total_money = tempArray[parseInt(index)] * this.data.shopcar[parseInt(index)].num;
        list[parseInt(index)]["price"] = total_money;
        this.setData({
          shopcar: list,
          totalPrice: 0
        });
        this.totalPrice();
        var num = list[parseInt(index)].num
        var price = list[parseInt(index)].price;
        app.util.request({
          'url': 'entry/wxapp/buyNum',
          data: {
            id: id,
            num: num,
            price: price
          },
          success: function (res) {

          }
        })
      }
    }


    return
    const carts = wx.getStorageSync('carts') || [];

    try {

      for (var i = 0; i < carts.length; i++) {
        /***********订单列表判断*****************/

        if (carts[i].id == id) {
          if (carts[i].num == carts[i].limit) {
            wx.showToast({
              title: '商品限购' + carts[i].limit + '件',
              icon: 'none',
              duration: 2000
            })
          } else {
            carts[index].num++;
          }
          that.setData({
            carts: carts
          })
          wx.setStorageSync('carts', carts);
          that.totalPrice();
          return;
        }
      }
      wx.showToast({
        title: '加入购物车成功',
        icon: 'success',
        duration: 2000
      })
      that.totalPrice();
  
    } catch (e) {
      // Do something when catch error
      wx.showToast({
        title: '加入购物车失败',
        icon: 'none',
        duration: 2000
      })
    }
  },
  /*********减少 */
  reduce(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var id = e.currentTarget.dataset.id;
    var list = this.data.shopcar;
    tempArray[parseInt(index)] = this.data.shopcar[parseInt(index)].price / this.data.shopcar[parseInt(index)].num;
    if (index !== "" && index != null) {
      if (list[parseInt(index)].num > 1) {
        list[parseInt(index)].num--;
        this.setData({
          shopcar: list,
          totalPrice: 0
        })
        if (!tempArray[parseInt(index)]) {
          tempArray[parseInt(index)] = this.data.shopcar[parseInt(index)]["price"];
        }
        var total_money = tempArray[parseInt(index)] * this.data.shopcar[parseInt(index)].num;
        list[parseInt(index)]["price"] = total_money;
        this.setData({
          shopcar: list,
          totalPrice: 0
        });
        this.totalPrice();
        var num = list[parseInt(index)].num
        var price = list[parseInt(index)].price;
        app.util.request({
          'url': 'entry/wxapp/buyNum',
          data: {
            id: id,
            num: num,
            price: price
          },
          success: function (res) {

          }
        })
      }else if(list[parseInt(index)].num==1){
        wx: wx.showModal({
          title: '提示',
          content: '确定删除该商品吗',
          showCancel: true,
          success: function (res) {
            if (res.confirm) {          
              app.util.request({
                'url': 'entry/wxapp/DelSopSingleCar',
                'cachetime': '0',
                data: {
                  id: id,
                },
                success: function (res) {
                  console.log(res.data.message)
                  that.setData({
                    shopcar: res.data.message
                  })
                }
              })
             
            } else if (res.cancel) {

            }
    
          }
        })
      }

    }
    return

    try {
      const carts = wx.getStorageSync('carts') || [];
      for (var i = 0; i < carts.length; i++) {
        if (carts[i].id == id) {
          if (carts[index].num > 0) {
            if (carts[index].num == 1) {
              wx: wx.showModal({
                title: '提示',
                content: '确定删除该商品吗',
                showCancel: true,
                success: function (res) {
                  if (res.confirm) {
                   // console.log('点击了')
                    carts[index].num--;
                    carts.splice(index, 1);
                    wx.setStorageSync('carts', carts);
                    that.setData({
                      carts: carts
                    })
                    that.totalPrice()
                  } else if (res.cancel) {
                    // return;
                  }
                }
              })
            } else {
              carts[index].num--;
              wx.setStorageSync('carts', carts);
              that.totalPrice()
              that.setData({
                carts: carts
              })
            }
            return;

          }
        }
      }

    } catch (e) {
      // Do something when catch error
      wx.showToast({
        title: '删除购物车失败',
        icon: 'none',
        duration: 2000
      })
    }
  },
  /******计算总价 */
  totalPrice: function () {
    var list = this.data.shopcar;
    var total = 0;
    for (var i = 0; i < list.length; i++) {
      var curItem = list[i];
      if (curItem.check) {
        total += parseFloat(curItem.price);
      }
    }
    total = parseFloat(total.toFixed(2));//js浮点计算bug，取两位小数精度
    this.setData({
      totalPrice: total
    })
    return total;
  },
  /*
  totalPrice: function () {
    var that=this;
    const carts =that.data.carts;
    var that = this;
    var totalPrice = 0;
    var price = 0;
    for (var i = 0; i < carts.length; i++) {
      if (carts[i].selected){
        price = parseFloat(carts[i].price) * parseFloat(carts[i].num);
        totalPrice += price
      }
    }
    totalPrice= totalPrice.toFixed(2)
    that.setData({
      totalPrice: totalPrice
    })
  },*/
  /*******清空商品 */
  empty(e) {
    var carts = [];
    var that = this;
    wx: wx.showModal({
      title: '提示',
      content: '确定清空商品吗',
      showCancel: true,
      success: function (res) { 
        if (res.confirm) {
          app.util.request({
            'url': 'entry/wxapp/EmptySopCar',
            'cachetime': '0', 
            data: {
              uid: wx.getStorageSync("openid")
            },
            success: function (res) {
              that.setData({
                shopcar: []
              })
            }
          })

          wx.setStorageSync('carts', carts);
          that.setData({
            shopcar: [],
          })
          that.totalPrice();
        } else if (res.cancel) {
          // return;
        }
      }
    })

  },
  toCforder(e) {
    var that = this;
    var cart = that.data.shopcar;
    var crid = '';
    for (var i = 0; i < cart.length; i++) {
      if (cart[i].check) {
        crid = crid + cart[i].id + ',';
      }
    }
    console.log(crid);
    wx.setStorage({
      key: 'crid',
      data: {
        crid: crid,
      } 
    })
    if (!crid) {
      wx.showModal({
        title: '提示',
        content: '请选择商品~',
        showCancel: false
      })
      return;
    } else {
      //判断库存是否足够
      app.util.request({
        'url': 'entry/wxapp/is_stock',
        'cachetime': '0',
        data: {
          crid: crid
        },
        success: function (res) {
          wx.navigateTo({
            url: '../index/cforder/cforder?cid=' + e.currentTarget.dataset.cid,
          })
        }
      })

    }
  },
  toTab(e) {
    var url = e.currentTarget.dataset.url;
    url = '/' + url;
    wx.redirectTo({
      url: url,
    })
  },
  
})