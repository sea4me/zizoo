var CogzidelDashboard;
(function (a) {
    CogzidelDashboard = {
        listeners: {},
        init: function (b) {
            CogzidelDashboard.options = b || {};
            if (!CogzidelDashboard.options.disableFormSpinner) {
                a("form").submit(function () {
                    CogzidelDashboard.setLoading(true, {
                        context: a(this)
                    })
                })
            }
            a(".edit_room_nav").delegate("a", "click", function () {
                a(".edit_room_nav .spinner").removeClass("spinner");
                a(this).find(".icon").addClass("spinner")
            });
            a("#notification-area div span.close").live("click", function () {
                a(this).parent().fadeOut(500, function () {
                    a(this).remove()
                })
            });
												
            if (a.browser.webkit) {
                a("body").addClass("webkit")
            }
            a("#address_verify").submit(function (f) {
                f.preventDefault();
                var d = a(this);
                var c = d.find("div").addClass("loading");
                a.post(d.attr("action"), d.serialize(), function (e) {
                    if (e.result === "success") {
                        document.location.reload()
                    } else {
                        c.removeClass("loading");
                        a("#address_verify_errors_detail").text(e.error);
                        a("#address_verify_errors").slideDown()
                    }
                })
            });
            a("#address_verify_retry").submit(function (f) {
                f.preventDefault();
                var d = a(this);
                var c = d.find("div").addClass("loading");
                a.post(d.attr("action"), d.serialize(), function (e) {
                    if (e.result === "success") {
                        document.location.reload()
                    } else {
                        alert(e.error);
                        c.removeClass("loading")
                    }
                })
            });
            CogzidelDashboard.initSpinner()
        },
        initSpinner: function () {
            var b = new Image();
            b.src = "/images/spinner.gif";
            a(".edit_room_nav").delegate("a", "click", function () {
                a(".edit_room_nav .spinner").removeClass("spinner");
                a(this).find(".icon").addClass("spinner")
            })
        },
        addListener: function (d, e) {
            var c = CogzidelDashboard.listeners;
            var b;
            b = c[d];
            if (!b) {
                b = c[d] = []
            }
            b.push(e)
        },
        removeListener: function (e, f) {
            var d, c;
            var b = CogzidelDashboard.listeners[e];
            if (b) {
                for (d = 0, c = b.length; d < c; d++) {
                    if (b[d] === f) {
                        b.splice(d, 1);
                        return true
                    }
                }
            }
            return false
        },
        createNotificationItem: function (c, g, e) {
            var d, b;
            var f = CogzidelDashboard.listeners[g];
            if (e) {
                a('#notification-area [data-form="' + a(e).attr("id") + '"]').remove()
            }
            a("#notification-area > :first-child").remove();
            a("#notification-area").prepend(a("#notification-item-template").jqote({
                type: g,
                label: c
            }, "*"));
            var h = a("#notification-area > :first-child");
            if (e) {
                h.attr("data-form", a(e).attr("id"))
            }
            h.children(".label").pulsate(4, 700);
            if (f) {
                for (d = 0, b = f.length; d < b; d++) {
                    f[d]()
                }
            }
        },
        updateProgressBar: function (d, f, b, e) {
            var c = a("#listing_progress");
            c.fadeOut(350, function () {
                a("#progress_text").html(b);
                var j = a("#creamy_bar_filling");
                j.removeClass();
                j.addClass("filled_" + (Math.floor(d * 10) * 10));
                var i = a("#next_steps");
                i.empty();
                for (var g in f) {
                    var h = f[g];
                    i.append('<li><a class="step_link" href="' + h.url + '" title="' + h.description + '">' + h.description + '</a><span class="plus_percent">(+' + Math.round(h.weight * 100) + "%)</span></li>")
                }
                if (e !== true) {
                    c.fadeIn(350);
                    a(".set-availability").availabilityWidget("setInactive")
                } else {
                    a(".set-availability").availabilityWidget("setActive")
                }
            })
        },
        setLoading: function (b, c) {
            var c = c || {},
                d = a("div.form-submit span.spinner", c.context),
                e = a("div.form-submit :submit", c.context);
            if (b) {
                d.show();
                e.attr("disabled", "disabled")
            } else {
                d.hide();
                e.removeAttr("disabled");
                if (c.scroll) {
                    a("html, body").animate({
                        scrollTop: 0
                    }, "slow")
                }
            }
        }
    }
})(jQuery);
(function (b) {
    var a = function (d, c) {
            if (d) {
                this.init(d, c)
            }
        };
    b.extend(a.prototype, {
        name: "cogzidelMap",
        init: function (g, f) {
            this.element = b(g);
            b.data(g, this.name, this);
            var h = this;
            if (f.position) {
                this.position = f.position
            }
            if (f.isFuzzy) {
                this.isFuzzy = f.isFuzzy
            }
            if (f.onMarkerClick) {
                this.onMarkerClick = f.onMarkerClick
            }
            if (f.accuracy) {
                this.accuracy = f.accuracy
            }
            if (this.isFuzzy) {
                var d = 11;
                if (this.accuracy >= 3 && this.accuracy <= 9) {
                    d = this.accuracy + 6
                } else {
                    if (this.accuracy == 2) {
                        d = 6
                    } else {
                        if (this.accuracy == 1) {
                            d = 4
                        } else {
                            d = 1
                        }
                    }
                }
                this.map = new google.maps.Map(g, {
                    zoom: d,
                    center: this.position,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControl: false,
                    streetViewControl: false,
                    scrollwheel: false
                });
                this.marker = new google.maps.Circle({
                    center: this.position,
                    map: this.map,
                    fillColor: "rgb(255, 0, 162)",
                    fillOpacity: 0.25,
                    radius: CogzidelConstants.MapCircleSizes[d],
                    strokeOpacity: 0,
                    clickable: false
                });
                var e = function () {
                        var j = h.marker.getBounds();
                        var i = h.map.getBounds();
                        if (j.contains && j.contains(i.getNorthEast()) && j.contains(i.getSouthWest())) {
                            if (!h.markerHidden) {
                                h.marker.setOptions({
                                    fillOpacity: 0
                                });
                                h.markerHidden = true
                            }
                        } else {
                            if (h.markerHidden) {
                                h.marker.setOptions({
                                    fillOpacity: 0.25
                                });
                                h.markerHidden = false
                            }
                        }
                    };
                var c = function () {
                        h.marker.setRadius(CogzidelConstants.MapCircleSizes[h.map.getZoom()])
                    };
                google.maps.event.addListener(h.map, "bounds_changed", e);
                google.maps.event.addListener(h.map, "zoom_changed", c)
            } else {
                this.map = new google.maps.Map(g, {
                    zoom: 15,
                    center: this.position,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControl: false,
                    streetViewControl: false,
                    scrollwheel: false,
                    scaleControl: true
                });
                this.marker = new google.maps.Marker({
                    clickable: !! this.onMarkerClick,
                    position: this.position,
                    map: this.map,
                    zIndex: 10,
                    icon: new google.maps.MarkerImage("/images/guidebook/pin_home.png", null, null, new google.maps.Point(14, 32))
                })
            }
            if (this.onMarkerClick) {
                google.maps.event.addListener(this.marker, "click", function () {
                    h.onMarkerClick(h)
                })
            }
        },
        setMarkerPosition: function (c) {
            if (this.isFuzzy) {
                this.marker.setCenter(c)
            } else {
                this.marker.setPosition(c)
            }
            this.map.panTo(c)
        },
        position: null,
        isFuzzy: false,
        map: null,
        marker: null,
        onMarkerClick: null,
        accuracy: 9,
        minZoom: 1,
        markerHidden: false
    });
    b.fn.cogzidelMap = function (e) {
        var d = b.makeArray(arguments),
            g = d.slice(1);
        var c;
        var f = this.each(function () {
            c = b.data(this, "cogzidelMap");
            if (c) {
                if (typeof e === "string") {
                    c[e].apply(c, g)
                } else {
                    if (c.update) {
                        c.update.apply(c, d)
                    }
                }
            } else {
                new a(this, e)
            }
        });
        return c ? c : f
    }
})(jQuery);
if (!window.CogzidelConstants) {
    var CogzidelConstants = {}
}
CogzidelConstants.MapCircleSizes = [4096000, 2048000, 1024000, 512000, 256000, 128000, 64000, 32000, 16000, 8000, 4000, 2000, 1000, 500, 500, 500, 500, 500, 500, 500];
this.tooltip = function () {
    xOffset = 20;
    yOffset = 20;
    jQuery("a.tooltip").hover(function (a) {
        this.t = this.title;
        this.title = "";
        jQuery("body").append("<p id='tooltip'>" + this.t.replace(/\n/g, "<br />") + "</p>");
        jQuery("#tooltip").css("top", (a.pageY - xOffset) + "px").css("left", (a.pageX + yOffset) + "px").fadeIn("fast")
    }, function () {
        this.title = this.t;
        jQuery("#tooltip").remove()
    });
    jQuery("a.tooltip").mousemove(function (a) {
        jQuery("#tooltip").css("top", (a.pageY - xOffset) + "px").css("left", (a.pageX + yOffset) + "px")
    })
};
jQuery(document).ready(function () {
    tooltip()
});
var COMPILED = true,
    goog = goog || {};
goog.global = this;
goog.DEBUG = true;
goog.LOCALE = "en";
goog.evalWorksForGlobals_ = null;
goog.provide = function (d) {
    if (!COMPILED) {
        if (goog.getObjectByName(d) && !goog.implicitNamespaces_[d]) {
            throw Error('Namespace "' + d + '" already declared.')
        }
        for (var c = d; c = c.substring(0, c.lastIndexOf("."));) {
            goog.implicitNamespaces_[c] = true
        }
    }
    goog.exportPath_(d)
};
goog.setTestOnly = function (b) {
    if (COMPILED && !goog.DEBUG) {
        b = b || "";
        throw Error("Importing test-only code into non-debug environment" + b ? ": " + b : ".")
    }
};
if (!COMPILED) {
    goog.implicitNamespaces_ = {}
}
goog.exportPath_ = function (f, e, h) {
    f = f.split(".");
    h = h || goog.global;
    !(f[0] in h) && h.execScript && h.execScript("var " + f[0]);
    for (var g; f.length && (g = f.shift());) {
        if (!f.length && goog.isDef(e)) {
            h[g] = e
        } else {
            h = h[g] ? h[g] : h[g] = {}
        }
    }
};
goog.getObjectByName = function (g, f) {
    for (var j = g.split("."), i = f || goog.global, h; h = j.shift();) {
        if (goog.isDefAndNotNull(i[h])) {
            i = i[h]
        } else {
            return null
        }
    }
    return i
};
goog.globalize = function (f, e) {
    var h = e || goog.global,
        g;
    for (g in f) {
        h[g] = f[g]
    }
};
goog.addDependency = function (h, g, l) {
    if (!COMPILED) {
        var k;
        h = h.replace(/\\/g, "/");
        for (var j = goog.dependencies_, i = 0; k = g[i]; i++) {
            j.nameToPath[k] = h;
            h in j.pathToNames || (j.pathToNames[h] = {});
            j.pathToNames[h][k] = true
        }
        for (k = 0; g = l[k]; k++) {
            h in j.requires || (j.requires[h] = {});
            j.requires[h][g] = true
        }
    }
};
goog.require = function (d) {
    if (!COMPILED) {
        if (!goog.getObjectByName(d)) {
            var c = goog.getPathFromDeps_(d);
            if (c) {
                goog.included_[c] = true;
                goog.writeScripts_()
            } else {
                d = "goog.require could not find: " + d;
                goog.global.console && goog.global.console.error(d);
                throw Error(d)
            }
        }
    }
};
goog.basePath = "";
goog.nullFunction = function () {};
goog.identityFunction = function (b) {
    return b
};
goog.abstractMethod = function () {
    throw Error("unimplemented abstract method")
};
goog.addSingletonGetter = function (b) {
    b.getInstance = function () {
        return b.instance_ || (b.instance_ = new b)
    }
};
if (!COMPILED) {
    goog.included_ = {};
    goog.dependencies_ = {
        pathToNames: {},
        nameToPath: {},
        requires: {},
        visited: {},
        written: {}
    };
    goog.inHtmlDocument_ = function () {
        var b = goog.global.document;
        return typeof b != "undefined" && "write" in b
    };
    goog.findBasePath_ = function () {
        if (goog.global.CLOSURE_BASE_PATH) {
            goog.basePath = goog.global.CLOSURE_BASE_PATH
        } else {
            if (goog.inHtmlDocument_()) {
                for (var f = goog.global.document.getElementsByTagName("script"), e = f.length - 1; e >= 0; --e) {
                    var h = f[e].src,
                        g = h.lastIndexOf("?");
                    g = g == -1 ? h.length : g;
                    if (h.substr(g - 7, 7) == "base.js") {
                        goog.basePath = h.substr(0, g - 7);
                        break
                    }
                }
            }
        }
    };
    goog.importScript_ = function (d) {
        var c = goog.global.CLOSURE_IMPORT_SCRIPT || goog.writeScriptTag_;
        if (!goog.dependencies_.written[d] && c(d)) {
            goog.dependencies_.written[d] = true
        }
    };
    goog.writeScriptTag_ = function (b) {
        if (goog.inHtmlDocument_()) {
            goog.global.document.write('<script type="text/javascript" src="' + b + '"><\/script>');
            return true
        } else {
            return false
        }
    };
    goog.writeScripts_ = function () {
        function g(b) {
            if (!(b in i.written)) {
                if (!(b in i.visited)) {
                    i.visited[b] = true;
                    if (b in i.requires) {
                        for (var a in i.requires[b]) {
                            if (a in i.nameToPath) {
                                g(i.nameToPath[a])
                            } else {
                                if (!goog.getObjectByName(a)) {
                                    throw Error("Undefined nameToPath for " + a)
                                }
                            }
                        }
                    }
                }
                if (!(b in j)) {
                    j[b] = true;
                    f.push(b)
                }
            }
        }
        var f = [],
            j = {},
            i = goog.dependencies_,
            h;
        for (h in goog.included_) {
            i.written[h] || g(h)
        }
        for (h = 0; h < f.length; h++) {
            if (f[h]) {
                goog.importScript_(goog.basePath + f[h])
            } else {
                throw Error("Undefined script input")
            }
        }
    };
    goog.getPathFromDeps_ = function (b) {
        return b in goog.dependencies_.nameToPath ? goog.dependencies_.nameToPath[b] : null
    };
    goog.findBasePath_();
    goog.global.CLOSURE_NO_DEPS || goog.importScript_(goog.basePath + "deps.js")
}
goog.typeOf = function (e) {
    var d = typeof e;
    if (d == "object") {
        if (e) {
            if (e instanceof Array) {
                return "array"
            } else {
                if (e instanceof Object) {
                    return d
                }
            }
            var f = Object.prototype.toString.call(e);
            if (f == "[object Window]") {
                return "object"
            }
            if (f == "[object Array]" || typeof e.length == "number" && typeof e.splice != "undefined" && typeof e.propertyIsEnumerable != "undefined" && !e.propertyIsEnumerable("splice")) {
                return "array"
            }
            if (f == "[object Function]" || typeof e.call != "undefined" && typeof e.propertyIsEnumerable != "undefined" && !e.propertyIsEnumerable("call")) {
                return "function"
            }
        } else {
            return "null"
        }
    } else {
        if (d == "function" && typeof e.call == "undefined") {
            return "object"
        }
    }
    return d
};
goog.propertyIsEnumerableCustom_ = function (e, d) {
    if (d in e) {
        for (var f in e) {
            if (f == d && Object.prototype.hasOwnProperty.call(e, d)) {
                return true
            }
        }
    }
    return false
};
goog.propertyIsEnumerable_ = function (d, c) {
    return d instanceof Object ? Object.prototype.propertyIsEnumerable.call(d, c) : goog.propertyIsEnumerableCustom_(d, c)
};
goog.isDef = function (b) {
    return b !== undefined
};
goog.isNull = function (b) {
    return b === null
};
goog.isDefAndNotNull = function (b) {
    return b != null
};
goog.isArray = function (b) {
    return goog.typeOf(b) == "array"
};
goog.isArrayLike = function (d) {
    var c = goog.typeOf(d);
    return c == "array" || c == "object" && typeof d.length == "number"
};
goog.isDateLike = function (b) {
    return goog.isObject(b) && typeof b.getFullYear == "function"
};
goog.isString = function (b) {
    return typeof b == "string"
};
goog.isBoolean = function (b) {
    return typeof b == "boolean"
};
goog.isNumber = function (b) {
    return typeof b == "number"
};
goog.isFunction = function (b) {
    return goog.typeOf(b) == "function"
};
goog.isObject = function (b) {
    b = goog.typeOf(b);
    return b == "object" || b == "array" || b == "function"
};
goog.getUid = function (b) {
    return b[goog.UID_PROPERTY_] || (b[goog.UID_PROPERTY_] = ++goog.uidCounter_)
};
goog.removeUid = function (d) {
    "removeAttribute" in d && d.removeAttribute(goog.UID_PROPERTY_);
    try {
        delete d[goog.UID_PROPERTY_]
    } catch (c) {}
};
goog.UID_PROPERTY_ = "closure_uid_" + Math.floor(Math.random() * 2147483648).toString(36);
goog.uidCounter_ = 0;
goog.getHashCode = goog.getUid;
goog.removeHashCode = goog.removeUid;
goog.cloneObject = function (e) {
    var d = goog.typeOf(e);
    if (d == "object" || d == "array") {
        if (e.clone) {
            return e.clone()
        }
        d = d == "array" ? [] : {};
        for (var f in e) {
            d[f] = goog.cloneObject(e[f])
        }
        return d
    }
    return e
};
goog.bindNative_ = function (b) {
    return b.call.apply(b.bind, arguments)
};
goog.bindJs_ = function (f, e) {
    var h = e || goog.global;
    if (arguments.length > 2) {
        var g = Array.prototype.slice.call(arguments, 2);
        return function () {
            var a = Array.prototype.slice.call(arguments);
            Array.prototype.unshift.apply(a, g);
            return f.apply(h, a)
        }
    } else {
        return function () {
            return f.apply(h, arguments)
        }
    }
};
goog.bind = function () {
    goog.bind = Function.prototype.bind && Function.prototype.bind.toString().indexOf("native code") != -1 ? goog.bindNative_ : goog.bindJs_;
    return goog.bind.apply(null, arguments)
};
goog.partial = function (d) {
    var c = Array.prototype.slice.call(arguments, 1);
    return function () {
        var a = Array.prototype.slice.call(arguments);
        a.unshift.apply(a, c);
        return d.apply(this, a)
    }
};
goog.mixin = function (e, d) {
    for (var f in d) {
        e[f] = d[f]
    }
};
goog.now = Date.now ||
function () {
    return +new Date
};
goog.globalEval = function (a) {
    if (goog.global.execScript) {
        goog.global.execScript(a, "JavaScript")
    } else {
        if (goog.global.eval) {
            if (goog.evalWorksForGlobals_ == null) {
                goog.global.eval("var _et_ = 1;");
                if (typeof goog.global._et_ != "undefined") {
                    delete goog.global._et_;
                    goog.evalWorksForGlobals_ = true
                } else {
                    goog.evalWorksForGlobals_ = false
                }
            }
            if (goog.evalWorksForGlobals_) {
                goog.global.eval(a)
            } else {
                var b = goog.global.document,
                    c = b.createElement("script");
                c.type = "text/javascript";
                c.defer = false;
                c.appendChild(b.createTextNode(a));
                b.body.appendChild(c);
                b.body.removeChild(c)
            }
        } else {
            throw Error("goog.globalEval not available")
        }
    }
};
goog.typedef = true;
goog.getCssName = function (e, d) {
    var f;
    f = goog.cssNameMapping_ ? goog.cssNameMappingStyle_ == "BY_WHOLE" ?
    function (a) {
        return goog.cssNameMapping_[a] || a
    } : function (j) {
        for (var i = j.split("-"), c = [], b = 0; b < i.length; b++) {
            var a = goog.cssNameMapping_[i[b]];
            if (!a) {
                return j
            }
            c.push(a)
        }
        return c.join("-")
    } : function (a) {
        return a
    };
    return d ? e + "-" + f(d) : f(e)
};
goog.setCssNameMapping = function (d, c) {
    goog.cssNameMapping_ = d;
    goog.cssNameMappingStyle_ = c
};
goog.getMsg = function (g, f) {
    var j = f || {},
        i;
    for (i in j) {
        var h = ("" + j[i]).replace(/\$/g, "$$$$");
        g = g.replace(RegExp("\\{\\$" + i + "\\}", "gi"), h)
    }
    return g
};
goog.exportSymbol = function (e, d, f) {
    goog.exportPath_(e, d, f)
};
goog.exportProperty = function (e, d, f) {
    e[d] = f
};
goog.inherits = function (e, d) {
    function f() {}
    f.prototype = d.prototype;
    e.superClass_ = d.prototype;
    e.prototype = new f;
    e.prototype.constructor = e
};
goog.base = function (h, g) {
    var l = arguments.callee.caller;
    if (l.superClass_) {
        return l.superClass_.constructor.apply(h, Array.prototype.slice.call(arguments, 1))
    }
    for (var k = Array.prototype.slice.call(arguments, 2), j = false, i = h.constructor; i; i = i.superClass_ && i.superClass_.constructor) {
        if (i.prototype[g] === l) {
            j = true
        } else {
            if (j) {
                return i.prototype[g].apply(h, k)
            }
        }
    }
    if (h[g] === l) {
        return h.constructor.prototype[g].apply(h, k)
    } else {
        throw Error("goog.base called from a method of one name to a method of a different name")
    }
};
goog.scope = function (b) {
    b.call(goog.global)
};
goog.debug = {};
goog.debug.Error = function (b) {
    this.stack = Error().stack || "";
    if (b) {
        this.message = String(b)
    }
};
goog.inherits(goog.debug.Error, Error);
goog.debug.Error.prototype.name = "CustomError";
goog.string = {};
goog.string.Unicode = {
    NBSP: "\u00a0"
};
goog.string.startsWith = function (d, c) {
    return d.lastIndexOf(c, 0) == 0
};
goog.string.endsWith = function (e, d) {
    var f = e.length - d.length;
    return f >= 0 && e.indexOf(d, f) == f
};
goog.string.caseInsensitiveStartsWith = function (d, c) {
    return goog.string.caseInsensitiveCompare(c, d.substr(0, c.length)) == 0
};
goog.string.caseInsensitiveEndsWith = function (d, c) {
    return goog.string.caseInsensitiveCompare(c, d.substr(d.length - c.length, c.length)) == 0
};
goog.string.subs = function (e) {
    for (var d = 1; d < arguments.length; d++) {
        var f = String(arguments[d]).replace(/\$/g, "$$$$");
        e = e.replace(/\%s/, f)
    }
    return e
};
goog.string.collapseWhitespace = function (b) {
    return b.replace(/[\s\xa0]+/g, " ").replace(/^\s+|\s+$/g, "")
};
goog.string.isEmpty = function (b) {
    return /^[\s\xa0]*$/.test(b)
};
goog.string.isEmptySafe = function (b) {
    return goog.string.isEmpty(goog.string.makeSafe(b))
};
goog.string.isBreakingWhitespace = function (b) {
    return !/[^\t\n\r ]/.test(b)
};
goog.string.isAlpha = function (b) {
    return !/[^a-zA-Z]/.test(b)
};
goog.string.isNumeric = function (b) {
    return !/[^0-9]/.test(b)
};
goog.string.isAlphaNumeric = function (b) {
    return !/[^a-zA-Z0-9]/.test(b)
};
goog.string.isSpace = function (b) {
    return b == " "
};
goog.string.isUnicodeChar = function (b) {
    return b.length == 1 && b >= " " && b <= "~" || b >= "\u0080" && b <= "\ufffd"
};
goog.string.stripNewlines = function (b) {
    return b.replace(/(\r\n|\r|\n)+/g, " ")
};
goog.string.canonicalizeNewlines = function (b) {
    return b.replace(/(\r\n|\r|\n)/g, "\n")
};
goog.string.normalizeWhitespace = function (b) {
    return b.replace(/\xa0|\s/g, " ")
};
goog.string.normalizeSpaces = function (b) {
    return b.replace(/\xa0|[ \t]+/g, " ")
};
goog.string.trim = function (b) {
    return b.replace(/^[\s\xa0]+|[\s\xa0]+$/g, "")
};
goog.string.trimLeft = function (b) {
    return b.replace(/^[\s\xa0]+/, "")
};
goog.string.trimRight = function (b) {
    return b.replace(/[\s\xa0]+$/, "")
};
goog.string.caseInsensitiveCompare = function (f, e) {
    var h = String(f).toLowerCase(),
        g = String(e).toLowerCase();
    return h < g ? -1 : h == g ? 0 : 1
};
goog.string.numerateCompareRegExp_ = /(\.\d+)|(\d+)|(\D+)/g;
goog.string.numerateCompare = function (j, i) {
    if (j == i) {
        return 0
    }
    if (!j) {
        return -1
    }
    if (!i) {
        return 1
    }
    for (var p = j.toLowerCase().match(goog.string.numerateCompareRegExp_), o = i.toLowerCase().match(goog.string.numerateCompareRegExp_), n = Math.min(p.length, o.length), m = 0; m < n; m++) {
        var l = p[m],
            k = o[m];
        if (l != k) {
            p = parseInt(l, 10);
            if (!isNaN(p)) {
                o = parseInt(k, 10);
                if (!isNaN(o) && p - o) {
                    return p - o
                }
            }
            return l < k ? -1 : 1
        }
    }
    if (p.length != o.length) {
        return p.length - o.length
    }
    return j < i ? -1 : 1
};
goog.string.encodeUriRegExp_ = /^[a-zA-Z0-9\-_.!~*'()]*$/;
goog.string.urlEncode = function (b) {
    b = String(b);
    if (!goog.string.encodeUriRegExp_.test(b)) {
        return encodeURIComponent(b)
    }
    return b
};
goog.string.urlDecode = function (b) {
    return decodeURIComponent(b.replace(/\+/g, " "))
};
goog.string.newLineToBr = function (d, c) {
    return d.replace(/(\r\n|\r|\n)/g, c ? "<br />" : "<br>")
};
goog.string.htmlEscape = function (d, c) {
    if (c) {
        return d.replace(goog.string.amperRe_, "&amp;").replace(goog.string.ltRe_, "&lt;").replace(goog.string.gtRe_, "&gt;").replace(goog.string.quotRe_, "&quot;")
    } else {
        if (!goog.string.allRe_.test(d)) {
            return d
        }
        if (d.indexOf("&") != -1) {
            d = d.replace(goog.string.amperRe_, "&amp;")
        }
        if (d.indexOf("<") != -1) {
            d = d.replace(goog.string.ltRe_, "&lt;")
        }
        if (d.indexOf(">") != -1) {
            d = d.replace(goog.string.gtRe_, "&gt;")
        }
        if (d.indexOf('"') != -1) {
            d = d.replace(goog.string.quotRe_, "&quot;")
        }
        return d
    }
};
goog.string.amperRe_ = /&/g;
goog.string.ltRe_ = /</g;
goog.string.gtRe_ = />/g;
goog.string.quotRe_ = /\"/g;
goog.string.allRe_ = /[&<>\"]/;
goog.string.unescapeEntities = function (b) {
    if (goog.string.contains(b, "&")) {
        return "document" in goog.global && !goog.string.contains(b, "<") ? goog.string.unescapeEntitiesUsingDom_(b) : goog.string.unescapePureXmlEntities_(b)
    }
    return b
};
goog.string.unescapeEntitiesUsingDom_ = function (d) {
    var c = goog.global.document.createElement("div");
    c.innerHTML = "<pre>x" + d + "</pre>";
    if (c.firstChild[goog.string.NORMALIZE_FN_]) {
        c.firstChild[goog.string.NORMALIZE_FN_]()
    }
    d = c.firstChild.firstChild.nodeValue.slice(1);
    c.innerHTML = "";
    return goog.string.canonicalizeNewlines(d)
};
goog.string.unescapePureXmlEntities_ = function (b) {
    return b.replace(/&([^;]+);/g, function (a, f) {
        switch (f) {
        case "amp":
            return "&";
        case "lt":
            return "<";
        case "gt":
            return ">";
        case "quot":
            return '"';
        default:
            if (f.charAt(0) == "#") {
                var e = Number("0" + f.substr(1));
                if (!isNaN(e)) {
                    return String.fromCharCode(e)
                }
            }
            return a
        }
    })
};
goog.string.NORMALIZE_FN_ = "normalize";
goog.string.whitespaceEscape = function (d, c) {
    return goog.string.newLineToBr(d.replace(/  /g, " &#160;"), c)
};
goog.string.stripQuotes = function (g, f) {
    for (var j = f.length, i = 0; i < j; i++) {
        var h = j == 1 ? f : f.charAt(i);
        if (g.charAt(0) == h && g.charAt(g.length - 1) == h) {
            return g.substring(1, g.length - 1)
        }
    }
    return g
};
goog.string.truncate = function (e, d, f) {
    if (f) {
        e = goog.string.unescapeEntities(e)
    }
    if (e.length > d) {
        e = e.substring(0, d - 3) + "..."
    }
    if (f) {
        e = goog.string.htmlEscape(e)
    }
    return e
};
goog.string.truncateMiddle = function (g, f, j) {
    if (j) {
        g = goog.string.unescapeEntities(g)
    }
    if (g.length > f) {
        var i = Math.floor(f / 2),
            h = g.length - i;
        i += f % 2;
        g = g.substring(0, i) + "..." + g.substring(h)
    }
    if (j) {
        g = goog.string.htmlEscape(g)
    }
    return g
};
goog.string.specialEscapeChars_ = {
    "\u0000": "\\0",
    "\u0008": "\\b",
    "\u000c": "\\f",
    "\n": "\\n",
    "\r": "\\r",
    "\t": "\\t",
    "\u000b": "\\x0B",
    '"': '\\"',
    "\\": "\\\\"
};
goog.string.jsEscapeCache_ = {
    "'": "\\'"
};
goog.string.quote = function (g) {
    g = String(g);
    if (g.quote) {
        return g.quote()
    } else {
        for (var f = ['"'], j = 0; j < g.length; j++) {
            var i = g.charAt(j),
                h = i.charCodeAt(0);
            f[j + 1] = goog.string.specialEscapeChars_[i] || (h > 31 && h < 127 ? i : goog.string.escapeChar(i))
        }
        f.push('"');
        return f.join("")
    }
};
goog.string.escapeString = function (e) {
    for (var d = [], f = 0; f < e.length; f++) {
        d[f] = goog.string.escapeChar(e.charAt(f))
    }
    return d.join("")
};
goog.string.escapeChar = function (e) {
    if (e in goog.string.jsEscapeCache_) {
        return goog.string.jsEscapeCache_[e]
    }
    if (e in goog.string.specialEscapeChars_) {
        return goog.string.jsEscapeCache_[e] = goog.string.specialEscapeChars_[e]
    }
    var d = e,
        f = e.charCodeAt(0);
    if (f > 31 && f < 127) {
        d = e
    } else {
        if (f < 256) {
            d = "\\x";
            if (f < 16 || f > 256) {
                d += "0"
            }
        } else {
            d = "\\u";
            if (f < 4096) {
                d += "0"
            }
        }
        d += f.toString(16).toUpperCase()
    }
    return goog.string.jsEscapeCache_[e] = d
};
goog.string.toMap = function (e) {
    for (var d = {}, f = 0; f < e.length; f++) {
        d[e.charAt(f)] = true
    }
    return d
};
goog.string.contains = function (d, c) {
    return d.indexOf(c) != -1
};
goog.string.removeAt = function (f, e, h) {
    var g = f;
    if (e >= 0 && e < f.length && h > 0) {
        g = f.substr(0, e) + f.substr(e + h, f.length - e - h)
    }
    return g
};
goog.string.remove = function (e, d) {
    var f = RegExp(goog.string.regExpEscape(d), "");
    return e.replace(f, "")
};
goog.string.removeAll = function (e, d) {
    var f = RegExp(goog.string.regExpEscape(d), "g");
    return e.replace(f, "")
};
goog.string.regExpEscape = function (b) {
    return String(b).replace(/([-()\[\]{}+?*.$\^|,:#<!\\])/g, "\\$1").replace(/\x08/g, "\\x08")
};
goog.string.repeat = function (d, c) {
    return Array(c + 1).join(d)
};
goog.string.padNumber = function (e, d, f) {
    e = goog.isDef(f) ? e.toFixed(f) : String(e);
    f = e.indexOf(".");
    if (f == -1) {
        f = e.length
    }
    return goog.string.repeat("0", Math.max(0, d - f)) + e
};
goog.string.makeSafe = function (b) {
    return b == null ? "" : String(b)
};
goog.string.buildString = function () {
    return Array.prototype.join.call(arguments, "")
};
goog.string.getRandomString = function () {
    return Math.floor(Math.random() * 2147483648).toString(36) + Math.abs(Math.floor(Math.random() * 2147483648) ^ goog.now()).toString(36)
};
goog.string.compareVersions = function (B, A) {
    for (var z = 0, y = goog.string.trim(String(B)).split("."), x = goog.string.trim(String(A)).split("."), w = Math.max(y.length, x.length), v = 0; z == 0 && v < w; v++) {
        var u = y[v] || "",
            t = x[v] || "",
            s = RegExp("(\\d*)(\\D*)", "g"),
            q = RegExp("(\\d*)(\\D*)", "g");
        do {
            var r = s.exec(u) || ["", "", ""],
                p = q.exec(t) || ["", "", ""];
            if (r[0].length == 0 && p[0].length == 0) {
                break
            }
            z = r[1].length == 0 ? 0 : parseInt(r[1], 10);
            var o = p[1].length == 0 ? 0 : parseInt(p[1], 10);
            z = goog.string.compareElements_(z, o) || goog.string.compareElements_(r[2].length == 0, p[2].length == 0) || goog.string.compareElements_(r[2], p[2])
        } while (z == 0)
    }
    return z
};
goog.string.compareElements_ = function (d, c) {
    if (d < c) {
        return -1
    } else {
        if (d > c) {
            return 1
        }
    }
    return 0
};
goog.string.HASHCODE_MAX_ = 4294967296;
goog.string.hashCode = function (e) {
    for (var d = 0, f = 0; f < e.length; ++f) {
        d = 31 * d + e.charCodeAt(f);
        d %= goog.string.HASHCODE_MAX_
    }
    return d
};
goog.string.uniqueStringCounter_ = Math.random() * 2147483648 | 0;
goog.string.createUniqueString = function () {
    return "goog_" + goog.string.uniqueStringCounter_++
};
goog.string.toNumber = function (d) {
    var c = Number(d);
    if (c == 0 && goog.string.isEmpty(d)) {
        return NaN
    }
    return c
};
goog.string.toCamelCaseCache_ = {};
goog.string.toCamelCase = function (b) {
    return goog.string.toCamelCaseCache_[b] || (goog.string.toCamelCaseCache_[b] = String(b).replace(/\-([a-z])/g, function (a, d) {
        return d.toUpperCase()
    }))
};
goog.string.toSelectorCaseCache_ = {};
goog.string.toSelectorCase = function (b) {
    return goog.string.toSelectorCaseCache_[b] || (goog.string.toSelectorCaseCache_[b] = String(b).replace(/([A-Z])/g, "-$1").toLowerCase())
};
goog.asserts = {};
goog.asserts.ENABLE_ASSERTS = goog.DEBUG;
goog.asserts.AssertionError = function (d, c) {
    c.unshift(d);
    goog.debug.Error.call(this, goog.string.subs.apply(null, c));
    c.shift();
    this.messagePattern = d
};
goog.inherits(goog.asserts.AssertionError, goog.debug.Error);
goog.asserts.AssertionError.prototype.name = "AssertionError";
goog.asserts.doAssertFailure_ = function (h, g, l, k) {
    var j = "Assertion failed";
    if (l) {
        j += ": " + l;
        var i = k
    } else {
        if (h) {
            j += ": " + h;
            i = g
        }
    }
    throw new goog.asserts.AssertionError("" + j, i || [])
};
goog.asserts.assert = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !d && goog.asserts.doAssertFailure_("", null, c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.fail = function (b) {
    if (goog.asserts.ENABLE_ASSERTS) {
        throw new goog.asserts.AssertionError("Failure" + (b ? ": " + b : ""), Array.prototype.slice.call(arguments, 1))
    }
};
goog.asserts.assertNumber = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !goog.isNumber(d) && goog.asserts.doAssertFailure_("Expected number but got %s: %s.", [goog.typeOf(d), d], c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.assertString = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !goog.isString(d) && goog.asserts.doAssertFailure_("Expected string but got %s: %s.", [goog.typeOf(d), d], c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.assertFunction = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !goog.isFunction(d) && goog.asserts.doAssertFailure_("Expected function but got %s: %s.", [goog.typeOf(d), d], c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.assertObject = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !goog.isObject(d) && goog.asserts.doAssertFailure_("Expected object but got %s: %s.", [goog.typeOf(d), d], c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.assertArray = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !goog.isArray(d) && goog.asserts.doAssertFailure_("Expected array but got %s: %s.", [goog.typeOf(d), d], c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.assertBoolean = function (d, c) {
    goog.asserts.ENABLE_ASSERTS && !goog.isBoolean(d) && goog.asserts.doAssertFailure_("Expected boolean but got %s: %s.", [goog.typeOf(d), d], c, Array.prototype.slice.call(arguments, 2));
    return d
};
goog.asserts.assertInstanceof = function (e, d, f) {
    goog.asserts.ENABLE_ASSERTS && !(e instanceof d) && goog.asserts.doAssertFailure_("instanceof check failed.", null, f, Array.prototype.slice.call(arguments, 3))
};
goog.array = {};
goog.array.ArrayLike = {};
goog.array.peek = function (b) {
    return b[b.length - 1]
};
goog.array.ARRAY_PROTOTYPE_ = Array.prototype;
goog.array.indexOf = goog.array.ARRAY_PROTOTYPE_.indexOf ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return goog.array.ARRAY_PROTOTYPE_.indexOf.call(e, d, f)
} : function (e, d, f) {
    f = f == null ? 0 : f < 0 ? Math.max(0, e.length + f) : f;
    if (goog.isString(e)) {
        if (!goog.isString(d) || d.length != 1) {
            return -1
        }
        return e.indexOf(d, f)
    }
    for (; f < e.length; f++) {
        if (f in e && e[f] === d) {
            return f
        }
    }
    return -1
};
goog.array.lastIndexOf = goog.array.ARRAY_PROTOTYPE_.lastIndexOf ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return goog.array.ARRAY_PROTOTYPE_.lastIndexOf.call(e, d, f == null ? e.length - 1 : f)
} : function (e, d, f) {
    f = f == null ? e.length - 1 : f;
    if (f < 0) {
        f = Math.max(0, e.length + f)
    }
    if (goog.isString(e)) {
        if (!goog.isString(d) || d.length != 1) {
            return -1
        }
        return e.lastIndexOf(d, f)
    }
    for (; f >= 0; f--) {
        if (f in e && e[f] === d) {
            return f
        }
    }
    return -1
};
goog.array.forEach = goog.array.ARRAY_PROTOTYPE_.forEach ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    goog.array.ARRAY_PROTOTYPE_.forEach.call(e, d, f)
} : function (h, g, l) {
    for (var k = h.length, j = goog.isString(h) ? h.split("") : h, i = 0; i < k; i++) {
        i in j && g.call(l, j[i], i, h)
    }
};
goog.array.forEachRight = function (g, f, j) {
    var i = g.length,
        h = goog.isString(g) ? g.split("") : g;
    for (i -= 1; i >= 0; --i) {
        i in h && f.call(j, h[i], i, g)
    }
};
goog.array.filter = goog.array.ARRAY_PROTOTYPE_.filter ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return goog.array.ARRAY_PROTOTYPE_.filter.call(e, d, f)
} : function (r, q, p) {
    for (var o = r.length, n = [], m = 0, l = goog.isString(r) ? r.split("") : r, k = 0; k < o; k++) {
        if (k in l) {
            var j = l[k];
            if (q.call(p, j, k, r)) {
                n[m++] = j
            }
        }
    }
    return n
};
goog.array.map = goog.array.ARRAY_PROTOTYPE_.map ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return goog.array.ARRAY_PROTOTYPE_.map.call(e, d, f)
} : function (i, h, n) {
    for (var m = i.length, l = Array(m), k = goog.isString(i) ? i.split("") : i, j = 0; j < m; j++) {
        if (j in k) {
            l[j] = h.call(n, k[j], j, i)
        }
    }
    return l
};
goog.array.reduce = function (g, f, j, i) {
    if (g.reduce) {
        return i ? g.reduce(goog.bind(f, i), j) : g.reduce(f, j)
    }
    var h = j;
    goog.array.forEach(g, function (b, a) {
        h = f.call(i, h, b, a, g)
    });
    return h
};
goog.array.reduceRight = function (g, f, j, i) {
    if (g.reduceRight) {
        return i ? g.reduceRight(goog.bind(f, i), j) : g.reduceRight(f, j)
    }
    var h = j;
    goog.array.forEachRight(g, function (b, a) {
        h = f.call(i, h, b, a, g)
    });
    return h
};
goog.array.some = goog.array.ARRAY_PROTOTYPE_.some ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return goog.array.ARRAY_PROTOTYPE_.some.call(e, d, f)
} : function (h, g, l) {
    for (var k = h.length, j = goog.isString(h) ? h.split("") : h, i = 0; i < k; i++) {
        if (i in j && g.call(l, j[i], i, h)) {
            return true
        }
    }
    return false
};
goog.array.every = goog.array.ARRAY_PROTOTYPE_.every ?
function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return goog.array.ARRAY_PROTOTYPE_.every.call(e, d, f)
} : function (h, g, l) {
    for (var k = h.length, j = goog.isString(h) ? h.split("") : h, i = 0; i < k; i++) {
        if (i in j && !g.call(l, j[i], i, h)) {
            return false
        }
    }
    return true
};
goog.array.find = function (e, d, f) {
    d = goog.array.findIndex(e, d, f);
    return d < 0 ? null : goog.isString(e) ? e.charAt(d) : e[d]
};
goog.array.findIndex = function (h, g, l) {
    for (var k = h.length, j = goog.isString(h) ? h.split("") : h, i = 0; i < k; i++) {
        if (i in j && g.call(l, j[i], i, h)) {
            return i
        }
    }
    return -1
};
goog.array.findRight = function (e, d, f) {
    d = goog.array.findIndexRight(e, d, f);
    return d < 0 ? null : goog.isString(e) ? e.charAt(d) : e[d]
};
goog.array.findIndexRight = function (g, f, j) {
    var i = g.length,
        h = goog.isString(g) ? g.split("") : g;
    for (i -= 1; i >= 0; i--) {
        if (i in h && f.call(j, h[i], i, g)) {
            return i
        }
    }
    return -1
};
goog.array.contains = function (d, c) {
    return goog.array.indexOf(d, c) >= 0
};
goog.array.isEmpty = function (b) {
    return b.length == 0
};
goog.array.clear = function (d) {
    if (!goog.isArray(d)) {
        for (var c = d.length - 1; c >= 0; c--) {
            delete d[c]
        }
    }
    d.length = 0
};
goog.array.insert = function (d, c) {
    goog.array.contains(d, c) || d.push(c)
};
goog.array.insertAt = function (e, d, f) {
    goog.array.splice(e, f, 0, d)
};
goog.array.insertArrayAt = function (e, d, f) {
    goog.partial(goog.array.splice, e, f, 0).apply(null, d)
};
goog.array.insertBefore = function (f, e, h) {
    var g;
    arguments.length == 2 || (g = goog.array.indexOf(f, h)) < 0 ? f.push(e) : goog.array.insertAt(f, e, g)
};
goog.array.remove = function (f, e) {
    var h = goog.array.indexOf(f, e),
        g;
    if (g = h >= 0) {
        goog.array.removeAt(f, h)
    }
    return g
};
goog.array.removeAt = function (d, c) {
    goog.asserts.assert(d.length != null);
    return goog.array.ARRAY_PROTOTYPE_.splice.call(d, c, 1).length == 1
};
goog.array.removeIf = function (e, d, f) {
    d = goog.array.findIndex(e, d, f);
    if (d >= 0) {
        goog.array.removeAt(e, d);
        return true
    }
    return false
};
goog.array.concat = function () {
    return goog.array.ARRAY_PROTOTYPE_.concat.apply(goog.array.ARRAY_PROTOTYPE_, arguments)
};
goog.array.clone = function (f) {
    if (goog.isArray(f)) {
        return goog.array.concat(f)
    } else {
        for (var e = [], h = 0, g = f.length; h < g; h++) {
            e[h] = f[h]
        }
        return e
    }
};
goog.array.toArray = function (b) {
    if (goog.isArray(b)) {
        return goog.array.concat(b)
    }
    return goog.array.clone(b)
};
goog.array.extend = function (i) {
    for (var h = 1; h < arguments.length; h++) {
        var n = arguments[h],
            m;
        if (goog.isArray(n) || (m = goog.isArrayLike(n)) && n.hasOwnProperty("callee")) {
            i.push.apply(i, n)
        } else {
            if (m) {
                for (var l = i.length, k = n.length, j = 0; j < k; j++) {
                    i[l + j] = n[j]
                }
            } else {
                i.push(n)
            }
        }
    }
};
goog.array.splice = function (b) {
    goog.asserts.assert(b.length != null);
    return goog.array.ARRAY_PROTOTYPE_.splice.apply(b, goog.array.slice(arguments, 1))
};
goog.array.slice = function (e, d, f) {
    goog.asserts.assert(e.length != null);
    return arguments.length <= 2 ? goog.array.ARRAY_PROTOTYPE_.slice.call(e, d) : goog.array.ARRAY_PROTOTYPE_.slice.call(e, d, f)
};
goog.array.removeDuplicates = function (j, i) {
    for (var p = i || j, o = {}, n = 0, m = 0; m < j.length;) {
        var l = j[m++],
            k = goog.isObject(l) ? "o" + goog.getUid(l) : (typeof l).charAt(0) + l;
        if (!Object.prototype.hasOwnProperty.call(o, k)) {
            o[k] = true;
            p[n++] = l
        }
    }
    p.length = n
};
goog.array.binarySearch = function (e, d, f) {
    return goog.array.binarySearch_(e, f || goog.array.defaultCompare, false, d)
};
goog.array.binarySelect = function (e, d, f) {
    return goog.array.binarySearch_(e, d, true, undefined, f)
};
goog.array.binarySearch_ = function (t, s, r, q, p) {
    for (var o = 0, n = t.length, m; o < n;) {
        var l = o + n >> 1,
            k;
        k = r ? s.call(p, t[l], l, t) : s(q, t[l]);
        if (k > 0) {
            o = l + 1
        } else {
            n = l;
            m = !k
        }
    }
    return m ? o : ~o
};
goog.array.sort = function (d, c) {
    goog.asserts.assert(d.length != null);
    goog.array.ARRAY_PROTOTYPE_.sort.call(d, c || goog.array.defaultCompare)
};
goog.array.stableSort = function (f, e) {
    for (var h = 0; h < f.length; h++) {
        f[h] = {
            index: h,
            value: f[h]
        }
    }
    var g = e || goog.array.defaultCompare;
    goog.array.sort(f, function (b, a) {
        return g(b.value, a.value) || b.index - a.index
    });
    for (h = 0; h < f.length; h++) {
        f[h] = f[h].value
    }
};
goog.array.sortObjectsByKey = function (f, e, h) {
    var g = h || goog.array.defaultCompare;
    goog.array.sort(f, function (b, a) {
        return g(b[e], a[e])
    })
};
goog.array.isSorted = function (g, f, j) {
    f = f || goog.array.defaultCompare;
    for (var i = 1; i < g.length; i++) {
        var h = f(g[i - 1], g[i]);
        if (h > 0 || h == 0 && j) {
            return false
        }
    }
    return true
};
goog.array.equals = function (g, f, j) {
    if (!goog.isArrayLike(g) || !goog.isArrayLike(f) || g.length != f.length) {
        return false
    }
    var i = g.length;
    j = j || goog.array.defaultCompareEquality;
    for (var h = 0; h < i; h++) {
        if (!j(g[h], f[h])) {
            return false
        }
    }
    return true
};
goog.array.compare = function (e, d, f) {
    return goog.array.equals(e, d, f)
};
goog.array.defaultCompare = function (d, c) {
    return d > c ? 1 : d < c ? -1 : 0
};
goog.array.defaultCompareEquality = function (d, c) {
    return d === c
};
goog.array.binaryInsert = function (e, d, f) {
    f = goog.array.binarySearch(e, d, f);
    if (f < 0) {
        goog.array.insertAt(e, d, -(f + 1));
        return true
    }
    return false
};
goog.array.binaryRemove = function (e, d, f) {
    d = goog.array.binarySearch(e, d, f);
    return d >= 0 ? goog.array.removeAt(e, d) : false
};
goog.array.bucket = function (h, g) {
    for (var l = {}, k = 0; k < h.length; k++) {
        var j = h[k],
            i = g(j, k, h);
        if (goog.isDef(i)) {
            (l[i] || (l[i] = [])).push(j)
        }
    }
    return l
};
goog.array.repeat = function (f, e) {
    for (var h = [], g = 0; g < e; g++) {
        h[g] = f
    }
    return h
};
goog.array.flatten = function () {
    for (var e = [], d = 0; d < arguments.length; d++) {
        var f = arguments[d];
        goog.isArray(f) ? e.push.apply(e, goog.array.flatten.apply(null, f)) : e.push(f)
    }
    return e
};
goog.array.rotate = function (d, c) {
    goog.asserts.assert(d.length != null);
    if (d.length) {
        c %= d.length;
        if (c > 0) {
            goog.array.ARRAY_PROTOTYPE_.unshift.apply(d, d.splice(-c, c))
        } else {
            c < 0 && goog.array.ARRAY_PROTOTYPE_.push.apply(d, d.splice(0, -c))
        }
    }
    return d
};
goog.array.zip = function () {
    if (!arguments.length) {
        return []
    }
    for (var g = [], f = 0;; f++) {
        for (var j = [], i = 0; i < arguments.length; i++) {
            var h = arguments[i];
            if (f >= h.length) {
                return g
            }
            j.push(h[f])
        }
        g.push(j)
    }
};
goog.array.shuffle = function (h, g) {
    for (var l = g || Math.random, k = h.length - 1; k > 0; k--) {
        var j = Math.floor(l() * (k + 1)),
            i = h[k];
        h[k] = h[j];
        h[j] = i
    }
};
goog.object = {};
goog.object.forEach = function (f, e, h) {
    for (var g in f) {
        e.call(h, f[g], g, f)
    }
};
goog.object.filter = function (g, f, j) {
    var i = {},
        h;
    for (h in g) {
        if (f.call(j, g[h], h, g)) {
            i[h] = g[h]
        }
    }
    return i
};
goog.object.map = function (g, f, j) {
    var i = {},
        h;
    for (h in g) {
        i[h] = f.call(j, g[h], h, g)
    }
    return i
};
goog.object.some = function (f, e, h) {
    for (var g in f) {
        if (e.call(h, f[g], g, f)) {
            return true
        }
    }
    return false
};
goog.object.every = function (f, e, h) {
    for (var g in f) {
        if (!e.call(h, f[g], g, f)) {
            return false
        }
    }
    return true
};
goog.object.getCount = function (e) {
    var d = 0,
        f;
    for (f in e) {
        d++
    }
    return d
};
goog.object.getAnyKey = function (d) {
    for (var c in d) {
        return c
    }
};
goog.object.getAnyValue = function (d) {
    for (var c in d) {
        return d[c]
    }
};
goog.object.contains = function (d, c) {
    return goog.object.containsValue(d, c)
};
goog.object.getValues = function (f) {
    var e = [],
        h = 0,
        g;
    for (g in f) {
        e[h++] = f[g]
    }
    return e
};
goog.object.getKeys = function (f) {
    var e = [],
        h = 0,
        g;
    for (g in f) {
        e[h++] = g
    }
    return e
};
goog.object.getValueByKeys = function (f, e) {
    var h = goog.isArrayLike(e),
        g = h ? e : arguments;
    for (h = h ? 0 : 1; h < g.length; h++) {
        f = f[g[h]];
        if (!goog.isDef(f)) {
            break
        }
    }
    return f
};
goog.object.containsKey = function (d, c) {
    return c in d
};
goog.object.containsValue = function (e, d) {
    for (var f in e) {
        if (e[f] == d) {
            return true
        }
    }
    return false
};
goog.object.findKey = function (f, e, h) {
    for (var g in f) {
        if (e.call(h, f[g], g, f)) {
            return g
        }
    }
};
goog.object.findValue = function (e, d, f) {
    return (d = goog.object.findKey(e, d, f)) && e[d]
};
goog.object.isEmpty = function (d) {
    for (var c in d) {
        return false
    }
    return true
};
goog.object.clear = function (d) {
    for (var c in d) {
        delete d[c]
    }
};
goog.object.remove = function (e, d) {
    var f;
    if (f = d in e) {
        delete e[d]
    }
    return f
};
goog.object.add = function (e, d, f) {
    if (d in e) {
        throw Error('The object already contains the key "' + d + '"')
    }
    goog.object.set(e, d, f)
};
goog.object.get = function (e, d, f) {
    if (d in e) {
        return e[d]
    }
    return f
};
goog.object.set = function (e, d, f) {
    e[d] = f
};
goog.object.setIfUndefined = function (e, d, f) {
    return d in e ? e[d] : e[d] = f
};
goog.object.clone = function (e) {
    var d = {},
        f;
    for (f in e) {
        d[f] = e[f]
    }
    return d
};
goog.object.transpose = function (e) {
    var d = {},
        f;
    for (f in e) {
        d[e[f]] = f
    }
    return d
};
goog.object.PROTOTYPE_FIELDS_ = ["constructor", "hasOwnProperty", "isPrototypeOf", "propertyIsEnumerable", "toLocaleString", "toString", "valueOf"];
goog.object.extend = function (g) {
    for (var f, j, i = 1; i < arguments.length; i++) {
        j = arguments[i];
        for (f in j) {
            g[f] = j[f]
        }
        for (var h = 0; h < goog.object.PROTOTYPE_FIELDS_.length; h++) {
            f = goog.object.PROTOTYPE_FIELDS_[h];
            if (Object.prototype.hasOwnProperty.call(j, f)) {
                g[f] = j[f]
            }
        }
    }
};
goog.object.create = function () {
    var e = arguments.length;
    if (e == 1 && goog.isArray(arguments[0])) {
        return goog.object.create.apply(null, arguments[0])
    }
    if (e % 2) {
        throw Error("Uneven number of arguments")
    }
    for (var d = {}, f = 0; f < e; f += 2) {
        d[arguments[f]] = arguments[f + 1]
    }
    return d
};
goog.object.createSet = function () {
    var e = arguments.length;
    if (e == 1 && goog.isArray(arguments[0])) {
        return goog.object.createSet.apply(null, arguments[0])
    }
    for (var d = {}, f = 0; f < e; f++) {
        d[arguments[f]] = true
    }
    return d
};
goog.proto2 = {};
goog.proto2.Util = {};
goog.proto2.Util.PBCHECK = !COMPILED;
goog.proto2.Util.assert = function (d, c) {
    goog.proto2.Util.PBCHECK && goog.asserts.assert(d, c)
};
goog.proto2.Util.conductChecks = function () {
    return goog.proto2.Util.PBCHECK
};
goog.proto2.Metadata = goog.typedef;
goog.proto2.Descriptor = function (e, d, f) {
    this.messageType_ = e;
    this.name_ = d.name || null;
    this.fullName_ = d.fullName || null;
    this.containingType_ = d.containingType;
    this.fields_ = {};
    for (e = 0; e < f.length; e++) {
        d = f[e];
        this.fields_[d.getTag()] = d
    }
};
goog.proto2.Descriptor.prototype.getName = function () {
    return this.name_
};
goog.proto2.Descriptor.prototype.getFullName = function () {
    return this.fullName_
};
goog.proto2.Descriptor.prototype.getContainingType = function () {
    if (!this.containingType_) {
        return null
    }
    return this.containingType_.getDescriptor()
};
goog.proto2.Descriptor.prototype.getFields = function () {
    var b = goog.object.getValues(this.fields_);
    goog.array.sort(b, function (a, d) {
        return a.getTag() - d.getTag()
    });
    return b
};
goog.proto2.Descriptor.prototype.getFieldsMap = function () {
    return goog.object.clone(this.fields_)
};
goog.proto2.Descriptor.prototype.findFieldByName = function (b) {
    return goog.object.findValue(this.fields_, function (a) {
        return a.getName() == b
    }) || null
};
goog.proto2.Descriptor.prototype.findFieldByTag = function (b) {
    goog.proto2.Util.assert(goog.string.isNumeric(b));
    return this.fields_[parseInt(b, 10)] || null
};
goog.proto2.Descriptor.prototype.createMessageInstance = function () {
    return new this.messageType_
};
goog.proto2.FieldDescriptor = function (e, d, f) {
    this.parent_ = e;
    goog.proto2.Util.assert(goog.string.isNumeric(d));
    this.tag_ = d;
    this.name_ = f.name;
    this.isRepeated_ = !! f.repeated;
    this.isRequired_ = !! f.required;
    this.fieldType_ = f.fieldType;
    this.nativeType_ = f.type;
    this.deserializationConversionPermitted_ = false;
    switch (this.fieldType_) {
    case goog.proto2.FieldDescriptor.FieldType.INT64:
    case goog.proto2.FieldDescriptor.FieldType.UINT64:
    case goog.proto2.FieldDescriptor.FieldType.FIXED64:
    case goog.proto2.FieldDescriptor.FieldType.SFIXED64:
    case goog.proto2.FieldDescriptor.FieldType.SINT64:
        this.deserializationConversionPermitted_ = true
    }
    this.defaultValue_ = f.defaultValue
};
goog.proto2.FieldDescriptor.FieldType = {
    DOUBLE: 1,
    FLOAT: 2,
    INT64: 3,
    UINT64: 4,
    INT32: 5,
    FIXED64: 6,
    FIXED32: 7,
    BOOL: 8,
    STRING: 9,
    GROUP: 10,
    MESSAGE: 11,
    BYTES: 12,
    UINT32: 13,
    ENUM: 14,
    SFIXED32: 15,
    SFIXED64: 16,
    SINT32: 17,
    SINT64: 18
};
goog.proto2.FieldDescriptor.prototype.getTag = function () {
    return this.tag_
};
goog.proto2.FieldDescriptor.prototype.getContainingType = function () {
    return this.parent_.descriptor_
};
goog.proto2.FieldDescriptor.prototype.getName = function () {
    return this.name_
};
goog.proto2.FieldDescriptor.prototype.getDefaultValue = function () {
    if (this.defaultValue_ === undefined) {
        var b = this.nativeType_;
        this.defaultValue_ = b === Boolean ? false : b === Number ? 0 : b === String ? "" : new b
    }
    return this.defaultValue_
};
goog.proto2.FieldDescriptor.prototype.getFieldType = function () {
    return this.fieldType_
};
goog.proto2.FieldDescriptor.prototype.getNativeType = function () {
    return this.nativeType_
};
goog.proto2.FieldDescriptor.prototype.deserializationConversionPermitted = function () {
    return this.deserializationConversionPermitted_
};
goog.proto2.FieldDescriptor.prototype.getFieldMessageType = function () {
    goog.proto2.Util.assert(this.isCompositeType(), "Expected message or group");
    return this.nativeType_.descriptor_
};
goog.proto2.FieldDescriptor.prototype.isCompositeType = function () {
    return this.fieldType_ == goog.proto2.FieldDescriptor.FieldType.MESSAGE || this.fieldType_ == goog.proto2.FieldDescriptor.FieldType.GROUP
};
goog.proto2.FieldDescriptor.prototype.isRepeated = function () {
    return this.isRepeated_
};
goog.proto2.FieldDescriptor.prototype.isRequired = function () {
    return this.isRequired_
};
goog.proto2.FieldDescriptor.prototype.isOptional = function () {
    return !this.isRepeated_ && !this.isRequired_
};
goog.proto2.Message = function () {
    this.values_ = {};
    this.descriptor_ = this.constructor.descriptor_;
    this.fields_ = this.descriptor_.getFieldsMap();
    this.deserializedFields_ = this.lazyDeserializer_ = null
};
goog.proto2.Message.FieldType = {
    DOUBLE: 1,
    FLOAT: 2,
    INT64: 3,
    UINT64: 4,
    INT32: 5,
    FIXED64: 6,
    FIXED32: 7,
    BOOL: 8,
    STRING: 9,
    GROUP: 10,
    MESSAGE: 11,
    BYTES: 12,
    UINT32: 13,
    ENUM: 14,
    SFIXED32: 15,
    SFIXED64: 16,
    SINT32: 17,
    SINT64: 18
};
goog.proto2.Message.prototype.initializeForLazyDeserializer = function (d, c) {
    this.lazyDeserializer_ = d;
    this.values_ = c;
    this.deserializedFields_ = {}
};
goog.proto2.Message.prototype.setUnknown = function (d, c) {
    goog.proto2.Util.assert(!this.fields_[d], "Field is not unknown in this message");
    goog.proto2.Util.assert(d >= 1, "Tag is not valid");
    goog.proto2.Util.assert(c !== null, "Value cannot be null");
    this.values_[d] = c
};
goog.proto2.Message.prototype.forEachUnknown = function (d) {
    for (var c in this.values_) {
        this.fields_[c] || d(c, this.values_[c])
    }
};
goog.proto2.Message.prototype.getDescriptor = function () {
    return this.descriptor_
};
goog.proto2.Message.prototype.has = function (b) {
    goog.proto2.Util.assert(b.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    return this.has$Value(b.getTag())
};
goog.proto2.Message.prototype.arrayOf = function (b) {
    goog.proto2.Util.assert(b.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    return this.array$Values(b.getTag())
};
goog.proto2.Message.prototype.countOf = function (b) {
    goog.proto2.Util.assert(b.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    return this.count$Values(b.getTag())
};
goog.proto2.Message.prototype.get = function (d, c) {
    goog.proto2.Util.assert(d.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    return this.get$Value(d.getTag(), c)
};
goog.proto2.Message.prototype.getOrDefault = function (d, c) {
    goog.proto2.Util.assert(d.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    return this.get$ValueOrDefault(d.getTag(), c)
};
goog.proto2.Message.prototype.set = function (d, c) {
    goog.proto2.Util.assert(d.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    this.set$Value(d.getTag(), c)
};
goog.proto2.Message.prototype.add = function (d, c) {
    goog.proto2.Util.assert(d.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    this.add$Value(d.getTag(), c)
};
goog.proto2.Message.prototype.clear = function (b) {
    goog.proto2.Util.assert(b.getContainingType() == this.descriptor_, "The current message does not contain the given field");
    this.clear$Field(b.getTag())
};
goog.proto2.Message.prototype.equals = function (i) {
    if (!i || this.constructor != i.constructor) {
        return false
    }
    for (var h = this.getDescriptor().getFields(), n = 0; n < h.length; n++) {
        var m = h[n];
        if (this.has(m) != i.has(m)) {
            return false
        }
        if (this.has(m)) {
            var l = m.isCompositeType(),
                k = m.getTag(),
                j = this.values_[k];
            k = i.values_[k];
            if (m.isRepeated()) {
                if (j.length != k.length) {
                    return false
                }
                for (m = 0; m < j.length; m++) {
                    if (!(l ? j[m].equals(k[m]) : j[m] == k[m])) {
                        return false
                    }
                }
            } else {
                if (!(l ? j.equals(k) : j == k)) {
                    return false
                }
            }
        }
    }
    return true
};
goog.proto2.Message.prototype.copyFrom = function (i) {
    goog.proto2.Util.assert(this.constructor == i.constructor, "The source message must have the same type.");
    for (var h = this.getDescriptor().getFields(), n = 0; n < h.length; n++) {
        var m = h[n];
        delete this.values_[m.getTag()];
        if (i.has(m)) {
            var l = m.isCompositeType();
            if (m.isRepeated()) {
                for (var k = i.arrayOf(m), j = 0; j < k.length; j++) {
                    this.add(m, l ? k[j].clone() : k[j])
                }
            } else {
                k = i.get(m);
                this.set(m, l ? k.clone() : k)
            }
        }
    }
};
goog.proto2.Message.prototype.clone = function () {
    var b = new this.constructor;
    b.copyFrom(this);
    return b
};
goog.proto2.Message.prototype.initDefaults = function (h) {
    for (var g = this.getDescriptor().getFields(), l = 0; l < g.length; l++) {
        var k = g[l],
            j = k.getTag(),
            i = k.isCompositeType();
        if (!this.has(k) && !k.isRepeated()) {
            if (i) {
                this.values_[j] = new(k.getNativeType())
            } else {
                if (h) {
                    this.values_[j] = k.getDefaultValue()
                }
            }
        }
        if (i) {
            if (k.isRepeated()) {
                k = this.array$Values(j);
                for (j = 0; j < k.length; j++) {
                    k[j].initDefaults(h)
                }
            } else {
                this.get$Value(j).initDefaults(h)
            }
        }
    }
};
goog.proto2.Message.prototype.getFieldByTag_ = function (b) {
    goog.proto2.Util.assert(this.fields_[b], "No field found for the given tag");
    return this.fields_[b]
};
goog.proto2.Message.prototype.has$Value = function (b) {
    goog.proto2.Util.assert(this.fields_[b], "No field found for the given tag");
    return b in this.values_ && goog.isDef(this.values_[b])
};
goog.proto2.Message.prototype.lazyDeserialize_ = function (d) {
    if (this.lazyDeserializer_) {
        var c = d.getTag();
        if (!(c in this.deserializedFields_)) {
            this.values_[c] = this.lazyDeserializer_.deserializeField(this, d, this.values_[c]);
            this.deserializedFields_[c] = true
        }
    }
};
goog.proto2.Message.prototype.get$Value = function (e, d) {
    var f = this.getFieldByTag_(e);
    this.lazyDeserialize_(f);
    if (f.isRepeated()) {
        f = d || 0;
        goog.proto2.Util.assert(f < this.count$Values(e), "Field value count is less than index given");
        return this.values_[e][f]
    } else {
        goog.proto2.Util.assert(!goog.isArray(this.values_[e]));
        return this.values_[e]
    }
};
goog.proto2.Message.prototype.get$ValueOrDefault = function (d, c) {
    if (!this.has$Value(d)) {
        return this.getFieldByTag_(d).getDefaultValue()
    }
    return this.get$Value(d, c)
};
goog.proto2.Message.prototype.array$Values = function (b) {
    goog.proto2.Util.assert(this.getFieldByTag_(b).isRepeated(), "Cannot call fieldArray on a non-repeated field");
    this.lazyDeserialize_(this.getFieldByTag_(b));
    return this.values_[b] || []
};
goog.proto2.Message.prototype.count$Values = function (b) {
    if (this.getFieldByTag_(b).isRepeated()) {
        this.has$Value(b) && goog.proto2.Util.assert(goog.isArray(this.values_[b]));
        return this.has$Value(b) ? this.values_[b].length : 0
    } else {
        return this.has$Value(b) ? 1 : 0
    }
};
goog.proto2.Message.prototype.set$Value = function (e, d) {
    if (goog.proto2.Util.conductChecks()) {
        var f = this.getFieldByTag_(e);
        goog.proto2.Util.assert(!f.isRepeated(), "Cannot call set on a repeated field");
        this.checkFieldType_(f, d)
    }
    this.values_[e] = d
};
goog.proto2.Message.prototype.add$Value = function (e, d) {
    if (goog.proto2.Util.conductChecks()) {
        var f = this.getFieldByTag_(e);
        goog.proto2.Util.assert(f.isRepeated(), "Cannot call add on a non-repeated field");
        this.checkFieldType_(f, d)
    }
    this.values_[e] || (this.values_[e] = []);
    this.values_[e].push(d)
};
goog.proto2.Message.prototype.checkFieldType_ = function (e, d) {
    goog.proto2.Util.assert(d !== null);
    var f = e.getNativeType();
    if (f === String) {
        goog.proto2.Util.assert(typeof d === "string", "Expected value of type string")
    } else {
        if (f === Boolean) {
            goog.proto2.Util.assert(typeof d === "boolean", "Expected value of type boolean")
        } else {
            if (f === Number) {
                goog.proto2.Util.assert(typeof d === "number", "Expected value of type number")
            } else {
                e.getFieldType() == goog.proto2.FieldDescriptor.FieldType.ENUM ? goog.proto2.Util.assert(typeof d === "number", "Expected an enum value, which is a number") : goog.proto2.Util.assert(d instanceof f, "Expected a matching message type")
            }
        }
    }
};
goog.proto2.Message.prototype.clear$Field = function (b) {
    goog.proto2.Util.assert(this.getFieldByTag_(b), "Unknown field");
    delete this.values_[b]
};
goog.proto2.Message.set$Metadata = function (g, f) {
    var j = [],
        i, h;
    for (h in f) {
        if (f.hasOwnProperty(h)) {
            goog.proto2.Util.assert(goog.string.isNumeric(h), "Keys must be numeric");
            if (h == 0) {
                i = f[0]
            } else {
                j.push(new goog.proto2.FieldDescriptor(g, h, f[h]))
            }
        }
    }
    goog.proto2.Util.assert(i);
    g.descriptor_ = new goog.proto2.Descriptor(g, i, j);
    g.getDescriptor = function () {
        return g.descriptor_
    }
};
var i18n = {};
i18n.phonenumbers = {};
i18n.phonenumbers.NumberFormat = function () {
    goog.proto2.Message.apply(this)
};
goog.inherits(i18n.phonenumbers.NumberFormat, goog.proto2.Message);
i18n.phonenumbers.NumberFormat.prototype.getPattern = function () {
    return this.get$Value(1)
};
i18n.phonenumbers.NumberFormat.prototype.getPatternOrDefault = function () {
    return this.get$ValueOrDefault(1)
};
i18n.phonenumbers.NumberFormat.prototype.setPattern = function (b) {
    this.set$Value(1, b)
};
i18n.phonenumbers.NumberFormat.prototype.hasPattern = function () {
    return this.has$Value(1)
};
i18n.phonenumbers.NumberFormat.prototype.patternCount = function () {
    return this.count$Values(1)
};
i18n.phonenumbers.NumberFormat.prototype.clearPattern = function () {
    this.clear$Field(1)
};
i18n.phonenumbers.NumberFormat.prototype.getFormat = function () {
    return this.get$Value(2)
};
i18n.phonenumbers.NumberFormat.prototype.getFormatOrDefault = function () {
    return this.get$ValueOrDefault(2)
};
i18n.phonenumbers.NumberFormat.prototype.setFormat = function (b) {
    this.set$Value(2, b)
};
i18n.phonenumbers.NumberFormat.prototype.hasFormat = function () {
    return this.has$Value(2)
};
i18n.phonenumbers.NumberFormat.prototype.formatCount = function () {
    return this.count$Values(2)
};
i18n.phonenumbers.NumberFormat.prototype.clearFormat = function () {
    this.clear$Field(2)
};
i18n.phonenumbers.NumberFormat.prototype.getLeadingDigitsPattern = function (b) {
    return this.get$Value(3, b)
};
i18n.phonenumbers.NumberFormat.prototype.getLeadingDigitsPatternOrDefault = function (b) {
    return this.get$ValueOrDefault(3, b)
};
i18n.phonenumbers.NumberFormat.prototype.addLeadingDigitsPattern = function (b) {
    this.add$Value(3, b)
};
i18n.phonenumbers.NumberFormat.prototype.leadingDigitsPatternArray = function () {
    return this.array$Values(3)
};
i18n.phonenumbers.NumberFormat.prototype.hasLeadingDigitsPattern = function () {
    return this.has$Value(3)
};
i18n.phonenumbers.NumberFormat.prototype.leadingDigitsPatternCount = function () {
    return this.count$Values(3)
};
i18n.phonenumbers.NumberFormat.prototype.clearLeadingDigitsPattern = function () {
    this.clear$Field(3)
};
i18n.phonenumbers.NumberFormat.prototype.getNationalPrefixFormattingRule = function () {
    return this.get$Value(4)
};
i18n.phonenumbers.NumberFormat.prototype.getNationalPrefixFormattingRuleOrDefault = function () {
    return this.get$ValueOrDefault(4)
};
i18n.phonenumbers.NumberFormat.prototype.setNationalPrefixFormattingRule = function (b) {
    this.set$Value(4, b)
};
i18n.phonenumbers.NumberFormat.prototype.hasNationalPrefixFormattingRule = function () {
    return this.has$Value(4)
};
i18n.phonenumbers.NumberFormat.prototype.nationalPrefixFormattingRuleCount = function () {
    return this.count$Values(4)
};
i18n.phonenumbers.NumberFormat.prototype.clearNationalPrefixFormattingRule = function () {
    this.clear$Field(4)
};
i18n.phonenumbers.NumberFormat.prototype.getDomesticCarrierCodeFormattingRule = function () {
    return this.get$Value(5)
};
i18n.phonenumbers.NumberFormat.prototype.getDomesticCarrierCodeFormattingRuleOrDefault = function () {
    return this.get$ValueOrDefault(5)
};
i18n.phonenumbers.NumberFormat.prototype.setDomesticCarrierCodeFormattingRule = function (b) {
    this.set$Value(5, b)
};
i18n.phonenumbers.NumberFormat.prototype.hasDomesticCarrierCodeFormattingRule = function () {
    return this.has$Value(5)
};
i18n.phonenumbers.NumberFormat.prototype.domesticCarrierCodeFormattingRuleCount = function () {
    return this.count$Values(5)
};
i18n.phonenumbers.NumberFormat.prototype.clearDomesticCarrierCodeFormattingRule = function () {
    this.clear$Field(5)
};
i18n.phonenumbers.PhoneNumberDesc = function () {
    goog.proto2.Message.apply(this)
};
goog.inherits(i18n.phonenumbers.PhoneNumberDesc, goog.proto2.Message);
i18n.phonenumbers.PhoneNumberDesc.prototype.getNationalNumberPattern = function () {
    return this.get$Value(2)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.getNationalNumberPatternOrDefault = function () {
    return this.get$ValueOrDefault(2)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.setNationalNumberPattern = function (b) {
    this.set$Value(2, b)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.hasNationalNumberPattern = function () {
    return this.has$Value(2)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.nationalNumberPatternCount = function () {
    return this.count$Values(2)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.clearNationalNumberPattern = function () {
    this.clear$Field(2)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.getPossibleNumberPattern = function () {
    return this.get$Value(3)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.getPossibleNumberPatternOrDefault = function () {
    return this.get$ValueOrDefault(3)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.setPossibleNumberPattern = function (b) {
    this.set$Value(3, b)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.hasPossibleNumberPattern = function () {
    return this.has$Value(3)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.possibleNumberPatternCount = function () {
    return this.count$Values(3)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.clearPossibleNumberPattern = function () {
    this.clear$Field(3)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.getExampleNumber = function () {
    return this.get$Value(6)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.getExampleNumberOrDefault = function () {
    return this.get$ValueOrDefault(6)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.setExampleNumber = function (b) {
    this.set$Value(6, b)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.hasExampleNumber = function () {
    return this.has$Value(6)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.exampleNumberCount = function () {
    return this.count$Values(6)
};
i18n.phonenumbers.PhoneNumberDesc.prototype.clearExampleNumber = function () {
    this.clear$Field(6)
};
i18n.phonenumbers.PhoneMetadata = function () {
    goog.proto2.Message.apply(this)
};
goog.inherits(i18n.phonenumbers.PhoneMetadata, goog.proto2.Message);
i18n.phonenumbers.PhoneMetadata.prototype.getGeneralDesc = function () {
    return this.get$Value(1)
};
i18n.phonenumbers.PhoneMetadata.prototype.getGeneralDescOrDefault = function () {
    return this.get$ValueOrDefault(1)
};
i18n.phonenumbers.PhoneMetadata.prototype.setGeneralDesc = function (b) {
    this.set$Value(1, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasGeneralDesc = function () {
    return this.has$Value(1)
};
i18n.phonenumbers.PhoneMetadata.prototype.generalDescCount = function () {
    return this.count$Values(1)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearGeneralDesc = function () {
    this.clear$Field(1)
};
i18n.phonenumbers.PhoneMetadata.prototype.getFixedLine = function () {
    return this.get$Value(2)
};
i18n.phonenumbers.PhoneMetadata.prototype.getFixedLineOrDefault = function () {
    return this.get$ValueOrDefault(2)
};
i18n.phonenumbers.PhoneMetadata.prototype.setFixedLine = function (b) {
    this.set$Value(2, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasFixedLine = function () {
    return this.has$Value(2)
};
i18n.phonenumbers.PhoneMetadata.prototype.fixedLineCount = function () {
    return this.count$Values(2)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearFixedLine = function () {
    this.clear$Field(2)
};
i18n.phonenumbers.PhoneMetadata.prototype.getMobile = function () {
    return this.get$Value(3)
};
i18n.phonenumbers.PhoneMetadata.prototype.getMobileOrDefault = function () {
    return this.get$ValueOrDefault(3)
};
i18n.phonenumbers.PhoneMetadata.prototype.setMobile = function (b) {
    this.set$Value(3, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasMobile = function () {
    return this.has$Value(3)
};
i18n.phonenumbers.PhoneMetadata.prototype.mobileCount = function () {
    return this.count$Values(3)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearMobile = function () {
    this.clear$Field(3)
};
i18n.phonenumbers.PhoneMetadata.prototype.getTollFree = function () {
    return this.get$Value(4)
};
i18n.phonenumbers.PhoneMetadata.prototype.getTollFreeOrDefault = function () {
    return this.get$ValueOrDefault(4)
};
i18n.phonenumbers.PhoneMetadata.prototype.setTollFree = function (b) {
    this.set$Value(4, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasTollFree = function () {
    return this.has$Value(4)
};
i18n.phonenumbers.PhoneMetadata.prototype.tollFreeCount = function () {
    return this.count$Values(4)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearTollFree = function () {
    this.clear$Field(4)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPremiumRate = function () {
    return this.get$Value(5)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPremiumRateOrDefault = function () {
    return this.get$ValueOrDefault(5)
};
i18n.phonenumbers.PhoneMetadata.prototype.setPremiumRate = function (b) {
    this.set$Value(5, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasPremiumRate = function () {
    return this.has$Value(5)
};
i18n.phonenumbers.PhoneMetadata.prototype.premiumRateCount = function () {
    return this.count$Values(5)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearPremiumRate = function () {
    this.clear$Field(5)
};
i18n.phonenumbers.PhoneMetadata.prototype.getSharedCost = function () {
    return this.get$Value(6)
};
i18n.phonenumbers.PhoneMetadata.prototype.getSharedCostOrDefault = function () {
    return this.get$ValueOrDefault(6)
};
i18n.phonenumbers.PhoneMetadata.prototype.setSharedCost = function (b) {
    this.set$Value(6, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasSharedCost = function () {
    return this.has$Value(6)
};
i18n.phonenumbers.PhoneMetadata.prototype.sharedCostCount = function () {
    return this.count$Values(6)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearSharedCost = function () {
    this.clear$Field(6)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPersonalNumber = function () {
    return this.get$Value(7)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPersonalNumberOrDefault = function () {
    return this.get$ValueOrDefault(7)
};
i18n.phonenumbers.PhoneMetadata.prototype.setPersonalNumber = function (b) {
    this.set$Value(7, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasPersonalNumber = function () {
    return this.has$Value(7)
};
i18n.phonenumbers.PhoneMetadata.prototype.personalNumberCount = function () {
    return this.count$Values(7)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearPersonalNumber = function () {
    this.clear$Field(7)
};
i18n.phonenumbers.PhoneMetadata.prototype.getVoip = function () {
    return this.get$Value(8)
};
i18n.phonenumbers.PhoneMetadata.prototype.getVoipOrDefault = function () {
    return this.get$ValueOrDefault(8)
};
i18n.phonenumbers.PhoneMetadata.prototype.setVoip = function (b) {
    this.set$Value(8, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasVoip = function () {
    return this.has$Value(8)
};
i18n.phonenumbers.PhoneMetadata.prototype.voipCount = function () {
    return this.count$Values(8)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearVoip = function () {
    this.clear$Field(8)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPager = function () {
    return this.get$Value(21)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPagerOrDefault = function () {
    return this.get$ValueOrDefault(21)
};
i18n.phonenumbers.PhoneMetadata.prototype.setPager = function (b) {
    this.set$Value(21, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasPager = function () {
    return this.has$Value(21)
};
i18n.phonenumbers.PhoneMetadata.prototype.pagerCount = function () {
    return this.count$Values(21)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearPager = function () {
    this.clear$Field(21)
};
i18n.phonenumbers.PhoneMetadata.prototype.getId = function () {
    return this.get$Value(9)
};
i18n.phonenumbers.PhoneMetadata.prototype.getIdOrDefault = function () {
    return this.get$ValueOrDefault(9)
};
i18n.phonenumbers.PhoneMetadata.prototype.setId = function (b) {
    this.set$Value(9, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasId = function () {
    return this.has$Value(9)
};
i18n.phonenumbers.PhoneMetadata.prototype.idCount = function () {
    return this.count$Values(9)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearId = function () {
    this.clear$Field(9)
};
i18n.phonenumbers.PhoneMetadata.prototype.getCountryCode = function () {
    return this.get$Value(10)
};
i18n.phonenumbers.PhoneMetadata.prototype.getCountryCodeOrDefault = function () {
    return this.get$ValueOrDefault(10)
};
i18n.phonenumbers.PhoneMetadata.prototype.setCountryCode = function (b) {
    this.set$Value(10, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasCountryCode = function () {
    return this.has$Value(10)
};
i18n.phonenumbers.PhoneMetadata.prototype.countryCodeCount = function () {
    return this.count$Values(10)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearCountryCode = function () {
    this.clear$Field(10)
};
i18n.phonenumbers.PhoneMetadata.prototype.getInternationalPrefix = function () {
    return this.get$Value(11)
};
i18n.phonenumbers.PhoneMetadata.prototype.getInternationalPrefixOrDefault = function () {
    return this.get$ValueOrDefault(11)
};
i18n.phonenumbers.PhoneMetadata.prototype.setInternationalPrefix = function (b) {
    this.set$Value(11, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasInternationalPrefix = function () {
    return this.has$Value(11)
};
i18n.phonenumbers.PhoneMetadata.prototype.internationalPrefixCount = function () {
    return this.count$Values(11)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearInternationalPrefix = function () {
    this.clear$Field(11)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPreferredInternationalPrefix = function () {
    return this.get$Value(17)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPreferredInternationalPrefixOrDefault = function () {
    return this.get$ValueOrDefault(17)
};
i18n.phonenumbers.PhoneMetadata.prototype.setPreferredInternationalPrefix = function (b) {
    this.set$Value(17, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasPreferredInternationalPrefix = function () {
    return this.has$Value(17)
};
i18n.phonenumbers.PhoneMetadata.prototype.preferredInternationalPrefixCount = function () {
    return this.count$Values(17)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearPreferredInternationalPrefix = function () {
    this.clear$Field(17)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNationalPrefix = function () {
    return this.get$Value(12)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNationalPrefixOrDefault = function () {
    return this.get$ValueOrDefault(12)
};
i18n.phonenumbers.PhoneMetadata.prototype.setNationalPrefix = function (b) {
    this.set$Value(12, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasNationalPrefix = function () {
    return this.has$Value(12)
};
i18n.phonenumbers.PhoneMetadata.prototype.nationalPrefixCount = function () {
    return this.count$Values(12)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearNationalPrefix = function () {
    this.clear$Field(12)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPreferredExtnPrefix = function () {
    return this.get$Value(13)
};
i18n.phonenumbers.PhoneMetadata.prototype.getPreferredExtnPrefixOrDefault = function () {
    return this.get$ValueOrDefault(13)
};
i18n.phonenumbers.PhoneMetadata.prototype.setPreferredExtnPrefix = function (b) {
    this.set$Value(13, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasPreferredExtnPrefix = function () {
    return this.has$Value(13)
};
i18n.phonenumbers.PhoneMetadata.prototype.preferredExtnPrefixCount = function () {
    return this.count$Values(13)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearPreferredExtnPrefix = function () {
    this.clear$Field(13)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNationalPrefixForParsing = function () {
    return this.get$Value(15)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNationalPrefixForParsingOrDefault = function () {
    return this.get$ValueOrDefault(15)
};
i18n.phonenumbers.PhoneMetadata.prototype.setNationalPrefixForParsing = function (b) {
    this.set$Value(15, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasNationalPrefixForParsing = function () {
    return this.has$Value(15)
};
i18n.phonenumbers.PhoneMetadata.prototype.nationalPrefixForParsingCount = function () {
    return this.count$Values(15)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearNationalPrefixForParsing = function () {
    this.clear$Field(15)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNationalPrefixTransformRule = function () {
    return this.get$Value(16)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNationalPrefixTransformRuleOrDefault = function () {
    return this.get$ValueOrDefault(16)
};
i18n.phonenumbers.PhoneMetadata.prototype.setNationalPrefixTransformRule = function (b) {
    this.set$Value(16, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasNationalPrefixTransformRule = function () {
    return this.has$Value(16)
};
i18n.phonenumbers.PhoneMetadata.prototype.nationalPrefixTransformRuleCount = function () {
    return this.count$Values(16)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearNationalPrefixTransformRule = function () {
    this.clear$Field(16)
};
i18n.phonenumbers.PhoneMetadata.prototype.getSameMobileAndFixedLinePattern = function () {
    return this.get$Value(18)
};
i18n.phonenumbers.PhoneMetadata.prototype.getSameMobileAndFixedLinePatternOrDefault = function () {
    return this.get$ValueOrDefault(18)
};
i18n.phonenumbers.PhoneMetadata.prototype.setSameMobileAndFixedLinePattern = function (b) {
    this.set$Value(18, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasSameMobileAndFixedLinePattern = function () {
    return this.has$Value(18)
};
i18n.phonenumbers.PhoneMetadata.prototype.sameMobileAndFixedLinePatternCount = function () {
    return this.count$Values(18)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearSameMobileAndFixedLinePattern = function () {
    this.clear$Field(18)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNumberFormat = function (b) {
    return this.get$Value(19, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.getNumberFormatOrDefault = function (b) {
    return this.get$ValueOrDefault(19, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.addNumberFormat = function (b) {
    this.add$Value(19, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.numberFormatArray = function () {
    return this.array$Values(19)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasNumberFormat = function () {
    return this.has$Value(19)
};
i18n.phonenumbers.PhoneMetadata.prototype.numberFormatCount = function () {
    return this.count$Values(19)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearNumberFormat = function () {
    this.clear$Field(19)
};
i18n.phonenumbers.PhoneMetadata.prototype.getIntlNumberFormat = function (b) {
    return this.get$Value(20, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.getIntlNumberFormatOrDefault = function (b) {
    return this.get$ValueOrDefault(20, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.addIntlNumberFormat = function (b) {
    this.add$Value(20, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.intlNumberFormatArray = function () {
    return this.array$Values(20)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasIntlNumberFormat = function () {
    return this.has$Value(20)
};
i18n.phonenumbers.PhoneMetadata.prototype.intlNumberFormatCount = function () {
    return this.count$Values(20)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearIntlNumberFormat = function () {
    this.clear$Field(20)
};
i18n.phonenumbers.PhoneMetadata.prototype.getMainCountryForCode = function () {
    return this.get$Value(22)
};
i18n.phonenumbers.PhoneMetadata.prototype.getMainCountryForCodeOrDefault = function () {
    return this.get$ValueOrDefault(22)
};
i18n.phonenumbers.PhoneMetadata.prototype.setMainCountryForCode = function (b) {
    this.set$Value(22, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasMainCountryForCode = function () {
    return this.has$Value(22)
};
i18n.phonenumbers.PhoneMetadata.prototype.mainCountryForCodeCount = function () {
    return this.count$Values(22)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearMainCountryForCode = function () {
    this.clear$Field(22)
};
i18n.phonenumbers.PhoneMetadata.prototype.getLeadingDigits = function () {
    return this.get$Value(23)
};
i18n.phonenumbers.PhoneMetadata.prototype.getLeadingDigitsOrDefault = function () {
    return this.get$ValueOrDefault(23)
};
i18n.phonenumbers.PhoneMetadata.prototype.setLeadingDigits = function (b) {
    this.set$Value(23, b)
};
i18n.phonenumbers.PhoneMetadata.prototype.hasLeadingDigits = function () {
    return this.has$Value(23)
};
i18n.phonenumbers.PhoneMetadata.prototype.leadingDigitsCount = function () {
    return this.count$Values(23)
};
i18n.phonenumbers.PhoneMetadata.prototype.clearLeadingDigits = function () {
    this.clear$Field(23)
};
i18n.phonenumbers.PhoneMetadataCollection = function () {
    goog.proto2.Message.apply(this)
};
goog.inherits(i18n.phonenumbers.PhoneMetadataCollection, goog.proto2.Message);
i18n.phonenumbers.PhoneMetadataCollection.prototype.getMetadata = function (b) {
    return this.get$Value(1, b)
};
i18n.phonenumbers.PhoneMetadataCollection.prototype.getMetadataOrDefault = function (b) {
    return this.get$ValueOrDefault(1, b)
};
i18n.phonenumbers.PhoneMetadataCollection.prototype.addMetadata = function (b) {
    this.add$Value(1, b)
};
i18n.phonenumbers.PhoneMetadataCollection.prototype.metadataArray = function () {
    return this.array$Values(1)
};
i18n.phonenumbers.PhoneMetadataCollection.prototype.hasMetadata = function () {
    return this.has$Value(1)
};
i18n.phonenumbers.PhoneMetadataCollection.prototype.metadataCount = function () {
    return this.count$Values(1)
};
i18n.phonenumbers.PhoneMetadataCollection.prototype.clearMetadata = function () {
    this.clear$Field(1)
};
goog.proto2.Message.set$Metadata(i18n.phonenumbers.NumberFormat, {
    0: {
        name: "NumberFormat",
        fullName: "i18n.phonenumbers.NumberFormat"
    },
    "1": {
        name: "pattern",
        required: true,
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "2": {
        name: "format",
        required: true,
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "3": {
        name: "leading_digits_pattern",
        repeated: true,
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "4": {
        name: "national_prefix_formatting_rule",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "5": {
        name: "domestic_carrier_code_formatting_rule",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    }
});
goog.proto2.Message.set$Metadata(i18n.phonenumbers.PhoneNumberDesc, {
    0: {
        name: "PhoneNumberDesc",
        fullName: "i18n.phonenumbers.PhoneNumberDesc"
    },
    "2": {
        name: "national_number_pattern",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "3": {
        name: "possible_number_pattern",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "6": {
        name: "example_number",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    }
});
goog.proto2.Message.set$Metadata(i18n.phonenumbers.PhoneMetadata, {
    0: {
        name: "PhoneMetadata",
        fullName: "i18n.phonenumbers.PhoneMetadata"
    },
    "1": {
        name: "general_desc",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "2": {
        name: "fixed_line",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "3": {
        name: "mobile",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "4": {
        name: "toll_free",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "5": {
        name: "premium_rate",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "6": {
        name: "shared_cost",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "7": {
        name: "personal_number",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "8": {
        name: "voip",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "9": {
        name: "id",
        required: true,
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "10": {
        name: "country_code",
        required: true,
        fieldType: goog.proto2.Message.FieldType.INT32,
        type: Number
    },
    "11": {
        name: "international_prefix",
        required: true,
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "17": {
        name: "preferred_international_prefix",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "12": {
        name: "national_prefix",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "13": {
        name: "preferred_extn_prefix",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "15": {
        name: "national_prefix_for_parsing",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "16": {
        name: "national_prefix_transform_rule",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "18": {
        name: "same_mobile_and_fixed_line_pattern",
        fieldType: goog.proto2.Message.FieldType.BOOL,
        defaultValue: false,
        type: Boolean
    },
    "19": {
        name: "number_format",
        repeated: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.NumberFormat
    },
    "20": {
        name: "intl_number_format",
        repeated: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.NumberFormat
    },
    "21": {
        name: "pager",
        required: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneNumberDesc
    },
    "22": {
        name: "main_country_for_code",
        fieldType: goog.proto2.Message.FieldType.BOOL,
        defaultValue: false,
        type: Boolean
    },
    "23": {
        name: "leading_digits",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    }
});
goog.proto2.Message.set$Metadata(i18n.phonenumbers.PhoneMetadataCollection, {
    0: {
        name: "PhoneMetadataCollection",
        fullName: "i18n.phonenumbers.PhoneMetadataCollection"
    },
    "1": {
        name: "metadata",
        repeated: true,
        fieldType: goog.proto2.Message.FieldType.MESSAGE,
        type: i18n.phonenumbers.PhoneMetadata
    }
});
i18n.phonenumbers.PhoneNumber = function () {
    goog.proto2.Message.apply(this)
};
goog.inherits(i18n.phonenumbers.PhoneNumber, goog.proto2.Message);
i18n.phonenumbers.PhoneNumber.prototype.getCountryCode = function () {
    return this.get$Value(1)
};
i18n.phonenumbers.PhoneNumber.prototype.getCountryCodeOrDefault = function () {
    return this.get$ValueOrDefault(1)
};
i18n.phonenumbers.PhoneNumber.prototype.setCountryCode = function (b) {
    this.set$Value(1, b)
};
i18n.phonenumbers.PhoneNumber.prototype.hasCountryCode = function () {
    return this.has$Value(1)
};
i18n.phonenumbers.PhoneNumber.prototype.countryCodeCount = function () {
    return this.count$Values(1)
};
i18n.phonenumbers.PhoneNumber.prototype.clearCountryCode = function () {
    this.clear$Field(1)
};
i18n.phonenumbers.PhoneNumber.prototype.getNationalNumber = function () {
    return this.get$Value(2)
};
i18n.phonenumbers.PhoneNumber.prototype.getNationalNumberOrDefault = function () {
    return this.get$ValueOrDefault(2)
};
i18n.phonenumbers.PhoneNumber.prototype.setNationalNumber = function (b) {
    this.set$Value(2, b)
};
i18n.phonenumbers.PhoneNumber.prototype.hasNationalNumber = function () {
    return this.has$Value(2)
};
i18n.phonenumbers.PhoneNumber.prototype.nationalNumberCount = function () {
    return this.count$Values(2)
};
i18n.phonenumbers.PhoneNumber.prototype.clearNationalNumber = function () {
    this.clear$Field(2)
};
i18n.phonenumbers.PhoneNumber.prototype.getExtension = function () {
    return this.get$Value(3)
};
i18n.phonenumbers.PhoneNumber.prototype.getExtensionOrDefault = function () {
    return this.get$ValueOrDefault(3)
};
i18n.phonenumbers.PhoneNumber.prototype.setExtension = function (b) {
    this.set$Value(3, b)
};
i18n.phonenumbers.PhoneNumber.prototype.hasExtension = function () {
    return this.has$Value(3)
};
i18n.phonenumbers.PhoneNumber.prototype.extensionCount = function () {
    return this.count$Values(3)
};
i18n.phonenumbers.PhoneNumber.prototype.clearExtension = function () {
    this.clear$Field(3)
};
i18n.phonenumbers.PhoneNumber.prototype.getItalianLeadingZero = function () {
    return this.get$Value(4)
};
i18n.phonenumbers.PhoneNumber.prototype.getItalianLeadingZeroOrDefault = function () {
    return this.get$ValueOrDefault(4)
};
i18n.phonenumbers.PhoneNumber.prototype.setItalianLeadingZero = function (b) {
    this.set$Value(4, b)
};
i18n.phonenumbers.PhoneNumber.prototype.hasItalianLeadingZero = function () {
    return this.has$Value(4)
};
i18n.phonenumbers.PhoneNumber.prototype.italianLeadingZeroCount = function () {
    return this.count$Values(4)
};
i18n.phonenumbers.PhoneNumber.prototype.clearItalianLeadingZero = function () {
    this.clear$Field(4)
};
i18n.phonenumbers.PhoneNumber.prototype.getRawInput = function () {
    return this.get$Value(5)
};
i18n.phonenumbers.PhoneNumber.prototype.getRawInputOrDefault = function () {
    return this.get$ValueOrDefault(5)
};
i18n.phonenumbers.PhoneNumber.prototype.setRawInput = function (b) {
    this.set$Value(5, b)
};
i18n.phonenumbers.PhoneNumber.prototype.hasRawInput = function () {
    return this.has$Value(5)
};
i18n.phonenumbers.PhoneNumber.prototype.rawInputCount = function () {
    return this.count$Values(5)
};
i18n.phonenumbers.PhoneNumber.prototype.clearRawInput = function () {
    this.clear$Field(5)
};
i18n.phonenumbers.PhoneNumber.prototype.getCountryCodeSource = function () {
    return this.get$Value(6)
};
i18n.phonenumbers.PhoneNumber.prototype.getCountryCodeSourceOrDefault = function () {
    return this.get$ValueOrDefault(6)
};
i18n.phonenumbers.PhoneNumber.prototype.setCountryCodeSource = function (b) {
    this.set$Value(6, b)
};
i18n.phonenumbers.PhoneNumber.prototype.hasCountryCodeSource = function () {
    return this.has$Value(6)
};
i18n.phonenumbers.PhoneNumber.prototype.countryCodeSourceCount = function () {
    return this.count$Values(6)
};
i18n.phonenumbers.PhoneNumber.prototype.clearCountryCodeSource = function () {
    this.clear$Field(6)
};
i18n.phonenumbers.PhoneNumber.CountryCodeSource = {
    FROM_NUMBER_WITH_PLUS_SIGN: 1,
    FROM_NUMBER_WITH_IDD: 5,
    FROM_NUMBER_WITHOUT_PLUS_SIGN: 10,
    FROM_DEFAULT_COUNTRY: 20
};
goog.proto2.Message.set$Metadata(i18n.phonenumbers.PhoneNumber, {
    0: {
        name: "PhoneNumber",
        fullName: "i18n.phonenumbers.PhoneNumber"
    },
    "1": {
        name: "country_code",
        required: true,
        fieldType: goog.proto2.Message.FieldType.INT32,
        type: Number
    },
    "2": {
        name: "national_number",
        required: true,
        fieldType: goog.proto2.Message.FieldType.UINT64,
        type: Number
    },
    "3": {
        name: "extension",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "4": {
        name: "italian_leading_zero",
        fieldType: goog.proto2.Message.FieldType.BOOL,
        type: Boolean
    },
    "5": {
        name: "raw_input",
        fieldType: goog.proto2.Message.FieldType.STRING,
        type: String
    },
    "6": {
        name: "country_code_source",
        fieldType: goog.proto2.Message.FieldType.ENUM,
        defaultValue: i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITH_PLUS_SIGN,
        type: i18n.phonenumbers.PhoneNumber.CountryCodeSource
    }
});
i18n.phonenumbers.metadata = {};
i18n.phonenumbers.metadata.countryCodeToRegionCodeMap = {
    1: ["US", "AG", "AI", "AS", "BB", "BM", "BS", "CA", "DM", "DO", "GD", "GU", "JM", "KN", "KY", "LC", "MP", "MS", "PR", "TC", "TT", "VC", "VG", "VI"],
    7: ["RU", "KZ"],
    20: ["EG"],
    27: ["ZA"],
    30: ["GR"],
    31: ["NL"],
    32: ["BE"],
    33: ["FR"],
    34: ["ES"],
    36: ["HU"],
    39: ["IT"],
    40: ["RO"],
    41: ["CH"],
    43: ["AT"],
    44: ["GB", "GG", "IM", "JE"],
    45: ["DK"],
    46: ["SE"],
    47: ["NO"],
    48: ["PL"],
    49: ["DE"],
    51: ["PE"],
    52: ["MX"],
    53: ["CU"],
    54: ["AR"],
    55: ["BR"],
    56: ["CL"],
    57: ["CO"],
    58: ["VE"],
    60: ["MY"],
    61: ["AU"],
    62: ["ID"],
    63: ["PH"],
    64: ["NZ"],
    65: ["SG"],
    66: ["TH"],
    81: ["JP"],
    82: ["KR"],
    84: ["VN"],
    86: ["CN"],
    90: ["TR"],
    91: ["IN"],
    92: ["PK"],
    93: ["AF"],
    94: ["LK"],
    95: ["MM"],
    98: ["IR"],
    212: ["MA"],
    213: ["DZ"],
    216: ["TN"],
    218: ["LY"],
    220: ["GM"],
    221: ["SN"],
    222: ["MR"],
    223: ["ML"],
    224: ["GN"],
    225: ["CI"],
    226: ["BF"],
    227: ["NE"],
    228: ["TG"],
    229: ["BJ"],
    230: ["MU"],
    231: ["LR"],
    232: ["SL"],
    233: ["GH"],
    234: ["NG"],
    235: ["TD"],
    236: ["CF"],
    237: ["CM"],
    238: ["CV"],
    239: ["ST"],
    240: ["GQ"],
    241: ["GA"],
    242: ["CG"],
    243: ["CD"],
    244: ["AO"],
    245: ["GW"],
    246: ["IO"],
    248: ["SC"],
    249: ["SD"],
    250: ["RW"],
    251: ["ET"],
    252: ["SO"],
    253: ["DJ"],
    254: ["KE"],
    255: ["TZ"],
    256: ["UG"],
    257: ["BI"],
    258: ["MZ"],
    260: ["ZM"],
    261: ["MG"],
    262: ["RE", "TF", "YT"],
    263: ["ZW"],
    264: ["NA"],
    265: ["MW"],
    266: ["LS"],
    267: ["BW"],
    268: ["SZ"],
    269: ["KM"],
    290: ["SH"],
    291: ["ER"],
    297: ["AW"],
    298: ["FO"],
    299: ["GL"],
    350: ["GI"],
    351: ["PT"],
    352: ["LU"],
    353: ["IE"],
    354: ["IS"],
    355: ["AL"],
    356: ["MT"],
    357: ["CY"],
    358: ["FI"],
    359: ["BG"],
    370: ["LT"],
    371: ["LV"],
    372: ["EE"],
    373: ["MD"],
    374: ["AM"],
    375: ["BY"],
    376: ["AD"],
    377: ["MC"],
    378: ["SM"],
    379: ["VA"],
    380: ["UA"],
    381: ["RS"],
    382: ["ME"],
    385: ["HR"],
    386: ["SI"],
    387: ["BA"],
    389: ["MK"],
    420: ["CZ"],
    421: ["SK"],
    423: ["LI"],
    500: ["FK"],
    501: ["BZ"],
    502: ["GT"],
    503: ["SV"],
    504: ["HN"],
    505: ["NI"],
    506: ["CR"],
    507: ["PA"],
    508: ["PM"],
    509: ["HT"],
    590: ["GP", "BL", "MF"],
    591: ["BO"],
    592: ["GY"],
    593: ["EC"],
    594: ["GF"],
    595: ["PY"],
    596: ["MQ"],
    597: ["SR"],
    598: ["UY"],
    599: ["AN"],
    670: ["TL"],
    672: ["NF"],
    673: ["BN"],
    674: ["NR"],
    675: ["PG"],
    676: ["TO"],
    677: ["SB"],
    678: ["VU"],
    679: ["FJ"],
    680: ["PW"],
    681: ["WF"],
    682: ["CK"],
    683: ["NU"],
    685: ["WS"],
    686: ["KI"],
    687: ["NC"],
    688: ["TV"],
    689: ["PF"],
    690: ["TK"],
    691: ["FM"],
    692: ["MH"],
    850: ["KP"],
    852: ["HK"],
    853: ["MO"],
    855: ["KH"],
    856: ["LA"],
    880: ["BD"],
    886: ["TW"],
    960: ["MV"],
    961: ["LB"],
    962: ["JO"],
    963: ["SY"],
    964: ["IQ"],
    965: ["KW"],
    966: ["SA"],
    967: ["YE"],
    968: ["OM"],
    970: ["PS"],
    971: ["AE"],
    972: ["IL"],
    973: ["BH"],
    974: ["QA"],
    975: ["BT"],
    976: ["MN"],
    977: ["NP"],
    992: ["TJ"],
    993: ["TM"],
    994: ["AZ"],
    995: ["GE"],
    996: ["KG"],
    998: ["UZ"]
};
i18n.phonenumbers.metadata.countryToMetadata = {
    AD: [, [, , "(?:[346-9]|180)\\d{5}", "\\d{6,8}"],
        [, , "[78]\\d{5}", "\\d{6}", , , "712345"],
        [, , "[346]\\d{5}", "\\d{6}", , , "312345"],
        [, , "180[02]\\d{4}", "\\d{8}", , , "18001234"],
        [, , "9\\d{5}", "\\d{6}", , , "912345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AD", 376, "00", , , , , , , , [
            [, "(\\d{3})(\\d{3})", "$1 $2", ["[346-9]"], "", ""],
            [, "(180[02])(\\d{4})", "$1 $2", ["1"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    AE: [, [, , "[2-79]\\d{7,8}|800\\d{2,9}", "\\d{5,12}"],
        [, , "(?:[2-4679][2-8]\\d|600[25])\\d{5}", "\\d{7,9}", , , "22345678"],
        [, , "5[056]\\d{7}", "\\d{9}", , , "501234567"],
        [, , "400\\d{6}|800\\d{2,9}", "\\d{5,12}", , , "800123456"],
        [, , "900[02]\\d{5}", "\\d{9}", , , "900234567"],
        [, , "700[05]\\d{5}", "\\d{9}", , , "700012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AE", 971, "00", "0", , , "0", , , , [
            [, "([2-4679])(\\d{3})(\\d{4})", "$1 $2 $3", ["[2-4679][2-8]"], "0$1", ""],
            [, "(5[056])(\\d{3})(\\d{4})", "$1 $2 $3", ["5"], "0$1", ""],
            [, "([4679]00)(\\d)(\\d{5})", "$1 $2 $3", ["[4679]0"], "$1", ""],
            [, "(800)(\\d{2,9})", "$1 $2", ["8"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    AF: [, [, , "[2-7]\\d{8}", "\\d{7,9}"],
        [, , "(?:[25][0-8]|[34][0-4]|6[0-5])[2-9]\\d{6}", "\\d{7,9}", , , "234567890"],
        [, , "7[057-9]\\d{7}", "\\d{9}", , , "701234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AF", 93, "00", "0", , , "0", , , , [
            [, "([2-7]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    AG: [, [, , "[289]\\d{9}", "\\d{7,10}"],
        [, , "268(?:4(?:6[0-3]|84)|56[0-2])\\d{4}", "\\d{7,10}", , , "2684601234"],
        [, , "268(?:464|7(?:2[0-9]|64|7[0-5]|8[358]))\\d{4}", "\\d{10}", , , "2684641234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "26848[01]\\d{4}", "\\d{10}", , , "2684801234"], "AG", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "268"],
    AI: [, [, , "[289]\\d{9}", "\\d{7,10}"],
        [, , "2644(?:6[12]|9[78])\\d{4}", "\\d{7,10}", , , "2644612345"],
        [, , "264(?:235|476|5(?:3[6-9]|8[1-4])|7(?:29|72))\\d{4}", "\\d{10}", , , "2642351234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AI", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "264"],
    AL: [, [, , "[2-57]\\d{7}|6\\d{8}|8\\d{5,7}|9\\d{5}", "\\d{5,9}"],
        [, , "(?:2(?:[168][1-9]|[247]\\d|9[1-7])|3(?:1[1-3]|[2-6]\\d|[79][1-8]|8[1-9])|4\\d{2}|5(?:1[1-4]|[2-578]\\d|6[1-5]|9[1-7])|8(?:[19][1-5]|[2-6]\\d|[78][1-7]))\\d{5}", "\\d{5,8}", , , "22345678"],
        [, , "6[6-9]\\d{7}", "\\d{9}", , , "661234567"],
        [, , "800\\d{4}", "\\d{7}", , , "8001234"],
        [, , "900\\d{3}", "\\d{6}", , , "900123"],
        [, , "808\\d{3}", "\\d{6}", , , "808123"],
        [, , "700\\d{5}", "\\d{8}", , , "70012345"],
        [, , "NA", "NA"], "AL", 355, "00", "0", , , "0", , , , [
            [, "(4)(\\d{3})(\\d{4})", "$1 $2 $3", ["4[0-6]"], "0$1", ""],
            [, "(6[6-9])(\\d{3})(\\d{4})", "$1 $2 $3", ["6"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["[2358][2-5]|4[7-9]"], "0$1", ""],
            [, "(\\d{3})(\\d{3,5})", "$1 $2", ["[235][16-9]|8[016-9]|[79]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    AM: [, [, , "[1-37-9]\\d{7}", "\\d{5,8}"],
        [, , "(?:10\\d|2(?:2[2-46]|3[1-8]|4[2-69]|5[2-7]|6[1-9]|8[1-7])|3[12]2)\\d{5}", "\\d{5,8}", , , "10123456"],
        [, , "(?:77|9[1-49])\\d{6}", "\\d{8}", , , "77123456"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "90[016]\\d{5}", "\\d{8}", , , "90012345"],
        [, , "80[1-4]\\d{5}", "\\d{8}", , , "80112345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AM", 374, "00", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{6})", "$1 $2", ["[17]|9[1-49]"], "(0$1)", ""],
            [, "(\\d{3})(\\d{5})", "$1 $2", ["[23]"], "(0$1)", ""],
            [, "(\\d{3})(\\d{2})(\\d{3})", "$1 $2 $3", ["8|90"], "0 $1", ""]
        ], , [, , "NA", "NA"]
    ],
    AN: [, [, , "[13-79]\\d{6,7}", "\\d{7,8}"],
        [, , "(?:318|5(?:25|4\\d|8[239])|7(?:1[578]|50)|9(?:[48]\\d{2}|50\\d|7(?:2[0-2]|[34]\\d|6[35-7]|77)))\\d{4}|416[0239]\\d{3}", "\\d{7,8}", , , "7151234"],
        [, , "(?:318|5(?:1[01]|2[0-7]|5\\d|8[016-8])|7(?:0[01]|[89]\\d)|9(?:5(?:[1246]\\d|3[01])|6(?:[1679]\\d|3[01])))\\d{4}|416[15-8]\\d{3}", "\\d{7,8}", , , "3181234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "(?:10|69)\\d{5}", "\\d{7,8}", , , "1011234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AN", 599, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", ["[13-7]"], "", ""],
            [, "(9)(\\d{3})(\\d{4})", "$1 $2 $3", ["9"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    AO: [, [, , "[29]\\d{8}", "\\d{9}"],
        [, , "2\\d(?:[26-9]\\d|\\d[26-9])\\d{5}", "\\d{9}", , , "222123456"],
        [, , "9[1-3]\\d{7}", "\\d{9}", , , "923123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AO", 244, "00", , , , , , , , [
            [, "(\\d{3})(\\d{3})(\\d{3})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    AR: [, [, , "[1-9]\\d{9,11}", "\\d{6,12}"],
        [, , "[1-9]\\d{9}", "\\d{6,10}", , , "1123456789"],
        [, , "9(?:11[2-9]\\d{7}|(?:2(?:2[013]|37|6[14]|9[179])|3(?:4[1235]|5[138]|8[1578]))[2-9]\\d{6}|\\d{4}[2-9]\\d{5})", "\\d{6,12}", , , "91123456789"],
        [, , "80\\d{8}", "\\d{10}", , , "8012345678"],
        [, , "6(?:0\\d|10)\\d{7}", "\\d{10}", , , "6001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AR", 54, "00", "0", , , "0(?:(11|2(?:2(?:02?|[13]|2[13-79]|4[1-6]|5[2457]|6[124-8]|7[1-4]|8[13-6]|9[1-367])|3(?:[06]2|1[467]|2[02-6]|3[13-8]|[49][2-6]|5[2-8]|7)|47[3-578]|6(?:1|2[2-7]|4[6-8]?|5[125-8])|9(?:0[1-3]|[19]|2\\d|3[1-6]|4[0-24-68]|5[2-4]|6[2-6]|72?|8[23]?))|3(?:3(?:2[79]|8[2578])|4(?:0[124-9]|[12]|3[5-8]?|4[24-7]|5[4-68]?|6\\d|7[126]|8[237-9]|9[1-36-8])|5(?:1|2[1245]|3[2-4]?|4[1-46-9]|6[2-4]|7[1-6]|8[2-5]?)|7(?:1[15-8]|2[125]|3[1245]|4[13]|5[124-8]|7[2-57]|8[1-36])|8(?:1|2[125-7]|3[23578]|4[13-6]|5[4-8]?|6[1-357-9]|7[5-8]?|8[4-7]?|9[124])))15)?", "9$1", , , [
            [, "([68]\\d{2})(\\d{3})(\\d{4})", "$1-$2-$3", ["[68]"], "0$1", ""],
            [, "9(11)(\\d{4})(\\d{4})", "$1 15-$2-$3", ["91"], "0$1", ""],
            [, "9(\\d{3})(\\d{3})(\\d{4})", "$1 15-$2-$3", ["9(?:2[2369]|3[458])", "9(?:2(?:2[013]|37|6[14]|9[179])|3(?:4[1235]|5[138]|8[1578]))"], "0$1", ""],
            [, "9(\\d{4})(\\d{2})(\\d{4})", "$1 15-$2-$3", ["9(?:2[2-469]|3[3-578])", "9(?:2(?:2[24-9]|3[0-69]|47|6[25]|9[02-68])|3(?:3[28]|4[046-9]|5[2467]|7[1-578]|8[23469]))"], "0$1", ""],
            [, "(11)(\\d{4})(\\d{4})", "$1 $2-$3", ["1"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2-$3", ["2(?:2[013]|37|6[14]|9[179])|3(?:4[1235]|5[138]|8[1578])"], "0$1", ""],
            [, "(\\d{4})(\\d{2})(\\d{4})", "$1 $2-$3", ["[23]"], "0$1", ""]
        ],
        [
            [, "([68]\\d{2})(\\d{3})(\\d{4})", "$1-$2-$3", ["[68]"], , ""],
            [, "9(11)(\\d{4})(\\d{4})", "9 $1 $2-$3", ["91"], , ""],
            [, "9(\\d{3})(\\d{3})(\\d{4})", "9 $1 $2-$3", ["9(?:2[2369]|3[458])", "9(?:2(?:2[013]|37|6[14]|9[179])|3(?:4[1235]|5[138]|8[1578]))"], , ""],
            [, "9(\\d{4})(\\d{2})(\\d{4})", "9 $1 $2-$3", ["9(?:2[2-469]|3[3-578])", "9(?:2(?:2[24-9]|3[0-69]|47|6[25]|9[02-68])|3(?:3[28]|4[046-9]|5[2467]|7[1-578]|8[23469]))"], , ""],
            [, "(11)(\\d{4})(\\d{4})", "$1 $2-$3", ["1"], , ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2-$3", ["2(?:2[013]|37|6[14]|9[179])|3(?:4[1235]|5[138]|8[1578])"], , ""],
            [, "(\\d{4})(\\d{2})(\\d{4})", "$1 $2-$3", ["[23]"], , ""]
        ],
        [, , "NA", "NA"]
    ],
    AS: [, [, , "[689]\\d{9}", "\\d{7,10}"],
        [, , "6846(?:22|33|44|55|77|88|9[19])\\d{4}", "\\d{7,10}", , , "6846221234"],
        [, , "684(?:733|258)\\d{4}", "\\d{10}", , , "6847331234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AS", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "684"],
    AT: [, [, , "\\d{4,13}", "\\d{3,13}"],
        [, , "1\\d{3,12}|(?:2(?:1[467]|2[134-8]|5[2357]|6[1-46-8]|7[1-8]|8[124-7]|8[1458])|3(?:1[1-8]|3[23568]|4[5-7]|5[1378]|6[1-38]|8[3-68])|4(?:2[1-8]|35|63|7[1368]|8[2457])|5(?:1[27]|2[1-8]|3[357]|4[147]|5[12578]|6[37])|6(?:13|2[1-47]|4[1-35-8]|5[468]|62)|7(?:2[1-8]|3[25]|4[13478]|5[68]|6[16-8]|7[1-6]|9[45]))\\d{3,10}|5(?:0[1-9]|[79]\\d)\\d{2,10}|720\\d{6,10}", "\\d{3,13}", , , "1234567890"],
        [, , "6(?:44|5[0-3579]|6[013-9]|[7-9]\\d)\\d{4,10}", "\\d{7,13}", , , "644123456"],
        [, , "80[02]\\d{6,10}", "\\d{9,13}", , , "800123456"],
        [, , "(?:711|9(?:0[01]|3[019]))\\d{6,10}", "\\d{9,13}", , , "900123456"],
        [, , "8(?:10|2[018])\\d{6,10}", "\\d{9,13}", , , "810123456"],
        [, , "NA", "NA"],
        [, , "780\\d{6,10}", "\\d{9,13}", , , "780123456"], "AT", 43, "00", "0", , , "0", , , , [
            [, "([15])(\\d{3,12})", "$1 $2", ["1|5[079]"], "0$1", ""],
            [, "(\\d{3})(\\d{3,10})", "$1 $2", ["316|46|51|732|6(?:44|5[0-3579]|[6-9])|7(?:1|[28]0)|[89]"], "0$1", ""],
            [, "(\\d{4})(\\d{3,9})", "$1 $2", ["2|3(?:1[1-578]|[3-8])|4[2378]|5[2-6]|6(?:[12]|4[1-35-9]|5[468])|7(?:2[1-8]|35|4[1-8]|[57-9])"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    AU: [, [, , "[1-578]\\d{5,9}", "\\d{6,10}"],
        [, , "[2378]\\d{8}", "\\d{8,9}", , , "212345678"],
        [, , "4[0-68]\\d{7}", "\\d{9}", , , "412345678"],
        [, , "1(?:80(?:0\\d{2})?|3(?:00\\d{2})?)\\d{4}", "\\d{6,10}", , , "1800123456"],
        [, , "190[0126]\\d{6}", "\\d{10}", , , "1900123456"],
        [, , "NA", "NA"],
        [, , "500\\d{6}", "\\d{9}", , , "500123456"],
        [, , "550\\d{6}", "\\d{9}", , , "550123456"], "AU", 61, "(?:14(?:1[14]|34|4[17]|[56]6|7[47]|88))?001[14-689]", "0", , , "0", , "0011", , [
            [, "([2378])(\\d{4})(\\d{4})", "$1 $2 $3", ["[2378]"], "(0$1)", ""],
            [, "(4\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["4"], "0$1", ""],
            [, "(5[05]0)(\\d{3})(\\d{3})", "$1 $2 $3", ["5"], "0$1", ""],
            [, "(1[389]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["1(?:[38]0|9)", "1(?:[38]00|9)"], "$1", ""],
            [, "(180)(\\d{4})", "$1 $2", ["180", "180[1-9]"], "$1", ""],
            [, "(13)(\\d{2})(\\d{2})", "$1 $2 $3", ["13[1-9]"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    AW: [, [, , "[5-9]\\d{6}", "\\d{7}"],
        [, , "5(?:2\\d{2}|8(?:[2-7]\\d|8[0-79]|9[48]))\\d{3}", "\\d{7}", , , "5212345"],
        [, , "(?:5[69]\\d|660|9(?:6\\d|9[02-9])|7[34]\\d)\\d{4}", "\\d{7}", , , "5601234"],
        [, , "800\\d{4}", "\\d{7}", , , "8001234"],
        [, , "900\\d{4}", "\\d{7}", , , "9001234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AW", 297, "00", , , , , , , , [
            [, "([5-9]\\d{2})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    AZ: [, [, , "[1-8]\\d{7,8}", "\\d{8,9}"],
        [, , "(?:1(?:(?:[28]\\d|9)\\d|02|1[0-589]|3[358]|4[013-79]|5[0-479]|6[0236-9]|7[0-24-8])|2(?:16|2\\d|3[0-24]|4[1468]|55|6[56]|79)|365?\\d)\\d{5}", "\\d{8,9}", , , "123123456"],
        [, , "(?:4[04]|5[015]|60|7[07])\\d{7}", "\\d{9}", , , "401234567"],
        [, , "88\\d{7}", "\\d{9}", , , "881234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "AZ", 994, "00", , , , , , , , [
            [, "(\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["1[28]|22|[3-8]"], "", ""],
            [, "([12]\\d{2})(\\d{5})", "$1 $2", ["1[013-79]|2[013-9]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    BA: [, [, , "[3-689]\\d{7}", "\\d{6,8}"],
        [, , "(?:[35]\\d|49|81)\\d{6}", "\\d{6,8}", , , "30123456"],
        [, , "6[1-356]\\d{6}", "\\d{8}", , , "61123456"],
        [, , "8[08]\\d{6}", "\\d{8}", , , "80123456"],
        [, , "9[0246]\\d{6}", "\\d{8}", , , "90123456"],
        [, , "82\\d{6}", "\\d{8}", , , "82123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BA", 387, "00", "0", , , "0", , , , [
            [, "([3-689]\\d)(\\d{3})(\\d{3})", "$1 $2-$3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    BB: [, [, , "[289]\\d{9}", "\\d{7,10}"],
        [, , "246[2-9]\\d{6}", "\\d{7,10}", , , "2462345678"],
        [, , "246(?:(?:2[346]|45|82)\\d|25[0-4])\\d{4}", "\\d{10}", , , "2462501234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BB", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "246"],
    BD: [, [, , "[2-79]\\d{5,9}|1\\d{9}|8[0-7]\\d{4,8}", "\\d{6,10}"],
        [, , "2(?:7\\d1|8(?:[026]1|[1379][1-5]|8[1-8])|9(?:0[0-2]|1[1-4]|3[3-5]|5[56]|6[67]|71|8[078]))\\d{4}|3(?:[6-8]1|(?:0[23]|[25][12]|82|416)\\d|(?:31|12?[5-7])\\d{2})\\d{3}|4(?:(?:02|[49]6|[68]1)|(?:0[13]|21\\d?|[23]2|[457][12]|6[28])\\d|(?:23|[39]1)\\d{2}|1\\d{3})\\d{3}|5(?:(?:[457-9]1|62)|(?:1\\d?|2[12]|3[1-3]|52)\\d|61{2})|6(?:[45]1|(?:11|2[15]|[39]1)\\d|(?:[06-8]1|62)\\d{2})|7(?:(?:32|91)|(?:02|31|[67][12])\\d|[458]1\\d{2}|21\\d{3})\\d{3}|8(?:(?:4[12]|[5-7]2|1\\d?)|(?:0|3[12]|[5-7]1|217)\\d)\\d{4}|9(?:[35]1|(?:[024]2|81)\\d|(?:1|[24]1)\\d{2})\\d{3}", "\\d{6,9}", , , "27111234"],
        [, , "(?:1[13-9]\\d|(?:3[78]|44)[02-9]|6(?:44|6[02-9]))\\d{7}", "\\d{10}", , , "1812345678"],
        [, , "80[03]\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BD", 880, "00[12]?", "0", , , "0", , "00", , [
            [, "(2)(\\d{7})", "$1 $2", ["2"], "0$1", ""],
            [, "(\\d{2})(\\d{4,6})", "$1 $2", ["[3-79]1"], "0$1", ""],
            [, "(\\d{3})(\\d{3,7})", "$1 $2", ["[3-79][2-9]|8"], "0$1", ""],
            [, "(\\d{4})(\\d{6})", "$1 $2", ["1"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    BE: [, [, , "[1-9]\\d{7,8}", "\\d{8,9}"],
        [, , "(?:1[0-69]|[23][2-8]|[49][23]|5\\d|6[013-57-9]|7[18])\\d{6}|8(?:0[1-9]|[1-79]\\d)\\d{5}", "\\d{8}", , , "12345678"],
        [, , "4(?:7\\d|8[4-9]|9[1-9])\\d{6}", "\\d{9}", , , "470123456"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "(?:90|7[07])\\d{6}", "\\d{8}", , , "90123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BE", 32, "00", "0", , , "0", , , , [
            [, "(4[7-9]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["4[7-9]"], "0$1", ""],
            [, "([2-49])(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[23]|[49][23]"], "0$1", ""],
            [, "([15-8]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[156]|7[0178]|8(?:0[1-9]|[1-79])"], "0$1", ""],
            [, "([89]\\d{2})(\\d{2})(\\d{3})", "$1 $2 $3", ["(?:80|9)0"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    BF: [, [, , "[2457]\\d{7}", "\\d{8}"],
        [, , "(?:20(?:49|5[23]|9[016-9])|40(?:4[569]|55|7[0179])|50[34]\\d)\\d{4}", "\\d{8}", , , "20491234"],
        [, , "7(?:[024-6]\\d|1[0-489]|3[01]|8[013-9]|9[012])\\d{5}", "\\d{8}", , , "70123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BF", 226, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    BG: [, [, , "[2-9]\\d{6,8}", "\\d{7,9}"],
        [, , "(?:2\\d|[36]\\d|5[1-9]|8[1-6]|9[1-7])\\d{5,6}|(?:4(?:[124-7]\\d|3[1-6])|7(?:0[1-9]|[1-9]\\d))\\d{4,5}", "\\d{7,8}", , , "2123456"],
        [, , "(?:8[7-9]|98)\\d{7}|4(?:3[0789]|8\\d)\\d{5}", "\\d{8,9}", , , "48123456"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "90\\d{6}", "\\d{8}", , , "90123456"],
        [, , "NA", "NA"],
        [, , "700\\d{5}", "\\d{7,9}", , , "70012345"],
        [, , "NA", "NA"], "BG", 359, "00", "0", , , "0", , , , [
            [, "(2)(\\d{3})(\\d{3,4})", "$1/$2 $3", ["2"], "0$1", ""],
            [, "(\\d{3})(\\d{4})", "$1/$2", ["43[124-7]|70[1-9]"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{2})", "$1/$2 $3", ["43[124-7]|70[1-9]"], "0$1", ""],
            [, "(\\d{3})(\\d{2})(\\d{3})", "$1 $2 $3", ["[78]00"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{2,3})", "$1/$2 $3", ["[356]|7[1-9]|8[1-6]|9[1-7]"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["48|8[7-9]|9[08]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    BH: [, [, , "[1367]\\d{7}", "\\d{8}"],
        [, , "(?:1(?:3[3-6]|6[0156]|7\\d)|6(?:1[16]|6[03469]|9[69])|77\\d)\\d{5}", "\\d{8}", , , "17001234"],
        [, , "(?:3(?:[369]\\d|77|8[38])|6(?:1[16]|6[03469]|9[69])|77\\d)\\d{5}", "\\d{8}", , , "36001234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BH", 973, "00", , , , , , , , [
            [, "(\\d{4})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    BI: [, [, , "[27]\\d{7}", "\\d{8}"],
        [, , "22(?:2[0-7]|[3-5]0)\\d{4}", "\\d{8}", , , "22201234"],
        [, , "(?:29\\d|7(?:1[1-3]|[4-9]\\d))\\d{5}", "\\d{8}", , , "79561234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BI", 257, "00", , , , , , , , [
            [, "([27]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    BJ: [, [, , "[2689]\\d{7}|7\\d{3}", "\\d{4,8}"],
        [, , "2(?:02|1[037]|2[45]|3[68])\\d{5}", "\\d{8}", , , "20211234"],
        [, , "66\\d{6}|9(?:0[069]|[35][0-2457-9]|[6-8]\\d)\\d{5}", "\\d{8}", , , "90011234"],
        [, , "7[3-5]\\d{2}", "\\d{4}", , , "7312"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "857[58]\\d{4}", "\\d{8}", , , "85751234"], "BJ", 229, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    BL: [, [, , "[56]\\d{8}", "\\d{9}"],
        [, , "590(?:2[7-9]|5[12]|87)\\d{4}", "\\d{9}", , , "590271234"],
        [, , "690(?:10|2[27]|66|77|8[78])\\d{4}", "\\d{9}", , , "690221234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BL", 590, "00", "0", , , "0", , , , , , [, , "NA", "NA"]
    ],
    BM: [, [, , "[489]\\d{9}", "\\d{7,10}"],
        [, , "441(?:2(?:02|23|61|[3479]\\d)|[46]\\d{2}|5(?:4\\d|60|89)|824)\\d{4}", "\\d{7,10}", , , "4412345678"],
        [, , "441(?:[37]\\d|5[0-39])\\d{5}", "\\d{10}", , , "4413701234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BM", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "441"],
    BN: [, [, , "[2-578]\\d{6}", "\\d{7}"],
        [, , "[2-5]\\d{6}", "\\d{7}", , , "2345678"],
        [, , "[78]\\d{6}", "\\d{7}", , , "7123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BN", 673, "00", "0", , , "0", , , , [
            [, "([2-578]\\d{2})(\\d{4})", "$1 $2", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    BO: [, [, , "[23467]\\d{7}", "\\d{7,8}"],
        [, , "(?:2(?:2\\d{2}|5(?:11|[258]\\d|9[67])|6(?:12|2\\d|9[34])|8(?:2[34]|39|62))|3(?:3\\d{2}|4(?:6\\d|8[24])|8(?:25|42|5[257]|86|9[25])|9(?:2\\d|3[234]|4[248]|5[24]|6[2-6]|7\\d))|4(?:4\\d{2}|6(?:11|[24689]\\d|72)))\\d{4}", "\\d{7,8}", , , "22123456"],
        [, , "[67]\\d{7}", "\\d{8}", , , "71234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BO", 591, "00(1\\d)?", "0", , , "0(1\\d)?", , , , [
            [, "([234])(\\d{7})", "$1 $2", ["[234]"], "", ""],
            [, "([67]\\d{7})", "$1", ["[67]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    BR: [, [, , "[1-9]\\d{7,9}", "\\d{8,10}"],
        [, , "(?:[14689][1-9]|2[12478]|3[1-578]|5[13-5]|7[13-579])[2-5]\\d{7}", "\\d{8,10}", , , "1123456789"],
        [, , "(?:[14689][1-9]|2[12478]|3[1-578]|5[13-5]|7[13-579])[6-9]\\d{7}", "\\d{10}", , , "1161234567"],
        [, , "800\\d{6,7}", "\\d{8,10}", , , "800123456"],
        [, , "[359]00\\d{6,7}", "\\d{8,10}", , , "300123456"],
        [, , "(?:400\\d|3003)\\d{4}", "\\d{8,10}", , , "40041234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BR", 55, "00(?:1[45]|2[135]|[34]1|43)", "0", , , "0(?:(?:1[245]|2[135]|[34]1)(\\d{10}))?", "$1", , , [
            [, "(\\d{2})(\\d{4})(\\d{4})", "$1 $2-$3", ["[1-9][1-9]"], "($1)", "0 $CC $1"],
            [, "([34]00\\d)(\\d{4})", "$1-$2", ["[34]00", "400|3003"], "", ""],
            [, "([3589]00)(\\d{2,3})(\\d{4})", "$1 $2 $3", ["[3589]00"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    BS: [, [, , "[289]\\d{9}", "\\d{7,10}"],
        [, , "242(?:3(?:02|[236][1-9]|4[0-24-9]|5[0-68]|7[3467]|8[0-4]|9[2-467])|461|502|6(?:12|7[67]|8[78]|9[89])|702)\\d{4}", "\\d{7,10}", , , "2423456789"],
        [, , "242(?:3(?:5[79]|[79]5)|4(?:[2-4][1-9]|5[1-8]|6[2-8]|7\\d|81)|5(?:2[34]|3[35]|44|5[1-9]|65|77)|6[34]6|727)\\d{4}", "\\d{10}", , , "2423591234"],
        [, , "242300\\d{4}|8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BS", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "242"],
    BT: [, [, , "(?:17|[2-8])\\d{6}", "\\d{6,8}"],
        [, , "(?:2[3-6]|[34][5-7]|5[236]|6[2-46]|7[246]|8[2-4])\\d{5}", "\\d{6,7}", , , "2345678"],
        [, , "17\\d{6}", "\\d{8}", , , "17123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BT", 975, "00", , , , , , , , [
            [, "(17)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["1"], "", ""],
            [, "([2-8])(\\d{3})(\\d{3})", "$1 $2 $3", ["[2-8]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    BW: [, [, , "[2-9]\\d{6,7}", "\\d{7,8}"],
        [, , "(?:2(?:4[0-48]|6[0-24]|9[0578])|3(?:1[0235-9]|55|6\\d|7[01]|9[0-57])|4(?:6[03]|7[1267]|9[0-5])|5(?:3[0389]|4[0489]|7[1-47]|88|9[0-49])|6(?:2[1-35]|5[149]|8[067]))\\d{4}", "\\d{7}", , , "2401234"],
        [, , "7(?:[1-3]\\d{6}|4[0-7]\\d{5})", "\\d{8}", , , "71123456"],
        [, , "8\\d{6}", "\\d{7}", , , "8123456"],
        [, , "90\\d{5}", "\\d{7}", , , "9012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BW", 267, "00", , , , , , , , [
            [, "(7[1-4])(\\d{3})(\\d{3})", "$1 $2 $3", ["7"], "", ""],
            [, "(90)(\\d{5})", "$1 $2", ["9"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    BY: [, [, , "[12-4]\\d{8}|[89]\\d{9}", "\\d{7,10}"],
        [, , "(?:1(?:5(?:1[1-5]|2\\d|6[1-4]|9[1-7])|6(?:[235]\\d|4[1-7])|7\\d{2})|2(?:1(?:[246]\\d|3[0-35-9]|5[1-9])|2(?:[235]\\d|4[0-8])|3(?:2\\d|3[02-79]|4[024-7]|5[0-7])))\\d{5}", "\\d{7,9}", , , "152450911"],
        [, , "(?:2(?:5[679]|9[1-9])|33\\d|44\\d)\\d{6}", "\\d{9}", , , "294911911"],
        [, , "80[13]\\d{7}", "\\d{10}", , , "8011234567"],
        [, , "902\\d{7}", "\\d{10}", , , "9021234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BY", 375, "8~10", "8", , , "80?", , , , [
            [, "([1-4]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["[1-4]"], "8 0$1", ""],
            [, "([89]\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["[89]"], "8 $1", ""]
        ], , [, , "NA", "NA"]
    ],
    BZ: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "BZ", 501, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    CA: [, [, , "[2-9]\\d{9}|3\\d{6}", "\\d{7,10}"],
        [, , "(?:2(?:04|26|50|89)|306|4(?:03|16|18|38|50|56)|5(?:00|06|14|19|81|87)|6(?:00|04|13|47)|7(?:00|05|09|10|78|80)|8(?:07|19|67))[2-9]\\d{6}|310\\d{4}", "\\d{7,10}", , , "2042345678"],
        [, , "(?:2(?:04|26|50|89)|306|4(?:03|16|18|38|50|56)|5(?:00|06|14|19|81|87)|6(?:00|04|13|47)|7(?:00|05|09|10|78|80)|8(?:07|19|67)|9(?:02|05))[2-9]\\d{6}", "\\d{7,10}", , , "2042345678"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}|310\\d{4}", "\\d{7,10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CA", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"]
    ],
    CD: [, [, , "[89]\\d{8}|[1-6]\\d{6}", "\\d{7,9}"],
        [, , "[1-6]\\d{6}", "\\d{7}", , , "1234567"],
        [, , "(?:8[0149]|9[7-9])\\d{7}", "\\d{9}", , , "991234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CD", 243, "00", "0", , , "0", , , , [
            [, "([89]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["[89]"], "0$1", ""],
            [, "([1-6]\\d)(\\d{5})", "$1 $2", ["[1-6]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    CF: [, [, , "[278]\\d{7}", "\\d{8}"],
        [, , "2[12]\\d{6}", "\\d{8}", , , "21612345"],
        [, , "7[0257]\\d{6}", "\\d{8}", , , "70012345"],
        [, , "NA", "NA"],
        [, , "8776\\d{4}", "\\d{8}", , , "87761234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CF", 236, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    CG: [, [, , "[24-68]\\d{6}", "\\d{7}"],
        [, , "(?:2[1-589]|8\\d)\\d{5}", "\\d{7}", , , "2123456"],
        [, , "[4-6]\\d{6}", "\\d{7}", , , "5012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CG", 242, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    CH: [, [, , "[2-9]\\d{8}", "\\d{9}"],
        [, , "(?:2[12467]|3[1-4]|4[134]|5[12568]|6[12]|[7-9]1)\\d{7}", "\\d{9}", , , "212345678"],
        [, , "7[46-9]\\d{7}", "\\d{9}", , , "741234567"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "90[016]\\d{6}", "\\d{9}", , , "900123456"],
        [, , "84[0248]\\d{6}", "\\d{9}", , , "840123456"],
        [, , "878\\d{6}", "\\d{9}", , , "878123456"],
        [, , "NA", "NA"], "CH", 41, "00", "0", , , "0", , , , [
            [, "([2-9]\\d)(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[2-7]|[89]1"], "0$1", ""],
            [, "([89]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["8[047]|90"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    CI: [, [, , "[02-5]\\d{7}", "\\d{8}"],
        [, , "(?:2(?:0[023]|1[02357]|[23][045]|4[03-5])|3(?:0[06]|1[069]|[2-4][07]|5[09]|6[08]))\\d{5}", "\\d{8}", , , "21234567"],
        [, , "(?:0[1-9]|4[04-9]|50|6[067])\\d{6}", "\\d{8}", , , "01234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CI", 225, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    CK: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CK", 682, "00", "00", , , "00", , , 1, , , [, , "NA", "NA"]
    ],
    CL: [, [, , "(?:[2-9]|600|123)\\d{7,8}", "\\d{6,11}"],
        [, , "(?:2|32|41)\\d{7}|(?:3[3-5]|4[235]|5[1-3578]|6[13-57]|7[1-35])\\d{6,7}", "\\d{6,9}", , , "21234567"],
        [, , "9[6-9]\\d{7}", "\\d{8,9}", , , "961234567"],
        [, , "800\\d{6}|1230\\d{7}", "\\d{9,11}", , , "800123456"],
        [, , "600\\d{7,8}", "\\d{10,11}", , , "6001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "44\\d{7}", "\\d{9}", , , "441234567"], "CL", 56, "(?:0|1(?:1[0-69]|2[0-57]|5[13-58]|69|7[0167]|8[018]))0", "0", , , "(?:0|1(?:1[0-69]|2[0-57]|5[13-58]|69|7[0167]|8[018]))", , , , [
            [, "(2)(\\d{3})(\\d{4})", "$1 $2 $3", ["2"], "0$1", ""],
            [, "(\\d{2})(\\d{2,3})(\\d{4})", "$1 $2 $3", ["[357]|4[1-35]|6[13-57]"], "0$1", ""],
            [, "(9)([6-9]\\d{3})(\\d{4})", "$1 $2 $3", ["9"], "0$1", ""],
            [, "(44)(\\d{3})(\\d{4})", "$1 $2 $3", ["44"], "0$1", ""],
            [, "([68]00)(\\d{3})(\\d{3,4})", "$1 $2 $3", ["60|8"], "$1", ""],
            [, "(600)(\\d{3})(\\d{2})(\\d{3})", "$1 $2 $3 $4", ["60"], "$1", ""],
            [, "(1230)(\\d{3})(\\d{4})", "$1 $2 $3", ["1"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    CM: [, [, , "[237-9]\\d{7}", "\\d{8}"],
        [, , "(?:22|33)\\d{6}", "\\d{8}", , , "22123456"],
        [, , "[79]\\d{7}", "\\d{8}", , , "71234567"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "88\\d{6}", "\\d{8}", , , "88012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CM", 237, "00", , , , , , , , [
            [, "([237-9]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[2379]|88"], "", ""],
            [, "(800)(\\d{2})(\\d{3})", "$1 $2 $3", ["80"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    CN: [, [, , "[1-79]\\d{7,11}|8[0-357-9]\\d{6,9}", "\\d{4,12}"],
        [, , "21\\d{8,10}|(?:10|2[02-57-9]|3(?:11|7[159])|4[135]1|5(?:1\\d|2[37]|3[12]|7[13-79]|9[15])|7(?:31|5[457]|6[09])|898)\\d{8}|(?:3(?:1[02-9]|35|49|5\\d|7[02-68]|9[1-68])|4(?:1[02-9]|2[179]|[35][2-9]|6[4789]|7[0-46-9]|8[23])|5(?:3[03-9]|4[36]|5\\d|6[1-6]|7[028]|80|9[2-46-9])|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]\\d|2[248]|3[04-9]|4[3-6]|6[2368])|8(?:1[236-8]|2[5-7]|[37]\\d|5[1-9]|8[3678]|9[1-7])|9(?:0[1-3689]|1[1-79]|[379]\\d|4[13]|5[1-5]))\\d{7}|80(?:29|6[03578]|7[018]|81)\\d{4}", "\\d{4,12}", , , "1012345678"],
        [, , "1(?:3[0-9]|47|5[0135689]|8[05-9])\\d{8}", "\\d{11}", , , "13123456789"],
        [, , "(?:10)?800\\d{7}", "\\d{10,12}", , , "8001234567"],
        [, , "16[08]\\d{5}", "\\d{8}", , , "16812345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "400\\d{7}", "\\d{10}", , , "4001234567"], "CN", 86, "00", "0", , , "0", , , , [
            [, "(80\\d{2})(\\d{4})", "$1 $2", ["80[2678]"], "0$1", ""],
            [, "([48]00)(\\d{3})(\\d{4})", "$1 $2 $3", ["[48]00"], "", ""],
            [, "(\\d{3,4})(\\d{4})", "$1 $2", ["[2-9]"], "", ""],
            [, "(21)(\\d{4})(\\d{4,6})", "$1 $2 $3", ["21"], "0$1", ""],
            [, "([12]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["10[1-9]|2[02-9]", "10[1-9]|2[02-9]", "10(?:[1-79]|8(?:[1-9]|0[1-9]))|2[02-9]"], "0$1", ""],
            [, "(\\d{3})(\\d{4})(\\d{4})", "$1 $2 $3", ["3(?:11|7[159])|4[135]1|5(?:1|2[37]|3[12]|7[13-79]|9[15])|7(?:31|5[457]|6[09])|898"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["3(?:1[02-9]|35|49|5|7[02-68]|9[1-68])|4(?:1[02-9]|2[179]|[35][2-9]|6[4789]|7[0-46-9]|8[23])|5(?:3[03-9]|4[36]|5|6[1-6]|7[028]|80|9[2-46-9])|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]|2[248]|3[04-9]|4[3-6]|6[2368])|8(?:1[236-8]|2[5-7]|[37]|5[1-9]|8[3678]|9[1-7])|9(?:0[1-3689]|1[1-79]|[379]|4[13]|5[1-5])"], "0$1", ""],
            [, "(1[3-58]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["1[3-58]"], "", ""],
            [, "(10800)(\\d{3})(\\d{4})", "$1 $2 $3", ["108", "1080", "10800"], "", ""]
        ],
        [
            [, "(21)(\\d{4})(\\d{4,6})", "$1 $2 $3", ["21"], , ""],
            [, "([12]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["10[1-9]|2[02-9]", "10[1-9]|2[02-9]", "10(?:[1-79]|8(?:[1-9]|0[1-9]))|2[02-9]"], , ""],
            [, "(80\\d{2})(\\d{4})", "$1 $2", ["80[2678]"], , ""],
            [, "(\\d{3})(\\d{4})(\\d{4})", "$1 $2 $3", ["3(?:11|7[159])|4[135]1|5(?:1|2[37]|3[12]|7[13-79]|9[15])|7(?:31|5[457]|6[09])|898"], , ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["3(?:1[02-9]|35|49|5|7[02-68]|9[1-68])|4(?:1[02-9]|2[179]|[35][2-9]|6[4789]|7[0-46-9]|8[23])|5(?:3[03-9]|4[36]|5|6[1-6]|7[028]|80|9[2-46-9])|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]|2[248]|3[04-9]|4[3-6]|6[2368])|8(?:1[236-8]|2[5-7]|[37]|5[1-9]|8[3678]|9[1-7])|9(?:0[1-3689]|1[1-79]|[379]|4[13]|5[1-5])"], , ""],
            [, "(1[3-58]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["1[3-58]"], , ""],
            [, "([48]00)(\\d{3})(\\d{4})", "$1 $2 $3", ["[48]00"], , ""],
            [, "(10800)(\\d{3})(\\d{4})", "$1 $2 $3", ["108", "1080", "10800"], , ""]
        ],
        [, , "NA", "NA"]
    ],
    CO: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CO", 57, "(?:00[579]|#555|#999)", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    CR: [, [, , "[28]\\d{7}", "\\d{8}"],
        [, , "2[24-7]\\d{6}", "\\d{8}", , , "22123456"],
        [, , "8[38]\\d{6}", "\\d{8}", , , "83123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CR", 506, "00", , , , , , , , [
            [, "([28]\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    CU: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CU", 53, "119", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    CV: [, [, , "[259]\\d{6}", "\\d{7}"],
        [, , "2(?:2[1-7]|3[0-8]|4[12]|5[1256]|6\\d|7[1-3]|8[1-5])\\d{4}", "\\d{7}", , , "2211234"],
        [, , "(?:9\\d|59)\\d{5}", "\\d{7}", , , "9911234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "CV", 238, "0", , , , , , , , [
            [, "(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    CY: [, [, , "[27-9]\\d{7}", "\\d{8}"],
        [, , "2[2-6]\\d{6}", "\\d{8}", , , "22345678"],
        [, , "7777\\d{4}|9(?:[69]\\d|7[67])\\d{5}", "\\d{8}", , , "96123456"],
        [, , "8000\\d{4}", "\\d{8}", , , "80001234"],
        [, , "9009\\d{4}", "\\d{8}", , , "90091234"],
        [, , "NA", "NA"],
        [, , "700\\d{5}", "\\d{8}", , , "70012345"],
        [, , "NA", "NA"], "CY", 357, "00", , , , , , , , [
            [, "([27-9]\\d)(\\d{6})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    CZ: [, [, , "[2-9]\\d{8}", "\\d{9}"],
        [, , "2\\d{8}|(?:3[1257-9]|4[16-9]|5[13-9])\\d{7}", "\\d{9}", , , "212345678"],
        [, , "60[1-8]\\d{6}|7[2379]\\d{7}", "\\d{9}", , , "601123456"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "90[0689]\\d{6}", "\\d{9}", , , "900123456"],
        [, , "8[134]\\d{7}", "\\d{9}", , , "811234567"],
        [, , "70[01]\\d{6}", "\\d{9}", , , "700123456"],
        [, , "NA", "NA"], "CZ", 420, "00", , , , , , , , [
            [, "([2-9]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    DE: [, [, , "(?:4[0-8]|[1-35-9]\\d)\\d{4,12}|49(?:4[1-8]|[0-35-7]\\d)\\d{2,7}", "\\d{2,14}"],
        [, , "(?:[246]\\d{2}|3[02-9]\\d|5(?:0[2-8]|[38][0-8]|[124-6]\\d|[79][0-7])|[789](?:[1-9]\\d|0[2-9]))\\d{3,10}", "\\d{2,14}", , , "30123456"],
        [, , "1(?:5\\d{9}|7(?:[0-57-9]|6\\d)\\d{7}|6[02]\\d{7,8}|63\\d{7})", "\\d{10,11}", , , "15123456789"],
        [, , "800\\d{7,9}", "\\d{10,12}", , , "8001234567"],
        [, , "900(?:[135]\\d{6}|9\\d{7})", "\\d{10,11}", , , "9001234567"],
        [, , "180\\d{5,11}", "\\d{8,14}", , , "18012345"],
        [, , "700\\d{8}", "\\d{11}", , , "70012345678"],
        [, , "NA", "NA"], "DE", 49, "00", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{4,11})", "$1/$2", ["3[02]|40|[68]9"], "0$1", ""],
            [, "(\\d{3})(\\d{3,10})", "$1/$2", ["2(?:\\d1|0[2389]|1[24]|28|34)|3(?:[3-9][15]|40)|[4-8][1-9]1|9(?:06|[1-9]1)"], "0$1", ""],
            [, "(\\d{4})(\\d{2,8})", "$1/$2", ["[24-6]|[7-9](?:\\d[1-9]|[1-9]\\d)|3(?:[3569][02-46-9]|4[2-4679]|7[2-467]|8[2-46-8])", "[24-6]|[7-9](?:\\d[1-9]|[1-9]\\d)|3(?:3(?:0[1-467]|2[127-9]|3[124578]|[46][1246]|7[1257-9]|8[1256]|9[145])|4(?:2[135]|3[1357]|4[13578]|6[1246]|7[1356]|9[1346])|5(?:0[14]|2[1-3589]|3[1357]|4[1246]|6[1-4]|7[1346]|8[13568]|9[1246])|6(?:0[356]|2[1-489]|3[124-6]|4[1347]|6[13]|7[12579]|8[1-356]|9[135])|7(?:2[1-7]|3[1357]|4[145]|6[1-5]|7[1-4])|8(?:21|3[1468]|4[1347]|6[0135-9]|7[1467]|8[136])|9(?:0[12479]|2[1358]|3[1357]|4[134679]|6[1-9]|7[136]|8[147]|9[1468]))"], "0$1", ""],
            [, "(\\d{5})(\\d{1,6})", "$1/$2", ["3"], "0$1", ""],
            [, "([18]\\d{2})(\\d{7,9})", "$1 $2", ["1[5-7]|800"], "0$1", ""],
            [, "(\\d{3})(\\d)(\\d{4,10})", "$1 $2 $3", ["(?:18|90)0", "180|900[1359]"], "0$1", ""],
            [, "(700)(\\d{4})(\\d{4})", "$1 $2 $3", ["700"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    DJ: [, [, , "[2-8]\\d{5}", "\\d{6}"],
        [, , "(?:25|3[0-6]|42)\\d{4}", "\\d{6}", , , "251234"],
        [, , "(?:[5-7]\\d|8[0-7])\\d{4}", "\\d{6}", , , "601234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "DJ", 253, "00", , , , , , , , [
            [, "([2-8]\\d)(\\d{2})(\\d{2})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    DK: [, [, , "[1-9]\\d{7}", "\\d{8}"],
        [, , "(?:3[2-9]|4[3-9]|5[4-9]|6[2-9]|7[02-9]|8[26-9]|9[6-9])\\d{6}", "\\d{8}", , , "32123456"],
        [, , "(?:2[0-9]|3[0-2]|4[0-2]|5[0-3]|6[01]|72|99)\\d{6}", "\\d{8}", , , "20123456"],
        [, , "80\\d{6}", "\\d{8}", , , "80123456"],
        [, , "90\\d{6}", "\\d{8}", , , "90123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "DK", 45, "00", , , , , , , , [
            [, "([1-9]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    DM: [, [, , "[7-9]\\d{9}", "\\d{7,10}"],
        [, , "767(?:2(?:55|66)|4(?:2[01]|4[0-25-9])|50[0-4])\\d{4}", "\\d{7,10}", , , "7674201234"],
        [, , "767(?:2(?:[2346]5|7[5-7])|31[5-7]|61[4-6])\\d{4}", "\\d{10}", , , "7672251234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "DM", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "767"],
    DO: [, [, , "[89]\\d{9}", "\\d{7,10}"],
        [, , "8[024]9[2-9]\\d{6}", "\\d{7,10}", , , "8092345678"],
        [, , "8[024]9[2-9]\\d{6}", "\\d{7,10}", , , "8092345678"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "DO", 1, "011", "1", , , "1", , , 1, , , [, , "NA", "NA"], , "8[024]9"],
    DZ: [, [, , "(?:[1-4]|[5-9]\\d)\\d{7}", "\\d{8,9}"],
        [, , "(?:1\\d|2[014-79]|3[0-8]|4[0135689])\\d{6}|9619\\d{5}", "\\d{8,9}", , , "12345678"],
        [, , "(?:5[56]|6[69]|7[79])\\d{7}", "\\d{9}", , , "551234567"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "80[3-689]1\\d{5}", "\\d{9}", , , "808123456"],
        [, , "80[12]1\\d{5}", "\\d{9}", , , "801123456"],
        [, , "NA", "NA"],
        [, , "98[23]\\d{6}", "\\d{9}", , , "983123456"], "DZ", 213, "00", "0", , , "0", , , , [
            [, "([1-4]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[1-4]"], "0$1", ""],
            [, "([5-8]\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[5-8]"], "0$1", ""],
            [, "(9\\d)(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["9"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    EC: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "EC", 593, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    EE: [, [, , "[3-9]\\d{6,7}|800\\d{6,7}", "\\d{6,10}"],
        [, , "(?:3[23589]|4[3-8]|6\\d|7[1-9]|88)\\d{5}", "\\d{7}", , , "3212345"],
        [, , "(?:5\\d|8[1-5])\\d{6}|5(?:[02]\\d{2}|1(?:[0-8]\\d|95)|5[0-478]\\d|64[0-4]|65[1-589])\\d{3}", "\\d{7,8}", , , "51234567"],
        [, , "800(?:0\\d{3}|1\\d|[2-9])\\d{3}", "\\d{7,10}", , , "80012345"],
        [, , "900\\d{4}", "\\d{7}", , , "9001234"],
        [, , "NA", "NA"],
        [, , "70\\d{5}", "\\d{7}", , , "7012345"],
        [, , "NA", "NA"], "EE", 372, "00", , , , , , , , [
            [, "([34-79]\\d{2})(\\d{4})", "$1 $2", ["[34679]|5(?:[0-2]|5[0-478]|6[45])", "[34679]|5(?:[02]|1(?:[0-8]|95)|5[0-478]|6(?:4[0-4]|5[1-589]))"], "", ""],
            [, "(8000)(\\d{3})(\\d{3})", "$1 $2 $3", ["800", "8000"], "", ""],
            [, "([58]\\d{3})(\\d{3,4})", "$1 $2", ["5|8(?:00|[1-5])", "5|8(?:00[1-9]|[1-5])"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    EG: [, [, , "1\\d{4,9}|[2-689]\\d{7,9}", "\\d{5,10}"],
        [, , "(?:1[35][23]|2[23]\\d|3\\d|4(?:0[2-4]|[578][23]|64)|5(?:0[234]|[57][23])|6[24-689]3|8(?:[28][2-4]|42|6[23])|9(?:[25]2|3[24]|6[23]|7[2-4]))\\d{6}|1[69]\\d{3}", "\\d{5,9}", , , "234567890"],
        [, , "1[0-246-9]\\d{7}", "\\d{9}", , , "101234567"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "900\\d{7}", "\\d{10}", , , "9001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "EG", 20, "00", "0", , , "0", , , , [
            [, "(\\d)(\\d{7,8})", "$1 $2", ["[23]"], "0$1", ""],
            [, "(\\d{2})(\\d{7})", "$1 $2", ["[14-6]|[89][2-9]"], "0$1", ""],
            [, "([89]00)(\\d{3})(\\d{4})", "$1 $2 $3", ["[89]00"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    ER: [, [, , "[178]\\d{6}", "\\d{6,7}"],
        [, , "1(?:1[12568]|20|40|55|6[146])\\d{4}|8\\d{6}", "\\d{6,7}", , , "8370362"],
        [, , "17[1-3]\\d{4}|7\\d{6}", "\\d{7}", , , "7123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ER", 291, "00", "0", , , "0", , , , [
            [, "(\\d)(\\d{3})(\\d{3})", "$1 $2 $3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    ES: [, [, , "[5-9]\\d{8}", "\\d{9}"],
        [, , "[89][1-8]\\d{7}", "\\d{9}", , , "812345678"],
        [, , "6\\d{8}", "\\d{9}", , , "612345678"],
        [, , "[89]00\\d{6}", "\\d{9}", , , "800123456"],
        [, , "80[367]\\d{6}", "\\d{9}", , , "803123456"],
        [, , "90[12]\\d{6}", "\\d{9}", , , "901123456"],
        [, , "(?:51|70)\\d{7}", "\\d{9}", , , "701234567"],
        [, , "NA", "NA"], "ES", 34, "00", , , , , , , , [
            [, "([5-9]\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    ET: [, [, , "[1-59]\\d{8}", "\\d{7,9}"],
        [, , "(?:11(?:1(?:1[124]|2[2-57]|3[1-5]|5[5-8]|8[6-8])|2(?:13|3[6-8]|5[89]|7[05-9]|8[2-6])|3(?:2[01]|3[0-289]|4[1289]|7[1-4]|87)|4(?:1[69]|3[2-49]|4[0-23]|6[5-8])|5(?:1[57]|44|5[0-4])|6(?:18|2[69]|4[5-7]|5[1-5]|6[0-59]|8[015-8]))|2(?:2(?:11[1-9]|22[0-7]|33\\d|44[1467]|66[1-68])|5(?:11[124-6]|33[2-8]|44[1467]|55[14]|66[1-3679]|77[124-79]|880))|3(?:3(?:11[0-46-8]|22[0-6]|33[0134689]|44[04]|55[0-6]|66[01467])|4(?:44[0-8]|55[0-69]|66[0-3]|77[1-5]))|4(?:6(?:22[0-24-7]|33[1-5]|44[13-69]|55[14-689]|660|88[1-4])|7(?:11[1-9]|22[1-9]|33[13-7]|44[13-6]|55[1-689]))|5(?:7(?:227|55[05]|(?:66|77)[14-8])|8(?:11[149]|22[013-79]|33[0-68]|44[013-8]|550|66[1-5]|77\\d)))\\d{4}", "\\d{7,9}", , , "111112345"],
        [, , "91(?:1(?:[146]\\d|2[0-5]|3[4-6]|50|7[2-6]|8[46-9])|31\\d|4(?:3[0-2489]|7[0-3])|5(?:3[23]|7[3-5])|6(?:58|8[23])|7(?:5[57]|8[01])|8(?:3[45]|7[67]))\\d{4}", "\\d{9}", , , "911123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ET", 251, "00", "0", , , "0", , , , [
            [, "([1-59]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    FI: [, [, , "[1-9]\\d{4,11}", "\\d{5,12}"],
        [, , "1(?:0[1-9]\\d{3,7}|[35689][1-8]\\d{3,9}|[47]\\d{5,10})|2(?:0(?:[16-8]\\d{3,7}|2[14-9]\\d{1,6}|[3-5]\\d{2,7}|9[0-7]\\d{1,6})|[1-8]\\d{3,9}|9\\d{4,8})|3(?:0[1-9]\\d{3,7}|[1-8]\\d{3,9}|9\\d{4,8})|[5689][1-8]\\d{3,9}|7(?:1\\d{7}|3\\d{8}|5[03-9]\\d{2,7})", "\\d{5,12}", , , "1312345678"],
        [, , "4\\d{5,10}|50\\d{4,8}", "\\d{6,11}", , , "412345678"],
        [, , "800\\d{4,7}", "\\d{7,10}", , , "8001234567"],
        [, , "[67]00\\d{5,6}", "\\d{8,9}", , , "600123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "FI", 358, "00|99[049]", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{4,10})", "$1 $2", ["2[09]|[14]|50|7[135]"], "0$1", ""],
            [, "(\\d)(\\d{4,11})", "$1 $2", ["[25689][1-8]|3"], "0$1", ""],
            [, "([6-8]00)(\\d{4,7})", "$1 $2", ["[6-8]0"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    FJ: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "FJ", 679, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    FK: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "FK", 500, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    FM: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "FM", 691, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    FO: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "FO", 298, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    FR: [, [, , "[1-9]\\d{8}", "\\d{9}"],
        [, , "[1-5]\\d{8}", "\\d{9}", , , "123456789"],
        [, , "6\\d{8}|7[5-9]\\d{7}", "\\d{9}", , , "612345678"],
        [, , "80\\d{7}", "\\d{9}", , , "801234567"],
        [, , "89[1-37-9]\\d{6}", "\\d{9}", , , "891123456"],
        [, , "8(?:1[019]|2[0156]|84|90)\\d{6}", "\\d{9}", , , "810123456"],
        [, , "NA", "NA"],
        [, , "9\\d{8}", "\\d{9}", , , "912345678"], "FR", 33, "[04579]0", "0", , , "0", , "00", , [
            [, "([1-79])(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4 $5", ["[1-79]"], "0$1", ""],
            [, "(8\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["8"], "0 $1", ""]
        ], , [, , "NA", "NA"]
    ],
    GA: [, [, , "[4-9]\\d{5}|0\\d{7}", "\\d{6,8}"],
        [, , "(?:4(?:[04-8]\\d|2[04])|(?:5[04-689]|6[024-9]|7\\d|8[236]|9[02368])\\d)\\d{3}", "\\d{6}", , , "441234"],
        [, , "0(?:5(?:0[89]|3[0-4]|8[0-26]|9[238])|6(?:0[3-7]|1[01]|2[0-7]|6[0-589]|71|83|9[57])|7(?:1[2-5]|2[89]|3[35-9]|4[01]|5[0-347-9]|[67]\\d|8[457-9]|9[0146]))\\d{4}", "\\d{8}", , , "06031234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GA", 241, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3", ["[4-9]"], "", ""],
            [, "(0\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["0"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    GB: [, [, , "\\d{7,10}", "\\d{4,10}"],
        [, , "1(?:1[3-8]|[2-69]1)\\d{7}|1(?:2(?:0[024-9]|2[3-9]|3[3-79]|4[1-689]|[58][02-9]|6[0-4789]|7[013-9]|9\\d)|3(?:0\\d|[25][02-9]|3[02-579]|[468][0-46-9]|7[1235679]|9[24578])|4(?:0[03-9]|2[02-5789]|[37]\\d|4[02-69]|5[0-8]|[69][0-79]|8[02-5789])|5(?:0[1235-9]|2[024-9]|3[015689]|4[02-9]|5[03-9]|6\\d|7[0-35-9]|8[0-468]|9[0-5789])|6(?:0[034689]|2[0-35689]|3[013-9]|4[1-467]|5[0-69]|6[13-9]|7[0-8]|8[013-9]|9[0124578])|7(?:0[0246-9]|2\\d|3[023678]|4[03-9]|5[0-46-9]|6[013-9]|7[0-35-9]|8[024-9]|9[02-9])|8(?:0[35-9]|2[1-5789]|3[02-578]|4[0-578]|5[124-9]|6[2-69]|7\\d|8[02-9]|9[02569])|9(?:0[02-589]|2[02-689]|3[1-5789]|4[2-9]|5[0-579]|6[234789]|7[0124578]|8\\d|9[2-57]))\\d{6}|1(?:2(?:0(?:46[1-4]|87[2-9])|545[1-79]|76(?:2\\d|3[1-8]|6[1-6])|9(?:7(?:2[0-4]|3[2-5])|8(?:2[2-8]|7[0-4789]|8[345])))|3(?:638[2-5]|647[23]|8(?:47[04-9]|64[015789]))|4(?:044[1-7]|20(?:2[23]|8\\d)|6(?:0(?:30|5[2-57]|6[1-8]|7[2-8])|140)|8(?:052|87[123]))|5(?:24(?:3[2-79]|6\\d)|276\\d|6(?:26[06-9]|686))|6(?:06(?:4\\d|7[4-79])|295[567]|35[34]\\d|47(?:24|61)|59(?:5[08]|6[67]|74)|955[0-4])|7(?:26(?:6[13-9]|7[0-7])|442\\d|50(?:2[0-3]|[3-68]2|76))|8(?:27[56]\\d|37(?:5[2-5]|8[239])|84(?:3[2-58]))|9(?:0(?:0(?:6[1-8]|85)|52\\d)|3583|4(?:66[1-8]|9(?:2[01]|81))|63(?:23|3[1-4])|9561))\\d{3}|176888[234678]\\d{2}|16977[23]\\d{3}|2(?:0[01378]|3[0189]|4[017]|8[0-46-9]|9[012])\\d{7}|(?:3[0347]|55)\\d{8}", "\\d{4,10}", , , "1212345678"],
        [, , "7(?:[1-4]\\d\\d|5(?:0[0-8]|[13-9]\\d|2[0-35-9])|7(?:0[1-9]|[1-7]\\d|8[02-9]|9[0-689])|8(?:[014-9]\\d|[23][0-8])|9(?:[04-9]\\d|1[02-9]|2[0135-9]|3[0-689]))\\d{6}", "\\d{10}", , , "7400123456"],
        [, , "80(?:0(?:1111|\\d{6,7})|8\\d{7})|500\\d{6}", "\\d{7}(?:\\d{2,3})?", , , "8001234567"],
        [, , "(?:87[123]|9(?:[01]\\d|8[0-3]))\\d{7}", "\\d{10}", , , "9012345678"],
        [, , "8(?:4(?:5464\\d|[2-5]\\d{7})|70\\d{7})", "\\d{7}(?:\\d{3})?", , , "8431234567"],
        [, , "70\\d{8}", "\\d{10}", , , "7012345678"],
        [, , "56\\d{8}", "\\d{10}", , , "5612345678"], "GB", 44, "00", "0", " x", , "0", , , , [
            [, "(\\d{2})(\\d{4})(\\d{4})", "$1 $2 $3", ["2|5[56]|7[06]"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["1(?:1|\\d1)|3|9[018]"], "0$1", ""],
            [, "(\\d{5})(\\d{4,5})", "$1 $2", ["1(?:38|5[23]|69|76|94)", "1(?:387|5(?:24|39)|697|768|946)", "1(?:3873|5(?:242|39[456])|697[347]|768[347]|9467)"], "0$1", ""],
            [, "(1\\d{3})(\\d{5,6})", "$1 $2", ["1"], "0$1", ""],
            [, "(7\\d{3})(\\d{6})", "$1 $2", ["7[1-5789]"], "0$1", ""],
            [, "(800)(\\d{4})", "$1 $2", ["800", "8001", "80011", "800111", "8001111"], "0$1", ""],
            [, "(845)(46)(4\\d)", "$1 $2 $3", ["845", "8454", "84546", "845464"], "0$1", ""],
            [, "(8\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["8(?:4[2-5]|7[0-3])"], "0$1", ""],
            [, "(80\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["80"], "0$1", ""],
            [, "([58]00)(\\d{6})", "$1 $2", ["[58]00"], "0$1", ""]
        ], , [, , "76(?:0[012]|2[356]|4[0134]|5[49]|6[0-369]|77|81|9[39])\\d{6}", "\\d{10}", , , "7640123456"], 1],
    GD: [, [, , "[489]\\d{9}", "\\d{7,10}"],
        [, , "473(?:2(?:3[0-2]|69)|3(?:2[89]|86)|4(?:08|3[5-9]|4[0-49]|5[5-79]|68|73|90)|63[68]|7(?:58|84)|938)\\d{4}", "\\d{7,10}", , , "4732691234"],
        [, , "473(?:4(?:0[3-79]|1[04-9]|20|58)|53[3-8])\\d{4}", "\\d{10}", , , "4734031234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GD", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "473"],
    GE: [, [, , "[1-3579]\\d{7}|8\\d{8}", "\\d{3,9}"],
        [, , "(?:122|2(?:22|36|5[03])|3(?:1[0-35-8]|[24-6]\\d|3[1-35679]|7[0-39]|9[1-35-7])|44[2-6])\\d{5}", "\\d{3,8}", , , "32123456"],
        [, , "(?:5[1578]|6[28]|7[0147-9]|9[0135-9])\\d{6}", "\\d{8}", , , "55123456"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GE", 995, "8~10", "8", , , "8", , , , [
            [, "(32)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["32"], "8 $1", ""],
            [, "(\\d{3})(\\d{5})", "$1 $2", ["2|3[13-79]|446"], "8 $1", ""],
            [, "(\\d{4})(\\d{3,4})", "$1 $2", ["44[2-5]"], "8 $1", ""],
            [, "(\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["[5679]"], "8 $1", ""],
            [, "(800)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["8"], "8 $1", ""]
        ], , [, , "NA", "NA"]
    ],
    GF: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GF", 594, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    GG: [, [, , "[15789]\\d{6,9}", "\\d{6,10}"],
        [, , "1481\\d{6}", "\\d{6,10}", , , "1481456789"],
        [, , "7(?:781|839|911)\\d{6}", "\\d{10}", , , "7781123456"],
        [, , "80(?:0(?:1111|\\d{6,7})|8\\d{7})|500\\d{6}", "\\d{7}(?:\\d{2,3})?", , , "8001234567"],
        [, , "(?:87[123]|9(?:[01]\\d|8[0-3]))\\d{7}", "\\d{10}", , , "9012345678"],
        [, , "8(?:4(?:5464\\d|[2-5]\\d{7})|70\\d{7})", "\\d{7}(?:\\d{3})?", , , "8431234567"],
        [, , "70\\d{8}", "\\d{10}", , , "7012345678"],
        [, , "56\\d{8}", "\\d{10}", , , "5612345678"], "GG", 44, "00", "0", " x", , "0", , , , , , [, , "76(?:0[012]|2[356]|4[0134]|5[49]|6[0-369]|77|81|9[39])\\d{6}", "\\d{10}", , , "7640123456"]
    ],
    GH: [, [, , "[235]\\d{6,8}", "\\d{7,9}"],
        [, , "3(?:0[237]\\d|[167](?:2[0-6]|7\\d)|2(?:2[0-5]|7\\d)|3(?:2[0-37]|7\\d)|4(?:[27]\\d|30)|5(?:2[0-7]|7\\d)|8(?:2[0-2]|7\\d)|9(?:20|7\\d))\\d{5}", "\\d{7,9}", , , "302345678"],
        [, , "2(?:(?:[47]\\d|08)\\d{6}|[368]\\d{7})|54\\d{7}", "\\d{9}", , , "231234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GH", 233, "00", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    GI: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GI", 350, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    GL: [, [, , "[1-689]\\d{5}", "\\d{6}"],
        [, , "(?:19|3[1-6]|6[14689]|8[14-79]|9\\d)\\d{4}", "\\d{6}", , , "321000"],
        [, , "[245][2-9]\\d{4}", "\\d{6}", , , "221234"],
        [, , "80\\d{4}", "\\d{6}", , , "801234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "3[89]\\d{4}", "\\d{6}", , , "381234"], "GL", 299, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    GM: [, [, , "[3-9]\\d{6}", "\\d{7}"],
        [, , "(?:4(?:[23]\\d{2}|4(?:1[024679]|[6-9]\\d))|5(?:54[0-7]|6(?:[67]\\d)|7(?:1[04]|2[035]|3[58]|48))|8\\d{3})\\d{3}", "\\d{7}", , , "5661234"],
        [, , "[3679]\\d{6}", "\\d{7}", , , "3012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GM", 220, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    GN: [, [, , "[3567]\\d{7}", "\\d{8}"],
        [, , "30(?:24|3[12]|4[1-35-7]|5[13]|6[189]|[78]1|9[1478])\\d{4}", "\\d{8}", , , "30241234"],
        [, , "55\\d{6}|6(?:0(?:2\\d|3[3467]|5[2457-9])|[2457]\\d{2}|3(?:[14]0|35))\\d{4}", "\\d{8}", , , "60201234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GN", 224, "00", , , , , , , , [
            [, "(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    GP: [, [, , "[56]\\d{8}", "\\d{9}"],
        [, , "590(?:1[12]|2[0-68]|3[28]|4[126-8]|5[067]|6[018]|[89]\\d)\\d{4}", "\\d{9}", , , "590201234"],
        [, , "690(?:00|[3-5]\\d|6[0-57-9]|7[1-6]|8[0-6]|9[09])\\d{4}", "\\d{9}", , , "690301234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GP", 590, "00", "0", , , "0", , , , [
            [, "([56]90)(\\d{2})(\\d{4})", "$1 $2-$3", , "0$1", ""]
        ], , [, , "NA", "NA"], 1],
    GQ: [, [, , "[23589]\\d{8}", "\\d{6,9}"],
        [, , "3(?:3(?:3\\d[7-9]|[0-24-9]\\d[46])|5\\d{2}[7-9])\\d{4}", "\\d{6,9}", , , "333091234"],
        [, , "(?:222|551)\\d{6}", "\\d{6,9}", , , "222123456"],
        [, , "80\\d[1-9]\\d{5}", "\\d{6,9}", , , "800123456"],
        [, , "90\\d[1-9]\\d{5}", "\\d{6,9}", , , "900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GQ", 240, "00", , , , , , , , [
            [, "(\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["[235]"], "", ""],
            [, "(\\d{3})(\\d{6})", "$1 $2", ["[89]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    GR: [, [, , "[26-9]\\d{9}", "\\d{10}"],
        [, , "2(?:1\\d{2}|2(?:3[1-8]|4[1-7]|5[1-4]|6[1-8]|7[1-5]|[289][1-9])|3(?:1\\d|2[1-5]|3[1-4]|[45][1-3]|7[1-7]|8[1-6]|9[1-79])|4(?:1\\d|2[1-8]|3[1-4]|4[13-5]|6[1-578]|9[1-5])|5(?:1\\d|2[1-3]|4[124]|5[1-6]|[39][1-4])|6(?:1\\d|3[24]|4[1-7]|5[13-9]|[269][1-6]|7[14]|8[1-35])|7(?:1\\d|[23][1-5]|4[1-7]|5[1-57]|6[134]|9[15-7])|8(?:1\\d|2[1-5]|[34][1-4]|9[1-7]))\\d{6}", "\\d{10}", , , "2123456789"],
        [, , "69\\d{8}", "\\d{10}", , , "6912345678"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "90[19]\\d{7}", "\\d{10}", , , "9091234567"],
        [, , "8(?:0[16]|12|25)\\d{7}", "\\d{10}", , , "8011234567"],
        [, , "70\\d{8}", "\\d{10}", , , "7012345678"],
        [, , "NA", "NA"], "GR", 30, "00", , , , , , , , [
            [, "([27]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["21|7"], "", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["2[2-9]1|[689]"], "", ""],
            [, "(2\\d{3})(\\d{6})", "$1 $2", ["2[2-9][02-9]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    GT: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GT", 502, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    GU: [, [, , "[689]\\d{9}", "\\d{7,10}"],
        [, , "671(?:3\\d{2}|47\\d|56\\d|6[3-5]\\d|7(?:3\\d|89)|828)\\d{4}", "\\d{7,10}", , , "6713123456"],
        [, , "671(?:3\\d{2}|47\\d|56\\d|6[3-5]\\d|7(?:3\\d|89)|828)\\d{4}", "\\d{7,10}", , , "6713123456"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GU", 1, "011", "1", , , "1", , , 1, , , [, , "NA", "NA"], , "671"],
    GW: [, [, , "[3567]\\d{6}", "\\d{7}"],
        [, , "3(?:2[0125]|3[1245]|4[12]|5[1-4]|70|9[1-467])\\d{4}", "\\d{7}", , , "3201234"],
        [, , "[5-7]\\d{6}", "\\d{7}", , , "5012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GW", 245, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    GY: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "GY", 592, "001", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    HK: [, [, , "[235-7]\\d{7}|8\\d{7,8}|9\\d{7,10}", "\\d{8,11}"],
        [, , "[23]\\d{7}", "\\d{8}", , , "21234567"],
        [, , "[5-79]\\d{7}", "\\d{8}", , , "51234567"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "900\\d{8}", "\\d{11}", , , "90012345678"],
        [, , "NA", "NA"],
        [, , "8[1-3]\\d{6}", "\\d{8}"],
        [, , "NA", "NA"], "HK", 852, "00", , , , , , , , [
            [, "(\\d{4})(\\d{4})", "$1 $2", ["[235-7]|[89](?:0[1-9]|[1-9])"], "", ""],
            [, "(800)(\\d{3})(\\d{3})", "$1 $2 $3", ["800"], "", ""],
            [, "(900)(\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["900"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    HN: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "HN", 504, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    HR: [, [, , "[1-7]\\d{5,8}|[89]\\d{6,11}", "\\d{6,12}"],
        [, , "(?:1|6[029])\\d{7}|(?:2[0-3]|3[1-5]|4[02-47-9]|5[1-3])\\d{6}", "\\d{6,9}", , , "12345678"],
        [, , "9[12589]\\d{6,10}", "\\d{8,12}", , , "912345678"],
        [, , "80[01]\\d{4,7}", "\\d{7,10}", , , "8001234567"],
        [, , "6[145]\\d{4,7}", "\\d{6,9}", , , "611234"],
        [, , "NA", "NA"],
        [, , "7[45]\\d{4,7}", "\\d{6,9}", , , "741234567"],
        [, , "NA", "NA"], "HR", 385, "00", "0", , , "0", , , , [
            [, "(1)(\\d{4})(\\d{3})", "$1 $2 $3", ["1"], "0$1", ""],
            [, "(6[029])(\\d{4})(\\d{3})", "$1 $2 $3", ["6[029]"], "0$1", ""],
            [, "([2-5]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["[2-5]"], "0$1", ""],
            [, "(9[12589])(\\d{3,4})(\\d{3,4})", "$1 $2 $3", ["9"], "0$1", ""],
            [, "(9[12589])(\\d{3,4})(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["9"], "0$1", ""],
            [, "(\\d{2})(\\d{2})(\\d{2,3})", "$1 $2 $3", ["6[145]|7"], "0$1", ""],
            [, "(\\d{2})(\\d{3,4})(\\d{3})", "$1 $2 $3", ["6[145]|7"], "0$1", ""],
            [, "(80[01])(\\d{2})(\\d{2,3})", "$1 $2 $3", ["8"], "0$1", ""],
            [, "(80[01])(\\d{3,4})(\\d{3})", "$1 $2 $3", ["8"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    HT: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "HT", 509, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    HU: [, [, , "\\d{8,9}", "\\d{6,9}"],
        [, , "(?:1\\d|2(?:1\\d|[2-9])|3[2-7]|4[24-9]|5[2-79]|6[23689]|7(?:1\\d|[2-9])|8[2-57-9]|9[2-69])\\d{6}", "\\d{6,9}", , , "12345678"],
        [, , "(?:[237]0|31)\\d{7}", "\\d{9}", , , "201234567"],
        [, , "80\\d{6}", "\\d{8}", , , "80123456"],
        [, , "9[01]\\d{6}", "\\d{8}", , , "90123456"],
        [, , "40\\d{6}", "\\d{8}", , , "40123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "HU", 36, "00", "06", , , "06", , , , [
            [, "(1)(\\d{3})(\\d{4})", "$1 $2 $3", ["1"], "($1)", ""],
            [, "(\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[2-9]"], "($1)", ""]
        ], , [, , "NA", "NA"]
    ],
    ID: [, [, , "[1-9]\\d{6,10}", "\\d{5,11}"],
        [, , "2[124]\\d{7,8}|(?:2(?:[35][1-4]|6[0-8]|7[1-6]|8\\d|9[1-8])|3(?:1|2[1-578]|3[1-68]|4[1-3]|5[1-8]|6[1-3568]|7[0-46]|8\\d)|4(?:0[1-589]|1[01347-9]|2[0-36-8]|3[0-24-68]|5[1-378]|6[1-5]|7[134]|8[1245])|5(?:1[1-35-9]|2[25-8]|3[1246-9]|4[1-3589]|5[1-46]|6[1-8])|6(?:19?|[25]\\d|3[1-469]|4[1-6])|7(?:1[1-46-9]|2[14-9]|[36]\\d|4[1-8]|5[1-9]|7[0-36-9])|9(?:0[12]|1[0134-8]|2[0-479]|5[125-8]|6[23679]|7[159]|8[01346]))\\d{5,8}", "\\d{5,10}", , , "612345678"],
        [, , "8[1-35-9]\\d{7,9}", "\\d{9,11}", , , "812345678"],
        [, , "177\\d{6,8}|800\\d{5,7}", "\\d{8,11}", , , "8001234567"],
        [, , "809\\d{7}", "\\d{10}", , , "8091234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ID", 62, "0(?:0[1789]|10(?:00|1[67]))", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{7,8})", "$1 $2", ["2[124]|[36]1"], "(0$1)", ""],
            [, "(\\d{3})(\\d{5,7})", "$1 $2", ["[4579]|2[035-9]|[36][02-9]"], "(0$1)", ""],
            [, "(8\\d{2})(\\d{3,4})(\\d{3,4})", "$1-$2-$3", ["8[1-35-9]"], "0$1", ""],
            [, "(177)(\\d{6,8})", "$1 $2", ["1"], "0$1", ""],
            [, "(800)(\\d{5,7})", "$1 $2", ["800"], "0$1", ""],
            [, "(809)(\\d)(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["809"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    IE: [, [, , "[124-9]\\d{6,9}", "\\d{5,10}"],
        [, , "1\\d{7,8}|(?:2[24-9]|4(?:0[24]|7)|5(?:0[45]|8)|6[237-9]|9[3-9])\\d{5}|(?:45|[569]1|818)\\d{6}|(?:4[12469]|5[3679]|6[56]|7[14]|9[04])\\d{7}|21\\d{6,7}|(?:23|4[34]|52|64)\\d{5,7}|48\\d{8}", "\\d{5,10}", , , "2212345"],
        [, , "8[35-9]\\d{7}", "\\d{9}", , , "850123456"],
        [, , "1800\\d{6}", "\\d{10}", , , "1800123456"],
        [, , "15(?:1[2-9]|[2-8]0|59|9[089])\\d{6}", "\\d{10}", , , "1520123456"],
        [, , "18[59]0\\d{6}", "\\d{10}", , , "1850123456"],
        [, , "700\\d{6}", "\\d{9}", , , "700123456"],
        [, , "76\\d{7}", "\\d{9}", , , "761234567"], "IE", 353, "00", "0", , , "0", , , , [
            [, "(1)(\\d{3,4})(\\d{4})", "$1 $2 $3", ["1"], "(0$1)", ""],
            [, "(\\d{2})(\\d{5})", "$1 $2", ["2[2-9]|4[347]|5[2-58]|6[2-47-9]|9[3-9]"], "(0$1)", ""],
            [, "(\\d{3})(\\d{5})", "$1 $2", ["40[24]|50[45]"], "(0$1)", ""],
            [, "(48)(\\d{4})(\\d{4})", "$1 $2 $3", ["48"], "(0$1)", ""],
            [, "(818)(\\d{3})(\\d{3})", "$1 $2 $3", ["81"], "(0$1)", ""],
            [, "(\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[24-69]|7[14]"], "(0$1)", ""],
            [, "([78]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["76|8[35-9]"], "0$1", ""],
            [, "(700)(\\d{3})(\\d{3})", "$1 $2 $3", ["70"], "0$1", ""],
            [, "(\\d{4})(\\d{3})(\\d{3})", "$1 $2 $3", ["1(?:8[059]|5)", "1(?:8[059]0|5)"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    IL: [, [, , "[1-57-9]\\d{6,9}", "\\d{7,10}"],
        [, , "(?:[2-489]|7[2-46-8])\\d{7}", "\\d{7,9}", , , "21234567"],
        [, , "5[024679]\\d{7}", "\\d{9}", , , "501234567"],
        [, , "1(?:80[01]\\d{3}|255)\\d{3}", "\\d{7,10}", , , "1800123456"],
        [, , "1(?:212|(?:919|200)\\d{2})\\d{4}", "\\d{8,10}", , , "1919123456"],
        [, , "1(?:700|809)\\d{6}", "\\d{10}", , , "1700123456"],
        [, , "NA", "NA"],
        [, , "77\\d{7}", "\\d{9}", , , "771234567"], "IL", 972, "0(?:0|1[2-48])", "0", , , "0", , , , [
            [, "([2-489])(\\d{3})(\\d{4})", "$1-$2-$3", ["[2-489]"], "0$1", ""],
            [, "([57]\\d)(\\d{3})(\\d{4})", "$1-$2-$3", ["[57]"], "0$1", ""],
            [, "(1)([7-9]\\d{2})(\\d{3})(\\d{3})", "$1-$2-$3-$4", ["1[7-9]"], "$1", ""],
            [, "(1255)(\\d{3})", "$1-$2", ["125"], "$1", ""],
            [, "(1200)(\\d{3})(\\d{3})", "$1-$2-$3", ["120"], "$1", ""],
            [, "(1212)(\\d{2})(\\d{2})", "$1-$2-$3", ["121"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    IM: [, [, , "[15789]\\d{6,9}", "\\d{6,10}"],
        [, , "1624\\d{6}", "\\d{6,10}", , , "1624456789"],
        [, , "7[569]24\\d{6}", "\\d{10}", , , "7924123456"],
        [, , "80(?:0(?:1111|\\d{6,7})|8\\d{7})|500\\d{6}", "\\d{7}(?:\\d{2,3})?", , , "8001234567"],
        [, , "(?:87[123]|9(?:[01]\\d|8[0-3]))\\d{7}", "\\d{10}", , , "9012345678"],
        [, , "8(?:4(?:5464\\d|[2-5]\\d{7})|70\\d{7})", "\\d{7}(?:\\d{3})?", , , "8431234567"],
        [, , "70\\d{8}", "\\d{10}", , , "7012345678"],
        [, , "56\\d{8}", "\\d{10}", , , "5612345678"], "IM", 44, "00", "0", " x", , "0", , , , , , [, , "7624\\d{6}", "\\d{10}", , , "7624123456"]
    ],
    IN: [, [, , "[1-9]\\d{9,10}", "\\d{6,11}"],
        [, , "(?:11|2[02]|33|4[04]|79|80)[2-6]\\d{7}|(?:1(?:2[0-249]|3[0-25]|4[145]|[59][14]|6[014]|7[1257]|8[01346])|2(?:1[257]|3[013]|4[01]|5[0137]|6[0158]|78|8[1568]|9[14])|3(?:26|4[1-3]|5[34]|6[01489]|7[02-46]|8[159])|4(?:1[36]|2[1-47]|3[15]|5[12]|6[126-9]|7[0-24-9]|8[013-57]|9[014-7])|5(?:[136][25]|22|4[28]|5[12]|[78]1|9[15])|6(?:12|[2345]1|57|6[13]|7[14]|80)|7(?:12|2[14]|3[134]|4[47]|5[15]|[67]1|88)|8(?:16|2[014]|3[126]|6[136]|7[078]|8[34]|91))[2-6]\\d{6}|(?:(?:1(?:2[35-8]|3[346-9]|4[236-9]|[59][0235-9]|6[235-9]|7[34689]|8[257-9])|2(?:1[134689]|3[24-8]|4[2-8]|5[25689]|6[2-4679]|7[13-79]|8[2-479]|9[235-9])|3(?:01|1[79]|2[1-5]|4[25-8]|5[125689]|6[235-7]|7[157-9]|8[2-467])|4(?:1[14578]|2[5689]|3[2-467]|5[4-7]|6[35]|73|8[2689]|9[2389])|5(?:[16][146-9]|2[14-8]|3[1346]|4[14-69]|5[46]|7[2-4]|8[2-8]|9[246])|6(?:1[1358]|2[2457]|3[2-4]|4[235-7]|5[2-689]|6[24-58]|7[23-689]|8[1-6])|8(?:1[1357-9]|2[235-8]|3[03-57-9]|4[0-24-9]|5\\d|6[2457-9]|7[1-6]|8[1256]|9[2-4]))\\d|7(?:(?:1[013-9]|2[0235-9]|3[2679]|4[1-35689]|5[2-46-9]|[67][02-9]|9\\d)\\d|8(?:2[0-6]|[013-8]\\d)))[2-6]\\d{5}", "\\d{6,10}", , , "1123456789"],
        [, , "(?:7(?:39[89]|5(?:50|6[6-8]|79|[89][7-9])|6(?:0[027]|20|3[19]|54|65|7[67]|9[6-9])|7(?:0[89]|3[589]|42|60|9[5-9])|8(?:[03][07-9]|14|2[7-9]|4[25]|6[09]))\\d|9\\d{4}|8(?:(?:0[01589]|1[024])\\d|8(?:[079]\\d|44)|9[057-9]\\d)\\d)\\d{5}", "\\d{10}", , , "9123456789"],
        [, , "1(?:800\\d?|600)\\d{6}", "\\d{10,11}", , , "1800123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "IN", 91, "00", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{2})(\\d{6})", "$1 $2 $3", ["7(?:39|5[5-9]|[67][02-9]|8[0-6])|8(?:0[01589]|1[024]|8[0479]|9[057-9])|9", "7(?:39|5(?:50|[6-9])|[67][02-9]|8[0-6])|8(?:0[01589]|1[024]|8(?:[079]|44)|9[057-9])|9"], "0$1", ""],
            [, "(\\d{2})(\\d{4})(\\d{4})", "$1 $2 $3", ["11|2[02]|33|4[04]|79|80[2-6]"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["1(?:2[0-249]|3[0-25]|4[145]|[569][14]|7[1257]|8[1346]|[68][1-9])"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["2(?:1[257]|3[013]|4[01]|5[0137]|6[0158]|78|8[1568]|9[14])"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["3(?:26|4[1-3]|5[34]|6[01489]|7[02-46]|8[159])"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["4(?:1[36]|2[1-47]|3[15]|5[12]|6[126-9]|7[0-24-9]|8[013-57]|9[014-7])"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["5(?:[136][25]|22|4[28]|5[12]|[78]1|9[15])"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["6(?:12|[2345]1|57|6[13]|7[14]|80)"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["7(?:12|2[14]|3[134]|4[47]|5[15]|[67]1|88)", "7(?:12|2[14]|3[134]|4[47]|5(?:1|5[1-9])|[67]1|88)"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["8(?:16|2[014]|3[126]|6[136]|7[078]|8[34]|91)"], "0$1", ""],
            [, "(\\d{4})(\\d{3})(\\d{3})", "$1 $2 $3", ["1(?:[2-579]|[68][1-9])|[2-8]"], "0$1", ""],
            [, "(1600)(\\d{2})(\\d{4})", "$1 $2 $3", ["160", "1600"], "$1", ""],
            [, "(1800)(\\d{2,3})(\\d{4})", "$1 $2 $3", ["180", "1800"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    IO: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "IO", 246, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    IQ: [, [, , "[1-7]\\d{7,9}", "\\d{6,10}"],
        [, , "1\\d{7}|(?:2[13-5]|3[02367]|4[023]|5[03]|6[026])\\d{6,7}", "\\d{6,9}", , , "12345678"],
        [, , "7[5-9]\\d{8}", "\\d{10}", , , "7912345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "IQ", 964, "00", "0", , , "0", , , , [
            [, "(1)(\\d{3})(\\d{4})", "$1 $2 $3", ["1"], "0$1", ""],
            [, "([2-6]\\d)(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[2-6]"], "0$1", ""],
            [, "(7[5-9]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["7"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    IR: [, [, , "[1-9]\\d{9}", "\\d{7,10}"],
        [, , "[1-8]\\d{9}", "\\d{7,10}", , , "2123456789"],
        [, , "9(?:1\\d|3[1-8])\\d{7}", "\\d{10}", , , "9123456789"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "IR", 98, "00", "0", , , "0", , , , [
            [, "(21)(\\d{4})(\\d{4})", "$1 $2 $3", ["21"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["[13-89]|2[02-9]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    IS: [, [, , "[4-9]\\d{6}|38\\d{7}", "\\d{7,9}"],
        [, , "(?:4(?:1[0-245]|2[0-7]|[37][0-8]|4[0245]|5[0-356]|6\\d|8[0-46-8]|9[013-79])|5(?:05|[156]\\d|2[02578]|3[013-6]|4[03-6]|7[0-2578]|8[0-25-9]|9[013-689])|87[23])\\d{4}", "\\d{7}", , , "4101234"],
        [, , "38[59]\\d{6}|(?:6(?:1[014-8]|2[0-8]|3[0-27-9]|4[0-29]|5[029]|[67][0-69]|[89]\\d)|7(?:5[057]|7[0-7])|8(?:2[0-5]|[469]\\d|5[1-9]))\\d{4}", "\\d{7,9}", , , "6101234"],
        [, , "800\\d{4}", "\\d{7}", , , "8001234"],
        [, , "90\\d{5}", "\\d{7}", , , "9011234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "49[013-79]\\d{4}", "\\d{7}", , , "4931234"], "IS", 354, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", ["[4-9]"], "", ""],
            [, "(3\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["3"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    IT: [, [, , "[01389]\\d{5,10}", "\\d{6,11}"],
        [, , "0\\d{7,10}", "\\d{8,11}", , , "0212345678"],
        [, , "3\\d{8,9}", "\\d{9,10}", , , "312345678"],
        [, , "80(?:0\\d{6}|3\\d{3})", "\\d{6,9}", , , "800123456"],
        [, , "89(?:2\\d{3}|9\\d{6})", "\\d{6,9}", , , "899123456"],
        [, , "84[78]\\d{6,7}", "\\d{9,10}", , , "8481234567"],
        [, , "178\\d{6,7}", "\\d{9,10}", , , "1781234567"],
        [, , "NA", "NA"], "IT", 39, "00", , , , , , , , [
            [, "(0[26])(\\d{3,4})(\\d{4})", "$1 $2 $3", ["0[26]"], "", ""],
            [, "(0[26])(\\d{4})(\\d{5})", "$1 $2 $3", ["0[26]"], "", ""],
            [, "(0[26])(\\d{6})", "$1 $2", ["0[26]"], "", ""],
            [, "(0\\d{2})(\\d{3,4})(\\d{4})", "$1 $2 $3", ["0(?:[13-57-9][0159]|36)"], "", ""],
            [, "(0\\d{2})(\\d{5,6})", "$1 $2", ["0(?:[13-57-9][0159]|36)"], "", ""],
            [, "(0\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["0[13-57-9]"], "", ""],
            [, "(0\\d{3})(\\d{4,6})", "$1 $2", ["0[13-57-9]"], "", ""],
            [, "(\\d{3})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[13]|8(?:00|4[78])"], "", ""],
            [, "(\\d{3})(\\d{3,6})", "$1 $2", ["8(?:03|9)"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    JE: [, [, , "[15789]\\d{6,9}", "\\d{6,10}"],
        [, , "1534\\d{6}", "\\d{6,10}", , , "1534456789"],
        [, , "7(?:509|7(?:00|97)|829|937)\\d{6}", "\\d{10}", , , "7797123456"],
        [, , "80(?:0(?:1111|\\d{6,7})|8\\d{7})|500\\d{6}", "\\d{7}(?:\\d{2,3})?", , , "8001234567"],
        [, , "(?:87[123]|9(?:[01]\\d|8[0-3]))\\d{7}", "\\d{10}", , , "9012345678"],
        [, , "8(?:4(?:5464\\d|[2-5]\\d{7})|70\\d{7})", "\\d{7}(?:\\d{3})?", , , "8431234567"],
        [, , "701511\\d{4}", "\\d{10}", , , "7015115678"],
        [, , "56\\d{8}", "\\d{10}", , , "5612345678"], "JE", 44, "00", "0", " x", , "0", , , , , , [, , "76(?:0[012]|2[356]|4[0134]|5[49]|6[0-369]|77|81|9[39])\\d{6}", "\\d{10}", , , "7640123456"]
    ],
    JM: [, [, , "[89]\\d{9}", "\\d{7,10}"],
        [, , "876(?:(?:5[0-26]|6\\d|7[1-6]|9[2-8])\\d{5}|(?:7(?:0[2-689]|8[056]|9[45])|9(?:0[1-8]|1[02378]|9[2-468]))\\d{4})", "\\d{7,10}", , , "8765123456"],
        [, , "876(?:(?:21|[348]\\d|5[78]|77)\\d|7(?:0[07]|8[1-47-9]|9[0-36-9])|9(?:[01]9|9[0579]))\\d{4}", "\\d{10}", , , "8762101234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "JM", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "876"],
    JO: [, [, , "[235-9]\\d{7,8}", "\\d{7,9}"],
        [, , "[2356][2-8]\\d{6}", "\\d{7,8}", , , "62345678"],
        [, , "7(?:4[5-7]|55|7[5-79]|8[5-8]|9[05-9])\\d{6}", "\\d{9}", , , "790123456"],
        [, , "80\\d{6}", "\\d{8}", , , "80012345"],
        [, , "90\\d{6}", "\\d{8}", , , "90012345"],
        [, , "(?:8[57]\\d|810)\\d{5}", "\\d{8}", , , "85012345"],
        [, , "70\\d{7}", "\\d{9}", , , "700123456"],
        [, , "NA", "NA"], "JO", 962, "00", "0", , , "0", , , , [
            [, "([2356])(\\d{3})(\\d{4})", "$1 $2 $3", ["[2356]"], "(0$1)", ""],
            [, "(7)(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4 $5", ["7[457-9]"], "0$1", ""],
            [, "(\\d{3})(\\d{5,6})", "$1 $2", ["70|[89]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    JP: [, [, , "\\d{9,10}", "\\d{9,10}"],
        [, , "(?:1[1-9][1-9]|9(?:[3-9][1-9]|2\\d)|(?:[36][1-9]|[24578][2-9])\\d)\\d{6}", "\\d{9}", , , "312345678"],
        [, , "[7-9]0\\d{8}", "\\d{10}", , , "7012345678"],
        [, , "120\\d{6}", "\\d{9}", , , "120123456"],
        [, , "990\\d{6}", "\\d{9}", , , "990123456"],
        [, , "NA", "NA"],
        [, , "60\\d{7}", "\\d{9}", , , "601234567"],
        [, , "50\\d{8}", "\\d{10}", , , "5012345678"], "JP", 81, "010", "0", , , "0", , , , [
            [, "(\\d{3})(\\d{3})(\\d{3})", "$1-$2-$3", ["(?:12|99)0"], "0$1", ""],
            [, "(\\d{2})(\\d{4})(\\d{4})", "$1-$2-$3", ["[57-9]0"], "0$1", ""],
            [, "(\\d{4})(\\d)(\\d{4})", "$1-$2-$3", ["1(?:26|3[79]|4[56]|5[4-68]|6[3-5])|5(?:76|97)|499|746|8(?:3[89]|63|47|51)|9(?:49|80|9[16])", "1(?:267|3(?:7[247]|9[278])|4(?:5[67]|66)|5(?:47|58|64|8[67])|6(?:3[245]|48|5[4-68]))|5(?:76|97)9|499[2468]|7468|8(?:3(?:8[78]|96)|636|477|51[24])|9(?:496|802|9(?:1[23]|69))", "1(?:267|3(?:7[247]|9[278])|4(?:5[67]|66)|5(?:47|58|64|8[67])|6(?:3[245]|48|5[4-68]))|5(?:769|979[2-69])|499[2468]|7468|8(?:3(?:8[78]|96[2457-9])|636[2-57-9]|477|51[24])|9(?:496|802|9(?:1[23]|69))"], "0$1", ""],
            [, "(\\d{3})(\\d{2})(\\d{4})", "$1-$2-$3", ["1(?:2[3-6]|3[3-9]|4[2-6]|5[2-8]|[68][2-7]|7[2-689]|9[1-578])|2(?:2[034-9]|3[3-58]|4[0-468]|5[04-8]|6[013-8]|7[06-9]|8[02-57-9]|9[13])|4(?:2[28]|3[689]|6[035-7]|7[05689]|80|9[3-5])|5(?:3[1-36-9]|4[4578]|5[013-8]|6[1-9]|7[2-8]|8[14-7]|9[4-9])|7(?:2[15]|3[5-9]|4[02-9]|6[135-8]|7[0-4689]|9[014-9])|8(?:2[49]|3[3-8]|4[5-8]|5[2-9]|6[35-9]|7[579]|8[03-579]|9[2-8])|9(?:[23]0|4[02-46-9]|5[0245-79]|6[4-9]|7[2-47-9]|8[02-7]|9[3-7])", "1(?:2[3-6]|3[3-9]|4[2-6]|5(?:[236-8]|[45][2-69])|[68][2-7]|7[2-689]|9[1-578])|2(?:2(?:[04-9]|3[23])|3[3-58]|4[0-468]|5(?:5[78]|7[2-4]|[0468][2-9])|6(?:[0135-8]|4[2-5])|7(?:[0679]|8[2-7])|8(?:[024578]|3[25-9]|9[6-9])|9(?:11|3[2-4]))|4(?:2(?:2[2-9]|8[237-9])|3[689]|6[035-7]|7(?:[059][2-8]|[68])|80|9[3-5])|5(?:3[1-36-9]|4[4578]|5[013-8]|6[1-9]|7[2-8]|8[14-7]|9(?:[89][2-8]|[4-7]))|7(?:2[15]|3[5-9]|4[02-9]|6[135-8]|7[0-4689]|9(?:[017-9]|4[6-8]|5[2-478]|6[2-589]))|8(?:2(?:4[4-8]|9[2-8])|3(?:7[2-56]|[3-6][2-9]|8[2-5])|4[5-8]|5[2-9]|6(?:[37]|5[4-7]|6[2-9]|8[2-8]|9[236-9])|7[579]|8[03-579]|9[2-8])|9(?:[23]0|4[02-46-9]|5[0245-79]|6[4-9]|7[2-47-9]|8[02-7]|9(?:3[34]|[4-7]))", "1(?:2[3-6]|3[3-9]|4[2-6]|5(?:[236-8]|[45][2-69])|[68][2-7]|7[2-689]|9[1-578])|2(?:2(?:[04-9]|3[23])|3[3-58]|4[0-468]|5(?:5[78]|7[2-4]|[0468][2-9])|6(?:[0135-8]|4[2-5])|7(?:[0679]|8[2-7])|8(?:[024578]|3[25-9]|9[6-9])|9(?:11|3[2-4]))|4(?:2(?:2[2-9]|8[237-9])|3[689]|6[035-7]|7(?:[059][2-8]|[68])|80|9[3-5])|5(?:3[1-36-9]|4[4578]|5[013-8]|6[1-9]|7[2-8]|8[14-7]|9(?:[89][2-8]|[4-7]))|7(?:2[15]|3[5-9]|4[02-9]|6[135-8]|7[0-4689]|9(?:[017-9]|4[6-8]|5[2-478]|6[2-589]))|8(?:2(?:4[4-8]|9(?:[3578]|20|4[04-9]|6[56]))|3(?:7(?:[2-5]|6[0-59])|[3-6][2-9]|8[2-5])|4[5-8]|5[2-9]|6(?:[37]|5(?:[467]|5[014-9])|6(?:[2-8]|9[02-69])|8[2-8]|9(?:[236-8]|9[23]))|7[579]|8[03-579]|9[2-8])|9(?:[23]0|4[02-46-9]|5[0245-79]|6[4-9]|7[2-47-9]|8[02-7]|9(?:3(?:3[02-9]|4[0-24689])|4[2-69]|[5-7]))", "1(?:2[3-6]|3[3-9]|4[2-6]|5(?:[236-8]|[45][2-69])|[68][2-7]|7[2-689]|9[1-578])|2(?:2(?:[04-9]|3[23])|3[3-58]|4[0-468]|5(?:5[78]|7[2-4]|[0468][2-9])|6(?:[0135-8]|4[2-5])|7(?:[0679]|8[2-7])|8(?:[024578]|3[25-9]|9[6-9])|9(?:11|3[2-4]))|4(?:2(?:2[2-9]|8[237-9])|3[689]|6[035-7]|7(?:[059][2-8]|[68])|80|9[3-5])|5(?:3[1-36-9]|4[4578]|5[013-8]|6[1-9]|7[2-8]|8[14-7]|9(?:[89][2-8]|[4-7]))|7(?:2[15]|3[5-9]|4[02-9]|6[135-8]|7[0-4689]|9(?:[017-9]|4[6-8]|5[2-478]|6[2-589]))|8(?:2(?:4[4-8]|9(?:[3578]|20|4[04-9]|6(?:5[25]|60)))|3(?:7(?:[2-5]|6[0-59])|[3-6][2-9]|8[2-5])|4[5-8]|5[2-9]|6(?:[37]|5(?:[467]|5[014-9])|6(?:[2-8]|9[02-69])|8[2-8]|9(?:[236-8]|9[23]))|7[579]|8[03-579]|9[2-8])|9(?:[23]0|4[02-46-9]|5[0245-79]|6[4-9]|7[2-47-9]|8[02-7]|9(?:3(?:3[02-9]|4[0-24689])|4[2-69]|[5-7]))"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{4})", "$1-$2-$3", ["1|2(?:23|5[5-89]|64|78|8[39]|91)|4(?:2[2689]|64|7[347])|5(?:[2-589]|39)|8(?:[46-9]|3[279]|2[124589])|9(?:[235-8]|93)", "1|2(?:23|5(?:[57]|[68]0|9[19])|64|78|8[39]|917)|4(?:2(?:[68]|20|9[178])|64|7[347])|5(?:[2-589]|39[67])|8(?:[46-9]|3[279]|2[124589])|9(?:[235-8]|93[34])", "1|2(?:23|5(?:[57]|[68]0|9(?:17|99))|64|78|8[39]|917)|4(?:2(?:[68]|20|9[178])|64|7[347])|5(?:[2-589]|39[67])|8(?:[46-9]|3[279]|2[124589])|9(?:[235-8]|93(?:31|4))"], "0$1", ""],
            [, "(\\d{3})(\\d{2})(\\d{4})", "$1-$2-$3", ["2(?:9[14-79]|74|[34]7|[56]9)|82|993"], "0$1", ""],
            [, "(\\d)(\\d{4})(\\d{4})", "$1-$2-$3", ["[36]|4(?:2[09]|7[01])"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{4})", "$1-$2-$3", ["[2479]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    KE: [, [, , "\\d{6,10}", "\\d{4,10}"],
        [, , "(?:20|4[0-6]|5\\d|6[0-24-9])\\d{4,7}", "\\d{4,9}", , , "202012345"],
        [, , "7(?:1[0-6]|2\\d|3[2-8]|5[0-2]|7[023])\\d{6}", "\\d{9}", , , "712123456"],
        [, , "8(?:00|88)\\d{6,7}", "\\d{9,10}", , , "800123456"],
        [, , "9(?:00|1)\\d{6,7}", "\\d{8,10}", , , "900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KE", 254, "000", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{4,7})", "$1 $2", ["[2-6]|91"], "0$1", ""],
            [, "(\\d{3})(\\d{6,7})", "$1 $2", ["[78]|90"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    KG: [, [, , "[356-8]\\d{8}", "\\d{5,9}"],
        [, , "(?:3(?:1(?:2\\d|3[1-9]|52|6[1-8])|2(?:22|3[0-479]|6[0-7])|4(?:22|5[6-9]|6[0-4])|5(?:22|3[4-7]|59|6[0-5])|6(?:22|5[35-7]|6[0-3])|7(?:22|3[468]|4[1-8]|59|6\\d|7[5-7])|9(?:22|4[1-7]|6[0-8]))|6(?:09|12|2[2-4])\\d)\\d{5}", "\\d{5,9}", , , "312123456"],
        [, , "5[124-7]\\d{7}|7(?:0[05]|7\\d)\\d{6}", "\\d{9}", , , "700123456"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KG", 996, "00", "0", , , "0", , , , [
            [, "(\\d{3})(\\d{3})(\\d{3})", "$1 $2 $3", ["31[25]|[5-8]"], "0$1", ""],
            [, "(\\d{4})(\\d{5})", "$1 $2", ["3(?:1[36]|[2-9])"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    KH: [, [, , "[1-9]\\d{7,9}", "\\d{6,10}"],
        [, , "(?:2[3-6]|3[2-6]|4[2-4]|[5-7][2-5])[2-47-9]\\d{5}", "\\d{6,8}", , , "23456789"],
        [, , "(?:(?:1[0-35-9]|9[1-49])[1-9]|85[2-689])\\d{5}", "\\d{8}", , , "91234567"],
        [, , "1800(?:1\\d|2[09])\\d{4}", "\\d{10}", , , "1800123456"],
        [, , "1900(?:1\\d|2[09])\\d{4}", "\\d{10}", , , "1900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KH", 855, "00[178]", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["1\\d[1-9]|[2-9]"], "0$1", ""],
            [, "(1[89]00)(\\d{3})(\\d{3})", "$1 $2 $3", ["1[89]0"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    KI: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KI", 686, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    KM: [, [, , "[37]\\d{6}", "\\d{7}"],
        [, , "7(?:6[0-37-9]|7[0-57-9])\\d{4}", "\\d{7}", , , "7712345"],
        [, , "3[23]\\d{5}", "\\d{7}", , , "3212345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KM", 269, "00", , , , , , , , [
            [, "(\\d)(\\d{3})(\\d{3})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    KN: [, [, , "[89]\\d{9}", "\\d{7,10}"],
        [, , "869(?:2(?:29|36)|4(?:6[5-9]|70))\\d{4}", "\\d{7,10}", , , "8692361234"],
        [, , "869(?:5(?:5[6-8]|6[5-7])|66[2-9]|76[2-5])\\d{4}", "\\d{10}", , , "8695561234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KN", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "869"],
    KP: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KP", 850, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    KR: [, [, , "[1-79]\\d{3,9}|8\\d{8}", "\\d{4,10}"],
        [, , "1(?:5(?:44|66|77|88|99)|6(?:00|44|6[16]|70|88))\\d{4}|(?:2|[34][1-3]|5[1-5]|6[1-4])(?:1\\d{2,3}|[2-9]\\d{6,7})", "\\d{4,10}", , , "22123456"],
        [, , "1[0-25-9]\\d{7,8}", "\\d{9,10}", , , "1023456789"],
        [, , "80\\d{7}", "\\d{9}", , , "801234567"],
        [, , "60[2-9]\\d{6}", "\\d{9}", , , "602345678"],
        [, , "NA", "NA"],
        [, , "50\\d{8}", "\\d{10}", , , "5012345678"],
        [, , "70\\d{8}", "\\d{10}", , , "7012345678"], "KR", 82, "00(?:[124-68]|[37]\\d{2})", "0", , , "0(?:8[1-46-8]|85\\d{2})?", , , , [
            [, "(\\d{2})(\\d{4})(\\d{4})", "$1-$2-$3", ["1(?:0|1[19]|[69]9|5[458])|[57]0", "1(?:0|1[19]|[69]9|5(?:44|59|8))|[57]0"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{4})", "$1-$2-$3", ["1(?:[169][2-8]|[78]|5[1-4])|[68]0|[3-9][1-9][2-9]", "1(?:[169][2-8]|[78]|5(?:[1-3]|4[56]))|[68]0|[3-9][1-9][2-9]"], "0$1", ""],
            [, "(\\d{3})(\\d)(\\d{4})", "$1-$2-$3", ["131", "1312"], "0$1", ""],
            [, "(\\d{3})(\\d{2})(\\d{4})", "$1-$2-$3", ["131", "131[13-9]"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1-$2-$3", ["13[2-9]"], "0$1", ""],
            [, "(\\d{2})(\\d{2})(\\d{3})(\\d{4})", "$1-$2-$3-$4", ["30"], "0$1", ""],
            [, "(\\d)(\\d{4})(\\d{4})", "$1-$2-$3", ["2(?:[26]|3[0-467])", "2(?:[26]|3(?:01|1[45]|2[17-9]|39|4|6[67]|7[078]))"], "0$1", ""],
            [, "(\\d)(\\d{3})(\\d{4})", "$1-$2-$3", ["2(?:3[0-35-9]|[457-9])", "2(?:3(?:0[02-9]|1[0-36-9]|2[02-6]|3[0-8]|6[0-589]|7[1-69]|[589])|[457-9])"], "0$1", ""],
            [, "(\\d)(\\d{3,4})", "$1-$2", ["21[0-46-9]"], "0$1", ""],
            [, "(\\d{2})(\\d{3,4})", "$1-$2", ["[3-9][1-9]1", "[3-9][1-9]1(?:[0-46-9])"], "0$1", ""],
            [, "(\\d{4})(\\d{4})", "$1-$2", ["1(?:5[46-9]|6[04678])", "1(?:5(?:44|66|77|88|99)|6(?:00|44|6[16]|70|88))"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    KW: [, [, , "[12569]\\d{6,7}", "\\d{7,8}"],
        [, , "(?:18\\d|2(?:[23]\\d{2}|4[1-35-9]\\d|5(?:0[034]|[2-46]\\d|5[1-3]|7[1-7])))\\d{4}", "\\d{7,8}", , , "22345678"],
        [, , "(?:5[05]|6[05-7]|9[0479])\\d{6}", "\\d{8}", , , "50012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KW", 965, "00", "0", , , "0", , , , [
            [, "(\\d{4})(\\d{3,4})", "$1 $2", ["[1269]"], "0$1", ""],
            [, "(5[05]\\d)(\\d{5})", "$1 $2", ["5"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    KY: [, [, , "[389]\\d{9}", "\\d{7,10}"],
        [, , "345(?:2(?:22|44)|444|6(?:23|38|40)|7(?:6[6-9]|77)|8(?:00|1[45]|25|4[89]|88)|9(?:14|4[035-9]))\\d{4}", "\\d{7,10}", , , "3452221234"],
        [, , "345(?:32[3-79]|5(?:1[467]|2[5-7]|4[5-9])|9(?:1[679]|2[4-9]|3[89]))\\d{4}", "\\d{10}", , , "3453231234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}|345976\\d{4}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KY", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "345"],
    KZ: [, [, , "(?:[67]\\d{2}|80[09])\\d{7}", "\\d{10}"],
        [, , "7(?:1(?:0(?:[23]\\d|4[023]|59|63)|1(?:[23]\\d|4[0-79]|59)|2(?:[23]\\d|59)|3(?:2\\d|3[1-7]|4[1235-9]|59)|4(?:2\\d|3[013-79]|4[0-58]|5[1-79])|5(?:2\\d|3[1-8]|4[1-7]|59)|6(?:22|[34]\\d|5[19])|72\\d|8(?:[27]\\d|3[1-46-9]|4[0-4]|))|2(?:1(?:[23]\\d|4[46-9]|5[3469])|2(?:2\\d|3[0679]|46|5[12679]|)|3(?:[234]\\d|5[139]|)|4(?:22|3[1235-8])|5(?:[23]\\d|4[0124-8]|59)|6(?:22|3[1-9]|4[0-4]|59)|7(?:[23]\\d|40|5[279]|7\\d)|8(?:[23]\\d|4[0-3]|59)|9(?:2\\d|3[12478]|59))|3622)\\d{5}", "\\d{10}", , , "7123456789"],
        [, , "7(?:0[01257]\\d{2}|1[2-578]9[01]|2(?:[13-6]9[01]|7(?:58|9[01]))|6[02-4]\\d{2}|7[157]\\d{2})\\d{5}|6\\d{9}", "\\d{10}", , , "7129012345"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "809\\d{7}", "\\d{10}", , , "8091234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "KZ", 7, "8~10", "8", , , "8", , , , , , [, , "NA", "NA"]
    ],
    LA: [, [, , "[2-57]\\d{7,9}", "\\d{6,10}"],
        [, , "(?:[2-57]1|54)\\d{6}", "\\d{6,8}", , , "21212862"],
        [, , "20(?:[23]|5[4-6]|77|9[89])\\d{6}", "\\d{9,10}", , , "202345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LA", 856, "00", "0", , , "0", , , , [
            [, "(20)([23])(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["20[23]"], "0$1", ""],
            [, "(20)([579]\\d)(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["20[579]"], "0$1", ""],
            [, "([2-57]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["21|[3-57]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    LB: [, [, , "[13-9]\\d{6,7}", "\\d{7,8}"],
        [, , "(?:[14-6]\\d|[7-9][2-9])\\d{5}", "\\d{7}", , , "1123456"],
        [, , "(?:3\\d|7(?:0\\d|1[167]))\\d{5}", "\\d{7,8}", , , "71123456"],
        [, , "NA", "NA"],
        [, , "8[01]\\d{6}", "\\d{8}", , , "80123456"],
        [, , "9[01]\\d{6}", "\\d{8}", , , "90123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LB", 961, "00", "0", , , "0", , , , [
            [, "([13-6])(\\d{3})(\\d{3})", "$1 $2 $3", ["[13-6]"], "0$1", ""],
            [, "([7-9][01])(\\d{3})(\\d{3})", "$1 $2 $3", ["[7-9][01]"], "0$1", ""],
            [, "([7-9][2-9])(\\d{2})(\\d{3})", "$1 $2 $3", ["[7-9][2-9]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    LC: [, [, , "[789]\\d{9}", "\\d{7,10}"],
        [, , "758(?:234|4(?:5[0-9]|6[2-9]|8[0-2])|638|758)\\d{4}", "\\d{7,10}", , , "7582345678"],
        [, , "758(?:28[4-7]|384|4(?:6[01]|8[4-9])|5(?:1[89]|20|84)|7(?:1[2-9]|2[0-4]))\\d{4}", "\\d{10}", , , "7582845678"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LC", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "758"],
    LI: [, [, , "(?:66|80|90)\\d{7}|[237-9]\\d{6}", "\\d{7,9}"],
        [, , "(?:2(?:17|3\\d|6[02-58]|96)|3(?:02|7[01357]|8[048]|9[0269])|870)\\d{4}", "\\d{7}", , , "2345678"],
        [, , "66(?:[0178][0-4]|2[025-9]|[36]\\d|4[129]|5[45]|9[019])\\d{5}|7(?:4[2-59]|56|[6-9]\\d)\\d{4}", "\\d{7,9}", , , "661234567"],
        [, , "80(?:0(?:07|2[238]|79|\\d{4})|9\\d{2})\\d{2}", "\\d{7,9}", , , "8002222"],
        [, , "NA", "NA"],
        [, , "90(?:0(?:2[278]|79|\\d{4})|1(?:23|\\d{4})|6(?:66|\\d{4}))\\d{2}", "\\d{7,9}", , , "9002222"],
        [, , "701\\d{4}", "\\d{7}", , , "7011234"],
        [, , "NA", "NA"], "LI", 423, "00", , , , , , , , [
            [, "(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3", ["[23]|7[4-9]|87"], "", ""],
            [, "(6\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["6"], "", ""],
            [, "([7-9]0\\d)(\\d{2})(\\d{2})", "$1 $2 $3", ["[7-9]0"], "", ""],
            [, "([89]0\\d)(\\d{2})(\\d{2})(\\d{2})", "0$1 $2 $3 $4", ["[89]0"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    LK: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LK", 94, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    LR: [, [, , "(?:[27]\\d|[4-6])\\d{6}", "\\d{7,8}"],
        [, , "2\\d{7}", "\\d{8}", , , "21234567"],
        [, , "(?:4[67]|5\\d|7\\d{2}|6[4-8])\\d{5}", "\\d{7,8}", , , "4612345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LR", 231, "00", "0", , , "0", , , , [
            [, "([27]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["[27]"], "0$1", ""],
            [, "([4-6])(\\d{3})(\\d{3})", "$1 $2 $3", ["[4-6]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    LS: [, [, , "[2568]\\d{7}", "\\d{8}"],
        [, , "2\\d{7}", "\\d{8}", , , "22123456"],
        [, , "[56]\\d{7}", "\\d{8}", , , "50123456"],
        [, , "800[256]\\d{4}", "\\d{8}", , , "80021234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LS", 266, "00", , , , , , , , [
            [, "(\\d{4})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    LT: [, [, , "[3-9]\\d{7}", "\\d{8}"],
        [, , "(?:3[1478]|4[124-6]|52)\\d{6}", "\\d{8}", , , "31234567"],
        [, , "6\\d{7}", "\\d{8}", , , "61234567"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "90[0239]\\d{5}", "\\d{8}", , , "90012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LT", 370, "00", "8", , , "8", , , , [
            [, "([34]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["37|4(?:1|5[45]|6[2-4])"], "8 $1", ""],
            [, "([3-689]\\d{2})(\\d{2})(\\d{3})", "$1 $2 $3", ["3[148]|4(?:[24]|6[09])|5(?:[0189]|28)|[689]"], "8 $1", ""],
            [, "(5)(2[0-79]\\d)(\\d{4})", "$1 $2 $3", ["52[0-79]"], "8 $1", ""]
        ], , [, , "NA", "NA"]
    ],
    LU: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LU", 352, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    LV: [, [, , "[2689]\\d{7}", "\\d{8}"],
        [, , "6\\d{7}", "\\d{8}", , , "61234567"],
        [, , "2\\d{7}", "\\d{8}", , , "21234567"],
        [, , "80\\d{6}", "\\d{8}", , , "80123456"],
        [, , "90\\d{6}", "\\d{8}", , , "90123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LV", 371, "00", , , , , , , , [
            [, "([2689]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    LY: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "LY", 218, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    MA: [, [, , "[5689]\\d{8}", "\\d{9}"],
        [, , "5(?:2(?:[015-7]\\d{2}|(?:[28][2-9]|3[2-7]|4[2-8])\\d|9(?:0\\d|[89]0))|3(?:[0-4]\\d{2}|(?:[57][2-9]|6[2-8]|9[3-9])\\d|8(?:0\\d|[89]0)))\\d{4}", "\\d{9}", , , "520123456"],
        [, , "6(?:00|33|[15-7]\\d|4[0-8]|99)\\d{6}", "\\d{9}", , , "650123456"],
        [, , "80\\d{7}", "\\d{9}", , , "801234567"],
        [, , "89\\d{7}", "\\d{9}", , , "891234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MA", 212, "00", "0", , , "0", , , , [
            [, "([56]\\d{2})(\\d{6})", "$1-$2", ["5(?:2[015-7]|3[0-4])|6"], "0$1", ""],
            [, "([58]\\d{3})(\\d{5})", "$1-$2", ["5(?:2[2-489]|3[5-9])|892", "5(?:2(?:[2-48]|90)|3(?:[5-79]|80))|892"], "0$1", ""],
            [, "(5\\d{4})(\\d{4})", "$1-$2", ["5(?:29|38)", "5(?:29|38)[89]"], "0$1", ""],
            [, "(8[09])(\\d{7})", "$1-$2", ["8(?:0|9[013-9])"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    MC: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MC", 377, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    MD: [, [, , "[256-9]\\d{7}", "\\d{8}"],
        [, , "(?:2(?:1[0569]|2\\d|3[015-7]|4[1-46-9]|5[0-24689]|6[2-589]|7[1-37]|9[1347-9])|5(?:33|5[257]))\\d{5}", "\\d{5,8}", , , "22212345"],
        [, , "(?:6(?:50|7[12]|[89]\\d)|7(?:80|9\\d))\\d{5}", "\\d{8}", , , "65012345"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "900\\d{5}", "\\d{8}", , , "90012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MD", 373, "00", "0", , , "0", , , , [
            [, "(22)(\\d{3})(\\d{3})", "$1 $2 $3", ["22"], "0$1", ""],
            [, "([25-7]\\d{2})(\\d{2})(\\d{3})", "$1 $2 $3", ["2[13-79]|[5-7]"], "0$1", ""],
            [, "([89]00)(\\d{5})", "$1 $2", ["[89]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    ME: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ME", 382, "99", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    MG: [, [, , "[23]\\d{8}", "\\d{7,9}"],
        [, , "2(?:0(?:(?:2\\d|4[47]|5[3467]|6[279]|8[268]|9[245])\\d|7(?:2[29]|[35]\\d))|210\\d)\\d{4}", "\\d{7,9}", , , "202123456"],
        [, , "3[02-4]\\d{7}", "\\d{9}", , , "301234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MG", 261, "00", "0", , , "0", , , , [
            [, "([23]\\d)(\\d{2})(\\d{3})(\\d{2})", "$1 $2 $3 $4", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    MF: [, [, , "[56]\\d{8}", "\\d{9}"],
        [, , "590(?:10|2[79]|5[128]|[78]7)\\d{4}", "\\d{9}", , , "590271234"],
        [, , "690(?:10|2[27]|66|77|8[78])\\d{4}", "\\d{9}", , , "690221234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MF", 590, "00", "0", , , "0", , , , , , [, , "NA", "NA"]
    ],
    MH: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MH", 692, "011", "1", , , "1", , , 1, , , [, , "NA", "NA"]
    ],
    MK: [, [, , "[2-578]\\d{7}", "\\d{8}"],
        [, , "(?:2\\d|3[1-4]|4[2-8])\\d{6}", "\\d{6,8}", , , "22212345"],
        [, , "7\\d{7}", "\\d{8}", , , "72345678"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "5[02-9]\\d{6}", "\\d{8}", , , "50012345"],
        [, , "8(?:0[1-9]|[1-9]\\d)\\d{5}", "\\d{8}", , , "80123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MK", 389, "00", "0", , , "0", , , , [
            [, "(2)(\\d{3})(\\d{4})", "$1 $2 $3", ["2"], "0$1", ""],
            [, "([347]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["[347]"], "0$1", ""],
            [, "([58]\\d{2})(\\d)(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[58]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    ML: [, [, , "[246-8]\\d{7}", "\\d{8}"],
        [, , "(?:2(?:0(?:2[0-589]|7[027-9])|1(?:2[5-7]|[3-689]\\d))|442\\d)\\d{4}", "\\d{8}", , , "20212345"],
        [, , "(?:6(?:[569]\\d)|7(?:[08][1-9]|[3579][0-4]|4[014-7]|6\\d))\\d{5}", "\\d{8}", , , "65012345"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ML", 223, "00", "0", , , "0", , , , [
            [, "([246-8]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    MM: [, [, , "[124-8]\\d{5,7}|9\\d{7,8}", "\\d{5,9}"],
        [, , "(?:1\\d|2|4[2-6]|5[2-9]|6\\d|7[0-5]|8[1-6])\\d{5}|1333\\d{4}", "\\d{5,8}", , , "1234567"],
        [, , "9(?:[25689]\\d|444)\\d{5}", "\\d{8,9}", , , "92123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MM", 95, "00", , , , , , , , [
            [, "(1)(\\d{3})(\\d{3})", "$1 $2 $3", ["1"], "", ""],
            [, "(1)(3)(33\\d)(\\d{3})", "$1 $2 $3 $4", ["133", "1333"], "", ""],
            [, "(2)(\\d{2})(\\d{3})", "$1 $2 $3", ["2"], "", ""],
            [, "(\\d{2})(\\d{2})(\\d{3})", "$1 $2 $3", ["[4-8]"], "", ""],
            [, "(9444)(\\d{5})", "$1 $2", ["94"], "", ""],
            [, "(9)([25689]\\d{2})(\\d{4})", "$1 $2 $3", ["9[25689]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    MN: [, [, , "[127-9]\\d{7}", "\\d{8}"],
        [, , "(?:[12](?:1\\d|2[1-37]|3[2-8]|4[2-68]|5[1-4689])|70)\\d{6}", "\\d{8}", , , "70123456"],
        [, , "(?:88|9[1569])\\d{6}", "\\d{8}", , , "88123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MN", 976, "001", "0", , , "0", , , , [
            [, "([127-9]\\d)(\\d{2})(\\d{4})", "$1 $2 $3", ["[12]1|[7-9]"], "0$1", ""],
            [, "([12]2\\d)(\\d{5})", "$1 $2", ["[12]2[1-3]"], "0$1", ""],
            [, "([12]\\d{3})(\\d{4})", "$1 $2", ["[12](?:27|[3-5])", "[12](?:27|[3-5]\\d)2"], "0$1", ""],
            [, "([12]\\d{4})(\\d{3})", "$1 $2", ["[12](?:27|[3-5])", "[12](?:27|[3-5]\\d)[4-9]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    MO: [, [, , "[268]\\d{7}", "\\d{8}"],
        [, , "(?:28[2-57-9]|8[2-57-9]\\d)\\d{5}", "\\d{8}", , , "28212345"],
        [, , "6[26]\\d{6}", "\\d{8}", , , "66123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MO", 853, "00", , , , , , , , [
            [, "([268]\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    MP: [, [, , "[689]\\d{9}", "\\d{7,10}"],
        [, , "670(?:2(?:3[3-5]|88|56)|32[23]|4[38]3|532|6(?:64|70|8\\d))\\d{4}", "\\d{7,10}", , , "6702345678"],
        [, , "670(?:2(?:3[3-5]|88|56)|32[23]|4[38]3|532|6(?:64|70|8\\d))\\d{4}", "\\d{7,10}", , , "6702345678"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MP", 1, "011", "1", , , "1", , , 1, , , [, , "NA", "NA"], , "670"],
    MQ: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MQ", 596, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    MR: [, [, , "[2-7]\\d{6}", "\\d{7}"],
        [, , "5(?:1[035]|2[0-69]|3[0348]|4[468]|5[02-467]|6[39]|7[4-69])\\d{4}", "\\d{7}", , , "5131234"],
        [, , "(?:[23][0-4]|4[3-5]|6\\d|7[0-7])\\d{5}", "\\d{7}", , , "3123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MR", 222, "00", , , , , , , , [
            [, "([2-7]\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    MS: [, [, , "[689]\\d{9}", "\\d{7,10}"],
        [, , "664491\\d{4}", "\\d{7,10}", , , "6644912345"],
        [, , "664492\\d{4}", "\\d{10}", , , "6644923456"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002123456"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MS", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "664"],
    MT: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MT", 356, "00", "21", , , "21", , , 1, , , [, , "NA", "NA"]
    ],
    MU: [, [, , "[2-9]\\d{6}", "\\d{7}"],
        [, , "(?:2(?:[034789]\\d|1[0-8]|2[0-79])|4(?:[013-8]\\d|2[4-7])|[56]\\d{2}|8(?:14|3[129]))\\d{4}", "\\d{7}", , , "2012345"],
        [, , "(?:25\\d|4(?:2[12389]|9\\d)|7\\d{2}|87[15-7]|9[1-8]\\d)\\d{4}", "\\d{7}", , , "2512345"],
        [, , "80[012]\\d{4}", "\\d{7}", , , "8001234"],
        [, , "30\\d{5}", "\\d{7}", , , "3012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MU", 230, "020", , , , , , , , [
            [, "([2-9]\\d{2})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    MV: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MV", 960, "020", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    MW: [, [, , "(?:[13-5]|[27]\\d{2}|[89](?:\\d{2})?)\\d{6}", "\\d{7,9}"],
        [, , "(?:1[2-9]|21\\d{2})\\d{5}", "\\d{7,9}", , , "1234567"],
        [, , "(?:[3-5]|77|8(?:8\\d)?|9(?:9\\d)?)\\d{6}", "\\d{7,9}", , , "991234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MW", 265, "00", "0", , , "0", , , , [
            [, "(\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["[13-5]"], "0$1", ""],
            [, "(2\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["2"], "0$1", ""],
            [, "(\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["7"], "0$1", ""],
            [, "(\\d)(\\d{3,4})(\\d{3,4})", "$1 $2 $3", ["[89]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    MX: [, [, , "[1-9]\\d{9,10}", "\\d{7,11}"],
        [, , "(?:33|55|81)\\d{8}|(?:2(?:2[2-9]|3[1-35-8]|4[13-9]|7[1-689]|8[1-58]|9[467])|3(?:1[1-79]|[2458][1-9]|7[1-8]|9[1-5])|4(?:1[1-57-9]|[24-6][1-9]|[37][1-8]|8[1-35-9]|9[2-689])|5(?:88|9[1-79])|6(?:1[2-68]|[234][1-9]|5[1-3689]|6[12457-9]|7[1-7]|8[67]|9[4-8])|7(?:[13467][1-9]|2[1-8]|5[13-9]|8[1-69]|9[17])|8(?:2[13-689]|3[1-6]|4[124-6]|6[1246-9]|7[1-378]|9[12479])|9(?:1[346-9]|2[1-4]|3[2-46-8]|5[1348]|[69][1-9]|7[12]|8[1-8]))\\d{7}", "\\d{7,10}", , , "2221234567"],
        [, , "1(?:(?:33|55|81)\\d{8}|(?:2(?:2[2-9]|3[1-35-8]|4[13-9]|7[1-689]|8[1-58]|9[467])|3(?:1[1-79]|[2458][1-9]|7[1-8]|9[1-5])|4(?:1[1-57-9]|[24-6][1-9]|[37][1-8]|8[1-35-9]|9[2-689])|5(?:88|9[1-79])|6(?:1[2-68]|[2-4][1-9]|5[1-3689]|6[12457-9]|7[1-7]|8[67]|9[4-8])|7(?:[13467][1-9]|2[1-8]|5[13-9]|8[1-69]|9[17])|8(?:2[13-689]|3[1-6]|4[124-6]|6[1246-9]|7[1-378]|9[12479])|9(?:1[346-9]|2[1-4]|3[2-46-8]|5[1348]|[69][1-9]|7[12]|8[1-8]))\\d{7})", "\\d{11}", , , "12221234567"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "900\\d{7}", "\\d{10}", , , "9001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MX", 52, "0[09]", "01", , , "0[12]|04[45](\\d{10})", "1$1", , , [
            [, "([358]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["33|55|81"], "01 $1", ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["[2467]|3[12457-9]|5[89]|8[02-9]|9[0-35-9]"], "01 $1", ""],
            [, "1([358]\\d)(\\d{4})(\\d{4})", "045 $1 $2 $3", ["1(?:33|55|81)"], "$1", ""],
            [, "1(\\d{3})(\\d{3})(\\d{4})", "045 $1 $2 $3", ["1(?:[2467]|3[12457-9]|5[89]|8[2-9]|9[1-35-9])"], "$1", ""]
        ],
        [
            [, "([358]\\d)(\\d{4})(\\d{4})", "$1 $2 $3", ["33|55|81"], , ""],
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["[2467]|3[12457-9]|5[89]|8[02-9]|9[0-35-9]"], , ""],
            [, "(1)([358]\\d)(\\d{4})(\\d{4})", "$1 $2 $3 $4", ["1(?:33|55|81)"], , ""],
            [, "(1)(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3 $4", ["1(?:[2467]|3[12457-9]|5[89]|8[2-9]|9[1-35-9])"], , ""]
        ],
        [, , "NA", "NA"]
    ],
    MY: [, [, , "[13-9]\\d{7,9}", "\\d{6,10}"],
        [, , "(?:3\\d{2}|[4-79]\\d|8[2-9])\\d{6}", "\\d{6,9}", , , "312345678"],
        [, , "1[0-46-9]\\d{7}", "\\d{9}", , , "123456789"],
        [, , "1[38]00\\d{6}", "\\d{10}", , , "1300123456"],
        [, , "1600\\d{6}", "\\d{10}", , , "1600123456"],
        [, , "NA", "NA"],
        [, , "1700\\d{6}", "\\d{10}", , , "1700123456"],
        [, , "154\\d{7}", "\\d{10}", , , "1541234567"], "MY", 60, "00", "0", , , "0", , , , [
            [, "([4-79])(\\d{3})(\\d{4})", "$1-$2 $3", ["[4-79]"], "0$1", ""],
            [, "(3)(\\d{4})(\\d{4})", "$1-$2 $3", ["3"], "0$1", ""],
            [, "([18]\\d)(\\d{3})(\\d{3,4})", "$1-$2 $3", ["1[0-46-9][1-9]|8"], "0$1", ""],
            [, "(1)([36-8]00)(\\d{2})(\\d{4})", "$1-$2-$3-$4", ["1[36-8]0"], "", ""],
            [, "(154)(\\d{3})(\\d{4})", "$1-$2 $3", ["15"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    MZ: [, [, , "[28]\\d{7,8}", "\\d{8,9}"],
        [, , "2(?:[1346]\\d|5[0-2]|[78][12]|93)\\d{5}", "\\d{8}", , , "21123456"],
        [, , "8[24]\\d{7}", "\\d{9}", , , "821234567"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "MZ", 258, "00", , , , , , , , [
            [, "([28]\\d)(\\d{3})(\\d{3,4})", "$1 $2 $3", ["2|8[24]"], "", ""],
            [, "(80\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["80"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    NA: [, [, , "[68]\\d{5,9}", "\\d{4,10}"],
        [, , "6(?:1(?:[136]|2\\d?)\\d|2(?:[25]\\d?|[134678])\\d|3(?:2\\d{0,3}|4\\d{1,2}|[135-8]\\d?)|4(?:[13-8]\\d|2\\d{1,2})|(?:5(?:[16-7]\\d|[3-58]\\d?|2\\d{1,2}))|6\\d{0,4}|7\\d{0,3})\\d{4}", "\\d{4,10}", , , "612012345"],
        [, , "8(?:1(?:1[0-24]|[2-4]\\d|50|6[0-2])|5\\d{2})\\d{5}", "\\d{9}", , , "811012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "88\\d{6}", "\\d{8}", , , "88123456"], "NA", 264, "00", "0", , , "0", , , , [
            [, "(8\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["8[15]"], "0$1", ""],
            [, "(632532)(\\d{2,4})", "$1 $2", ["632", "6325", "63253", "632532"], "0$1", ""],
            [, "(6\\d)(\\d{2,3})(\\d{4})", "$1 $2 $3", ["6(?:1|[245][1-7]|3[125-7]|6[1256]|7[1236])"], "0$1", ""],
            [, "(6\\d)(\\d{4,5})", "$1 $2", ["6(?:3[12567]|5[3-5]|6[1256]|7[1236])"], "0$1", ""],
            [, "(6\\d{2})(\\d{4,6})", "$1 $2", ["6[2356]8"], "0$1", ""],
            [, "(6\\d{3})(\\d{4,5})", "$1 $2", ["6(?:34|6[34]|75)", "6(?:342|6[34]|751)"], "0$1", ""],
            [, "(88)(\\d{3})(\\d{3})", "$1 $2 $3", ["88"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    NC: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NC", 687, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    NE: [, [, , "[029]\\d{7}", "\\d{8}"],
        [, , "2(?:0(?:20|3[1-7]|4[134]|5[14]|6[14578]|7[1-578])|1(?:4[145]|5[14]|6[14-68]|7[169]|88))\\d{4}", "\\d{8}", , , "20201234"],
        [, , "9[03467]\\d{6}", "\\d{8}", , , "93123456"],
        [, , "08\\d{6}", "\\d{8}", , , "08123456"],
        [, , "09\\d{6}", "\\d{8}", , , "09123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NE", 227, "00", , , , , , , , [
            [, "([029]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[29]|09"], "", ""],
            [, "(08)(\\d{3})(\\d{3})", "$1 $2 $3", ["08"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    NF: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NF", 672, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    NG: [, [, , "[1-69]\\d{5,8}|[78]\\d{5,13}", "\\d{5,14}"],
        [, , "[12]\\d{6,7}|9\\d{7}|(?:4[023568]|5[02368]|6[02-469]|7[569]|8[2-9])\\d{6}|(?:4[47]|5[14579]|6[1578]|7[0-357])\\d{5,6}|(?:78|41)\\d{5}", "\\d{5,9}", , , "12345678"],
        [, , "(?:70[3-9]|8(?:0[2-9]|1[23]))\\d{7}|(?:702[1-9]|819[01])\\d{6}", "\\d{10}", , , "8021234567"],
        [, , "800\\d{7,11}", "\\d{10,14}", , , "80017591759"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "700\\d{7,11}", "\\d{10,14}", , , "7001234567"],
        [, , "NA", "NA"], "NG", 234, "009", "0", , , "0", , , , [
            [, "([129])(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[129]"], "0$1", ""],
            [, "([3-8]\\d)(\\d{3})(\\d{2,3})", "$1 $2 $3", ["[3-6]|7(?:[1-79]|0[1-9])|8[2-9]"], "0$1", ""],
            [, "([78]\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["70[03-9]|8(?:0|1[23])"], "0$1", ""],
            [, "([78]\\d{3})(\\d{3})(\\d{3})", "$1 $2 $3", ["702|819"], "0$1", ""],
            [, "([78]00)(\\d{4})(\\d{4,5})", "$1 $2 $3", ["[78]00"], "0$1", ""],
            [, "([78]00)(\\d{5})(\\d{5,6})", "$1 $2 $3", ["[78]00"], "0$1", ""],
            [, "(78)(\\d{2})(\\d{3})", "$1 $2 $3", ["78"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    NI: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NI", 505, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    NL: [, [, , "[1-9]\\d{6,9}", "\\d{7,10}"],
        [, , "(?:1[0135-8]|2[02-69]|3[0-68]|4[0135-9]|[57]\\d|8[478])\\d{7}", "\\d{9}", , , "101234567"],
        [, , "6[1-58]\\d{7}", "\\d{9}", , , "612345678"],
        [, , "800\\d{4,7}", "\\d{7,10}", , , "8001234"],
        [, , "90[069]\\d{4,7}", "\\d{7,10}", , , "9001234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "85\\d{7}", "\\d{9}"], "NL", 31, "00", "0", , , "0", , , , [
            [, "([1-578]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["1[035]|2[0346]|3[03568]|4[0356]|5[0358]|7|8[458]"], "0$1", ""],
            [, "([1-5]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["1[16-8]|2[259]|3[124]|4[17-9]|5[124679]"], "0$1", ""],
            [, "(6)(\\d{8})", "$1 $2", ["6"], "0$1", ""],
            [, "([89]0\\d)(\\d{4,7})", "$1 $2", ["80|9"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    NO: [, [, , "0\\d{4}|[2-9]\\d{7}", "\\d{5}(?:\\d{3})?"],
        [, , "0\\d{4}|(?:2[1-4]|3[1-3578]|5[1-35-7]|6[1-4679]|7\\d)\\d{6}|81(?:0(?:0[7-9]|1\\d)|5\\d{2})\\d{3}", "\\d{5}(?:\\d{3})?", , , "21234567"],
        [, , "(?:4[015-8]|9\\d)\\d{6}", "\\d{8}", , , "41234567"],
        [, , "80[01]\\d{5}", "\\d{8}", , , "80012345"],
        [, , "82[09]\\d{5}", "\\d{8}", , , "82012345"],
        [, , "810(?:0[0-6]|[2-8]\\d)\\d{3}", "\\d{8}", , , "81021234"],
        [, , "880\\d{5}", "\\d{8}", , , "88012345"],
        [, , "NA", "NA"], "NO", 47, "00", , , , , , , , [
            [, "([489]\\d{2})(\\d{2})(\\d{3})", "$1 $2 $3", ["[489]"], "", ""],
            [, "([235-7]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[235-7]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    NP: [, [, , "[1-8]\\d{5,7}|98[45]\\d{7}", "\\d{6,10}"],
        [, , "(?:1[014-6]|2[13-79]|3[135-8]|4[146-9]|5[135-7]|6[13-9]|7[15-9]|8[1-4679]|9[1-79])\\d{6}", "\\d{6,8}", , , "14567890"],
        [, , "98[45]\\d{7}", "\\d{10}", , , "9841234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NP", 977, "00", "0", , , "0", , , , [
            [, "(1)([4-6]\\d{3})(\\d{3})", "$1 $2 $3", ["1[4-6]"], "0$1", ""],
            [, "(\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["1[01]|[2-8]|9[1-79]"], "0$1", ""],
            [, "(98[45])(\\d{3})(\\d{4})", "$1 $2 $3", ["98"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    NR: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NR", 674, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    NU: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NU", 683, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    NZ: [, [, , "[2-9]\\d{7,9}", "\\d{7,10}"],
        [, , "(?:3[2-79]|[479][2-689]|6[235-9])\\d{6}|24099\\d{3}", "\\d{7,8}", , , "32345678"],
        [, , "2(?:[027]\\d{7}|9\\d{6,7}|1(?:0\\d{5,7}|[12]\\d{5,6}|[3-9]\\d{5})|4[1-9]\\d{6}|8\\d{7,8})", "\\d{8,10}", , , "211234567"],
        [, , "(?:800|508)\\d{6,7}", "\\d{9,10}", , , "800123456"],
        [, , "900\\d{6,7}", "\\d{9,10}", , , "900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "NZ", 64, "00", "0", , , "0", , , , [
            [, "([34679])(\\d{3})(\\d{4})", "$1-$2 $3", ["[3467]|9[1-9]"], "0$1", ""],
            [, "(21)(\\d{4})(\\d{3,4})", "$1 $2 $3", ["21"], "0$1", ""],
            [, "([2589]\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["2[0247-9]|5|[89]00"], "0$1", ""],
            [, "(2[019])(\\d{3})(\\d{3})", "$1 $2 $3", ["2[019]"], "0$1", ""],
            [, "(24099)(\\d{3})", "$1 $2", ["240", "2409", "24099"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    OM: [, [, , "(?:2[3-6]|5|9[2-9])\\d{6}|800\\d{5,6}", "\\d{7,9}"],
        [, , "2[3-6]\\d{6}", "\\d{8}", , , "23123456"],
        [, , "9[2-9]\\d{6}", "\\d{8}", , , "92123456"],
        [, , "8007\\d{4,5}|500\\d{4}", "\\d{7,9}", , , "80071234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "OM", 968, "00", , , , , , , , [
            [, "(2\\d)(\\d{6})", "$1 $2", ["2"], "", ""],
            [, "(9\\d{3})(\\d{4})", "$1 $2", ["9"], "", ""],
            [, "([58]00)(\\d{4,6})", "$1 $2", ["[58]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    PA: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PA", 507, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    PE: [, [, , "[14-9]\\d{7,8}", "\\d{6,9}"],
        [, , "(?:1\\d|4[1-4]|5[1-46]|6[1-7]|7[2-46]|8[2-4])\\d{6}", "\\d{6,8}", , , "11234567"],
        [, , "9\\d{8}", "\\d{9}", , , "912345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PE", 51, "00", "0", " Anexo ", , "0", , , , [
            [, "(1)(\\d{7})", "$1 $2", ["1"], "($1)", ""],
            [, "([4-8]\\d)(\\d{6})", "$1 $2", ["[4-8]"], "($1)", ""],
            [, "(9\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["9"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    PF: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PF", 689, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    PG: [, [, , "[1-9]\\d{6,7}", "\\d{7,8}"],
        [, , "(?:3\\d{2}|4[257]\\d|5[34]\\d|6(?:29|4[1-9])|85[02-46-9]|9[78]\\d)\\d{4}", "\\d{7}", , , "3123456"],
        [, , "(?:68|7(?:[126]\\d|3[34689]))\\d{5}", "\\d{7,8}", , , "6812345"],
        [, , "180\\d{4}", "\\d{7}", , , "1801234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "275\\d{4}", "\\d{7}", , , "2751234"], "PG", 675, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", ["[1-689]"], "", ""],
            [, "(7[1-36]\\d)(\\d{2})(\\d{3})", "$1 $2 $3", ["7[1-36]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    PH: [, [, , "[2-9]\\d{7,9}|1800\\d{7,9}", "\\d{7,13}"],
        [, , "(?:2|3[2-68]|4[2-9]|5[2-6]|6[2-58]|7[24578]|8[2-8])\\d{7}", "\\d{7,9}", , , "21234567"],
        [, , "9(?:0[5-9]|1[025-9]|2[0-36-9]|3[0235-9]|7[349]|[89]9)\\d{7}", "\\d{10}", , , "9051234567"],
        [, , "1800\\d{7,9}", "\\d{11,13}", , , "180012345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PH", 63, "00", "0", , , "0", , , , [
            [, "(2)(\\d{3})(\\d{4})", "$1 $2 $3", ["2"], "(0$1)", ""],
            [, "(\\d{4})(\\d{5})", "$1 $2", ["3(?:23|39|46)|4(?:2[3-6]|[35]9|4[26]|76)|5(?:22|44)|642|8(?:62|8[245])", "3(?:230|397|461)|4(?:2(?:35|[46]4|51)|396|4(?:22|63)|59[347]|76[15])|5(?:221|446)|642[23]|8(?:622|8(?:[24]2|5[13]))"], "(0$1)", ""],
            [, "(\\d{5})(\\d{4})", "$1 $2", ["346|4(?:27|9[35])|883", "3469|4(?:279|9(?:30|56))|8834"], "(0$1)", ""],
            [, "([3-8]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["[3-8]"], "(0$1)", ""],
            [, "(9\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["9"], "0$1", ""],
            [, "(1800)(\\d{3})(\\d{4})", "$1 $2 $3", ["1"], "", ""],
            [, "(1800)(\\d{1,2})(\\d{3})(\\d{4})", "$1 $2 $3 $4", ["1"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    PK: [, [, , "1\\d{8}|[2-8]\\d{5,11}|9(?:[013-9]\\d{4,9}|2\\d(?:111\\d{6}|\\d{3,7}))", "\\d{6,12}"],
        [, , "(?:21|42)[2-9]\\d{7}|(?:2[25]|4[0146-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91)[2-9]\\d{6}|(?:2(?:3[2358]|4[2-4]|9[2-8])|45[3479]|54[2-467]|60[468]|72[236]|8(?:2[2-689]|3[23578]|4[3478]|5[2356])|9(?:1|2[2-8]|3[27-9]|4[2-6]|6[3569]|9[25-8]))[2-9]\\d{5,6}|58[126]\\d{7}", "\\d{6,10}", , , "2123456789"],
        [, , "3(?:0\\d|1[2-5]|2[1-3]|3[1-6]|4[2-6]|64)\\d{7}", "\\d{10}", , , "3012345678"],
        [, , "800\\d{5}", "\\d{8}", , , "80012345"],
        [, , "900\\d{5}", "\\d{8}", , , "90012345"],
        [, , "(?:2(?:[125]|3[2358]|4[2-4]|9[2-8])|4(?:[0-246-9]|5[3479])|5(?:[1-35-7]|4[2-467])|6(?:[1-8]|0[468])|7(?:[14]|2[236])|8(?:[16]|2[2-689]|3[23578]|4[3478]|5[2356])|9(?:1|22|3[27-9]|4[2-6]|6[3569]|9[2-7]))111\\d{6}", "\\d{11,12}", , , "21111825888"],
        [, , "122\\d{6}", "\\d{9}", , , "122044444"],
        [, , "NA", "NA"], "PK", 92, "00", "0", , , "0", , , , [
            [, "(\\d{2})(111)(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["(?:2[125]|4[0-246-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91)1", "(?:2[125]|4[0-246-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91)11", "(?:2[125]|4[0-246-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91)111"], "(0$1)", ""],
            [, "(\\d{3})(111)(\\d{3})(\\d{3})", "$1 $2 $3 $4", ["(?:2[349]|45|54|60|72|8[2-5]|9[2-9])", "(?:2[349]|45|54|60|72|8[2-5]|9[2-9])\\d1", "(?:2[349]|45|54|60|72|8[2-5]|9[2-9])\\d11", "(?:2[349]|45|54|60|72|8[2-5]|9[2-9])\\d111"], "(0$1)", ""],
            [, "(\\d{2})(\\d{7,8})", "$1 $2", ["(?:2[125]|4[0-246-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91)[2-9]"], "(0$1)", ""],
            [, "(\\d{3})(\\d{6,7})", "$1 $2", ["2[349]|45|54|60|72|8[2-5]|9[2-9]", "(?:2[349]|45|54|60|72|8[2-5]|9[2-9])\\d[2-9]"], "(0$1)", ""],
            [, "(3\\d{2})(\\d{7})", "$1 $2", ["3"], "0$1", ""],
            [, "([15]\\d{3})(\\d{5,6})", "$1 $2", ["58[12]|1"], "(0$1)", ""],
            [, "(586\\d{2})(\\d{5})", "$1 $2", ["586"], "(0$1)", ""],
            [, "([89]00)(\\d{3})(\\d{2})", "$1 $2 $3", ["[89]00"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    PL: [, [, , "[1-9]\\d{8}", "\\d{9}"],
        [, , "(?:1[2-8]|2[2-59]|3[2-4]|4[1-468]|5[24-689]|6[1-3578]|7[14-7]|8[1-79]|9[145])\\d{7}", "\\d{9}", , , "123456789"],
        [, , "(?:5[013]|6[069]|7[289]|88)\\d{7}", "\\d{9}", , , "512345678"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "70\\d{7}", "\\d{9}", , , "701234567"],
        [, , "801\\d{6}", "\\d{9}", , , "801234567"],
        [, , "NA", "NA"],
        [, , "39\\d{7}", "\\d{9}", , , "391234567"], "PL", 48, "00", , , , , , , , [
            [, "(\\d{2})(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[124]|3[2-4]|5[24-689]|6[1-3578]|7[14-7]|8[1-79]|9[145]"], "", ""],
            [, "(\\d{3})(\\d{3})(\\d{3})", "$1 $2 $3", ["39|5[013]|6[069]|7[0289]|8[08]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    PM: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PM", 508, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    PR: [, [, , "[789]\\d{9}", "\\d{7,10}"],
        [, , "(?:787|939)[2-9]\\d{6}", "\\d{7,10}", , , "7872345678"],
        [, , "(?:787|939)[2-9]\\d{6}", "\\d{7,10}", , , "7872345678"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PR", 1, "011", "1", , , "1", , , 1, , , [, , "NA", "NA"], , "787|939"],
    PS: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PS", 970, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    PT: [, [, , "[2-46-9]\\d{8}", "\\d{9}"],
        [, , "2(?:[12]\\d|[35][1-689]|4[1-59]|6[1-35689]|7[1-9]|8[1-69]|9[1256])\\d{6}", "\\d{9}", , , "212345678"],
        [, , "9(?:[136]\\d{2}|2[25-79]\\d|4(?:80|9\\d))\\d{5}", "\\d{9}", , , "912345678"],
        [, , "4\\d{8}|80[02]\\d{6}", "\\d{9}", , , "800123456"],
        [, , "71\\d{7}", "\\d{9}", , , "712345678"],
        [, , "808\\d{6}", "\\d{9}", , , "808123456"],
        [, , "NA", "NA"],
        [, , "30\\d{7}", "\\d{9}", , , "301234567"], "PT", 351, "00", , , , , , , , [
            [, "([2-46-9]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    PW: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PW", 680, "011", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    PY: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "PY", 595, "002", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    QA: [, [, , "[3-8]\\d{6,7}", "\\d{7,8}"],
        [, , "44\\d{6}", "\\d{7,8}", , , "44123456"],
        [, , "(?:33|55|66|77)\\d{6}", "\\d{7,8}", , , "33123456"],
        [, , "800\\d{4}", "\\d{7,8}", , , "8001234"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "QA", 974, "00", , , , , , , , [
            [, "(8\\d{2})(\\d{4})", "$1 $2", ["8"], "", ""],
            [, "([3-7]\\d{3})(\\d{4})", "$1 $2", ["[3-7]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    RE: [, [, , "[268]\\d{8}", "\\d{9}"],
        [, , "262\\d{6}", "\\d{9}", , , "262161234"],
        [, , "6(?:9[23]|47)\\d{6}", "\\d{9}", , , "692123456"],
        [, , "80\\d{7}", "\\d{9}", , , "801234567"],
        [, , "89[1-37-9]\\d{6}", "\\d{9}", , , "891123456"],
        [, , "8(?:1[019]|2[0156]|84|90)\\d{6}", "\\d{9}", , , "810123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "RE", 262, "00", "0", , , "0", , , , [
            [, "([268]\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "0$1", ""]
        ], , [, , "NA", "NA"], 1, "262|6[49]|8"],
    RO: [, [, , "[237-9]\\d{8}", "\\d{9}"],
        [, , "[23][13-6]\\d{7}", "\\d{9}", , , "211234567"],
        [, , "7[1-8]\\d{7}", "\\d{9}", , , "712345678"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "90[036]\\d{6}", "\\d{9}", , , "900123456"],
        [, , "801\\d{6}", "\\d{9}", , , "801123456"],
        [, , "802\\d{6}", "\\d{9}", , , "802123456"],
        [, , "NA", "NA"], "RO", 40, "00", "0", " int ", , "0", , , , [
            [, "([237]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["[23]1|7"], "0$1", ""],
            [, "(\\d{3})(\\d{3})(\\d{3})", "$1 $2 $3", ["[23][02-9]|[89]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    RS: [, [, , "[1-46-9]\\d{4,11}", "\\d{5,12}"],
        [, , "[1-3]\\d{6,9}", "\\d{5,10}", , , "1012345"],
        [, , "6[0-689]\\d{3,10}", "\\d{5,12}", , , "6012345"],
        [, , "800\\d{3,6}", "\\d{6,9}", , , "80012345"],
        [, , "(?:9[0-2]|42)\\d{4,7}", "\\d{6,9}", , , "90012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "RS", 381, "00", "0", , , "0", , , , [
            [, "([23]\\d{2})(\\d{4,7})", "$1 $2", ["(?:2[389]|39)0"], "0$1", ""],
            [, "([1-4]\\d)(\\d{4,8})", "$1 $2", ["1|2(?:[0-24-7]|[389][1-9])|3(?:[0-8]|9[1-9])|42"], "0$1", ""],
            [, "(6[0-689])(\\d{3,10})", "$1 $2", ["6"], "0$1", ""],
            [, "([89]\\d{2})(\\d{3,6})", "$1 $2", ["[89]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    RU: [, [, , "[3489]\\d{9}", "\\d{10}"],
        [, , "(?:3(?:0[12]|4[1-35-79]|5[1-3]|8[1-58]|9[0145])|4(?:01|1[1356]|2[13467]|7[1-5]|8[1-7]|9[1-689])|8(?:1[1-8]|2[01]|3[13-6]|4[0-8]|5[15]|6[1-35-7]|7[1-37-9]))\\d{7}", "\\d{10}", , , "3011234567"],
        [, , "9\\d{9}", "\\d{10}", , , "9123456789"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "809\\d{7}", "\\d{10}", , , "8091234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "RU", 7, "8~10", "8", , , "8", , , , [
            [, "([3489]\\d{2})(\\d{3})(\\d{2})(\\d{2})", "$1 $2-$3-$4", ["[34689]"], "8 ($1)", ""],
            [, "([67]\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["[67]"], "8 ($1)", ""]
        ], , [, , "NA", "NA"], 1],
    RW: [, [, , "[27-9]\\d{8}", "\\d{9}"],
        [, , "25\\d{7}", "\\d{9}", , , "250123456"],
        [, , "7[258]\\d{7}", "\\d{9}", , , "720123456"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "900\\d{6}", "\\d{9}", , , "900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "RW", 250, "000", "0", , , "0", , , , [
            [, "(25\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["2"], "$1", ""],
            [, "([7-9]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["[7-9]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    SA: [, [, , "[1-9]\\d{7,10}", "\\d{7,11}"],
        [, , "(?:1[24-7]|2[24-8]|3[35-8]|4[34-68]|6[2-5]|7[235-7])\\d{6}", "\\d{7,8}", , , "12345678"],
        [, , "(?:5[013-69]\\d|8111)\\d{6}", "\\d{9,10}", , , "512345678"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "9200\\d{7}", "\\d{11}", , , "92001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SA", 966, "00", "0", , , "0", , , , [
            [, "([1-467])(\\d{3})(\\d{4})", "$1 $2 $3", ["[1-467]"], "0$1", ""],
            [, "(9200)(\\d{3})(\\d{4})", "$1 $2 $3", ["9"], "0$1", ""],
            [, "(5\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["5"], "0$1", ""],
            [, "(800)(\\d{3})(\\d{4})", "$1 $2 $3", ["80"], "0$1", ""],
            [, "(8111)(\\d{3})(\\d{3})", "$1 $2 $3", ["81"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    SB: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SB", 677, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    SC: [, [, , "[2-8]\\d{5}", "\\d{6}"],
        [, , "(?:2(?:1[78]|2[14-69]|3[2-4]|4[1-36-8]|6[167]|[89]\\d)|3(?:2[1-6]|4[4-6]|55|6[016]|7\\d|8[0-589]|9[0-5])|5(?:5\\d|6[0-2])|6(?:0[0-27-9]|1[0-478]|2[145]|3[02-4]|4[124]|6[015]|7\\d|8[1-3])|78[0138])\\d{3}", "\\d{6}", , , "217123"],
        [, , "(?:5(?:[1247-9]\\d|6[3-9])|7(?:[14679]\\d|2[1-9]|8[24-79]))\\d{3}", "\\d{6}", , , "510123"],
        [, , "8000\\d{2}", "\\d{6}", , , "800000"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],

        [, , "4[1-37]\\d{4}", "\\d{6}", , , "410123"], "SC", 248, "0[0-2]", , , , , , "00", , [
            [, "(\\d{3})(\\d{3})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    SD: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SD", 249, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    SE: [, [, , "\\d{7,10}", "\\d{5,10}"],
        [, , "1(?:0[1-8]\\d{6}|[136]\\d{5,7}|(?:2[0-35]|4[0-4]|5[0-25-9]|7[13-6]|[89]\\d)\\d{5,6})|2(?:[136]\\d{5,7}|(?:2[0-7]|4[0136-8]|5[0-38]|7[018]|8[01]|9[0-57])\\d{5,6})|3(?:[356]\\d{5,7}|(?:0[0-4]|1\\d|2[0-25]|4[056]|7[0-2]|8[0-3]|9[023])\\d{5,6})|4(?:[0246]\\d{5,7}|(?:1[01-8]|3[0135]|5[14-79]|7[0-246-9]|8[0156]|9[0-689])\\d{5,6})|5(?:0[0-6]|1[1-5]|2[0-68]|3[0-4]|4\\d|5[0-5]|6[03-5]|7[013]|8[0-79]|9[01])\\d{5,6}|6(?:[03]\\d{5,7}|(?:1[1-3]|2[0-4]|4[02-57]|5[0-37]|6[0-3]|7[0-2]|8[0247]|9[0-356])\\d{5,6})|8\\d{6,8}|9(?:0\\d{5,7}|(?:1[0-68]|2\\d|3[02-59]|4[0-4]|5[0-4]|6[01]|7[0135-8]|8[01])\\d{5,6})", "\\d{5,9}", , , "8123456"],
        [, , "7[02-46]\\d{7}", "\\d{9}", , , "701234567"],
        [, , "20\\d{4,7}", "\\d{6,9}", , , "201234567"],
        [, , "9(?:00|39|44)\\d{7}", "\\d{10}", , , "9001234567"],
        [, , "77\\d{7}", "\\d{9}", , , "771234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SE", 46, "00", "0", , , "0", , , , [
            [, "(8)(\\d{2,3})(\\d{2,3})(\\d{2})", "$1 $2 $3 $4", ["8"], "0$1", ""],
            [, "([1-69]\\d)(\\d{2,3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["1[013689]|2[0136]|3[1356]|4[0246]|54|6[03]|90"], "0$1", ""],
            [, "([1-69]\\d)(\\d{3})(\\d{2})", "$1 $2 $3", ["1[13689]|2[136]|3[1356]|4[0246]|54|6[03]|90"], "0$1", ""],
            [, "(\\d{3})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["1[2457]|2[2457-9]|3[0247-9]|4[1357-9]|5[0-35-9]|6[124-9]|9(?:[125-8]|3[0-5]|4[0-3])"], "0$1", ""],
            [, "(\\d{3})(\\d{2,3})(\\d{2})", "$1 $2 $3", ["1[2457]|2[2457-9]|3[0247-9]|4[1357-9]|5[0-35-9]|6[124-9]|9(?:[125-8]|3[0-5]|4[0-3])"], "0$1", ""],
            [, "(7[02-467])(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["7[02-467]"], "0$1", ""],
            [, "(20)(\\d{2,3})(\\d{2})", "$1 $2 $3", ["20"], "0$1", ""],
            [, "(9[034]\\d)(\\d{2})(\\d{2})(\\d{3})", "$1 $2 $3 $4", ["9[034]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    SG: [, [, , "[13689]\\d{7,10}", "\\d{8,11}"],
        [, , "[36]\\d{7}", "\\d{8}", , , "31234567"],
        [, , "[89]\\d{7}", "\\d{8}", , , "81234567"],
        [, , "1?800\\d{7}", "\\d{10,11}", , , "18001234567"],
        [, , "1900\\d{7}", "\\d{11}", , , "19001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SG", 65, "0[0-3][0-9]", , , , , , , , [
            [, "([3689]\\d{3})(\\d{4})", "$1 $2", ["[369]|8[1-9]"], "", ""],
            [, "(1[89]00)(\\d{3})(\\d{4})", "$1 $2 $3", ["1[89]"], "", ""],
            [, "(800)(\\d{3})(\\d{4})", "$1 $2 $3", ["80"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    SH: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SH", 290, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    SI: [, [, , "[1-7]\\d{6,7}|[89]\\d{4,7}", "\\d{5,8}"],
        [, , "(?:1\\d|2[2-8]|3[4-8]|4[24-8]|[57][3-8])\\d{6}", "\\d{7,8}", , , "11234567"],
        [, , "(?:[37][01]|4[019]|51|64)\\d{6}", "\\d{8}", , , "31234567"],
        [, , "80\\d{4,6}", "\\d{6,8}", , , "80123456"],
        [, , "90\\d{4,6}|89[1-3]\\d{2,5}", "\\d{5,8}", , , "90123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "(?:59|8[1-3])\\d{6}", "\\d{8}", , , "59012345"], "SI", 386, "00", "0", , , "0", , , , [
            [, "(\\d)(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[12]|3[4-8]|4[24-8]|5[3-8]|7[3-8]"], "(0$1)", ""],
            [, "([3-7]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["[37][01]|4[019]|51|64"], "0$1", ""],
            [, "([89][09])(\\d{3,6})", "$1 $2", ["[89][09]"], "0$1", ""],
            [, "([58]\\d{2})(\\d{5})", "$1 $2", ["59|8[1-3]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    SK: [, [, , "[2-689]\\d{8}", "\\d{9}"],
        [, , "[2-5]\\d{8}", "\\d{9}", , , "212345678"],
        [, , "9(?:0[1-8]|1[0-24-9]|4[0489])\\d{6}", "\\d{9}", , , "912123456"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "9(?:[78]\\d{7}|00\\d{6})", "\\d{9}", , , "900123456"],
        [, , "8[5-9]\\d{7}", "\\d{9}", , , "850123456"],
        [, , "NA", "NA"],
        [, , "6(?:5[0-4]|9[0-6])\\d{6}", "\\d{9}", , , "690123456"], "SK", 421, "00", "0", , , "0", , , , [
            [, "(2)(\\d{3})(\\d{3})(\\d{2})", "$1/$2 $3 $4", ["2"], "0$1", ""],
            [, "([3-5]\\d)(\\d{3})(\\d{2})(\\d{2})", "$1/$2 $3 $4", ["[3-5]"], "0$1", ""],
            [, "([689]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["[689]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    SL: [, [, , "[2-578]\\d{7}", "\\d{6,8}"],
        [, , "[235]2[2-4][2-9]\\d{4}", "\\d{6,8}", , , "22221234"],
        [, , "(?:25|3[03]|44|5[056]|7[6-8]|88)[1-9]\\d{5}", "\\d{6,8}", , , "25123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SL", 232, "00", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{6})", "$1 $2", , "(0$1)", ""]
        ], , [, , "NA", "NA"]
    ],
    SM: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SM", 378, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    SN: [, [, , "[37]\\d{8}", "\\d{9}"],
        [, , "3(?:010|3(?:8[1-9]|9[2-9]))\\d{5}", "\\d{9}", , , "301012345"],
        [, , "7(?:0[1256]0|6(?:1[23]|2[89]|3[3489]|4[6-9]|5[1-389]|6[6-9]|7[45]|8[3-8])|7(?:1[014-8]|2[0-7]|3[0-35-8]|4[0-6]|[56]\\d|7[0-589]|8[01]|9[0-6]))\\d{5}", "\\d{9}", , , "701012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "33301\\d{4}", "\\d{9}", , , "333011234"], "SN", 221, "00", , , , , , , , [
            [, "(\\d{2})(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    SO: [, [, , "[13-59]\\d{6,7}", "\\d{7,8}"],
        [, , "(?:5[57-9]|[134]\\d)\\d{5}", "\\d{7}", , , "5522010"],
        [, , "(?:9[01]|15)\\d{6}", "\\d{8}", , , "90792024"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SO", 252, "00", , , , , , , , [
            [, "([13-5])(\\d{6})", "$1 $2", ["[13-5]"], "", ""],
            [, "([19]\\d)(\\d{6})", "$1 $2", ["[19]"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    SR: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SR", 597, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    ST: [, [, , "[29]\\d{6}", "\\d{7}"],
        [, , "22\\d{5}", "\\d{7}", , , "2221234"],
        [, , "9[89]\\d{5}", "\\d{7}", , , "9812345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ST", 239, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    SV: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SV", 503, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    SY: [, [, , "[1-59]\\d{7,8}", "\\d{6,9}"],
        [, , "(?:1(?:1\\d?|4\\d|[2356])|2[1-35]|3(?:1\\d|[34])|4[13]|5[1-3])\\d{6}", "\\d{6,9}", , , "112345678"],
        [, , "9(?:3[23]|4[457]|55|6[67]|88|9[19])\\d{6}", "\\d{9}", , , "944567890"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SY", 963, "00", "0", , , "0", , , , [
            [, "(\\d{2})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[1-5]"], "0$1", ""],
            [, "(9[3-689])(\\d{4})(\\d{3})", "$1 $2 $3", ["9"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    SZ: [, [, , "[2-7]\\d{6,7}", "\\d{7,8}"],
        [, , "2?(?:2(?:0[07]|[13]7|2[57])|3(?:0[34]|[1278]3|3[23]|[46][34])|(?:40[4-69]|16|2[12]|3[57]|[4578]2|67)|5(?:0[5-7]|1[6-9]|[23][78]|48|5[01]))\\d{4}", "\\d{7,8}", , , "2171234"],
        [, , "(?:6|7[67])\\d{6}", "\\d{7,8}", , , "76123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "SZ", 268, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", ["[2-6]"], "", ""],
            [, "(\\d{4})(\\d{4})", "$1 $2", ["7"], "", ""]
        ], , [, , "NA", "NA"]
    ],
    TC: [, [, , "[689]\\d{9}", "\\d{7,10}"],
        [, , "649(?:712|9(?:4\\d|50))\\d{4}", "\\d{7,10}", , , "6497121234"],
        [, , "649(?:2(?:3[12]|4[1-5])|3(?:3[1-39]|4[1-57])|4[34][12])\\d{4}", "\\d{10}", , , "6492311234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "64971[01]\\d{4}", "\\d{10}", , , "6497101234"], "TC", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "649"],
    TD: [, [, , "[2679]\\d{7}", "\\d{8}"],
        [, , "22(?:[3789]0|5[0-5]|6[89])\\d{4}", "\\d{8}", , , "22501234"],
        [, , "(?:6(?:3[0-7]|6\\d)|77\\d|9(?:5[0-4]|9\\d))\\d{5}", "\\d{8}", , , "63012345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TD", 235, "00|16", , , , , , "00", , [
            [, "(\\d{2})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    TF: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TF", 262, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    TG: [, [, , "[02-9]\\d{6}", "\\d{7}"],
        [, , "(?:2[2-7]|3[23]|44|55|66|77)\\d{5}", "\\d{7}", , , "2212345"],
        [, , "(?:0[1-9]|7[56]|8[1-7]|9\\d)\\d{5}", "\\d{7}", , , "0112345"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TG", 228, "00", , , , , , , , [
            [, "(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    TH: [, [, , "[2-8]\\d{7,8}|1\\d{9}", "\\d{8,10}"],
        [, , "(?:2[1-9]|3[24-9]|4[2-5]|5[3-6]|7[3-7])\\d{6}", "\\d{8}", , , "21234567"],
        [, , "8\\d{8}", "\\d{9}", , , "812345678"],
        [, , "1800\\d{6}", "\\d{10}", , , "1800123456"],
        [, , "1900\\d{6}", "\\d{10}", , , "1900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "60\\d{7}", "\\d{9}", , , "601234567"], "TH", 66, "00", "0", , , "0", , , , [
            [, "(2)(\\d{3})(\\d{4})", "$1 $2 $3", ["2"], "0$1", ""],
            [, "([3-7]\\d)(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[3-7]"], "0$1", ""],
            [, "(8)(\\d{4})(\\d{4})", "$1 $2 $3", ["8"], "0$1", ""],
            [, "(1[89]00)(\\d{3})(\\d{3})", "$1 $2 $3", ["1"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    TJ: [, [, , "[349]\\d{8}", "\\d{3,9}"],
        [, , "(?:3(?:1[3-5]|2[245]|31|4[24-7]|5[25]|72)|4(?:46|74|87))\\d{6}", "\\d{3,9}", , , "372123456"],
        [, , "9[0-35-9]\\d{7}", "\\d{9}", , , "917123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TJ", 992, "8~10", "8", , , "8", , , , [
            [, "([349]\\d{2})(\\d{2})(\\d{4})", "$1 $2 $3", ["[34]7|91[78]"], "8$1", ""],
            [, "([49]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["4[48]|9(?:19|[0235-9])"], "8$1", ""],
            [, "(331700)(\\d)(\\d{2})", "$1 $2 $3", ["331", "3317", "33170", "331700"], "8$1", ""],
            [, "(\\d{4})(\\d)(\\d{4})", "$1 $2 $3", ["3[1-5]", "3(?:[1245]|3(?:[02-9]|1[0-589]))"], "8$1", ""]
        ], , [, , "NA", "NA"]
    ],
    TK: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TK", 690, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    TL: [, [, , "[2-47-9]\\d{6}", "\\d{7}"],
        [, , "(?:2[1-5]|3[1-9]|4[1-4])\\d{5}", "\\d{7}", , , "2112345"],
        [, , "7[2-4]\\d{5}", "\\d{7}", , , "7212345"],
        [, , "80\\d{5}", "\\d{7}", , , "8012345"],
        [, , "90\\d{5}", "\\d{7}", , , "9012345"],
        [, , "NA", "NA"],
        [, , "70\\d{5}", "\\d{7}", , , "7012345"],
        [, , "NA", "NA"], "TL", 670, "00", , , , , , , , [
            [, "(\\d{3})(\\d{4})", "$1 $2", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    TM: [, [, , "[1-6]\\d{7}", "\\d{8}"],
        [, , "(?:12\\d|243|[3-5]22)\\d{5}", "\\d{8}", , , "12345678"],
        [, , "6[6-8]\\d{6}", "\\d{8}", , , "66123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TM", 993, "8~10", "8", , , "8", , , , [
            [, "([1-6]\\d)(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "8 $1", ""]
        ], , [, , "NA", "NA"]
    ],
    TN: [, [, , "[247-9]\\d{7}", "\\d{8}"],
        [, , "7\\d{7}", "\\d{8}", , , "71234567"],
        [, , "(?:2[0-7]|40|9\\d)\\d{6}", "\\d{8}", , , "20123456"],
        [, , "NA", "NA"],
        [, , "8[028]\\d{6}", "\\d{8}", , , "80123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TN", 216, "00", , , , , , , , [
            [, "([247-9]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    TO: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TO", 676, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    TR: [, [, , "[2-589]\\d{9}", "\\d{10}"],
        [, , "[2-4]\\d{9}|850\\d{7}", "\\d{10}", , , "2123456789"],
        [, , "5\\d{9}", "\\d{10}", , , "5123456789"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "900\\d{7}", "\\d{10}", , , "9001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TR", 90, "00", "0", , , "0", , , , [
            [, "([2-589]\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    TT: [, [, , "[89]\\d{9}", "\\d{7,10}"],
        [, , "868(?:2(?:01|2[1-4])|6(?:1[4-6]|2[1-9]|[3-6]\\d|7[0-79]|9[0-8])|82[12])\\d{4}", "\\d{7,10}", , , "8682211234"],
        [, , "868(?:29\\d|3(?:0[1-9]|1[02-9]|[2-9]\\d)|4(?:[679]\\d|8[0-4])|6(?:20|78|8\\d)|7(?:1[02-9]|[2-9]\\d))\\d{4}", "\\d{10}", , , "8682911234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TT", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "868"],
    TV: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TV", 688, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    TW: [, [, , "[2-9]\\d{7,8}", "\\d{8,9}"],
        [, , "[2-8]\\d{7,8}", "\\d{8,9}", , , "21234567"],
        [, , "9\\d{8}", "\\d{9}", , , "912345678"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "900\\d{6}", "\\d{9}", , , "900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "TW", 886, "0(?:0[25679]|19)", "0", "#", , "0", , , , [
            [, "([2-8])(\\d{3,4})(\\d{4})", "$1 $2 $3", ["[2-7]|8[1-9]"], "0$1", ""],
            [, "([89]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["80|9"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    TZ: [, [, , "\\d{9}", "\\d{7,9}"],
        [, , "2[2-8]\\d{7}", "\\d{7,9}", , , "222345678"],
        [, , "(?:6[158]|7[1-9])(?:\\d{7})", "\\d{9}", , , "612345678"],
        [, , "80[08]\\d{6}", "\\d{9}", , , "800123456"],
        [, , "90\\d{7}", "\\d{9}", , , "900123456"],
        [, , "8(?:40|6[01])\\d{6}", "\\d{9}", , , "840123456"],
        [, , "NA", "NA"],
        [, , "41\\d{7}", "\\d{9}", , , "412345678"], "TZ", 255, "00[056]", "0", , , "0", , , , [
            [, "([24]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["[24]"], "0$1", ""],
            [, "([67]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["[67]"], "0$1", ""],
            [, "([89]\\d{2})(\\d{2})(\\d{4})", "$1 $2 $3", ["[89]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    UA: [, [, , "[3-689]\\d{8}", "\\d{5,9}"],
        [, , "(?:3[1-8]|4[13-8]|5[1-7]|6[12459])\\d{7}", "\\d{5,9}", , , "311234567"],
        [, , "(?:39|50|6[36-8]|9[1-9])\\d{7}", "\\d{9}", , , "391234567"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "900\\d{6}", "\\d{9}", , , "900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "UA", 380, "0~0", "0", , , "0", , , , [
            [, "([3-69]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["39|4(?:[45][0-5]|87)|5(?:0|6[37]|7[37])|6[36-8]|9[1-9]", "39|4(?:[45][0-5]|87)|5(?:0|6(?:3[14-7]|7)|7[37])|6[36-8]|9[1-9]"], "0$1", ""],
            [, "([3-689]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["3[1-8]2|4[1378]2|5(?:[12457]2|6[24])|6(?:[49]2|[12][29]|5[24])|8|90", "3(?:[1-46-8]2[013-9]|52)|4[1378]2|5(?:[12457]2|6[24])|6(?:[49]2|[12][29]|5[24])|8|90"], "0$1", ""],
            [, "([3-6]\\d{3})(\\d{5})", "$1 $2", ["3(?:5[013-9]|[1-46-8])|4(?:[137][013-9]|6|[45][6-9]|8[4-6])|5(?:[1245][013-9]|6[0135-9]|3|7[4-6])|6(?:[49][013-9]|5[0135-9]|[12][13-8])", "3(?:5[013-9]|[1-46-8](?:22|[013-9]))|4(?:[137][013-9]|6|[45][6-9]|8[4-6])|5(?:[1245][013-9]|6(?:3[02389]|[015689])|3|7[4-6])|6(?:[49][013-9]|5[0135-9]|[12][13-8])"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    UG: [, [, , "\\d{9}", "\\d{5,9}"],
        [, , "3\\d{8}|4(?:[1-6]\\d|7[136]|8[1356]|96)\\d{6}|20(?:0\\d|24)\\d{5}", "\\d{5,9}", , , "312345678"],
        [, , "7(?:[1578]\\d|0[0-4])\\d{6}", "\\d{9}", , , "712345678"],
        [, , "800[123]\\d{5}", "\\d{9}", , , "800123456"],
        [, , "90[123]\\d{6}", "\\d{9}", , , "901123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "UG", 256, "00[057]", "0", , , "0", , , , [
            [, "([247-9]\\d{2})(\\d{6})", "$1 $2", ["[7-9]|200|4(?:6[45]|[7-9])"], "0$1", ""],
            [, "([34]\\d)(\\d{7})", "$1 $2", ["3|4(?:[1-5]|6[0-36-9])"], "0$1", ""],
            [, "(2024)(\\d{5})", "$1 $2", ["202"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    US: [, [, , "[2-9]\\d{9}", "\\d{7,10}"],
        [, , "(?:2(?:0[1-35-9]|1[02-9]|2[4589]|3[149]|4[08]|5[1-46]|6[0279]|7[06]|8[13])|3(?:0[1-57-9]|1[02-9]|2[0135]|3[014679]|47|5[12]|6[01]|8[056])|4(?:0[124-9]|1[02-579]|2[3-5]|3[0245]|4[0235]|69|7[089]|8[04])|5(?:0[1-57-9]|1[0235-8]|[23]0|4[01]|5[19]|6[1-37]|7[013-5]|8[056])|6(?:0[1-35-9]|1[024-9]|2[036]|3[016]|4[16]|5[017]|6[0-29]|78|8[12])|7(?:0[1-46-8]|1[2-9]|2[047]|3[124]|4[07]|5[47]|6[02359]|7[02-59]|8[156])|8(?:0[1-68]|1[02-8]|28|3[0-25]|4[3578]|5[06-9]|6[02-5]|7[028])|9(?:0[1346-9]|1[02-9]|2[058]|3[167]|4[0179]|5[1246]|7[0-3589]|8[059]))[2-9]\\d{6}", "\\d{7,10}", , , "2012345678"],
        [, , "(?:2(?:0[1-35-9]|1[02-9]|2[4589]|3[149]|4[08]|5[1-46]|6[0279]|7[06]|8[13])|3(?:0[1-57-9]|1[02-9]|2[0135]|3[014679]|47|5[12]|6[01]|8[056])|4(?:0[124-9]|1[02-579]|2[3-5]|3[0245]|4[0235]|69|7[089]|8[04])|5(?:0[1-57-9]|1[0235-8]|[23]0|4[01]|5[19]|6[1-37]|7[013-5]|8[056])|6(?:0[1-35-9]|1[024-9]|2[036]|3[016]|4[16]|5[017]|6[0-29]|78|8[12])|7(?:0[1-46-8]|1[2-9]|2[047]|3[124]|4[07]|5[47]|6[02359]|7[02-59]|8[156])|8(?:0[1-68]|1[02-8]|28|3[0-25]|4[3578]|5[06-9]|6[02-5]|7[028])|9(?:0[1346-9]|1[02-9]|2[058]|3[167]|4[0179]|5[1246]|7[0-3589]|8[059]))[2-9]\\d{6}", "\\d{7,10}", , , "2012345678"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "US", 1, "011", "1", , , "1", , , 1, [
            [, "(\\d{3})(\\d{3})(\\d{4})", "($1) $2-$3", , "", ""],
            [, "(\\d{3})(\\d{4})", "$1-$2", , "", ""]
        ],
        [
            [, "(\\d{3})(\\d{3})(\\d{4})", "$1-$2-$3", , , ""]
        ],
        [, , "NA", "NA"], 1],
    UY: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "UY", 598, "00", "0", , , "0", , , 1, , , [, , "NA", "NA"]
    ],
    UZ: [, [, , "[679]\\d{8}", "\\d{7,9}"],
        [, , "(?:6[125679]|7[0-69])\\d{7}", "\\d{7,9}", , , "612345678"],
        [, , "9[0-57-9]\\d{7}", "\\d{7,9}", , , "912345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "UZ", 998, "8~10", "8", , , "8", , , , [
            [, "([679]\\d)(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", , "8$1", ""]
        ], , [, , "NA", "NA"]
    ],
    VA: [, [, , "06\\d{8}", "\\d{10}"],
        [, , "06698\\d{5}", "\\d{10}", , , "0669812345"],
        [, , "N/A", "N/A"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VA", 379, "00", , , , , , , , [
            [, "(06)(\\d{4})(\\d{4})", "$1 $2 $3", , "", ""]
        ], , [, , "NA", "NA"]
    ],
    VC: [, [, , "(?:784|8(?:00|66|77|88)|900)[2-9]\\d{6}", "\\d{7,10}"],
        [, , "784(?:266|3(?:6[6-9]|7\\d|8[0-24-6])|4(?:38|5[0-36-8]|8\\d|9[01])|555|638|784)\\d{4}", "\\d{7,10}", , , "7842661234"],
        [, , "784(?:4(?:3[0-24]|5[45]|9[2-5])|5(?:2[6-9]|3[0-3]|93))\\d{4}", "\\d{10}", , , "7844301234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VC", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "784"],
    VE: [, [, , "[24589]\\d{9}", "\\d{7,10}"],
        [, , "(?:2(?:12|3[457-9]|[58][1-9]|[467]\\d|9[1-6])|50[01])\\d{7}", "\\d{7,10}", , , "2121234567"],
        [, , "4(?:1[24-8]|2[46])\\d{7}", "\\d{10}", , , "4121234567"],
        [, , "800\\d{7}", "\\d{10}", , , "8001234567"],
        [, , "900\\d{7}", "\\d{10}", , , "9001234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VE", 58, "00", "0", , , "1\\d{2}|0", , , , [
            [, "(\\d{3})(\\d{7})", "$1-$2", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    VG: [, [, , "(?:284|8(?:00|66|77|88)|900)[2-9]\\d{6}", "\\d{7,10}"],
        [, , "284(?:(?:229|4(?:46|9[45])|8(?:52|6[459]))\\d{4}|496[0-5]\\d{3})", "\\d{7,10}", , , "2842291234"],
        [, , "284(?:(?:30[0-3]|4(?:4[0-5]|68|99)|54[0-4])\\d{4}|496[6-9]\\d{3})", "\\d{10}", , , "2843001234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VG", 1, "011", "1", , , "1", , , , , , [, , "NA", "NA"], , "284"],
    VI: [, [, , "340(?:6[49]2|7[17]\\d)\\d{4}|(?:8(?:00|66|77|88)|900)[2-9]\\d{6}", "\\d{7,10}"],
        [, , "340(?:6[49]2|7[17]\\d)\\d{4}|(?:8(?:00|66|77|88)|900)[2-9]\\d{6}", "\\d{7,10}", , , "3406421234"],
        [, , "340(?:6[49]2|7[17]\\d)\\d{4}|(?:8(?:00|66|77|88)|900)[2-9]\\d{6}", "\\d{7,10}", , , "3406421234"],
        [, , "8(?:00|55|66|77|88)[2-9]\\d{6}", "\\d{10}", , , "8002345678"],
        [, , "900[2-9]\\d{6}", "\\d{10}", , , "9002345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VI", 1, "011", "1", , , "1", , , 1, , , [, , "NA", "NA"], , "340"],
    VN: [, [, , "8\\d{5,8}|[1-79]\\d{7,9}", "\\d{7,10}"],
        [, , "(?:2(?:[025-79]|1[0189]|[348][01])|3(?:[0136-9]|[25][01])|[48]\\d|5(?:[01][01]|[2-9])|6(?:[0-46-8]|5[01])|7(?:[02-79]|[18][01]))\\d{7}|69\\d{5,6}|80\\d{5}", "\\d{7,10}", , , "2101234567"],
        [, , "(?:9\\d|1(?:2[1-35-9]|6[3-9]|99))\\d{7}", "\\d{9,10}", , , "912345678"],
        [, , "1800\\d{4,6}", "\\d{8,10}", , , "1800123456"],
        [, , "1900\\d{4,6}", "\\d{8,10}", , , "1900123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VN", 84, "00", "0", , , "0", , , , [
            [, "([48])(\\d{4})(\\d{4})", "$1 $2 $3", ["[48]"], "0$1", ""],
            [, "([235-7]\\d)(\\d{4})(\\d{3})", "$1 $2 $3", ["2[025-79]|3[0136-9]|5[2-9]|6[0-46-9]|7[02-79]"], "0$1", ""],
            [, "(80)(\\d{5})", "$1 $2", ["80"], "0$1", ""],
            [, "(69\\d)(\\d{4,5})", "$1 $2", ["69"], "0$1", ""],
            [, "([235-7]\\d{2})(\\d{4})(\\d{3})", "$1 $2 $3", ["2[1348]|3[25]|5[01]|65|7[18]"], "0$1", ""],
            [, "(9\\d)(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["9"], "0$1", ""],
            [, "(1[269]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["1(?:[26]|99)"], "0$1", ""],
            [, "(1[89]00)(\\d{4,6})", "$1 $2", ["1(?:8|90)"], "$1", ""]
        ], , [, , "NA", "NA"]
    ],
    VU: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "VU", 678, "00", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    WF: [, [],
        [],
        [],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "WF", 681, "19", , , , , , , 1, , , [, , "NA", "NA"]
    ],
    WS: [, [, , "[2-8]\\d{4,6}", "\\d{5,7}"],
        [, , "(?:[2-5]\\d|6[1-9]|840\\d)\\d{3}", "\\d{5,7}", , , "22123"],
        [, , "(?:60|7[25-7]\\d)\\d{4}", "\\d{6,7}", , , "601234"],
        [, , "800\\d{3}", "\\d{6}", , , "800123"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "WS", 685, "0", "0", , , "0", , , , [
            [, "(8[04]0)(\\d{3,4})", "$1 $2", ["8[04]0"], "0$1", ""],
            [, "(7[25-7])(\\d{5})", "$1 $2", ["7[25-7]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    YE: [, [, , "[1-7]\\d{6,8}", "\\d{6,9}"],
        [, , "(?:1(?:7\\d|[2-68])|2[2-68]|3[2358]|4[2-58]|5[2-6]|6[3-58]|7[24-68])\\d{5}", "\\d{6,8}", , , "1234567"],
        [, , "7[137]\\d{7}", "\\d{9}", , , "712345678"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "YE", 967, "00", "0", , , "0", , , , [
            [, "([1-7])(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[1-6]|7[24-68]"], "0$1", ""],
            [, "(7[137]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["7[137]"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    YT: [, [, , "[268]\\d{8}", "\\d{9}"],
        [, , "2696[0-4]\\d{4}", "\\d{9}", , , "269601234"],
        [, , "639\\d{6}", "\\d{9}", , , "639123456"],
        [, , "80\\d{7}", "\\d{9}", , , "801234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "YT", 262, "00", "0", , , "0", , , , , , [, , "NA", "NA"], , "269|63"],
    ZA: [, [, , "\\d{9}", "\\d{8,9}"],
        [, , "(?:1[0-8]|2[1-478]|3[1-69]|4\\d|5[1346-8])\\d{7}", "\\d{8,9}", , , "101234567"],
        [, , "(?:7[1-4689]|8[1-5789])\\d{7}", "\\d{9}", , , "711234567"],
        [, , "80\\d{7}", "\\d{9}", , , "801234567"],
        [, , "86\\d{7}", "\\d{9}", , , "861234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "87\\d{7}", "\\d{9}", , , "871234567"], "ZA", 27, "00", "0", , , "0", , , , [
            [, "([1-578]\\d)(\\d{3})(\\d{4})", "$1 $2 $3", , "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    ZM: [, [, , "[289]\\d{8}", "\\d{9}"],
        [, , "21[1-8]\\d{6}", "\\d{9}", , , "211234567"],
        [, , "9(?:55|6[4-9]|7[4-9])\\d{6}", "\\d{9}", , , "955123456"],
        [, , "800\\d{6}", "\\d{9}", , , "800123456"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"], "ZM", 260, "00", "0", , , "0", , , , [
            [, "([29]\\d)(\\d{7})", "$1 $2", ["[29]"], "0$1", ""],
            [, "(800)(\\d{3})(\\d{3})", "$1 $2 $3", ["8"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ],
    ZW: [, [, , "2(?:[012457-9]\\d{3,8}|6\\d{3,6})|[13-79]\\d{4,8}|86\\d{8}", "\\d{3,10}"],
        [, , "(?:1[3-9]|2(?:0[45]|[16]|2[28]|[49]8?|58[23]|7[246]|8[1346-9])|3(?:08?|17?|3[78]|[2456]|7[1569]|8[379])|5(?:[07-9]|1[78]|483|5(?:7?|8))|6(?:0|28|37?|[45][68][78]|98?)|848)\\d{3,6}|(?:2(?:27|5|7[135789]|8[25])|3[39]|5[1-46]|6[126-8])\\d{4,6}|2(?:0|70)\\d{5,6}|(?:4\\d|9[2-8])\\d{4,7}", "\\d{3,10}", , , "1312345"],
        [, , "(?:[19]1|7[13])\\d{6,7}", "\\d{8,9}", , , "911234567"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "NA", "NA"],
        [, , "86(?:1[12]|22|30|44|8[367]|99)\\d{6}", "\\d{10}", , , "8686123456"], "ZW", 263, "00", "0", , , "0", , , , [
            [, "([49])(\\d{3})(\\d{2,5})", "$1 $2 $3", ["4|9[2-9]"], "0$1", ""],
            [, "([179]\\d)(\\d{3})(\\d{3,4})", "$1 $2 $3", ["[19]1|7"], "0$1", ""],
            [, "([1-356]\\d)(\\d{3,5})", "$1 $2", ["1[3-9]|2(?:[1-469]|0[0-35-9]|[45][0-79])|3(?:0[0-79]|1[0-689]|[24-69]|3[0-69])|5(?:[02-46-9]|[15][0-69])|6(?:[0145]|[29][0-79]|3[0-689]|[68][0-69])"], "0$1", ""],
            [, "([1-356]\\d)(\\d{3})(\\d{3})", "$1 $2 $3", ["1[3-9]|2(?:[1-469]|0[0-35-9]|[45][0-79])|3(?:0[0-79]|1[0-689]|[24-69]|3[0-69])|5(?:[02-46-9]|[15][0-69])|6(?:[0145]|[29][0-79]|3[0-689]|[68][0-69])"], "0$1", ""],
            [, "([2356]\\d{2})(\\d{3,5})", "$1 $2", ["2(?:[278]|0[45]|48)|3(?:08|17|3[78]|[78])|5[15][78]|6(?:[29]8|37|[68][78])"], "0$1", ""],
            [, "([2356]\\d{2})(\\d{3})(\\d{3})", "$1 $2 $3", ["2(?:[278]|0[45]|48)|3(?:08|17|3[78]|[78])|5[15][78]|6(?:[29]8|37|[68][78])"], "0$1", ""],
            [, "([25]\\d{3})(\\d{3,5})", "$1 $2", ["(?:25|54)8", "258[23]|5483"], "0$1", ""],
            [, "([25]\\d{3})(\\d{3})(\\d{3})", "$1 $2 $3", ["(?:25|54)8", "258[23]|5483"], "0$1", ""],
            [, "(8\\d{3})(\\d{6})", "$1 $2", ["8"], "0$1", ""]
        ], , [, , "NA", "NA"]
    ]
};
goog.proto2.Serializer = function () {};
goog.proto2.Serializer.prototype.getSerializedValue = function (d, c) {
    return d.isCompositeType() ? this.serialize(c) : c
};
goog.proto2.Serializer.prototype.deserialize = function (e, d) {
    var f = e.createMessageInstance();
    this.deserializeTo(f, d);
    goog.proto2.Util.assert(f instanceof goog.proto2.Message);
    return f
};
goog.proto2.Serializer.prototype.getDeserializedValue = function (e, d) {
    if (e.isCompositeType()) {
        return this.deserialize(e.getFieldMessageType(), d)
    }
    if (!e.deserializationConversionPermitted()) {
        return d
    }
    var f = e.getNativeType();
    if (f === String) {
        if (typeof d === "number") {
            return String(d)
        }
    } else {
        if (f === Number) {
            if (typeof d === "string") {
                if (/^-?[0-9]+$/.test(d)) {
                    return Number(d)
                }
            }
        }
    }
    return d
};
goog.proto2.LazyDeserializer = function () {};
goog.inherits(goog.proto2.LazyDeserializer, goog.proto2.Serializer);
goog.proto2.LazyDeserializer.prototype.deserialize = function (e, d) {
    var f = e.createMessageInstance();
    f.initializeForLazyDeserializer(this, d);
    goog.proto2.Util.assert(f instanceof goog.proto2.Message);
    return f
};
goog.proto2.LazyDeserializer.prototype.deserializeTo = function () {
    throw Error("Unimplemented")
};
goog.proto2.PbLiteSerializer = function () {};
goog.inherits(goog.proto2.PbLiteSerializer, goog.proto2.LazyDeserializer);
goog.proto2.PbLiteSerializer.prototype.serialize = function (i) {
    for (var h = i.getDescriptor().getFields(), n = [], m = 0; m < h.length; m++) {
        var l = h[m];
        if (i.has(l)) {
            var k = l.getTag();
            if (l.isRepeated()) {
                n[k] = [];
                for (var j = 0; j < i.countOf(l); j++) {
                    n[k][j] = this.getSerializedValue(l, i.get(l, j))
                }
            } else {
                n[k] = this.getSerializedValue(l, i.get(l))
            }
        }
    }
    i.forEachUnknown(function (b, a) {
        n[b] = a
    });
    return n
};
goog.proto2.PbLiteSerializer.prototype.deserializeField = function (f, e, h) {
    if (h == null) {
        return h
    }
    if (e.isRepeated()) {
        f = [];
        goog.proto2.Util.assert(goog.isArray(h));
        for (var g = 0; g < h.length; g++) {
            f[g] = this.getDeserializedValue(e, h[g])
        }
        return f
    } else {
        return this.getDeserializedValue(e, h)
    }
};
goog.proto2.PbLiteSerializer.prototype.getSerializedValue = function (d, c) {
    if (d.getFieldType() == goog.proto2.FieldDescriptor.FieldType.BOOL) {
        return c ? 1 : 0
    }
    return goog.proto2.Serializer.prototype.getSerializedValue.apply(this, arguments)
};
goog.proto2.PbLiteSerializer.prototype.getDeserializedValue = function (d, c) {
    if (d.getFieldType() == goog.proto2.FieldDescriptor.FieldType.BOOL) {
        return c === 1
    }
    return goog.proto2.Serializer.prototype.getDeserializedValue.apply(this, arguments)
};
goog.userAgent = {};
goog.userAgent.jscript = {};
goog.userAgent.jscript.ASSUME_NO_JSCRIPT = false;
goog.userAgent.jscript.init_ = function () {
    goog.userAgent.jscript.DETECTED_HAS_JSCRIPT_ = "ScriptEngine" in goog.global && goog.global.ScriptEngine() == "JScript";
    goog.userAgent.jscript.DETECTED_VERSION_ = goog.userAgent.jscript.DETECTED_HAS_JSCRIPT_ ? goog.global.ScriptEngineMajorVersion() + "." + goog.global.ScriptEngineMinorVersion() + "." + goog.global.ScriptEngineBuildVersion() : "0"
};
goog.userAgent.jscript.ASSUME_NO_JSCRIPT || goog.userAgent.jscript.init_();
goog.userAgent.jscript.HAS_JSCRIPT = goog.userAgent.jscript.ASSUME_NO_JSCRIPT ? false : goog.userAgent.jscript.DETECTED_HAS_JSCRIPT_;
goog.userAgent.jscript.VERSION = goog.userAgent.jscript.ASSUME_NO_JSCRIPT ? "0" : goog.userAgent.jscript.DETECTED_VERSION_;
goog.userAgent.jscript.isVersion = function (b) {
    return goog.string.compareVersions(goog.userAgent.jscript.VERSION, b) >= 0
};
goog.string.StringBuffer = function (b) {
    this.buffer_ = goog.userAgent.jscript.HAS_JSCRIPT ? [] : "";
    b != null && this.append.apply(this, arguments)
};
goog.string.StringBuffer.prototype.set = function (b) {
    this.clear();
    this.append(b)
};
if (goog.userAgent.jscript.HAS_JSCRIPT) {
    goog.string.StringBuffer.prototype.bufferLength_ = 0;
    goog.string.StringBuffer.prototype.append = function (d, c) {
        if (c == null) {
            this.buffer_[this.bufferLength_++] = d
        } else {
            this.buffer_.push.apply(this.buffer_, arguments);
            this.bufferLength_ = this.buffer_.length
        }
        return this
    }
} else {
    goog.string.StringBuffer.prototype.append = function (e, d) {
        this.buffer_ += e;
        if (d != null) {
            for (var f = 1; f < arguments.length; f++) {
                this.buffer_ += arguments[f]
            }
        }
        return this
    }
}
goog.string.StringBuffer.prototype.clear = function () {
    if (goog.userAgent.jscript.HAS_JSCRIPT) {
        this.bufferLength_ = this.buffer_.length = 0
    } else {
        this.buffer_ = ""
    }
};
goog.string.StringBuffer.prototype.getLength = function () {
    return this.toString().length
};
goog.string.StringBuffer.prototype.toString = function () {
    if (goog.userAgent.jscript.HAS_JSCRIPT) {
        var b = this.buffer_.join("");
        this.clear();
        b && this.append(b);
        return b
    } else {
        return this.buffer_
    }
};
i18n.phonenumbers.PhoneNumberUtil = function () {
    this.countryToMetadata = {}
};
goog.addSingletonGetter(i18n.phonenumbers.PhoneNumberUtil);
i18n.phonenumbers.Error = {
    INVALID_COUNTRY_CODE: "Invalid country code",
    NOT_A_NUMBER: "The string supplied did not seem to be a phone number",
    TOO_SHORT_AFTER_IDD: "Phone number too short after IDD",
    TOO_SHORT_NSN: "The string supplied is too short to be a phone number",
    TOO_LONG: "The string supplied is too long to be a phone number"
};
i18n.phonenumbers.PhoneNumberUtil.NANPA_COUNTRY_CODE_ = 1;
i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_ = 3;
i18n.phonenumbers.PhoneNumberUtil.MAX_LENGTH_FOR_NSN_ = 15;
i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN = "+";
i18n.phonenumbers.PhoneNumberUtil.DIGIT_MAPPINGS = {
    "0": "0",
    "1": "1",
    "2": "2",
    "3": "3",
    "4": "4",
    "5": "5",
    "6": "6",
    "7": "7",
    "8": "8",
    "9": "9",
    "\uff10": "0",
    "\uff11": "1",
    "\uff12": "2",
    "\uff13": "3",
    "\uff14": "4",
    "\uff15": "5",
    "\uff16": "6",
    "\uff17": "7",
    "\uff18": "8",
    "\uff19": "9",
    "\u0660": "0",
    "\u0661": "1",
    "\u0662": "2",
    "\u0663": "3",
    "\u0664": "4",
    "\u0665": "5",
    "\u0666": "6",
    "\u0667": "7",
    "\u0668": "8",
    "\u0669": "9"
};
i18n.phonenumbers.PhoneNumberUtil.ALPHA_MAPPINGS_ = {
    A: "2",
    B: "2",
    C: "2",
    D: "3",
    E: "3",
    F: "3",
    G: "4",
    H: "4",
    I: "4",
    J: "5",
    K: "5",
    L: "5",
    M: "6",
    N: "6",
    O: "6",
    P: "7",
    Q: "7",
    R: "7",
    S: "7",
    T: "8",
    U: "8",
    V: "8",
    W: "9",
    X: "9",
    Y: "9",
    Z: "9"
};
i18n.phonenumbers.PhoneNumberUtil.ALL_NORMALIZATION_MAPPINGS_ = {
    "0": "0",
    "1": "1",
    "2": "2",
    "3": "3",
    "4": "4",
    "5": "5",
    "6": "6",
    "7": "7",
    "8": "8",
    "9": "9",
    "\uff10": "0",
    "\uff11": "1",
    "\uff12": "2",
    "\uff13": "3",
    "\uff14": "4",
    "\uff15": "5",
    "\uff16": "6",
    "\uff17": "7",
    "\uff18": "8",
    "\uff19": "9",
    "\u0660": "0",
    "\u0661": "1",
    "\u0662": "2",
    "\u0663": "3",
    "\u0664": "4",
    "\u0665": "5",
    "\u0666": "6",
    "\u0667": "7",
    "\u0668": "8",
    "\u0669": "9",
    A: "2",
    B: "2",
    C: "2",
    D: "3",
    E: "3",
    F: "3",
    G: "4",
    H: "4",
    I: "4",
    J: "5",
    K: "5",
    L: "5",
    M: "6",
    N: "6",
    O: "6",
    P: "7",
    Q: "7",
    R: "7",
    S: "7",
    T: "8",
    U: "8",
    V: "8",
    W: "9",
    X: "9",
    Y: "9",
    Z: "9"
};
i18n.phonenumbers.PhoneNumberUtil.LEADING_ZERO_COUNTRIES_ = {
    39: 1,
    47: 1,
    225: 1,
    227: 1,
    228: 1,
    241: 1,
    379: 1
};
i18n.phonenumbers.PhoneNumberUtil.UNIQUE_INTERNATIONAL_PREFIX_ = /[\d]+(?:[~\u2053\u223C\uFF5E][\d]+)?/;
i18n.phonenumbers.PhoneNumberUtil.VALID_PUNCTUATION_ = "-x\u2010-\u2015\u2212\uff0d-\uff0f \u00a0\u200b\u2060\u3000()\uff08\uff09\uff3b\uff3d.\\[\\]/~\u2053\u223c\uff5e";
i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ = "0-9\uff10-\uff19\u0660-\u0669";
i18n.phonenumbers.PhoneNumberUtil.VALID_ALPHA_ = "A-Za-z";
i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_ = "+\uff0b";
i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_PATTERN_ = RegExp("^[" + i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_ + "]+");
i18n.phonenumbers.PhoneNumberUtil.CAPTURING_DIGIT_PATTERN_ = RegExp("([" + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + "])");
i18n.phonenumbers.PhoneNumberUtil.VALID_START_CHAR_PATTERN = RegExp("[" + i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_ + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + "]");
i18n.phonenumbers.PhoneNumberUtil.SECOND_NUMBER_START_PATTERN_ = /[\\\/] *x/;
i18n.phonenumbers.PhoneNumberUtil.UNWANTED_END_CHAR_PATTERN_ = RegExp("[^" + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + i18n.phonenumbers.PhoneNumberUtil.VALID_ALPHA_ + "#]+$");
i18n.phonenumbers.PhoneNumberUtil.VALID_ALPHA_PHONE_PATTERN_ = /(?:.*?[A-Za-z]){3}.*/;
i18n.phonenumbers.PhoneNumberUtil.VALID_PHONE_NUMBER_ = "[" + i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_ + "]*(?:[" + i18n.phonenumbers.PhoneNumberUtil.VALID_PUNCTUATION_ + "]*[" + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + "]){3,}[" + i18n.phonenumbers.PhoneNumberUtil.VALID_ALPHA_ + i18n.phonenumbers.PhoneNumberUtil.VALID_PUNCTUATION_ + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + "]*";
i18n.phonenumbers.PhoneNumberUtil.DEFAULT_EXTN_PREFIX_ = " ext. ";
i18n.phonenumbers.PhoneNumberUtil.KNOWN_EXTN_PATTERNS_ = "[ \u00a0\\t,]*(?:ext(?:ensio)?n?|\uff45\uff58\uff54\uff4e?|[,x\uff58#\uff03~\uff5e]|int|anexo|\uff49\uff4e\uff54)[:\\.\uff0e]?[ \u00a0\\t,-]*([" + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + "]{1,7})#?|[- ]+([" + i18n.phonenumbers.PhoneNumberUtil.VALID_DIGITS_ + "]{1,5})#";
i18n.phonenumbers.PhoneNumberUtil.EXTN_PATTERN_ = RegExp("(?:" + i18n.phonenumbers.PhoneNumberUtil.KNOWN_EXTN_PATTERNS_ + ")$", "i");
i18n.phonenumbers.PhoneNumberUtil.VALID_PHONE_NUMBER_PATTERN_ = RegExp("^" + i18n.phonenumbers.PhoneNumberUtil.VALID_PHONE_NUMBER_ + "(?:" + i18n.phonenumbers.PhoneNumberUtil.KNOWN_EXTN_PATTERNS_ + ")?$", "i");
i18n.phonenumbers.PhoneNumberUtil.NON_DIGITS_PATTERN_ = /\D+/;
i18n.phonenumbers.PhoneNumberUtil.FIRST_GROUP_PATTERN_ = /(\$1)/;
i18n.phonenumbers.PhoneNumberUtil.NP_PATTERN_ = /\$NP/;
i18n.phonenumbers.PhoneNumberUtil.FG_PATTERN_ = /\$FG/;
i18n.phonenumbers.PhoneNumberUtil.CC_PATTERN_ = /\$CC/;
i18n.phonenumbers.PhoneNumberFormat = {
    E164: 0,
    INTERNATIONAL: 1,
    NATIONAL: 2
};
i18n.phonenumbers.PhoneNumberType = {
    FIXED_LINE: 0,
    MOBILE: 1,
    FIXED_LINE_OR_MOBILE: 2,
    TOLL_FREE: 3,
    PREMIUM_RATE: 4,
    SHARED_COST: 5,
    VOIP: 6,
    PERSONAL_NUMBER: 7,
    PAGER: 8,
    UNKNOWN: 9
};
i18n.phonenumbers.PhoneNumberUtil.MatchType = {
    NO_MATCH: 0,
    SHORT_NSN_MATCH: 1,
    NSN_MATCH: 2,
    EXACT_MATCH: 3
};
i18n.phonenumbers.PhoneNumberUtil.ValidationResult = {
    IS_POSSIBLE: 0,
    INVALID_COUNTRY_CODE: 1,
    TOO_SHORT: 2,
    TOO_LONG: 3
};
i18n.phonenumbers.PhoneNumberUtil.extractPossibleNumber = function (d) {
    var c = d.search(i18n.phonenumbers.PhoneNumberUtil.VALID_START_CHAR_PATTERN);
    if (c >= 0) {
        d = d.substring(c);
        d = d.replace(i18n.phonenumbers.PhoneNumberUtil.UNWANTED_END_CHAR_PATTERN_, "");
        c = d.search(i18n.phonenumbers.PhoneNumberUtil.SECOND_NUMBER_START_PATTERN_);
        if (c >= 0) {
            d = d.substring(0, c)
        }
    } else {
        d = ""
    }
    return d
};
i18n.phonenumbers.PhoneNumberUtil.isViablePhoneNumber = function (b) {
    if (b.length < i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_) {
        return false
    }
    return i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(i18n.phonenumbers.PhoneNumberUtil.VALID_PHONE_NUMBER_PATTERN_, b)
};
i18n.phonenumbers.PhoneNumberUtil.normalize = function (b) {
    return i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(i18n.phonenumbers.PhoneNumberUtil.VALID_ALPHA_PHONE_PATTERN_, b) ? i18n.phonenumbers.PhoneNumberUtil.normalizeHelper_(b, i18n.phonenumbers.PhoneNumberUtil.ALL_NORMALIZATION_MAPPINGS_, true) : i18n.phonenumbers.PhoneNumberUtil.normalizeHelper_(b, i18n.phonenumbers.PhoneNumberUtil.DIGIT_MAPPINGS, true)
};
i18n.phonenumbers.PhoneNumberUtil.normalizeSB_ = function (d) {
    var c = i18n.phonenumbers.PhoneNumberUtil.normalize(d.toString());
    d.clear();
    d.append(c)
};
i18n.phonenumbers.PhoneNumberUtil.normalizeDigitsOnly = function (b) {
    return i18n.phonenumbers.PhoneNumberUtil.normalizeHelper_(b, i18n.phonenumbers.PhoneNumberUtil.DIGIT_MAPPINGS, true)
};
i18n.phonenumbers.PhoneNumberUtil.convertAlphaCharactersInNumber = function (b) {
    return i18n.phonenumbers.PhoneNumberUtil.normalizeHelper_(b, i18n.phonenumbers.PhoneNumberUtil.ALL_NORMALIZATION_MAPPINGS_, false)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getLengthOfGeographicalAreaCode = function (e) {
    if (e == null) {
        return 0
    }
    var d = this.getRegionCodeForNumber(e);
    if (!this.isValidRegionCode_(d)) {
        return 0
    }
    var f = this.getMetadataForRegion(d);
    if (!f.hasNationalPrefix() && !this.isNANPACountry(d)) {
        return 0
    }
    d = this.getNumberTypeHelper_(i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(e), f);
    if (d != i18n.phonenumbers.PhoneNumberType.FIXED_LINE && d != i18n.phonenumbers.PhoneNumberType.FIXED_LINE_OR_MOBILE) {
        return 0
    }
    if (e.hasExtension()) {
        d = new i18n.phonenumbers.PhoneNumber;
        d.mergeFrom(e);
        d.clearExtension()
    } else {
        d = e
    }
    e = this.format(d, i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL).split(i18n.phonenumbers.PhoneNumberUtil.NON_DIGITS_PATTERN_);
    e[0].length == 0 && e.shift();
    if (e.length <= 2) {
        return 0
    }
    return e[1].length
};
i18n.phonenumbers.PhoneNumberUtil.normalizeHelper_ = function (j, i, p) {
    for (var o = new goog.string.StringBuffer, n, m, l = j.length, k = 0; k < l; ++k) {
        n = j.charAt(k);
        m = i[n.toUpperCase()];
        if (m != null) {
            o.append(m)
        } else {
            p || o.append(n)
        }
    }
    return o.toString()
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isValidRegionCode_ = function (b) {
    return b != null && b.toUpperCase() in i18n.phonenumbers.metadata.countryToMetadata
};
i18n.phonenumbers.PhoneNumberUtil.prototype.format = function (h, g) {
    var l = h.getCountryCodeOrDefault(),
        k = i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(h);
    if (g == i18n.phonenumbers.PhoneNumberFormat.E164) {
        return this.formatNumberByFormat_(l, i18n.phonenumbers.PhoneNumberFormat.E164, k, "")
    }
    var j = this.getRegionCodeForCountryCode(l);
    if (!this.isValidRegionCode_(j)) {
        return k
    }
    var i = this.maybeGetFormattedExtension_(h, j);
    k = this.formatNationalNumber_(k, j, g);
    return this.formatNumberByFormat_(l, g, k, i)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatByPattern = function (x, w, v) {
    var u = x.getCountryCodeOrDefault(),
        t = i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(x),
        s = this.getRegionCodeForCountryCode(u);
    if (!this.isValidRegionCode_(s)) {
        return t
    }
    for (var r = [], q = v.length, p = 0; p < q; ++p) {
        var o = v[p],
            m = o.getNationalPrefixFormattingRuleOrDefault();
        if (m.length > 0) {
            var n = new i18n.phonenumbers.NumberFormat;
            n.mergeFrom(o);
            o = this.getMetadataForRegion(s).getNationalPrefixOrDefault();
            if (o.length > 0) {
                m = m.replace(i18n.phonenumbers.PhoneNumberUtil.NP_PATTERN_, o).replace(i18n.phonenumbers.PhoneNumberUtil.FG_PATTERN_, "$1");
                n.setNationalPrefixFormattingRule(m)
            } else {
                n.clearNationalPrefixFormattingRule()
            }
            r.push(n)
        } else {
            r.push(o)
        }
    }
    x = this.maybeGetFormattedExtension_(x, s);
    t = this.formatAccordingToFormats_(t, r, w);
    return this.formatNumberByFormat_(u, w, t, x)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatNationalNumberWithCarrierCode = function (h, g) {
    var l = h.getCountryCodeOrDefault(),
        k = i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(h),
        j = this.getRegionCodeForCountryCode(l);
    if (!this.isValidRegionCode_(j)) {
        return k
    }
    var i = this.maybeGetFormattedExtension_(h, j);
    k = this.formatNationalNumber_(k, j, i18n.phonenumbers.PhoneNumberFormat.NATIONAL, g);
    return this.formatNumberByFormat_(l, i18n.phonenumbers.PhoneNumberFormat.NATIONAL, k, i)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatOutOfCountryCallingNumber = function (j, i) {
    if (!this.isValidRegionCode_(i)) {
        return this.format(j, i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL)
    }
    var p = j.getCountryCodeOrDefault(),
        o = this.getRegionCodeForCountryCode(p),
        n = i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(j);
    if (!this.isValidRegionCode_(o)) {
        return n
    }
    if (p == i18n.phonenumbers.PhoneNumberUtil.NANPA_COUNTRY_CODE_) {
        if (this.isNANPACountry(i)) {
            return p + " " + this.format(j, i18n.phonenumbers.PhoneNumberFormat.NATIONAL)
        }
    } else {
        if (p == this.getCountryCodeForRegion(i)) {
            return this.format(j, i18n.phonenumbers.PhoneNumberFormat.NATIONAL)
        }
    }
    n = this.formatNationalNumber_(n, o, i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL);
    var m = this.getMetadataForRegion(i),
        l = m.getInternationalPrefixOrDefault();
    o = this.maybeGetFormattedExtension_(j, o);
    var k = "";
    if (i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(i18n.phonenumbers.PhoneNumberUtil.UNIQUE_INTERNATIONAL_PREFIX_, l)) {
        k = l
    } else {
        if (m.hasPreferredInternationalPrefix()) {
            k = m.getPreferredInternationalPrefixOrDefault()
        }
    }
    return k != "" ? k + " " + p + " " + n + o : this.formatNumberByFormat_(p, i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL, n, o)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatInOriginalFormat = function (d, c) {
    if (!d.hasCountryCodeSource()) {
        return this.format(d, i18n.phonenumbers.PhoneNumberFormat.NATIONAL)
    }
    switch (d.getCountryCodeSource()) {
    case i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITH_PLUS_SIGN:
        return this.format(d, i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL);
    case i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITH_IDD:
        return this.formatOutOfCountryCallingNumber(d, c);
    case i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITHOUT_PLUS_SIGN:
        return this.format(d, i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL).substring(1);
    default:
        return this.format(d, i18n.phonenumbers.PhoneNumberFormat.NATIONAL)
    }
};
i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber = function (d) {
    var c = "" + d.getNationalNumber();
    if (d.hasItalianLeadingZero() && d.getItalianLeadingZero() && i18n.phonenumbers.PhoneNumberUtil.isLeadingZeroCountry(d.getCountryCodeOrDefault())) {
        return "0" + c
    }
    return c
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatNumberByFormat_ = function (f, e, h, g) {
    switch (e) {
    case i18n.phonenumbers.PhoneNumberFormat.E164:
        return i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN + f + h + g;
    case i18n.phonenumbers.PhoneNumberFormat.INTERNATIONAL:
        return i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN + f + " " + h + g;
    default:
        return h + g
    }
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatNationalNumber_ = function (f, e, h, g) {
    e = this.getMetadataForRegion(e);
    e = e.intlNumberFormatArray().length == 0 || h == i18n.phonenumbers.PhoneNumberFormat.NATIONAL ? e.numberFormatArray() : e.intlNumberFormatArray();
    return this.formatAccordingToFormats_(f, e, h, g)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatAccordingToFormats_ = function (r, q, p, o) {
    for (var n, m = q.length, l = 0; l < m; ++l) {
        n = q[l];
        var k = n.leadingDigitsPatternCount();
        if (k == 0 || r.search(n.getLeadingDigitsPattern(k - 1)) == 0) {
            k = RegExp(n.getPattern());
            var j = n.getFormatOrDefault();
            if (i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(k, r)) {
                if (o != null && o.length > 0) {
                    q = n.getDomesticCarrierCodeFormattingRuleOrDefault();
                    if (q.length > 0) {
                        o = q.replace(i18n.phonenumbers.PhoneNumberUtil.CC_PATTERN_, o);
                        j = j.replace(i18n.phonenumbers.PhoneNumberUtil.FIRST_GROUP_PATTERN_, o)
                    }
                }
                n = n.getNationalPrefixFormattingRuleOrDefault();
                return p == i18n.phonenumbers.PhoneNumberFormat.NATIONAL && n != null && n.length > 0 ? r.replace(k, j.replace(i18n.phonenumbers.PhoneNumberUtil.FIRST_GROUP_PATTERN_, n)) : r.replace(k, j)
            }
        }
    }
    return r
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getExampleNumber = function (b) {
    return this.getExampleNumberForType(b, i18n.phonenumbers.PhoneNumberType.FIXED_LINE)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getExampleNumberForType = function (f, e) {
    var h = this.getNumberDescByType_(this.getMetadataForRegion(f), e);
    try {
        if (h.hasExampleNumber()) {
            return this.parse(h.getExampleNumberOrDefault(), f)
        }
    } catch (g) {}
    return null
};
i18n.phonenumbers.PhoneNumberUtil.prototype.maybeGetFormattedExtension_ = function (d, c) {
    return d.hasExtension() ? this.formatExtension_(d.getExtensionOrDefault(), c) : ""
};
i18n.phonenumbers.PhoneNumberUtil.prototype.formatExtension_ = function (e, d) {
    var f = this.getMetadataForRegion(d);
    return f.hasPreferredExtnPrefix() ? f.getPreferredExtnPrefix() + e : i18n.phonenumbers.PhoneNumberUtil.DEFAULT_EXTN_PREFIX_ + e
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getNumberDescByType_ = function (d, c) {
    switch (c) {
    case i18n.phonenumbers.PhoneNumberType.PREMIUM_RATE:
        return d.getPremiumRate();
    case i18n.phonenumbers.PhoneNumberType.TOLL_FREE:
        return d.getTollFree();
    case i18n.phonenumbers.PhoneNumberType.MOBILE:
        return d.getMobile();
    case i18n.phonenumbers.PhoneNumberType.FIXED_LINE:
    case i18n.phonenumbers.PhoneNumberType.FIXED_LINE_OR_MOBILE:
        return d.getFixedLine();
    case i18n.phonenumbers.PhoneNumberType.SHARED_COST:
        return d.getSharedCost();
    case i18n.phonenumbers.PhoneNumberType.VOIP:
        return d.getVoip();
    case i18n.phonenumbers.PhoneNumberType.PERSONAL_NUMBER:
        return d.getPersonalNumber();
    case i18n.phonenumbers.PhoneNumberType.PAGER:
        return d.getPager();
    default:
        return d.getGeneralDesc()
    }
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getNumberType = function (d) {
    var c = this.getRegionCodeForNumber(d);
    if (!this.isValidRegionCode_(c)) {
        return i18n.phonenumbers.PhoneNumberType.UNKNOWN
    }
    return this.getNumberTypeHelper_(i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(d), this.getMetadataForRegion(c))
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getNumberTypeHelper_ = function (e, d) {
    var f = d.getGeneralDesc();
    if (!f.hasNationalNumberPattern() || !this.isNumberMatchingDesc_(e, f)) {
        return i18n.phonenumbers.PhoneNumberType.UNKNOWN
    }
    if (this.isNumberMatchingDesc_(e, d.getPremiumRate())) {
        return i18n.phonenumbers.PhoneNumberType.PREMIUM_RATE
    }
    if (this.isNumberMatchingDesc_(e, d.getTollFree())) {
        return i18n.phonenumbers.PhoneNumberType.TOLL_FREE
    }
    if (this.isNumberMatchingDesc_(e, d.getSharedCost())) {
        return i18n.phonenumbers.PhoneNumberType.SHARED_COST
    }
    if (this.isNumberMatchingDesc_(e, d.getVoip())) {
        return i18n.phonenumbers.PhoneNumberType.VOIP
    }
    if (this.isNumberMatchingDesc_(e, d.getPersonalNumber())) {
        return i18n.phonenumbers.PhoneNumberType.PERSONAL_NUMBER
    }
    if (this.isNumberMatchingDesc_(e, d.getPager())) {
        return i18n.phonenumbers.PhoneNumberType.PAGER
    }
    if (this.isNumberMatchingDesc_(e, d.getFixedLine())) {
        if (d.getSameMobileAndFixedLinePattern()) {
            return i18n.phonenumbers.PhoneNumberType.FIXED_LINE_OR_MOBILE
        } else {
            if (this.isNumberMatchingDesc_(e, d.getMobile())) {
                return i18n.phonenumbers.PhoneNumberType.FIXED_LINE_OR_MOBILE
            }
        }
        return i18n.phonenumbers.PhoneNumberType.FIXED_LINE
    }
    if (!d.getSameMobileAndFixedLinePattern() && this.isNumberMatchingDesc_(e, d.getMobile())) {
        return i18n.phonenumbers.PhoneNumberType.MOBILE
    }
    return i18n.phonenumbers.PhoneNumberType.UNKNOWN
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getMetadataForRegion = function (e) {
    if (e == null) {
        return null
    }
    e = e.toUpperCase();
    var d = this.countryToMetadata[e];
    if (d == null) {
        d = new goog.proto2.PbLiteSerializer;
        var f = i18n.phonenumbers.metadata.countryToMetadata[e];
        if (f == null) {
            return null
        }
        d = d.deserialize(i18n.phonenumbers.PhoneMetadata.getDescriptor(), f);
        this.countryToMetadata[e] = d
    }
    return d
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isNumberMatchingDesc_ = function (d, c) {
    return i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(c.getPossibleNumberPattern(), d) && i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(c.getNationalNumberPattern(), d)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isValidNumber = function (d) {
    var c = this.getRegionCodeForNumber(d);
    return this.isValidRegionCode_(c) && this.isValidNumberForRegion(d, c)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isValidNumberForRegion = function (g, f) {
    if (g.getCountryCodeOrDefault() != this.getCountryCodeForRegion(f)) {
        return false
    }
    var j = this.getMetadataForRegion(f),
        i = j.getGeneralDesc(),
        h = i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(g);
    if (!i.hasNationalNumberPattern()) {
        j = h.length;
        return j > i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_ && j <= i18n.phonenumbers.PhoneNumberUtil.MAX_LENGTH_FOR_NSN_
    }
    return this.getNumberTypeHelper_(h, j) != i18n.phonenumbers.PhoneNumberType.UNKNOWN
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getRegionCodeForNumber = function (d) {
    if (d == null) {
        return null
    }
    var c = d.getCountryCodeOrDefault();
    c = i18n.phonenumbers.metadata.countryCodeToRegionCodeMap[c];
    if (c == null) {
        return null
    }
    return c.length == 1 ? c[0] : this.getRegionCodeForNumberFromRegionList_(d, c)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getRegionCodeForNumberFromRegionList_ = function (i, h) {
    for (var n = "" + i.getNationalNumber(), m, l = h.length, k = 0; k < l; k++) {
        m = h[k];
        var j = this.getMetadataForRegion(m);
        if (j.hasLeadingDigits()) {
            if (n.search(j.getLeadingDigits()) == 0) {
                return m
            }
        } else {
            if (this.getNumberTypeHelper_(n, j) != i18n.phonenumbers.PhoneNumberType.UNKNOWN) {
                return m
            }
        }
    }
    return null
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getRegionCodeForCountryCode = function (b) {
    b = i18n.phonenumbers.metadata.countryCodeToRegionCodeMap[b];
    return b == null ? "ZZ" : b[0]
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getCountryCodeForRegion = function (b) {
    if (!this.isValidRegionCode_(b)) {
        return 0
    }
    b = this.getMetadataForRegion(b);
    if (b == null) {
        return 0
    }
    return b.getCountryCodeOrDefault()
};
i18n.phonenumbers.PhoneNumberUtil.prototype.getNddPrefixForRegion = function (e, d) {
    if (!this.isValidRegionCode_(e)) {
        return null
    }
    var f = this.getMetadataForRegion(e);
    if (f == null) {
        return null
    }
    f = f.getNationalPrefixOrDefault();
    if (f.length == 0) {
        return null
    }
    if (d) {
        f = f.replace("~", "")
    }
    return f
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isNANPACountry = function (b) {
    return goog.array.contains(i18n.phonenumbers.metadata.countryCodeToRegionCodeMap[i18n.phonenumbers.PhoneNumberUtil.NANPA_COUNTRY_CODE_], b.toUpperCase())
};
i18n.phonenumbers.PhoneNumberUtil.isLeadingZeroCountry = function (b) {
    return b in i18n.phonenumbers.PhoneNumberUtil.LEADING_ZERO_COUNTRIES_
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isPossibleNumber = function (b) {
    return this.isPossibleNumberWithReason(b) == i18n.phonenumbers.PhoneNumberUtil.ValidationResult.IS_POSSIBLE
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isPossibleNumberWithReason = function (d) {
    var c = this.getRegionCodeForCountryCode(d.getCountryCodeOrDefault());
    if (!this.isValidRegionCode_(c)) {
        return i18n.phonenumbers.PhoneNumberUtil.ValidationResult.INVALID_COUNTRY_CODE
    }
    d = i18n.phonenumbers.PhoneNumberUtil.getNationalSignificantNumber(d);
    c = this.getMetadataForRegion(c).getGeneralDesc();
    if (!c.hasNationalNumberPattern()) {
        d = d.length;
        return d < i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_ ? i18n.phonenumbers.PhoneNumberUtil.ValidationResult.TOO_SHORT : d > i18n.phonenumbers.PhoneNumberUtil.MAX_LENGTH_FOR_NSN_ ? i18n.phonenumbers.PhoneNumberUtil.ValidationResult.TOO_LONG : i18n.phonenumbers.PhoneNumberUtil.ValidationResult.IS_POSSIBLE
    }
    c = c.getPossibleNumberPatternOrDefault();
    c = (c = d.match("^" + c)) ? c[0] : "";
    return c.length > 0 ? c.length == d.length ? i18n.phonenumbers.PhoneNumberUtil.ValidationResult.IS_POSSIBLE : i18n.phonenumbers.PhoneNumberUtil.ValidationResult.TOO_LONG : i18n.phonenumbers.PhoneNumberUtil.ValidationResult.TOO_SHORT
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isPossibleNumberString = function (e, d) {
    try {
        return this.isPossibleNumber(this.parse(e, d))
    } catch (f) {
        return false
    }
};
i18n.phonenumbers.PhoneNumberUtil.prototype.truncateTooLongNumber = function (e) {
    if (this.isValidNumber(e)) {
        return true
    }
    var d = new i18n.phonenumbers.PhoneNumber;
    d.mergeFrom(e);
    var f = e.getNationalNumberOrDefault();
    do {
        f = Math.floor(f / 10);
        d.setNationalNumber(f);
        if (f == 0 || this.isPossibleNumberWithReason(d) == i18n.phonenumbers.PhoneNumberUtil.ValidationResult.TOO_SHORT) {
            return false
        }
    } while (!this.isValidNumber(d));
    e.setNationalNumber(f);
    return true
};
i18n.phonenumbers.PhoneNumberUtil.prototype.extractCountryCode = function (h, g) {
    for (var l = h.toString(), k, j = l.length, i = 1; i <= 3 && i <= j; ++i) {
        k = parseInt(l.substring(0, i), 10);
        if (k in i18n.phonenumbers.metadata.countryCodeToRegionCodeMap) {
            g.append(l.substring(i));
            return k
        }
    }
    return 0
};
i18n.phonenumbers.PhoneNumberUtil.prototype.maybeExtractCountryCode = function (r, q, p, o, n) {
    if (r.length == 0) {
        return 0
    }
    var m = new goog.string.StringBuffer(r),
        l;
    if (q != null) {
        l = q.getInternationalPrefix()
    }
    if (l == null) {
        l = "NonMatch"
    }
    l = this.maybeStripInternationalPrefixAndNormalize(m, l);
    o && n.setCountryCodeSource(l);
    if (l != i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_DEFAULT_COUNTRY) {
        if (m.getLength() < i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_) {
            throw i18n.phonenumbers.Error.TOO_SHORT_AFTER_IDD
        }
        p = this.extractCountryCode(m, p);
        if (p != 0) {
            n.setCountryCode(p);
            return p
        }
        throw i18n.phonenumbers.Error.INVALID_COUNTRY_CODE
    } else {
        if (q != null) {
            var k = q.getGeneralDesc();
            l = RegExp(k.getNationalNumberPattern());
            if (!i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(l, m.toString())) {
                r = q.getCountryCodeOrDefault();
                var j = "" + r;
                m = m.toString();
                if (goog.string.startsWith(m, j)) {
                    m = new goog.string.StringBuffer(m.substring(j.length));
                    this.maybeStripNationalPrefix(m, q.getNationalPrefixForParsing(), q.getNationalPrefixTransformRule(), l);
                    q = m.toString();
                    k = (k = q.match("^" + k.getPossibleNumberPattern())) && k[0] != null && k[0].length || 0;
                    if (i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(l, q) || k > 0 && k != q.length) {
                        p.append(q);
                        o && n.setCountryCodeSource(i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITHOUT_PLUS_SIGN);
                        n.setCountryCode(r);
                        return r
                    }
                }
            }
        }
    }
    n.setCountryCode(0);
    return 0
};
i18n.phonenumbers.PhoneNumberUtil.prototype.parsePrefixAsIdd_ = function (g, f) {
    var j = f.toString();
    if (j.search(g) == 0) {
        var i = j.match(g)[0].length,
            h = j.substring(i).match(i18n.phonenumbers.PhoneNumberUtil.CAPTURING_DIGIT_PATTERN_);
        if (h && h[1] != null && h[1].length > 0) {
            if (i18n.phonenumbers.PhoneNumberUtil.normalizeHelper_(h[1], i18n.phonenumbers.PhoneNumberUtil.DIGIT_MAPPINGS, true) == "0") {
                return false
            }
        }
        f.clear();
        f.append(j.substring(i));
        return true
    }
    return false
};
i18n.phonenumbers.PhoneNumberUtil.prototype.maybeStripInternationalPrefixAndNormalize = function (e, d) {
    var f = e.toString();
    if (f.length == 0) {
        return i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_DEFAULT_COUNTRY
    }
    if (i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_PATTERN_.test(f)) {
        f = f.replace(i18n.phonenumbers.PhoneNumberUtil.PLUS_CHARS_PATTERN_, "");
        e.clear();
        e.append(i18n.phonenumbers.PhoneNumberUtil.normalize(f));
        return i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITH_PLUS_SIGN
    }
    f = RegExp(d);
    if (this.parsePrefixAsIdd_(f, e)) {
        i18n.phonenumbers.PhoneNumberUtil.normalizeSB_(e);
        return i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITH_IDD
    }
    i18n.phonenumbers.PhoneNumberUtil.normalizeSB_(e);
    return this.parsePrefixAsIdd_(f, e) ? i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_NUMBER_WITH_IDD : i18n.phonenumbers.PhoneNumber.CountryCodeSource.FROM_DEFAULT_COUNTRY
};
i18n.phonenumbers.PhoneNumberUtil.prototype.maybeStripNationalPrefix = function (h, g, l, k) {
    var j = h.toString();
    if (!(j.length == 0 || g == null || g.length == 0)) {
        g = RegExp("^" + g);
        var i = g.exec(j);
        if (i) {
            l = l == null || l.length == 0 || i[1] == null || i[1].length == 0 ? j.substring(i[0].length) : j.replace(g, l);
            if (i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_(k, l)) {
                h.clear();
                h.append(l)
            }
        }
    }
};
i18n.phonenumbers.PhoneNumberUtil.prototype.maybeStripExtension = function (h) {
    var g = h.toString(),
        l = g.search(i18n.phonenumbers.PhoneNumberUtil.EXTN_PATTERN_);
    if (l >= 0 && i18n.phonenumbers.PhoneNumberUtil.isViablePhoneNumber(g.substring(0, l))) {
        for (var k = g.match(i18n.phonenumbers.PhoneNumberUtil.EXTN_PATTERN_), j = k.length, i = 1; i < j; ++i) {
            if (k[i] != null && k[i].length > 0) {
                h.clear();
                h.append(g.substring(0, l));
                return k[i]
            }
        }
    }
    return ""
};
i18n.phonenumbers.PhoneNumberUtil.prototype.parse = function (d, c) {
    if (!this.isValidRegionCode_(c)) {
        if (d.length > 0 && d.charAt(0) != i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN) {
            throw i18n.phonenumbers.Error.INVALID_COUNTRY_CODE
        }
    }
    return this.parseHelper_(d, c, false)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.parseAndKeepRawInput = function (d, c) {
    if (!this.isValidRegionCode_(c)) {
        if (d.length > 0 && d.charAt(0) != i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN) {
            throw i18n.phonenumbers.Error.INVALID_COUNTRY_CODE
        }
    }
    return this.parseHelper_(d, c, true)
};
i18n.phonenumbers.PhoneNumberUtil.prototype.parseHelper_ = function (i, h, n) {
    var m = i18n.phonenumbers.PhoneNumberUtil.extractPossibleNumber(i);
    if (!i18n.phonenumbers.PhoneNumberUtil.isViablePhoneNumber(m)) {
        throw i18n.phonenumbers.Error.NOT_A_NUMBER
    }
    var l = new i18n.phonenumbers.PhoneNumber;
    n && l.setRawInput(i);
    var k = new goog.string.StringBuffer(m);
    i = this.maybeStripExtension(k);
    i.length > 0 && l.setExtension(i);
    m = this.getMetadataForRegion(h);
    var j = new goog.string.StringBuffer;
    i = this.maybeExtractCountryCode(k.toString(), m, j, n, l);
    if (i != 0) {
        n = this.getRegionCodeForCountryCode(i);
        if (n != h) {
            m = this.getMetadataForRegion(n)
        }
    } else {
        i18n.phonenumbers.PhoneNumberUtil.normalizeSB_(k);
        j.append(k.toString());
        if (h != null) {
            i = m.getCountryCodeOrDefault();
            l.setCountryCode(i)
        } else {
            n && l.clearCountryCodeSource()
        }
    }
    if (j.getLength() < i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_) {
        throw i18n.phonenumbers.Error.TOO_SHORT_NSN
    }
    if (m != null) {
        h = RegExp(m.getGeneralDesc().getNationalNumberPattern());
        this.maybeStripNationalPrefix(j, m.getNationalPrefixForParsing(), m.getNationalPrefixTransformRule(), h)
    }
    h = j.toString();
    n = h.length;
    if (n < i18n.phonenumbers.PhoneNumberUtil.MIN_LENGTH_FOR_NSN_) {
        throw i18n.phonenumbers.Error.TOO_SHORT_NSN
    }
    if (n > i18n.phonenumbers.PhoneNumberUtil.MAX_LENGTH_FOR_NSN_) {
        throw i18n.phonenumbers.Error.TOO_LONG
    }
    h.charAt(0) == "0" && i18n.phonenumbers.PhoneNumberUtil.isLeadingZeroCountry(i) && l.setItalianLeadingZero(true);
    l.setNationalNumber(parseInt(h, 10));
    return l
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isNumberMatch = function (h, g) {
    var l, k;
    if (typeof h == "string") {
        l = this.parseHelper_(h, null, false)
    } else {
        l = new i18n.phonenumbers.PhoneNumber;
        l.mergeFrom(h)
    }
    if (typeof g == "string") {
        k = this.parseHelper_(g, null, false)
    } else {
        k = new i18n.phonenumbers.PhoneNumber;
        k.mergeFrom(g)
    }
    l.clearRawInput();
    l.clearCountryCodeSource();
    k.clearRawInput();
    k.clearCountryCodeSource();
    l.hasExtension() && l.getExtension().length == 0 && l.clearExtension();
    k.hasExtension() && k.getExtension().length == 0 && k.clearExtension();
    if (l.hasExtension() && k.hasExtension() && l.getExtension() != k.getExtension()) {
        return i18n.phonenumbers.PhoneNumberUtil.MatchType.NO_MATCH
    }
    var j = l.getCountryCodeOrDefault(),
        i = k.getCountryCodeOrDefault();
    if (j != 0 && i != 0) {
        if (l.exactlySameAs(k)) {
            return i18n.phonenumbers.PhoneNumberUtil.MatchType.EXACT_MATCH
        } else {
            if (j == i && this.isNationalNumberSuffixOfTheOther_(l, k)) {
                return i18n.phonenumbers.PhoneNumberUtil.MatchType.SHORT_NSN_MATCH
            }
        }
        return i18n.phonenumbers.PhoneNumberUtil.MatchType.NO_MATCH
    }
    l.setCountryCode(0);
    k.setCountryCode(0);
    if (l.exactlySameAs(k)) {
        return i18n.phonenumbers.PhoneNumberUtil.MatchType.NSN_MATCH
    }
    if (this.isNationalNumberSuffixOfTheOther_(l, k)) {
        return i18n.phonenumbers.PhoneNumberUtil.MatchType.SHORT_NSN_MATCH
    }
    return i18n.phonenumbers.PhoneNumberUtil.MatchType.NO_MATCH
};
i18n.phonenumbers.PhoneNumberUtil.prototype.isNationalNumberSuffixOfTheOther_ = function (f, e) {
    var h = "" + f.getNationalNumber(),
        g = "" + e.getNationalNumber();
    return goog.string.endsWith(h, g) || goog.string.endsWith(g, h)
};
i18n.phonenumbers.PhoneNumberUtil.matchesEntirely_ = function (e, d) {
    var f = d.match(e);
    if (f && f[0].length == d.length) {
        return true
    }
    return false
};
i18n.phonenumbers.PhoneNumber.prototype.exactlySameAs = function (b) {
    return b != null && this.getCountryCode() == b.getCountryCode() && this.getNationalNumber() == b.getNationalNumber() && this.getExtension() == b.getExtension() && this.getItalianLeadingZero() == b.getItalianLeadingZero() && this.getRawInput() == b.getRawInput() && this.getCountryCodeSource() == b.getCountryCodeSource()
};
i18n.phonenumbers.PhoneNumberDesc.prototype.exactlySameAs = function (b) {
    return b != null && this.getNationalNumberPattern() == b.getNationalNumberPattern() && this.getPossibleNumberPattern() == b.getPossibleNumberPattern() && this.getExampleNumber() == b.getExampleNumber()
};
i18n.phonenumbers.PhoneNumber.prototype.mergeFrom = function (b) {
    if (b) {
        this.values_ = goog.cloneObject(b.values_)
    }
    return this
};
i18n.phonenumbers.NumberFormat.prototype.mergeFrom = function (b) {
    if (b) {
        this.values_ = goog.cloneObject(b.values_)
    }
    return this
};
i18n.phonenumbers.AsYouTypeFormatter = function (b) {
    this.CHARACTER_CLASS_PATTERN_ = /\[([^\[\]])*\]/g;
    this.STANDALONE_DIGIT_PATTERN_ = /\d(?=[^,}][^,}])/g;
    this.MIN_LEADING_DIGITS_LENGTH_ = 3;
    this.digitPlaceholder_ = "\u2008";
    this.digitPattern_ = RegExp(this.digitPlaceholder_);
    this.currentOutput_ = "";
    this.formattingTemplate_ = new goog.string.StringBuffer;
    this.currentFormattingPattern_ = "";
    this.accruedInput_ = new goog.string.StringBuffer;
    this.accruedInputWithoutFormatting_ = new goog.string.StringBuffer;
    this.ableToFormat_ = true;
    this.isExpectingCountryCode_ = this.isInternationalFormatting_ = false;
    this.phoneUtil_ = i18n.phonenumbers.PhoneNumberUtil.getInstance();
    this.positionToRemember_ = this.originalPosition_ = this.lastMatchPosition_ = 0;
    this.prefixBeforeNationalNumber_ = new goog.string.StringBuffer;
    this.nationalNumber_ = new goog.string.StringBuffer;
    this.possibleFormats_ = [];
    this.defaultCountry_ = b;
    this.initializeCountrySpecificInfo_(this.defaultCountry_);
    this.defaultMetaData_ = this.currentMetaData_
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.initializeCountrySpecificInfo_ = function (b) {
    this.currentMetaData_ = this.phoneUtil_.getMetadataForRegion(b);
    this.nationalPrefixForParsing_ = RegExp("^(" + this.currentMetaData_.getNationalPrefixForParsing() + ")");
    this.internationalPrefix_ = RegExp("^(\\+|" + this.currentMetaData_.getInternationalPrefix() + ")")
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.maybeCreateNewTemplate_ = function () {
    for (var f = this.possibleFormats_.length, e = 0; e < f; ++e) {
        var h = this.possibleFormats_[e],
            g = h.getPatternOrDefault();
        if (this.currentFormattingPattern_ == g) {
            return false
        }
        if (this.createFormattingTemplate_(h)) {
            this.currentFormattingPattern_ = g;
            return true
        }
    }
    return this.ableToFormat_ = false
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.getAvailableFormats_ = function (b) {
    this.possibleFormats_ = this.isInternationalFormatting_ && this.currentMetaData_.intlNumberFormatCount() > 0 ? this.currentMetaData_.intlNumberFormatArray() : this.currentMetaData_.numberFormatArray();
    this.narrowDownPossibleFormats_(b)
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.narrowDownPossibleFormats_ = function (h) {
    for (var g = [], l = h.length - this.MIN_LEADING_DIGITS_LENGTH_, k = this.possibleFormats_.length, j = 0; j < k; ++j) {
        var i = this.possibleFormats_[j];
        if (i.leadingDigitsPatternCount() > l) {
            RegExp("^(" + i.getLeadingDigitsPattern(l) + ")").test(h) && g.push(this.possibleFormats_[j])
        } else {
            g.push(this.possibleFormats_[j])
        }
    }
    this.possibleFormats_ = g
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.createFormattingTemplate_ = function (d) {
    var c = d.getFormatOrDefault();
    d = d.getPatternOrDefault();
    if (d.indexOf("|") != -1) {
        return false
    }
    d = d.replace(this.CHARACTER_CLASS_PATTERN_, "\\d");
    d = d.replace(this.STANDALONE_DIGIT_PATTERN_, "\\d");
    this.formattingTemplate_.clear();
    this.formattingTemplate_.append(this.getFormattingTemplate_(d, c));
    return true
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.getFormattingTemplate_ = function (e, d) {
    var f = "999999999999999".match(e)[0].replace(RegExp(e, "g"), d);
    return f = f.replace(RegExp("9", "g"), this.digitPlaceholder_)
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.clear = function () {
    this.currentOutput_ = "";
    this.accruedInput_.clear();
    this.accruedInputWithoutFormatting_.clear();
    this.formattingTemplate_.clear();
    this.lastMatchPosition_ = 0;
    this.currentFormattingPattern_ = "";
    this.prefixBeforeNationalNumber_.clear();
    this.nationalNumber_.clear();
    this.ableToFormat_ = true;
    this.originalPosition_ = this.positionToRemember_ = 0;
    this.isExpectingCountryCode_ = this.isInternationalFormatting_ = false;
    this.possibleFormats_ = [];
    this.currentMetaData_ != this.defaultMetaData_ && this.initializeCountrySpecificInfo_(this.defaultCountry_)
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.inputDigit = function (b) {
    return this.currentOutput_ = this.inputDigitWithOptionToRememberPosition_(b, false)
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.inputDigitAndRememberPosition = function (b) {
    return this.currentOutput_ = this.inputDigitWithOptionToRememberPosition_(b, true)
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.inputDigitWithOptionToRememberPosition_ = function (f, e) {
    this.accruedInput_.append(f);
    if (e) {
        this.originalPosition_ = this.accruedInput_.getLength()
    }
    if (!i18n.phonenumbers.PhoneNumberUtil.VALID_START_CHAR_PATTERN.test(f)) {
        this.ableToFormat_ = false
    }
    if (!this.ableToFormat_) {
        return this.accruedInput_.toString()
    }
    f = this.normalizeAndAccrueDigitsAndPlusSign_(f, e);
    switch (this.accruedInputWithoutFormatting_.getLength()) {
    case 0:
    case 1:
    case 2:
        return this.accruedInput_.toString();
    case 3:
        if (this.attemptToExtractIdd_()) {
            this.isExpectingCountryCode_ = true
        } else {
            this.removeNationalPrefixFromNationalNumber_();
            return this.attemptToChooseFormattingPattern_()
        }
    case 4:
    case 5:
        if (this.isExpectingCountryCode_) {
            if (this.attemptToExtractCountryCode_()) {
                this.isExpectingCountryCode_ = false
            }
            return this.prefixBeforeNationalNumber_.toString() + this.nationalNumber_.toString()
        }
    case 6:
        if (this.isExpectingCountryCode_ && !this.attemptToExtractCountryCode_()) {
            this.ableToFormat_ = false;
            return this.accruedInput_.toString()
        }
    default:
        if (this.possibleFormats_.length > 0) {
            var h = this.inputDigitHelper_(f),
                g = this.attemptToFormatAccruedDigits_();
            if (g.length > 0) {
                return g
            }
            this.narrowDownPossibleFormats_(this.nationalNumber_.toString());
            if (this.maybeCreateNewTemplate_()) {
                return this.inputAccruedNationalNumber_()
            }
            return this.ableToFormat_ ? this.prefixBeforeNationalNumber_.toString() + h : h
        } else {
            return this.attemptToChooseFormattingPattern_()
        }
    }
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.attemptToFormatAccruedDigits_ = function () {
    for (var g = this.nationalNumber_.toString(), f = this.possibleFormats_.length, j = 0; j < f; ++j) {
        var i = this.possibleFormats_[j],
            h = i.getPatternOrDefault();
        if (RegExp("^(" + h + ")$").test(g)) {
            return this.prefixBeforeNationalNumber_.toString() + g.replace(RegExp(h, "g"), i.getFormat())
        }
    }
    return ""
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.getRememberedPosition = function () {
    if (!this.ableToFormat_) {
        return this.originalPosition_
    }
    for (var g = 0, f = 0, j = this.accruedInputWithoutFormatting_.toString(), i = this.currentOutput_.toString(), h = i.length; g < this.positionToRemember_ && f < h;) {
        j.charAt(g) == i.charAt(f) && g++;
        f++
    }
    return f
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.attemptToChooseFormattingPattern_ = function () {
    var b = this.nationalNumber_.toString();
    if (b.length >= this.MIN_LEADING_DIGITS_LENGTH_) {
        this.getAvailableFormats_(b.substring(0, this.MIN_LEADING_DIGITS_LENGTH_));
        this.maybeCreateNewTemplate_();
        return this.inputAccruedNationalNumber_()
    } else {
        return this.prefixBeforeNationalNumber_.toString() + b
    }
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.inputAccruedNationalNumber_ = function () {
    var f = this.nationalNumber_.toString(),
        e = f.length;
    if (e > 0) {
        for (var h = "", g = 0; g < e; g++) {
            h = this.inputDigitHelper_(f.charAt(g))
        }
        return this.ableToFormat_ ? this.prefixBeforeNationalNumber_.toString() + h : h
    } else {
        return this.prefixBeforeNationalNumber_.toString()
    }
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.removeNationalPrefixFromNationalNumber_ = function () {
    var e = this.nationalNumber_.toString(),
        d = 0;
    if (this.currentMetaData_.getCountryCode() == 1 && e.charAt(0) == "1") {
        d = 1;
        this.prefixBeforeNationalNumber_.append("1 ");
        this.isInternationalFormatting_ = true
    } else {
        if (this.currentMetaData_.hasNationalPrefix()) {
            var f = e.match(this.nationalPrefixForParsing_);
            if (f != null && f[0] != null && f[0].length > 0) {
                this.isInternationalFormatting_ = true;
                d = f[0].length;
                this.prefixBeforeNationalNumber_.append(e.substring(0, d))
            }
        }
    }
    this.nationalNumber_.clear();
    this.nationalNumber_.append(e.substring(d))
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.attemptToExtractIdd_ = function () {
    var d = this.accruedInputWithoutFormatting_.toString(),
        c = d.match(this.internationalPrefix_);
    if (c != null && c[0] != null && c[0].length > 0) {
        this.isInternationalFormatting_ = true;
        c = c[0].length;
        this.nationalNumber_.clear();
        this.nationalNumber_.append(d.substring(c));
        this.prefixBeforeNationalNumber_.append(d.substring(0, c));
        d.charAt(0) != i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN && this.prefixBeforeNationalNumber_.append(" ");
        return true
    }
    return false
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.attemptToExtractCountryCode_ = function () {
    if (this.nationalNumber_.getLength() == 0) {
        return false
    }
    var d = new goog.string.StringBuffer,
        c = this.phoneUtil_.extractCountryCode(this.nationalNumber_, d);
    if (c == 0) {
        return false
    } else {
        this.nationalNumber_.clear();
        this.nationalNumber_.append(d.toString());
        d = this.phoneUtil_.getRegionCodeForCountryCode(c);
        d != this.defaultCountry_ && this.initializeCountrySpecificInfo_(d);
        this.prefixBeforeNationalNumber_.append("" + c).append(" ")
    }
    return true
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.normalizeAndAccrueDigitsAndPlusSign_ = function (d, c) {
    d == i18n.phonenumbers.PhoneNumberUtil.PLUS_SIGN && this.accruedInputWithoutFormatting_.append(d);
    if (d in i18n.phonenumbers.PhoneNumberUtil.DIGIT_MAPPINGS) {
        d = i18n.phonenumbers.PhoneNumberUtil.DIGIT_MAPPINGS[d];
        this.accruedInputWithoutFormatting_.append(d);
        this.nationalNumber_.append(d)
    }
    if (c) {
        this.positionToRemember_ = this.accruedInputWithoutFormatting_.getLength()
    }
    return d
};
i18n.phonenumbers.AsYouTypeFormatter.prototype.inputDigitHelper_ = function (e) {
    var d = this.formattingTemplate_.toString();
    if (d.substring(this.lastMatchPosition_).search(this.digitPattern_) >= 0) {
        var f = d.search(this.digitPattern_);
        e = d.replace(this.digitPattern_, e);
        this.formattingTemplate_.clear();
        this.formattingTemplate_.append(e);
        this.lastMatchPosition_ = f;
        return e.substring(0, this.lastMatchPosition_ + 1)
    } else {
        this.ableToFormat_ = false;
        return this.accruedInput_.toString()
    }
};
(function (a) {
    a.fn.validatePhone = (function (k) {
        var m = a(this);
        if (!m.is(":visible")) {
            return
        }
        var d = m.attr("id"),
            f = a("#" + d + "_country"),
            j = a("#" + d + "_country_selector"),
            b = a("#" + d + "_feedback"),
            c = a("#" + d + "_popup");
        if (!k && f.val()) {
            k = f.val()
        } else {
            if (!k) {
                k = "US"
            }
        }
        try {
            if (m.attr("value") === "") {
                f.attr("value", "");
                c.css("display", "none");
                return true
            }
            var n = i18n.phonenumbers.PhoneNumberUtil.getInstance();
            var g = n.parseAndKeepRawInput(m.attr("value"), k);
            var h = n.getRegionCodeForNumber(g);
            var i = n.format(g, i18n.phonenumbers.PhoneNumberFormat.E164);
            if (i && h) {
                m.attr("value", i).removeClass("error");
                f.attr("value", h);
                j.attr("value", h);
                c.css("display", "none");
                return true
            } else {
                throw ("")
            }
        } catch (l) {
            feedbackBody = "";
            if (l !== "") {
                feedbackBody += "<p><b>" + l + ".</b></p>"
            }
            feedbackBody += "<p>Sorry, but we do not recognize your phone number. Please help us by selecting your country.</p><p>Ensure that you have provided your full phone number, including area code, and country code if you have it available.</p><p>If you are still unable to successfully enter your phone number, please contact <a href='mailto:support@cogzidel.com'>support@cogzidel.com</a>.</p>";
            b.html(feedbackBody);
            if (f.val()) {
                j.val(f.val())
            }
            c.css("top", m.offset().top + m.outerHeight(true) + 1).css("left", m.offset().left + ((m.outerWidth(true) - c.outerWidth(true)) / 2));
            m.addClass("error").closest("form").find(".validated_phone_popup").css("display", "none");
            c.css("display", "block");
            return false
        }
    });
    a.fn.validatedPhone = (function () {
        var b;
        var c = this.attr("id");
        this.addClass("validated_phone_input");
        b = a('<div class="validated_phone_popup" style="display:none;"><div class="validated_phone_popup_content"><form /></div></div>');
        b.attr("id", c + "_popup");
        a("#" + c + "_country_selector").css("display", "inherit").appendTo(b.find("form"));
        a("<div id='" + c + "_feedback'></div>").appendTo(b.find(".validated_phone_popup_content"));
        b.appendTo("body");
        this.blur(function () {
            a(this).validatePhone(a("#" + a(this).attr("id") + "_country_selector").attr("value"))
        });
        a("#" + c + "_country_selector").change(function () {
            a("#" + a(this).attr("id").replace("_country_selector", "")).validatePhone(a(this).attr("value"))
        });
        this.closest("form").unbind("submit.validated_phone");
        this.closest("form").bind("submit.validated_phone", function () {
            var d = a(this).find("input.validated_phone_input").map(function () {
                if (!a(this).validatePhone()) {
                    a(this).focus();
                    return "f"
                } else {
                    return "t"
                }
            });
            return (a.inArray("f", d) < 0)
        });
        this.validatePhone();
        return this
    })
})(jQuery);
(function (a) {
    a.fn.formTipHelper = function () {
        return this.each(function (c, b) {
            a(b).focus(function () {
                a(b).next("div").fadeIn(200)
            });
            a(b).blur(function () {
                a(b).next("div").fadeOut(400)
            })
        })
    }
})(jQuery);
(function (a) {
    CharCounter = function (c, b) {
        this.init(c, b)
    };
    a.extend(CharCounter.prototype, {
        name: "charCounter",
        options: {
            warningcount: 60,
            inputchanged: function () {},
            warningenter: function () {},
            warningexit: function () {},
            limitreached: function () {}
        },
        States: {
            Normal: 0,
            Warning: 1
        },
        currentState: null,
        init: function (c, b) {
            var d = this;
            this.element = a(c);
            a.data(c, d.name, d);
            a.extend(this.options, b);
            d.currentState = d.States.Normal;
            return d.element.each(function (f, g) {
                a(this).keyup(function () {
                    d.inputChanged.call(d)
                }).keyup()
            })
        },
        inputChanged: function () {
            var c = this;
            var b = parseInt(c.element.attr("maxlength")) - c.element.val().length;
            c.options.inputchanged.call(c.element, b);
            switch (c.currentState) {
            case c.States.Normal:
                if (b <= c.options.warningcount) {
                    c.options.warningenter.call(c.element);
                    c.currentState = c.States.Warning
                }
                break;
            case c.States.Warning:
                if (b > c.options.warningcount) {
                    c.options.warningexit.call(c.element);
                    c.currentState = c.States.Normal
                }
                break
            }
            if (b <= 0) {
                c.options.limitreached.call(c.element)
            }
        }
    });
    a.fn.charCounter = function (c) {
        var b = a.makeArray(arguments),
            d = b.slice(1);
        return this.each(function () {
            var e = a.data(this, "charCounter");
            if (e) {
                if (typeof c === "string") {
                    e[c].apply(e, d)
                } else {
                    if (e.update) {
                        e.update.apply(e, b)
                    }
                }
            } else {
                new CharCounter(this, c)
            }
        })
    }
})(jQuery);
(function (a) {
    Tabberizer = function (c, b) {
        if (c) {
            this.init(c, b)
        }
    };
    a.extend(Tabberizer.prototype, {
        name: "tabberizer",
        init: function (d, c) {
            this.element = a(d);
            a.data(d, this.name, this);
            c = c || {};
            if (typeof c.updateHash === "undefined") {
                c.updateHash = true
            }
            var e = this;
            var b = this.element;
            var f = b.attr("id");
            b.delegate("li", "click", function () {
                var j = a(this);
                var h = parseInt(b.find("li").index(this));
                a("#" + f + ", #" + f + "_panels").find("> li.selected").removeClass("selected");
                a(this).addClass("selected");
                a("#" + f + "_panels").find("> li:nth-child(" + (h + 1) + ")").addClass("selected");
                a("span.notification:not(.persistent)", this).delay(1000).fadeOut(function () {
                    a(this).remove()
                });
                var g = j.attr("id");
                if (c.updateHash) {
                    if (g) {
                        j.attr("id", "");
                        setTimeout(function () {
                            window.location.hash = g;
                            j.attr("id", g)
                        }, 0)
                    } else {
                        window.location.hash = ""
                    }
                }
            });
            if (window.location.hash) {
                jQuery(window.location.hash.toString()).click()
            } else {
                jQuery("> li:first-child", this.element).click()
            }
        }
    });
    a.fn.tabberizer = function (c) {
        var b = a.makeArray(arguments),
            d = b.slice(1);
        return this.each(function () {
            var e = a.data(this, "tabberizer");
            if (e) {
                if (typeof c === "string") {
                    e[c].apply(e, d)
                } else {
                    if (e.update) {
                        e.update.apply(e, b)
                    }
                }
            } else {
                new Tabberizer(this, c)
            }
        })
    }
})(jQuery);
(function (a) {
    a.fn.currencychanger = function (b) {
        var c = this.val();
        return this.change(function (d) {
            new_currency = jQuery(this).val();
            var e = b[new_currency];
            var f = e.rate / b[c]["rate"];
            jQuery(".currency_symbol").html(e.symbol);
            jQuery('.currency_symbol + input[type="text"]').val(function (g, h) {
                return h == "" ? "" : parseInt(Math.round(h * f))
            });
            c = new_currency
        })
    }
})(jQuery);