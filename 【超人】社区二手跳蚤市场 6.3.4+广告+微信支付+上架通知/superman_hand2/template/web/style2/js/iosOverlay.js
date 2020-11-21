/*global $*/
/*jshint unused:false,forin:false*/
'use strict';

var iosOverlay = function(params) {


    var overlayDOM;
    var overlayBg;
    var noop = function() {};
    var defaults = {
        onbeforeshow: noop,
        onshow: noop,
        onbeforehide: noop,
        onhide: noop,
        text: "",
        icon: null,
        spinner: null,
        duration: null,
        id: null,
        parentEl: null
    };

    // helper - merge two objects together, without using $.extend
    var merge = function(obj1, obj2) {
        var obj3 = {};
        for (var attrOne in obj1) {
            obj3[attrOne] = obj1[attrOne];
        }
        for (var attrTwo in obj2) {
            obj3[attrTwo] = obj2[attrTwo];
        }
        return obj3;
    };

    // helper - does it support CSS3 transitions/animation
    var doesTransitions = (function() {
        var b = document.body || document.documentElement;
        var s = b.style;
        var p = 'transition';
        if (typeof s[p] === 'string') {
            return true;
        }

        // Tests for vendor specific prop
        var v = ['Moz', 'Webkit', 'Khtml', 'O', 'ms'];
        p = p.charAt(0).toUpperCase() + p.substr(1);
        for (var i = 0; i < v.length; i++) {
            if (typeof s[v[i] + p] === 'string') {
                return true;
            }
        }
        return false;
    }());

    // setup overlay settings
    var settings = merge(defaults, params);

    //
    var handleAnim = function(anim) {
        if (anim.animationName === "ios-overlay-show") {
            settings.onshow();
        }
        if (anim.animationName === "ios-overlay-hide") {
            destroy();
            settings.onhide();
        }
    };

    // IIFE
    var create = (function() {
        //背景遮罩
        overlayBg = document.createElement("div");
        overlayBg.className = "ui-ios-bg";
        // initial DOM creation and event binding
        overlayDOM = document.createElement("div");
        overlayDOM.className = "ui-ios-overlay";
        overlayDOM.innerHTML += '<span class="title">' + settings.text + '</span';
        if (params.icon) {
            overlayDOM.innerHTML += '<img src="' + params.icon + '">';
        } else if (params.spinner) {
            overlayDOM.appendChild(params.spinner.el);
        }
        if (doesTransitions) {
            overlayBg.addEventListener("webkitAnimationEnd", handleAnim, false);
            overlayBg.addEventListener("msAnimationEnd", handleAnim, false);
            overlayBg.addEventListener("oAnimationEnd", handleAnim, false);
            overlayBg.addEventListener("animationend", handleAnim, false);
        }
        if (params.parentEl) {
            document.getElementById(params.parentEl).appendChild(overlayDOM);
        } else {
            //document.body.appendChild(overlayDOM);
            overlayBg.appendChild(overlayDOM);
            document.body.appendChild(overlayBg);
        }
        settings.onbeforeshow();
        // begin fade in
        if (doesTransitions) {
            overlayBg.className += " ios-overlay-show";
        } else if (typeof $ === "function") {
            $(overlayBg).fadeIn({
                duration: 200
            }, function() {
                settings.onshow();
            });
        }

        if (settings.duration) {
            window.setTimeout(function() {
                hide();
            }, settings.duration);
        }

    }());

    var hide = function() {
        // pre-callback
        settings.onbeforehide();
        // fade out
        if (doesTransitions) {
            // CSS animation bound to classes
            overlayBg.className = overlayBg.className.replace("show", "hide");
        } else if (typeof $ === "function") {
            // polyfill requires jQuery
            $(overlayDOM).fadeOut({
                duration: 200
            }, function() {
                destroy();
                settings.onhide();
            });
        }
    };

    var destroy = function() {
        if (params.parentEl) {
            document.getElementById(params.parentEl).removeChild(overlayDOM);
        } else {
            document.body.removeChild(overlayBg);
        }
    };

    var update = function(params) {
        if (params.text) {
            overlayDOM.getElementsByTagName("span")[0].innerHTML = params.text;
        }
        if (params.icon) {
            if (settings.spinner) {
                // Unless we set spinner to null, this will throw on the second update
                settings.spinner.el.parentNode.removeChild(settings.spinner.el);
                settings.spinner = null;
            }
            overlayDOM.innerHTML += '<img src="' + params.icon + '">';
        }
    };

    return {
        hide: hide,
        destroy: destroy,
        update: update
    };

};

//Added support for requirejs
if (typeof define === 'function' && define.amd) {
    define([], function() {
        return iosOverlay;
    });
}
