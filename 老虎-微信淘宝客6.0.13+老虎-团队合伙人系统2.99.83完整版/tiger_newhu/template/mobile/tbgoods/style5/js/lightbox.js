(function($){
    XDLightBox = function(k) {
        c = $;
        var a = this,
        f = null,
        d = c.extend({
            title: "",
            lightBoxId: "",
            ajax: false,
            contentHtml: "",
            scroll: false,
            isBgClickClose: true,
            type: "default"
        },
        k),
        b = null,
        i = null,
        h = null,
        j = function() {
            return (document.documentElement.scrollTop || document.body.scrollTop) + ((document.documentElement.clientHeight || document.body.clientHeight) - b.height()) / 2
        };
        a.getBoxFrame = function() {
            return b
        };
        a.getFrameId = function() {
            return d.lightBoxId
        };
        a.getBackground = function() {
            return h
        };
        a.close = function() {
            f && f.abort();
            b.remove();
            h.remove();
            c("body").unbind("keydown")
        };
        a.resize = function() {
            var a = (c(window).width() - b.width()) / 2,
            g = j();
            i.css({
                width: b.width(),
                height: b.height()
            });
            c.browser.msie && c.browser.version == "6.0" && h.css("height", document.documentElement.clientHeight || document.body.clientHeight);
            d.scroll ? c.browser.msie && c.browser.version == "6.0" ? (b.css({
                left: a,
                top: g
            }).show(), c(window).scroll(function() {
                var a = j();
                b.css("top", a)
            })) : (g = ((document.documentElement.clientHeight || document.body.clientHeight) - b.height()) / 2, b.css({
                left: a,
                top: g,
                position: "fixed"
            }).show()) : b.css({
                left: a,
                top: g
            }).show()
        };
        a.init = function() {
            if (d.lightBoxId != "") {
                if (d.type == "default") var e = XDTEMPLATE.lightBox.replace(/{title}/g, d.title).replace(/{id}/g, d.lightBoxId);
                e = d.ajax ? e.replace(/{body}/g, "") : e.replace(/{body}/g, d.contentHtml);
                c("body").append('<div class="alert_fullbg"></div>'+e);
                b = c("#" + d.lightBoxId);
                i = c(".lb_fix");
                h = c(".alert_fullbg");
                d.ajax && a.loading();
                a.resize();
                c(window).resize(function() {
                    a.resize()
                });
                c(".alert_close").click(function() {
                    a.close()
                });
                c(".alert_fullbg").click(function() {
                    d.isBgClickClose && a.close()
                })
            }
        };
        a.fadeout = function() {
            f && 
            f.abort();
            b.fadeOut(500);
            h.fadeOut(500, 
            function() {
                a.close()
            })
        };
        a.startAjax = function(a) {
            f = a
        };
        a.buildContent = function(e) {
            var g = false;
            b.find(".alert_content").size() == 0 && (b.find(".alert_box").html('<div class="alert_top"><span>' + d.title + '</span><a href="javascript:;" class="alert_close" ></a></div><div class="alert_content"></div>'), g = true);
            b.find(".alert_content").html(e);
            g && c("#" + d.lightBoxId + " .alert_close").click(function() {
                a.close()
            });
            a.resize()
        };
        a.success = function(e) {
            e = '<div class="alert_suc"><em></em><span>{text}</span><a href="javascript:;" class="close alert_close"></a></div>'.replace(/{text}/, 
            e);
            b.find(".lb_hd").hide();
            b.find(".alert_box").html(e);
            a.resize();
            b.find(".alert_bbg .alert_close").click(function() {
                a.close()
            });
            setTimeout(function() {
                a.fadeout()
            },
            1E3)
        };
        a.success_close = function(e, c) {
            var d = '<div class="lb_nohd"><a href="javascript:;" class="lb_close"></a><div class="lb_s">{text}</div></div>'.replace(/{text}/, e);
            b.find(".content").html(d);
            b.find(".lb_hd").hide();
            a.resize();
            b.find(".lb_nohd .lb_close").click(function() {
                a.close()
            });
            setTimeout(function() {
                a.close()
            },
            c || 1E3)
        };
        a.fail = function(c, 
        d) {
            var f = '<div class="lb_nohd"><a href="javascript:;" class="lb_close"></a><div class="lb_f">{text}</div></div>'.replace(/{text}/, c);
            b.find(".content").html(f);
            b.find(".lb_hd").hide();
            a.resize();
            b.find(".lb_nohd .lb_close").click(function() {
                a.close()
            });
            setTimeout(function() {
                a.close()
            },
            d || 2E3)
        };
        a.loading = function(c) {
            c || (c = "请稍后");
            b.find(".alert_box").html('<div class="alert_loading"><img src="'+__U_STATIC__+'/img/icon/loading.gif" /><span>{text}......</span><a href="javascript:;" class="alert_close">取消</a></div>'.replace(/{text}/, 
            c));
            a.resize()
        }
    }


})(jQuery)

;(function($, window) {
    var $window = $(window);

    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 0,
            failure_limit   : 0,
            event           : "scroll",
            effect          : "show",
            container       : window,
            data_attribute  : "original",
            skip_invisible  : true,
            appear          : null,
            load            : null
        };

        function update() {
            var counter = 0;
      
            elements.each(function() {
                var $this = $(this);

                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) {
                        $this.trigger("appear");
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit; 
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed; 
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.bind(settings.event, function(event) {
                return update();
            });
        }

        this.each(function() {
            var self = this;
            var $self = $(self);

            self.loaded = false;

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
                if (!this.loaded) {
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    $("<img />")
                        .bind("load", function() {
                            $self
                                .hide()
                                .attr("src", $self.data(settings.data_attribute)===undefined?$self.attr("d-src"):$self.data(settings.data_attribute))
                                [settings.effect](settings.effect_speed);
                            self.loaded = true;

                            /* Remove image from array so it is not looped next time. */
                            var temp = $.grep(elements, function(element) {
                                return !element.loaded;
                            });
                            elements = $(temp);

                            if (settings.load) {
                                var elements_left = elements.length;
                                settings.load.call(self, elements_left, settings);
                            }
                        })
                        .attr("src", $self.data(settings.data_attribute)===undefined?$self.attr("d-src"):$self.data(settings.data_attribute));
                }
            });

            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.bind(settings.event, function(event) {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.bind("resize", function(event) {
            update();
        });

        /* Force initial check if images should appear. */
        update();
        
        return this;
    };

    /* Convenience methods in jQuery namespace.           */
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.height() + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };
    
    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };
        
    $.abovethetop = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };
    
    $.leftofbegin = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightofscreen(element, settings) && !$.leftofscreen(element, settings) && 
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() */

    $.extend($.expr[':'], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return !$.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window);
