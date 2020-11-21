import { tmpUrl, fly, req } from '../js/xx_request.js';

export default { 
  /****************************************************福包**/  
  /*员工福包列表/核销线下福包/领取某个福包的用户列表*/
  getStaffCouponList(param) {
    return req.post("couponstafflist", param)
  },
  getCouponClean(param) {
    return req.post("couponclean", param)
  },
  getCouponUserList(param) {
    return req.post("coupongetlist", param)
  },
  /****************************************************分销**/
  /*我的收入/佣金流水//////*/
  getSouponshop(param) {
    return req.post("sellingprofit", param)
  },
  getSouponshop(param) {
    return req.post("sellingwater", param)
  },
}