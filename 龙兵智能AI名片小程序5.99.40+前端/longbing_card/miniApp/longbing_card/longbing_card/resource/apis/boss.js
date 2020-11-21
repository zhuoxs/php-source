import { req } from '../js/xx_request.js';

export default {
  /****************************************************saveFormId**/
  getFormId(param) {
    return req.post("formid", param)
  },
  /****************************************************总览**/
  /*九宫格数据汇总/成交率漏斗/商城订单量&交易金额/新增客户/咨询客户数/跟进客户数/客户兴趣占比/近15日客户活跃度/近15日客户活跃度柱状图*/
  getOverview(param) {
    return req.post("BossOverview", param)
  },
  /****************************************************销售排行**/
  /*客户人员/订单量/互动频率/成交率区间/员工客户列表/*/
  getRankClients(param) {
    return req.post("BossRankClients", param)
  },
  getRankOrder(param) {
    return req.post("BossRankOrder", param)
  },
  getRankInteraction(param) {
    return req.post("BossRankInteraction", param)
  },
  getRankRate(param) {
    return req.post("BossRankRate", param)
  },
  getClients(param) {
    return req.post("BossClients", param)
  },
  getClientList(param) {
    return req.post("clientList", param)
  },
  /****************************************************AI分析**/
  /*AI分析/员工总客户跟进咨询数/员工数据分析/客户互动/TA的跟进*/
  getAi(param) {
    return req.post("BossAiV2", param)
    // return req.post("BossAi", param)
  },
  getStaffNumber(param) {
    return req.post("BossStaffNumber", param)
  },
  getStaffEchart(param) {
    return req.post("bossstaffnineanalysis", param)
  },
  getStaffView(param) {
    return req.post("aiTime", param)
  },
  getStaffFollow(param) {
    return req.post("followList", param)
  },
}