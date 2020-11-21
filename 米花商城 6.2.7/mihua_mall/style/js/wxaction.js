var shareData = {
      title: wxData.title,
      link: wxData.link,
    	desc: wxData.desc,
      imgUrl:  wxData.imgUrl
    };

wx.ready(function () {
    wx.onMenuShareAppMessage(sharedata);
    wx.onMenuShareTimeline(shareData);
    wx.onMenuShareQQ(shareData);
    wx.onMenuShareWeibo(shareData);
	
});
function t_hideOptionMenu()
{
 
}
function t_showOptionMenu()
{
 
}