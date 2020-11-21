var __placeImgeUrlHttps = "https", __emojisReg = "", __emojisBaseSrc = "", __emojis = {}, wxDiscode = require("./wxDiscode.js"), HTMLParser = require("./htmlparser.js"), empty = makeMap("area,base,basefont,br,col,frame,hr,img,input,link,meta,param,embed,command,keygen,source,track,wbr"), block = makeMap("br,a,code,address,article,applet,aside,audio,blockquote,button,canvas,center,dd,del,dir,div,dl,dt,fieldset,figcaption,figure,footer,form,frameset,h1,h2,h3,h4,h5,h6,header,hgroup,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,output,p,pre,section,script,table,tbody,td,tfoot,th,thead,tr,ul,video"), inline = makeMap("abbr,acronym,applet,b,basefont,bdo,big,button,cite,del,dfn,em,font,i,iframe,img,input,ins,kbd,label,map,object,q,s,samp,script,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"), closeSelf = makeMap("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr"), fillAttrs = makeMap("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"), special = makeMap("wxxxcode-style,script,style,view,scroll-view,block");

function makeMap(e) {
    for (var t = {}, r = e.split(","), s = 0; s < r.length; s++) t[r[s]] = !0;
    return t;
}

function q(e) {
    return '"' + e + '"';
}

function removeDOCTYPE(e) {
    return e.replace(/<\?xml.*\?>\n/, "").replace(/<.*!doctype.*\>\n/, "").replace(/<.*!DOCTYPE.*\>\n/, "");
}

function html2json(e, m) {
    e = removeDOCTYPE(e), e = wxDiscode.strDiscode(e);
    var d = [], p = {
        node: m,
        nodes: [],
        images: [],
        imageUrls: []
    };
    return HTMLParser(e, {
        start: function(e, t, r) {
            var a = {
                node: "element",
                tag: e
            };
            if (block[e] ? a.tagType = "block" : inline[e] ? a.tagType = "inline" : closeSelf[e] && (a.tagType = "closeSelf"), 
            0 !== t.length && (a.attr = t.reduce(function(e, t) {
                var r = t.name, s = t.value;
                return "class" == r && (a.classStr = s), "style" == r && (a.styleStr = s), s.match(/ /) && (s = s.split(" ")), 
                e[r] ? Array.isArray(e[r]) ? e[r].push(s) : e[r] = [ e[r], s ] : e[r] = s, e;
            }, {})), "img" === a.tag) {
                a.imgIndex = p.images.length;
                var s = a.attr.src;
                s = wxDiscode.urlToHttpUrl(s, __placeImgeUrlHttps), a.attr.src = s, a.from = m, 
                p.images.push(a), p.imageUrls.push(s);
            }
            if ("font" === a.tag) {
                var o = [ "x-small", "small", "medium", "large", "x-large", "xx-large", "-webkit-xxx-large" ], i = {
                    color: "color",
                    face: "font-family",
                    size: "font-size"
                };
                for (var n in a.attr.style || (a.attr.style = []), a.styleStr || (a.styleStr = ""), 
                i) if (a.attr[n]) {
                    var l = "size" === n ? o[a.attr[n] - 1] : a.attr[n];
                    a.attr.style.push(i[n]), a.attr.style.push(l), a.styleStr += i[n] + ": " + l + ";";
                }
            }
            if ("source" === a.tag && (p.source = a.attr.src), r) {
                var c = d[0] || p;
                void 0 === c.nodes && (c.nodes = []), c.nodes.push(a);
            } else d.unshift(a);
        },
        end: function(e) {
            var t = d.shift();
            if (t.tag !== e && console.error("invalid state: mismatch end tag"), "video" === t.tag && p.source && (t.attr.src = p.source, 
            delete p.source), 0 === d.length) p.nodes.push(t); else {
                var r = d[0];
                void 0 === r.nodes && (r.nodes = []), r.nodes.push(t);
            }
        },
        chars: function(e) {
            var t = {
                node: "text",
                text: e,
                textArray: transEmojiStr(e)
            };
            if (0 === d.length) p.nodes.push(t); else {
                var r = d[0];
                void 0 === r.nodes && (r.nodes = []), r.nodes.push(t);
            }
        },
        comment: function(e) {}
    }), p;
}

function transEmojiStr(e) {
    var t = [];
    if (0 == __emojisReg.length || !__emojis) return (i = {
        node: "text"
    }).text = e, s = [ i ];
    e = e.replace(/\[([^\[\]]+)\]/g, ":$1:");
    for (var r = new RegExp("[:]"), s = e.split(r), a = 0; a < s.length; a++) {
        var o = s[a], i = {};
        __emojis[o] ? (i.node = "element", i.tag = "emoji", i.text = __emojis[o], i.baseSrc = __emojisBaseSrc) : (i.node = "text", 
        i.text = o), t.push(i);
    }
    return t;
}

function emojisInit() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "", t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", r = arguments[2];
    __emojisReg = e, __emojisBaseSrc = t, __emojis = r;
}

module.exports = {
    html2json: html2json,
    emojisInit: emojisInit
};