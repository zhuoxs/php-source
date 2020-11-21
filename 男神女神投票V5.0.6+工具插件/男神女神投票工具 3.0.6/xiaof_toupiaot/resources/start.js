/**
 * Created by xiaof on 2017-08-07.
 */
function loadtool() {
    var o = 0;
    var t = setInterval(function () {
        $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=start&m=xiaof_toupiaot&i=" + window.sysinfo.uniacid);
        o++;
        if (o >= 10) {
            clearInterval(t);
        }
    }, 5000)
}
window.onload = function () {
    if (typeof jQuery == 'undefined') {
        require(["jquery"], function ($) {
            $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=start&m=xiaof_toupiaot&i=" + window.sysinfo.uniacid);
            loadtool();
        });
    } else {
        $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=start&m=xiaof_toupiaot&i=" + window.sysinfo.uniacid);
        loadtool();
    }
};