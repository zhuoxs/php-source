import { tmpUrl, fly, req } from '../js/xx_request.js';

export default {
  /****************************************************名片**/
  /*名片详情/获取名片二维码/点赞靠谱/转发记录/复制记录/分享记录/分享记录2/*/
  getCollectionList(param) {
    // return req.post("cards", param)
    return req.post("cardsV2", param)
  },
  getCardIndexData(param) {
    // return req.post("cardV3", param)
    // return req.post("cardV4", param)
    return req.post("cardV5", param)
  },
  getEditPraiseStatus(param) {
    return req.post("thumbs", param)
  },
  getForwardRecord(param) {
    return req.post("Forward", param)
  },
  getCopyRecord(param) {
    return req.post("copyRecord", param)
  },
  getShareRecord(param) {
    return req.post("record", param)
  },
  getShareInfo(param) {
    return req.post("getShare", param)
  },
  getPhone(param) {
    return req.post("phone", param)
  },
  /****************************************************商城**/
  /*商品分类/商品列表*/
  getShopTypes(param) {
    return req.post("ShopTypesV2", param)
  },
  getShopList(param) {
    return req.post("ShopGoods", param)
  },
  getShopSearch(param) {
    return req.post("ShopSearch", param)
  },
  /****************************************************动态**/
  /*动态列表/点赞/评论/获取新点赞评论数据/*/
  getNewsList(param) {
    return req.post("timeline", param)
  },
  getThumbs(param) {
    return req.post("timelineThumbs", param)
  },
  getComment(param) {
    return req.post("timelineComment", param)
  },
  getNewThumbsComment(param) {
    return req.post("timelineNew", param)
  },
  /****************************************************官网**/
  /*官网首页/////*/
  getModular(param) {
    return req.post("modularV2", param)
  },
  getModularInfo(param) {
    return req.post("modularInfo", param)
  },
  /****************************************************个人中心**/
  /*励志海报///////*/
  getPosterType(param) {
    return req.post("postertypeV2", param)
    // return req.post("postertype", param)
  },
  /****************************************************福包**/ 
  /*领取福包/用户领取福包列表/福包核销二维码/商城结算可用福包列表*/
  getCoupon(param) {
    return req.post("couponget", param)
  },
  getCouponList(param) {
    return req.post("couponlist", param)
  },
  getCouponQr(param) {
    return req.post("couponqr", param)
  },
  getSouponshop(param) {
    return req.post("couponshop", param)
  },
  /****************************************************分销**/
  /*我的收入/收入明细/分销商品/佣金流水/提现/提现记录////*/
  getMyEarning(param) {
    return req.post("sellingprofit", param)
  },
  getEarning(param) {
    return req.post("sellingwater", param)
  },
  getDistribution(param) {
    return req.post("sellingwater", param)
  },
  getCommission(param) {
    return req.post("sellingwater", param)
  },
  getWithdraw(param) {
    return req.post("sellingwater", param)
  },
  getWithdrawList(param) {
    return req.post("sellingwater", param)
  },
}