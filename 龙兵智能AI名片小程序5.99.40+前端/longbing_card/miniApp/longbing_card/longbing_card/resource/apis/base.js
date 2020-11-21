import { tmpUrl, fly, req } from '../js/xx_request.js';

export default { 
  /*登录/保存FormId/配置/获取电话号码/更新用户信息/未读消息数/////*/
  getLogin(param) {
    return req.post("login", param)
  },
  getFormId(param) {
    return req.post("formid", param)
  },
  getConfigV2(param) {
    return req.post("configV2", param)
  },
  getUserPhone(param) {
    return req.post("UserPhone", param)
  },
  getUpdateUserInfo(param) {
    return req.post("update", param)
  },
  getClientUnread(param) {
    return fly.post( tmpUrl + "ClientUnread", param)
    // return req.post("ClientUnread", param)
  },
  getChatInfo(param) {
    return req.post("messageinfo", param)
  },
  getShareimg(param) {
    return req.get("getshareimg", param)
  },
}