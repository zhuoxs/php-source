// mzhk_sun/pages/modal/login.js
const app = getApp();
Component({
  properties: {
    modalHidden: {
      type: Boolean,
      value: true
    }, //这里定义了modalHidden属性，属性值可以在组件使用时指定.写法为modal-hidden  
    modalMsg: {
      type: String,
      value: '获取你的公开信息(昵称、头像等)',
    }
  },
  data: {
    // 这里是一些组件内部数据  
    modalMsg: "获取你的公开信息(昵称、头像等)",
    isLogin: true,
  },
  methods: {
    // 这里放置自定义方法  
    isLogin(e) {
      const isLogin = this.data.isLogin;
      this.setData({
        isLogin: false
      })
    },
    //去调用父组件的更新信息操作
    getUserInfo: function () {
      this.triggerEvent('togetuserinfo', {}) // 只会触发 updateUserInfo
    }
  }
})  
