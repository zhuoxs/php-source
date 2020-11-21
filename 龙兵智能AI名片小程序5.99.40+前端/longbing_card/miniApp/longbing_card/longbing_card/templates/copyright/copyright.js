let _that;
let _baseModel;
let _util;
function getAppGlobalData(that,baseModel,util,isTabBar = false) {
  _that = that;
  _baseModel = baseModel;
  _util = util;
  getApp().globalData.userid = wx.getStorageSync("userid");
  _baseModel.getConfigV2().then((d) => {
    _util.hideAll();
    console.log(d.data,"copyright   getconfigV2") 
    let configInfo = d.data;
    let { my_company, tabBar} = configInfo;
    if(my_company){ 
      if (my_company.addr.length > 23) {
        let addrMore = my_company.slice(0, 23) +'...';
        getApp().globalData.my_company.addrMore = addrMore;
      }
    }

    if(isTabBar == true){
      // 跳转方式0=>跳转外部链接1=>小程序appid
      let tmpTabList = getApp().globalData.tabBarList; 
      for (let i in tabBar.menu_name) {
        if (tabBar.menu_url_out[i]) {
          if (tabBar.menu_url_jump_way[i] == 0) {
            tmpTabList[i].jump = 'toOutUrl';
          }
          if (tabBar.menu_url_jump_way[i] == 1) {
            tmpTabList[i].jump = 'toMiniApp';
            tmpTabList[i].toMiniApp = tabBar.menu_url_out[i].split('；'); 
          }
        }
        if (tabBar.menu_is_hide[i] == 1) {
          tmpTabList[i].showTab = 1;
        }  
        tmpTabList[i].text = tabBar.menu_name[i];
        if (tabBar.menu_url[i].indexOf('currentTabBar=') > -1) {
          tmpTabList[i].type = tabBar.menu_url[i].split('currentTabBar=')[1];
        }
        tmpTabList[i].url = tabBar.menu_url[i];
        if (tabBar.menu_url_out[i]) {
          tmpTabList[i].url = tabBar.menu_url_out[i];
        }
      } 
      getApp().globalData.tabBarList = tmpTabList;
    }
    
    getApp().globalData.configInfo = configInfo; 
    _that.setData({
      globalData: getApp().globalData
    })
  })
}

module.exports = {
  getAppGlobalData: getAppGlobalData
};


