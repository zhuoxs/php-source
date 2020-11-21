/* 
* @Author: Mark
* @Date:   2015-04-11 15:34:05
* @Last Modified by:   Mark
* @Last Modified time: 2015-11-01 11:20:03
*/

  (function (doc, win) {
    var docEl = doc.documentElement,
    resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
    recalc = function () {
      var clientWidth = docEl.clientWidth;
      if (!clientWidth) return;
      docEl.style.fontSize = 40 * (clientWidth / 640) + 'px';
      doc.body.style["opacity"]=1;
      if(clientWidth>640)docEl.style.fontSize = 40+ 'px';
      
    }
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);

  })(document, window);

