var photo_gallery_loaded = false;
var initPhotoGallery = function () {
        if (photo_gallery_loaded) {
            return
        }
        photo_gallery_loaded = true;
        jQuery("#galleria_container").galleria({
            imagePosition: "top",
            transition: "fade",
            transitionSpeed: 100,
            thumbFit: false
        });
        var a = Galleria.get(0);
        jQuery(".share-button-container").hover(function () {
            jQuery("#share_buttons").fadeIn(200)
        }, function () {
            jQuery("#share_buttons").fadeOut(200)
        }).click(function () {
            a.next()
        });
        a.bind("loadstart", function (b) {
            if (b.index > 0) {
                jQuery(".image-placeholder").hide()
            }
        })
    };
var Page3 = {
    showInstantBookButton: function () {
        jQuery("#book_it_button").addClass("force_hide");
        jQuery("#instant_book_it_button").removeClass("force_hide").removeAttr("disabled");
        jQuery("#instant_book_arrow").removeClass("force_hide")
    },
    showBookItButton: function () {
        jQuery("#instant_book_it_button").addClass("force_hide");
        jQuery("#book_it_button").removeClass("force_hide");
        jQuery("#instant_book_arrow").addClass("force_hide")
    }
};
var page3Slideshow = {
    keypressListenerEnabled: false,
    freezeSlideshowControls: false,
    deactivateSlideshowControls: function () {
        setTimeout(function () {
            page3Slideshow.freezeSlideshowControls = false
        }, 200)
    },
    galleriaLoaded: function () {
        var a = (Galleria.get(0) !== undefined);
        return a
    },
    enableKeypressListener: function () {
        if (page3Slideshow.keypressListenerEnabled === false) {
            if (!this.galleriaLoaded()) {
                return
            }
            var a = Galleria.get(0);
            jQuery(document.documentElement).bind("keydown", function (c) {
                if (page3Slideshow.freezeSlideshowControls === false && page3Slideshow.galleriaLoaded() === true) {
                    var b = c.keyCode || c.which;
                    if (b == jQuery.ui.keyCode.LEFT) {
                        a.prev();
                        page3Slideshow.freezeSlideshowControls = true
                    } else {
                        if (b == jQuery.ui.keyCode.RIGHT) {
                            a.next();
                            page3Slideshow.freezeSlideshowControls = true
                        }
                    }
                    page3Slideshow.deactivateSlideshowControls()
                }
            });
            page3Slideshow.keypressListenerEnabled = true
        }
    },
    disableKeypressListener: function () {
        jQuery(document.documentElement).unbind("keydown");
        page3Slideshow.keypressListenerEnabled = false
    }
};
var map_loaded = false;

function load_map_wrapper(a) {
    if (map_loaded) {
        if (a && window[a]) {
            window[a]()
        }
    } else {
        (function () {
            var b = document.createElement("script");
            b.type = "text/javascript";
            b.async = true;
            b.src = document.location.protocol + "//maps.google.com/maps/api/js?v=3.5&sensor=false&callback=" + a;
            var c = document.getElementsByTagName("script")[0];
            c.parentNode.insertBefore(b, c)
        })();
        map_loaded = true
    }
}
function isValidDate(a) {
    if (Object.prototype.toString.call(a) !== "[object Date]") {
        return false
    }
    return !isNaN(a.getTime())
}
function lwlb_signup_button_click() {
    jQuery("#intended_action").val("signup");
    jQuery("#lwlb_signup_spinner").show();
    jQuery("#lwlb_signup_button").hide();
    jQuery("#message_form").submit()
}
function lwlb_login_button_click() {
    jQuery("#intended_action").val("login");
    jQuery("#lwlb_login_spinner").show();
    jQuery("#lwlb_login_button").hide();
    jQuery("#message_form").submit()
}
function lwlb_hide_and_reset(a) {
    page3Slideshow.enableKeypressListener();
    lwlb_hide(a);
    lwlb_reset_messaging()
}
function check_inputs(b, c, a) {
    b = typeof (b) != "undefined" ? b : true;
    c = typeof (c) != "undefined" ? c : "checkin";
    a = typeof (a) != "undefined" ? a : "checkout";
    if (calendar_is_not_set_date(c)) {
        if (b) {
            calendar_show_cal(c)
        }
        return false
    }
    if (calendar_is_not_set_date(a)) {
        if (b) {
            calendar_show_cal(a)
        }
        return false
    }
    return true
}
function copy_checkin_checkout_fields() {
    var a = check_inputs(false);
    if (a) {
        jQuery("#message_checkin").val(jQuery("#checkin").val());
        jQuery("#message_checkout").val(jQuery("#checkout").val());
        jQuery("#message_number_of_guests").val(jQuery("#number_of_guests").val());
        check_availability_of_dates()
    }
}
function copy_message_fields_to_book_it() {
    jQuery("#checkin").val(jQuery("#message_checkin").val());
    jQuery("#checkout").val(jQuery("#message_checkout").val());
    jQuery("#number_of_guests").val(jQuery("#message_number_of_guests").val())
}
function refresh_subtotal() {
    var a = function (c, e, d) {
            var b;
            if (c.available) {
                jQuery("#book_it_disabled").hide();
                jQuery("#book_it_enabled").show();
                b = jQuery("#price_amount").html(c.price_per_night).data("nightly-price", c.price_per_night);
                jQuery("#service_fee").html(c.service_fee);
                CogzidelRooms.staggered = c.staggered;
                if (CogzidelRooms.staggered === true) {
                    if (CogzidelRooms.stayOffered !== 0) {
                        jQuery("#payment_period").hide();
                        jQuery("#per_month").show();
                        CogzidelRooms.$cancellationVal.text(Translations.long_term);
                        jQuery("#includesFees").show();
                        jQuery("#book_it_default").addClass("monthly")
                    }
                    jQuery("#subtotal_area").hide();
                    jQuery("#show_more_subtotal_info").hide();
                    jQuery("#price_amount").text(Cogzidel.Utils.decode(c.staggered_price));
                    b.data("monthly-price", c.staggered_price)
                } else {
                    if (CogzidelRooms.stayOffered === 2) {
                        jQuery("#per_month").hide();
                        CogzidelRooms.$cancellationVal.text(CogzidelRooms.originalCancellationPolicy);
                        jQuery("#includesFees").hide();
                        jQuery("#book_it_default").removeClass("monthly");
                        jQuery("#payment_period").show()
                    }
                    jQuery("#subtotal_area ").show();
                    jQuery("#subtotal_area").find("p").show();
                    jQuery("#show_more_subtotal_info").show();
                    jQuery("#subtotal").html(c.total_price);
                    jQuery("#payment_period").val("per_night");
                    b.removeAttr("data-monthly-price")
                }
                if (c.can_instant_book) {
                    Page3.showInstantBookButton()
                } else {
                    Page3.showBookItButton()
                }
            } else {
                if (CogzidelRooms.stayOffered === 1) {
                    jQuery("#payment_period").hide();
                    jQuery("#per_month").show();
                    CogzidelRooms.$cancellationVal.text(Translations.long_term);
                    jQuery("#includesFees").show()
                } else {
                    jQuery("#book_it_default").removeClass("monthly");
                    jQuery("#payment_period").show();
                    jQuery("#per_month").hide();
                    CogzidelRooms.$cancellationVal.text(CogzidelRooms.originalCancellationPolicy);
                    jQuery("#includesFees").hide();
                    jQuery("#price_amount").html(jQuery("#price_amount").data("nightly-price"))
                }
                jQuery("#book_it_disabled_message").html(c.reason_message);
                jQuery("#book_it_enabled").hide();
                jQuery("#book_it_disabled").show();
                jQuery("#show_more_subtotal_info").hide()
            }
            jQuery("#book_it_status").effect("pulsate", {
                times: 1
            }, 600)
        };
    jQuery("#book_it_button").removeAttr("disabled");
    jQuery("#subtotal_area").find("p").hide();
    jQuery("#subtotal_area").show();
    if (calendar_is_not_set_date("checkin") || calendar_is_not_set_date("checkout")) {
        a = function () {};
        jQuery("#book_it_disabled").hide();
        jQuery("#book_it_enabled").show();
        jQuery("#subtotal_area").hide();
        jQuery("#show_more_subtotal_info").hide()
    } else {
        jQuery("#subtotal, #book_it_disabled_message").html('<img src="../images/spinner_999999.gif" alt="" height="16" width="16" />')
    }
    jQuery.getJSON("/rooms/ajax_refresh_subtotal", jQuery("#book_it_form").serialize(), a)
}
function action_contact() {}
function setup_lwlb_contact() {
    copy_checkin_checkout_fields();
    lwlb_show("lwlb_contact");
    page3Slideshow.disableKeypressListener();
    jQuery.getJSON(ajax_already_messaged_url, function (a) {
        if (a.has_already_messaged) {
            jQuery("#already_messaged").show()
        }
    })
}
function action_link() {
    lwlb_show("lwlb_link")
}
function action_facebook() {
    var a = {
        method: "stream.share",
        display: "popup"
    };
    FB.ui(a, function (b) {})
}
var load_pano = function () {
        var a = jQuery("#pano").data("streetView");
        var f;
        if (!a) {
            var e = jQuery("#pano").data("lat");
            var c = jQuery("#pano").data("lng");
            var b = new google.maps.LatLng(e, c);
            var d = new google.maps.StreetViewPanorama(document.getElementById("pano"), {
                position: b,
                visible: false,
                scrollwheel: false,
                enableCloseButton: false
            });
            new google.maps.StreetViewService().getPanoramaByLocation(b, 50, function (h, g) {
                if (g !== google.maps.StreetViewStatus.OK) {
                    jQuery("#pano_error").show();
                    jQuery("#pano_no_error").hide();
                    return
                }
                d.setPosition(h.location.latLng);
                d.setVisible(true);
                f = window.setInterval(function () {
                    if (jQuery("#auto_pan_pano").is(":checked")) {
                        var i = d.getPov();
                        i.heading += 2;
                        d.setPov(i)
                    }
                }, 200)
            });
            jQuery("#pano").data("streetView", d)
        }
    };

function load_google_map() {
    var k = 14;
    var c = 11;
    var b;
    var g = [];
    var f = [],
        j;
    var h = new google.maps.LatLng(jQuery("#map").data("lat"), jQuery("#map").data("lng"));
    var a = new google.maps.LatLngBounds();
    a.extend(h);
    if (!CogzidelRooms.inIsrael) {
        jQuery("#map").cogzidelMap({
            position: h,
            isFuzzy: true
        });
        var d = jQuery("#map").cogzidelMap().map;
        var i = new google.maps.InfoWindow({
            maxWidth: 160,
            zIndex: 0
        });
        google.maps.event.addListener(d, "click", function () {
            i.close()
        });
        var e = false;
        jQuery("#guidebook-recommendations li").each(function (n, p) {
            e = true;
            var m = jQuery(p);
            var l = new google.maps.LatLng(m.data("lat"), m.data("lng"));
            var o = new google.maps.Marker({
                clickable: true,
                position: l,
                map: d,
                zIndex: 1,
                icon: new google.maps.MarkerImage(jQuery("img", m).attr("src"), null, null, new google.maps.Point(11, 37))
            });
            google.maps.event.addListener(o, "click", function () {
                i.setContent('<address style="color:#808080"><p style="color:#E0007A;font-weight:bold;">' + jQuery("h2", m).html() + "</p><p>" + jQuery("span.location", m).html() + "</p><p><span>" + jQuery("span.city", m).html() + "</span>, <span>" + jQuery("span.state", m).html() + "</span> <span>" + jQuery("span.zipcode", m).html() + '</span></p></address><p style="margin-top: 10px">' + jQuery("div.description", m).html() + "</p>");
                i.open(d, o)
            });
            g.push(o);
            a.extend(l)
        });
        if (e) {
            d.fitBounds(a);
            google.maps.event.addListenerOnce(d, "bounds_changed", function () {
                if (this.getZoom() > 14) {
                    this.setZoom(14)
                }
            })
        }
    } else {
        document.getElementById("map").innerHTML = '<iframe width="639" height="470" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="/rooms/israel_map?id=' + CogzidelRooms.hostingId + '">'
    }
}
var CogzidelRooms = {
    init: function (d) {
        if (d.inIsrael) {
            this.inIsrael = d.inIsrael
        }
        if (d.hostingId) {
            this.hostingId = d.hostingId
        }
        if (d.staggered !== undefined) {
            this.staggered = d.staggered
        }
        if (d.staggeredPrice !== undefined) {
            this.staggeredPrice = d.staggeredPrice
        }
        if (d.stayOffered !== undefined) {
            this.stayOffered = d.stayOffered
        }
        this.$cancellationVal = jQuery("#cancellation_val").find("a");
        this.originalCancellationPolicy = this.$cancellationVal.text();
        jQuery("#book_it_default").removeClass("monthly");
        jQuery("#per_month").hide();
        jQuery("#includesFees").hide();
        if (d.isMonthly !== undefined) {
            this.isMonthly = d.isMonthly;
            if (this.isMonthly === true) {
                jQuery("#subtotal_area").find("p").hide();
                jQuery("#book_it_default").addClass("monthly");
                jQuery("#per_month").show();
                this.$cancellationVal.text(Translations.long_term);
                jQuery("#includesFees").show()
            }
        }
        var b = jQuery.datepicker._defaults.dateFormat;
        jQuery("#book_it_form").cogzidelInputDateSpan({
            onCheckinClose: refresh_subtotal,
            onCheckoutClose: refresh_subtotal
        });
								
        var a = jQuery("#price_amount");
        a.data("nightly-price", d.nightlyPrice);
        a.data("weekly-price", d.weeklyPrice);
        a.data("monthly-price", d.monthlyPrice);
        if (!this.isMonthly) {
            /*a.html(a.data("nightly-price"))*/
        }
        jQuery("#checkin").val(b);
        jQuery("#checkout").val(b);
        jQuery("#user_contact_link").live("click", function () {
            if (jQuery("#lwlb_contact").length !== 0) {
                setup_lwlb_contact();
                return
            }
            var h = jQuery(this).after("<span class='spinner'></span>");
            h.attr("disabled", "disabled");
            jQuery("#question").attr("disabled", "disabled");
            jQuery("#question_holder").css("opacity", "0.5");
            jQuery("#lwlb_contact_container").load(ajax_lwlb_contact_url, null, function () {
                jQuery("#message_checkin").val(b);
                jQuery("#message_checkout").val(b);
                h.removeAttr("disabled");
                h.next().remove();
                setup_lwlb_contact();
                jQuery("#message_form").cogzidelInputDateSpan({
                    onCheckinClose: check_availability_of_dates,
                    onCheckoutClose: check_availability_of_dates
                })
            })
        });
        if (document.location.hash) {
            jQuery("a[href='" + document.location.hash + "']").parent().click()
        }
        if (jQuery("#photos_div").is(":visible")) {
            initPhotoGallery()
        }
        jQuery("#show_more_user_info, #user_big_pic, #user_small_pic").click(CogzidelRooms.user_info_toggle);
        jQuery("#payment_period").change(function () {
            var l, k, i;
            var j = jQuery("#price_amount"),
                h = jQuery("#subtotal_area"),
                m = jQuery("#show_more_subtotal_info");
            switch (this.value) {
            case "per_night":
                j.html(j.data("nightly-price"));
                break;
            case "per_week":
                k = j.data("weekly-price");
                i = parseInt(k.match(/\d+/), 10);
                j.html(k.replace(/(\d+)/, i));
                break;
            case "per_month":
                if (CogzidelRooms.stayOffered === 1 || CogzidelRooms.stayOffered === 2) {
                    k = "" + CogzidelRooms.staggeredPrice
                } else {
                    k = j.data("monthly-price")
                }
                i = parseInt(k.match(/\d+/), 10);
                j.html(k.replace(/(\d+)/, i));
                break;
            default:
                break
            }
        });
        var f = jQuery("#videos_div embed");
        f.before('<param name="wmode" value="opaque" />');
        f.attr("wmode", "opaque");
        jQuery("#reputation .pagination a").live("click", function () {
            var h = jQuery(this);
            h.parent().append('<img src="/images/spinner.gif" class="spinner" height="16" width="16" alt="" />');
            jQuery.ajax({
                url: h.attr("href"),
                success: function (i) {
                    h.closest(".rep_content").html(i);
                    jQuery("html, body").animate({
                        scrollTop: jQuery("#reputation").offset().top
                    }, "slow")
                }
            });
            return false
        });
        var e = jQuery("#reputation");
        var c = e.data("review-type");
        var g = e.data("hosting-id");
        switch (c) {
        case "listing_has_reviews":
            select_tab("rep", "this_hosting_reviews", jQuery("#this_hosting_reviews_link"));
            jQuery.ajax({
                url: "/rooms/this_hosting_reviews_first/" + g,
                success: function (j, h, i) {
                    if (jQuery.trim(j) !== "") {
                        jQuery("#this_hosting_reviews").html(j)
                    }
                }
            });
            break;
        case "host_has_reviews":
            select_tab("rep", "other_hosting_reviews", jQuery("#other_hosting_reviews_link"));
            jQuery.ajax({
                url: "/rooms/other_hosting_reviews_first/" + g,
                success: function (h) {
                    if (jQuery.trim(h) !== "") {
                        jQuery("#other_hosting_reviews").html(h)
                    }
                }
            });
            break;
        case "host_has_recommendations":
            select_tab("rep", "friends", jQuery("#friends_link"));
            break;
        case "no_reviews":
        default:
            select_tab("rep", "this_hosting_reviews", jQuery("#this_hosting_reviews_link"));
            break
        }
    },
    Helper: {},
    user_info_toggle: function () {
        if (jQuery("#video_wrapper").is(":visible")) {
            jQuery("#user_big_pic").show();
            jQuery("#play_button_big").show();
            jQuery("#video_wrapper").html("").addClass("force_hide")
        }
        jQuery("#more_info_text, #less_info_text").toggle();
        jQuery("#more_info_arrow").toggleClass("contract");
        jQuery("#user_info_small, #user_info_big").toggle()
    },
    video_profile_init: function (g) {
        var b = jQuery("#play_button_small"),
            d = jQuery("#user_small_pic"),
            f = jQuery("#play_button_big"),
            c = jQuery("#user_big_pic"),
            e = jQuery("#video_wrapper"),
            a = jQuery("<iframe title='CogzidelTV Video Player' src='http://tv.cogzidel.com/player/" + g + "/autoplay' width='225' height='225' frameborder='0'></iframe>");
        Helper = {
            play_video: function () {
                f.hide();
                c.hide();
                e.html(a).removeClass("force_hide")
            }
        };
        CogzidelRooms.user_info_toggle();
        f.removeClass("force_hide");
        b.removeClass("force_hide");
        c.unbind();
        c.click(function (h) {
            h.stopPropagation();
            Helper.play_video()
        });
        c.hover(function () {
            f.css("opacity", "1")
        }, function () {
            f.css("opacity", "0.7")
        });
        b.hover(function () {
            b.css("opacity", "1")
        }, function () {
            b.css("opacity", "0.7")
        });
        f.hover(function () {
            f.css("opacity", "1")
        }, function () {
            f.css("opacity", "0.7")
        });
        c.click(function () {
            Helper.play_video()
        });
        b.click(function () {
            Helper.play_video();
            CogzidelRooms.user_info_toggle()
        });
        f.click(function () {
            Helper.play_video()
        })
    },
    staggered: false,
    hostingLengthType: 0,
    inIsrael: false
};
(function (e) {
    var b, l = this,
        t = l.document,
        k = e(t),
        d = false,
        p = navigator.userAgent.toLowerCase(),
        n = l.location.hash.replace(/#\//, ""),
        f = function () {
            return i.TOUCH ? "touchstart" : "click"
        },
        m = (function () {
            var u = 3,
                x = t.createElement("div"),
                w = x.getElementsByTagName("i");
            do {
                x.innerHTML = "<!--[if gt IE " + (++u) + "]><i></i><![endif]-->"
            } while (w[0]);
            return u > 4 ? u : b
        }()),
        s = function () {
            return {
                html: t.documentElement,
                body: t.body,
                head: t.getElementsByTagName("head")[0],
                title: t.title
            }
        },
        g = "data ready thumbnail loadstart loadfinish image play pause progress fullscreen_enter fullscreen_exit idle_enter idle_exit rescale lightbox_open lightbox_close lightbox_image",
        q = (function () {
            var u = [];
            e.each(g.split(" "), function (v, w) {
                u.push(w);
                if (/_/.test(w)) {
                    u.push(w.replace(/_/g, ""))
                }
            });
            return u
        }()),
        r = function (u) {
            var v;
            if (typeof u !== "object") {
                return u
            }
            e.each(u, function (w, x) {
                if (/^[a-z]+_/.test(w)) {
                    v = "";
                    e.each(w.split("_"), function (z, y) {
                        v += z > 0 ? y.substr(0, 1).toUpperCase() + y.substr(1) : y
                    });
                    u[v] = x;
                    delete u[w]
                }
            });
            return u
        },
        a = function (u) {
            if (e.inArray(u, q) > -1) {
                return i[u.toUpperCase()]
            }
            return u
        },
        h = {
            trunk: {},
            add: function (y, x, w, v) {
                v = v || false;
                this.clear(y);
                if (v) {
                    var u = x;
                    x = function () {
                        u();
                        h.add(y, x, w)
                    }
                }
                this.trunk[y] = l.setTimeout(x, w)
            },
            clear: function (w) {
                var u = function (x) {
                        l.clearTimeout(this.trunk[x]);
                        delete this.trunk[x]
                    },
                    v;
                if ( !! w && w in this.trunk) {
                    u.call(h, w)
                } else {
                    if (typeof w === "undefined") {
                        for (v in this.trunk) {
                            if (this.trunk.hasOwnProperty(v)) {
                                u.call(h, v)
                            }
                        }
                    }
                }
            }
        },
        o = [],
        c = (function () {
            return {
                array: function (u) {
                    return Array.prototype.slice.call(u)
                },
                create: function (u, w) {
                    w = w || "div";
                    var v = t.createElement(w);
                    v.className = u;
                    return v
                },
                forceStyles: function (v, u) {
                    v = e(v);
                    if (v.attr("style")) {
                        v.data("styles", v.attr("style")).removeAttr("style")
                    }
                    v.css(u)
                },
                revertStyles: function () {
                    e.each(c.array(arguments), function (u, v) {
                        v = e(v).removeAttr("style");
                        if (v.data("styles")) {
                            v.attr("style", v.data("styles")).data("styles", null)
                        }
                    })
                },
                moveOut: function (u) {
                    c.forceStyles(u, {
                        position: "absolute",
                        left: -10000
                    })
                },
                moveIn: function () {
                    c.revertStyles.apply(c, c.array(arguments))
                },
                hide: function (v, w, x) {
                    v = e(v);
                    if (!v.data("opacity")) {
                        v.data("opacity", v.css("opacity"))
                    }
                    var u = {
                        opacity: 0
                    };
                    if (w) {
                        v.stop().animate(u, w, x)
                    } else {
                        v.css(u)
                    }
                },
                show: function (w, x, y) {
                    w = e(w);
                    var v = parseFloat(w.data("opacity")) || 1,
                        u = {
                            opacity: v
                        };
                    if (x) {
                        w.stop().animate(u, x, y)
                    } else {
                        w.css(u)
                    }
                },
                addTimer: function () {
                    h.add.apply(h, c.array(arguments));
                    return this
                },
                clearTimer: function () {
                    h.clear.apply(h, c.array(arguments));
                    return this
                },
                wait: function (w) {
                    w = e.extend({
                        until: function () {
                            return false
                        },
                        success: function () {},
                        error: function () {
                            i.raise("Could not complete wait function.")
                        },
                        timeout: 3000
                    }, w);
                    var y = c.timestamp(),
                        u, v, x = function () {
                            v = c.timestamp();
                            u = v - y;
                            if (w.until(u)) {
                                w.success();
                                return false
                            }
                            if (v >= y + w.timeout) {
                                w.error();
                                return false
                            }
                            l.setTimeout(x, 2)
                        };
                    l.setTimeout(x, 2)
                },
                toggleQuality: function (u, v) {
                    if ((m !== 7 && m !== 8) || !u) {
                        return
                    }
                    if (typeof v === "undefined") {
                        v = u.style.msInterpolationMode === "nearest-neighbor"
                    }
                    u.style.msInterpolationMode = v ? "bicubic" : "nearest-neighbor"
                },
                insertStyleTag: function (w) {
                    var v = t.createElement("style");
                    s().head.appendChild(v);
                    if (v.styleSheet) {
                        v.styleSheet.cssText = w
                    } else {
                        var u = t.createTextNode(w);
                        v.appendChild(u)
                    }
                },
                loadScript: function (w, x) {
                    var u = false,
                        v = e("<script>").attr({
                            src: w,
                            async: true
                        }).get(0);
                    v.onload = v.onreadystatechange = function () {
                        if (!u && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                            u = true;
                            v.onload = v.onreadystatechange = null;
                            if (typeof x === "function") {
                                x.call(this, this)
                            }
                        }
                    };
                    s().head.appendChild(v)
                },
                parseValue: function (v) {
                    if (typeof v === "number") {
                        return v
                    } else {
                        if (typeof v === "string") {
                            var u = v.match(/\-?\d/g);
                            return u && u.constructor === Array ? parseInt(u.join(""), 10) : 0
                        } else {
                            return 0
                        }
                    }
                },
                timestamp: function () {
                    return new Date().getTime()
                },
                loadCSS: function (u, z, y) {
                    var x, v = false,
                        w;
                    e('link[rel="stylesheet"]').each(function () {
                        if (new RegExp(u).test(this.href)) {
                            x = this;
                            return false
                        }
                    });
                    if (typeof z === "function") {
                        y = z;
                        z = b
                    }
                    y = y ||
                    function () {};
                    if (x) {
                        y.call(x, x);
                        return x
                    }
                    w = t.styleSheets.length;
                    if (d) {
                        u += "?" + c.timestamp()
                    }
                    if (e("#" + z).length) {
                        e("#" + z).attr("href", u);
                        w--;
                        v = true
                    } else {
                        x = e("<link>").attr({
                            rel: "stylesheet",
                            href: u,
                            id: z
                        }).get(0);
                        l.setTimeout(function () {
                            var A = e('link[rel="stylesheet"], style');
                            if (A.length) {
                                A.get(0).parentNode.insertBefore(x, A[0])
                            } else {
                                s().head.appendChild(x)
                            }
                            if (m) {
                                x.attachEvent("onreadystatechange", function (B) {
                                    if (x.readyState === "complete") {
                                        v = true
                                    }
                                })
                            } else {
                                v = true
                            }
                        }, 10)
                    }
                    if (typeof y === "function") {
                        c.wait({
                            until: function () {
                                return v && t.styleSheets.length > w
                            },
                            success: function () {
                                c.addTimer("css", function () {
                                    y.call(x, x)
                                }, 100)
                            },
                            error: function () {
                                i.raise("Theme CSS could not load")
                            },
                            timeout: 10000
                        })
                    }
                    return x
                }
            }
        }()),
        j = {
            fade: function (v, u) {
                e(v.next).css("opacity", 0).show().animate({
                    opacity: 1
                }, v.speed, u);
                if (v.prev) {
                    e(v.prev).css("opacity", 1).show().animate({
                        opacity: 0
                    }, v.speed)
                }
            },
            flash: function (v, u) {
                e(v.next).css("opacity", 0);
                if (v.prev) {
                    e(v.prev).animate({
                        opacity: 0
                    }, (v.speed / 2), function () {
                        e(v.next).animate({
                            opacity: 1
                        }, v.speed, u)
                    })
                } else {
                    e(v.next).animate({
                        opacity: 1
                    }, v.speed, u)
                }
            },
            pulse: function (v, u) {
                if (v.prev) {
                    e(v.prev).hide()
                }
                e(v.next).css("opacity", 0).animate({
                    opacity: 1
                }, v.speed, u)
            },
            slide: function (y, v) {
                var x = e(y.next).parent(),
                    u = this.$("images"),
                    w = this._stageWidth,
                    z = this.getOptions("easing");
                x.css({
                    left: w * (y.rewind ? -1 : 1)
                });
                u.animate({
                    left: w * (y.rewind ? 1 : -1)
                }, {
                    duration: y.speed,
                    queue: false,
                    easing: z,
                    complete: function () {
                        u.css("left", 0);
                        x.css("left", 0);
                        v()
                    }
                })
            },
            fadeslide: function (w, v) {
                var u = 0,
                    z = this.getOptions("easing"),
                    y = this.getStageWidth();
                if (w.prev) {
                    u = c.parseValue(e(w.prev).css("left"));
                    e(w.prev).css({
                        opacity: 1,
                        left: u
                    }).animate({
                        opacity: 0,
                        left: u + (y * (w.rewind ? 1 : -1))
                    }, {
                        duration: w.speed,
                        queue: false,
                        easing: z
                    })
                }
                u = c.parseValue(e(w.next).css("left"));
                e(w.next).css({
                    left: u + (y * (w.rewind ? -1 : 1)),
                    opacity: 0
                }).animate({
                    opacity: 1,
                    left: u
                }, {
                    duration: w.speed,
                    complete: v,
                    queue: false,
                    easing: z
                })
            }
        };
    var i = function () {
            var C = this;
            this._theme = b;
            this._options = {};
            this._playing = false;
            this._playtime = 5000;
            this._active = null;
            this._queue = {
                length: 0
            };
            this._data = [];
            this._dom = {};
            this._thumbnails = [];
            this._initialized = false;
            this._stageWidth = 0;
            this._stageHeight = 0;
            this._target = b;
            this._id = Math.random();
            var y = "container stage images image-nav image-nav-left image-nav-right info info-text info-title info-description thumbnails thumbnails-list thumbnails-container thumb-nav-left thumb-nav-right loader counter tooltip",
                x = "current total";
            e.each(y.split(" "), function (E, F) {
                C._dom[F] = c.create("galleria-" + F)
            });
            e.each(x.split(" "), function (E, F) {
                C._dom[F] = c.create("galleria-" + F, "span")
            });
            var w = this._keyboard = {
                keys: {
                    UP: 38,
                    DOWN: 40,
                    LEFT: 37,
                    RIGHT: 39,
                    RETURN: 13,
                    ESCAPE: 27,
                    BACKSPACE: 8,
                    SPACE: 32
                },
                map: {},
                bound: false,
                press: function (F) {
                    var E = F.keyCode || F.which;
                    if (E in w.map && typeof w.map[E] === "function") {
                        w.map[E].call(C, F)
                    }
                },
                attach: function (G) {
                    var F, E;
                    for (F in G) {
                        if (G.hasOwnProperty(F)) {
                            E = F.toUpperCase();
                            if (E in w.keys) {
                                w.map[w.keys[E]] = G[F]
                            } else {
                                w.map[E] = G[F]
                            }
                        }
                    }
                    if (!w.bound) {
                        w.bound = true;
                        k.bind("keydown", w.press)
                    }
                },
                detach: function () {
                    w.bound = false;
                    w.map = {};
                    k.unbind("keydown", w.press)
                }
            };
            var A = this._controls = {
                0: b,
                1: b,
                active: 0,
                swap: function () {
                    A.active = A.active ? 0 : 1
                },
                getActive: function () {
                    return A[A.active]
                },
                getNext: function () {
                    return A[1 - A.active]
                }
            };
            var B = this._carousel = {
                next: C.$("thumb-nav-right"),
                prev: C.$("thumb-nav-left"),
                width: 0,
                current: 0,
                max: 0,
                hooks: [],
                update: function () {
                    var F = 0,
                        G = 0,
                        E = [0];
                    e.each(C._thumbnails, function (I, H) {
                        if (H.ready) {
                            F += H.outerWidth || e(H.container).outerWidth(true);
                            E[I + 1] = F;
                            G = Math.max(G, H.outerHeight || e(H.container).outerHeight(true))
                        }
                    });
                    C.$("thumbnails").css({
                        width: F + 10,
                        height: G
                    });
                    B.max = F;
                    B.hooks = E;
                    B.width = C.$("thumbnails-list").width();
                    B.setClasses();
                    C.$("thumbnails-container").toggleClass("galleria-carousel", F > B.width);
                    B.width = C.$("thumbnails-list").width()
                },
                bindControls: function () {
                    var E;
                    B.next.bind(f(), function (F) {
                        F.preventDefault();
                        if (C._options.carouselSteps === "auto") {
                            for (E = B.current; E < B.hooks.length; E++) {
                                if (B.hooks[E] - B.hooks[B.current] > B.width) {
                                    B.set(E - 2);
                                    break
                                }
                            }
                        } else {
                            B.set(B.current + C._options.carouselSteps)
                        }
                    });
                    B.prev.bind(f(), function (F) {
                        F.preventDefault();
                        if (C._options.carouselSteps === "auto") {
                            for (E = B.current; E >= 0; E--) {
                                if (B.hooks[B.current] - B.hooks[E] > B.width) {
                                    B.set(E + 2);
                                    break
                                } else {
                                    if (E === 0) {
                                        B.set(0);
                                        break
                                    }
                                }
                            }
                        } else {
                            B.set(B.current - C._options.carouselSteps)
                        }
                    })
                },
                set: function (E) {
                    E = Math.max(E, 0);
                    while (B.hooks[E - 1] + B.width >= B.max && E >= 0) {
                        E--
                    }
                    B.current = E;
                    B.animate()
                },
                getLast: function (E) {
                    return (E || B.current) - 1
                },
                follow: function (E) {
                    if (E === 0 || E === B.hooks.length - 2) {
                        B.set(E);
                        return
                    }
                    var F = B.current;
                    while (B.hooks[F] - B.hooks[B.current] < B.width && F <= B.hooks.length) {
                        F++
                    }
                    if (E - 1 < B.current) {
                        B.set(E - 1)
                    } else {
                        if (E + 2 > F) {
                            B.set(E - F + B.current + 2)
                        }
                    }
                },
                setClasses: function () {
                    B.prev.toggleClass("disabled", !B.current);
                    B.next.toggleClass("disabled", B.hooks[B.current] + B.width >= B.max)
                },
                animate: function (F) {
                    B.setClasses();
                    var E = B.hooks[B.current] * -1;
                    if (isNaN(E)) {
                        return
                    }
                    C.$("thumbnails").animate({
                        left: E
                    }, {
                        duration: C._options.carouselSpeed,
                        easing: C._options.easing,
                        queue: false
                    })
                }
            };
            var D = this._tooltip = {
                initialized: false,
                open: false,
                init: function () {
                    D.initialized = true;
                    var E = ".galleria-tooltip{padding:3px 8px;max-width:50%;background:#ffe;color:#000;z-index:3;position:absolute;font-size:11px;line-height:1.3opacity:0;box-shadow:0 0 2px rgba(0,0,0,.4);-moz-box-shadow:0 0 2px rgba(0,0,0,.4);-webkit-box-shadow:0 0 2px rgba(0,0,0,.4);}";
                    c.insertStyleTag(E);
                    C.$("tooltip").css("opacity", 0.8);
                    c.hide(C.get("tooltip"))
                },
                move: function (L) {
                    var K = C.getMousePosition(L).x,
                        J = C.getMousePosition(L).y,
                        H = C.$("tooltip"),
                        N = K,
                        M = J,
                        O = H.outerHeight(true) + 1,
                        G = H.outerWidth(true),
                        I = O + 15;
                    var F = C.$("container").width() - G - 2,
                        E = C.$("container").height() - O - 2;
                    if (!isNaN(N) && !isNaN(M)) {
                        N += 10;
                        M -= 30;
                        N = Math.max(0, Math.min(F, N));
                        M = Math.max(0, Math.min(E, M));
                        if (J < I) {
                            M = I
                        }
                        H.css({
                            left: N,
                            top: M
                        })
                    }
                },
                bind: function (F, G) {
                    if (!D.initialized) {
                        D.init()
                    }
                    var E = function (H, I) {
                            D.define(H, I);
                            e(H).hover(function () {
                                c.clearTimer("switch_tooltip");
                                C.$("container").unbind("mousemove", D.move).bind("mousemove", D.move).trigger("mousemove");
                                D.show(H);
                                i.utils.addTimer("tooltip", function () {
                                    C.$("tooltip").stop().show();
                                    c.show(C.get("tooltip"), 400);
                                    D.open = true
                                }, D.open ? 0 : 500)
                            }, function () {
                                C.$("container").unbind("mousemove", D.move);
                                c.clearTimer("tooltip");
                                C.$("tooltip").stop();
                                c.hide(C.get("tooltip"), 200, function () {
                                    C.$("tooltip").hide();
                                    c.addTimer("switch_tooltip", function () {
                                        D.open = false
                                    }, 1000)
                                })
                            })
                        };
                    if (typeof G === "string") {
                        E((F in C._dom ? C.get(F) : F), G)
                    } else {
                        e.each(F, function (H, I) {
                            E(C.get(H), I)
                        })
                    }
                },
                show: function (E) {
                    E = e(E in C._dom ? C.get(E) : E);
                    var G = E.data("tt"),
                        F = function (H) {
                            l.setTimeout((function (I) {
                                return function () {
                                    D.move(I)
                                }
                            }(H)), 10);
                            E.unbind("mouseup", F)
                        };
                    G = typeof G === "function" ? G() : G;
                    if (!G) {
                        return
                    }
                    C.$("tooltip").html(G.replace(/\s/, "&nbsp;"));
                    E.bind("mouseup", F)
                },
                define: function (F, G) {
                    if (typeof G !== "function") {
                        var E = G;
                        G = function () {
                            return E
                        }
                    }
                    F = e(F in C._dom ? C.get(F) : F).data("tt", G);
                    D.show(F)
                }
            };
            var z = this._fullscreen = {
                scrolled: 0,
                active: false,
                keymap: C._keyboard.map,
                enter: function (K) {
                    z.active = true;
                    c.hide(C.getActiveImage());
                    C.$("container").addClass("fullscreen");
                    z.scrolled = e(l).scrollTop();
                    c.forceStyles(C.get("container"), {
                        position: "fixed",
                        top: 0,
                        left: 0,
                        width: "100%",
                        height: "100%",
                        zIndex: 10000
                    });
                    var H = {
                        height: "100%",
                        overflow: "hidden",
                        margin: 0,
                        padding: 0
                    },
                        J = C.getData();
                    c.forceStyles(s().html, H);
                    c.forceStyles(s().body, H);
                    z.keymap = e.extend({}, C._keyboard.map);
                    C.attachKeyboard({
                        escape: C.exitFullscreen,
                        right: C.next,
                        left: C.prev
                    });
                    if (J && J.big && J.image !== J.big) {
                        var E = new i.Picture(),
                            I = E.isCached(J.big),
                            G = C.getIndex(),
                            F = C._thumbnails[G];
                        C.trigger({
                            type: i.LOADSTART,
                            cached: I,
                            index: G,
                            imageTarget: C.getActiveImage(),
                            thumbTarget: F
                        });
                        E.load(J.big, function (L) {
                            C._scaleImage(L, {
                                complete: function (M) {
                                    C.trigger({
                                        type: i.LOADFINISH,
                                        cached: I,
                                        index: G,
                                        imageTarget: M.image,
                                        thumbTarget: F
                                    });
                                    var N = C._controls.getActive().image;
                                    if (N) {
                                        e(N).width(M.image.width).height(M.image.height).attr("style", e(M.image).attr("style")).attr("src", M.image.src)
                                    }
                                }
                            })
                        })
                    }
                    C.rescale(function () {
                        c.addTimer("fullscreen_enter", function () {
                            c.show(C.getActiveImage());
                            if (typeof K === "function") {
                                K.call(C)
                            }
                        }, 100);
                        C.trigger(i.FULLSCREEN_ENTER)
                    });
                    e(l).resize(function () {
                        z.scale()
                    })
                },
                scale: function () {
                    C.rescale()
                },
                exit: function (E) {
                    z.active = false;
                    c.hide(C.getActiveImage());
                    C.$("container").removeClass("fullscreen");
                    c.revertStyles(C.get("container"), s().html, s().body);
                    l.scrollTo(0, z.scrolled);
                    C.detachKeyboard();
                    C.attachKeyboard(z.keymap);
                    C.rescale(function () {
                        c.addTimer("fullscreen_exit", function () {
                            c.show(C.getActiveImage());
                            if (typeof E === "function") {
                                E.call(C)
                            }
                        }, 50);
                        C.trigger(i.FULLSCREEN_EXIT)
                    });
                    e(l).unbind("resize", z.scale)
                }
            };
            var v = this._idle = {
                trunk: [],
                bound: false,
                add: function (F, H) {
                    if (!F) {
                        return
                    }
                    if (!v.bound) {
                        v.addEvent()
                    }
                    F = e(F);
                    var G = {},
                        E;
                    for (E in H) {
                        if (H.hasOwnProperty(E)) {
                            G[E] = F.css(E)
                        }
                    }
                    F.data("idle", {
                        from: G,
                        to: H,
                        complete: true,
                        busy: false
                    });
                    v.addTimer();
                    v.trunk.push(F)
                },
                remove: function (E) {
                    E = jQuery(E);
                    e.each(v.trunk, function (F, G) {
                        if (G.length && !G.not(E).length) {
                            C._idle.show(E);
                            C._idle.trunk.splice(F, 1)
                        }
                    });
                    if (!v.trunk.length) {
                        v.removeEvent();
                        c.clearTimer("idle")
                    }
                },
                addEvent: function () {
                    v.bound = true;
                    C.$("container").bind("mousemove click", v.showAll)
                },
                removeEvent: function () {
                    v.bound = false;
                    C.$("container").unbind("mousemove click", v.showAll)
                },
                addTimer: function () {
                    c.addTimer("idle", function () {
                        C._idle.hide()
                    }, C._options.idleTime)
                },
                hide: function () {
                    C.trigger(i.IDLE_ENTER);
                    e.each(v.trunk, function (E, F) {
                        var G = F.data("idle");
                        if (!G) {
                            return
                        }
                        F.data("idle").complete = false;
                        F.stop().animate(G.to, {
                            duration: C._options.idleSpeed,
                            queue: false,
                            easing: "swing"
                        })
                    })
                },
                showAll: function () {
                    c.clearTimer("idle");
                    e.each(C._idle.trunk, function (E, F) {
                        C._idle.show(F)
                    })
                },
                show: function (E) {
                    var F = E.data("idle");
                    if (!F.busy && !F.complete) {
                        F.busy = true;
                        C.trigger(i.IDLE_EXIT);
                        c.clearTimer("idle");
                        E.stop().animate(F.from, {
                            duration: C._options.idleSpeed / 2,
                            queue: false,
                            easing: "swing",
                            complete: function () {
                                e(this).data("idle").busy = false;
                                e(this).data("idle").complete = true
                            }
                        })
                    }
                    v.addTimer()
                }
            };
            var u = this._lightbox = {
                width: 0,
                height: 0,
                initialized: false,
                active: null,
                image: null,
                elems: {},
                init: function () {
                    C.trigger(i.LIGHTBOX_OPEN);
                    if (u.initialized) {
                        return
                    }
                    u.initialized = true;
                    var E = "overlay box content shadow title info close prevholder prev nextholder next counter image",
                        F = {},
                        G = C._options,
                        J = "",
                        M = "position:absolute;",
                        I = "lightbox-",
                        H = {
                            overlay: "position:fixed;display:none;opacity:" + G.overlayOpacity + ";filter:alpha(opacity=" + (G.overlayOpacity * 100) + ");top:0;left:0;width:100%;height:100%;background:" + G.overlayBackground + ";z-index:99990",
                            box: "position:fixed;display:none;width:400px;height:400px;top:50%;left:50%;margin-top:-200px;margin-left:-200px;z-index:99991",
                            shadow: M + "background:#000;width:100%;height:100%;",
                            content: M + "background-color:#fff;top:10px;left:10px;right:10px;bottom:10px;overflow:hidden",
                            info: M + "bottom:10px;left:10px;right:10px;color:#444;font:11px/13px arial,sans-serif;height:13px",
                            close: M + "top:10px;right:10px;height:20px;width:20px;background:#fff;text-align:center;cursor:pointer;color:#444;font:16px/22px arial,sans-serif;z-index:99999",
                            image: M + "top:10px;left:10px;right:10px;bottom:30px;overflow:hidden;display:block;",
                            prevholder: M + "width:50%;top:0;bottom:40px;cursor:pointer;",
                            nextholder: M + "width:50%;top:0;bottom:40px;right:-1px;cursor:pointer;",
                            prev: M + "top:50%;margin-top:-20px;height:40px;width:30px;background:#fff;left:20px;display:none;text-align:center;color:#000;font:bold 16px/36px arial,sans-serif",
                            next: M + "top:50%;margin-top:-20px;height:40px;width:30px;background:#fff;right:20px;left:auto;display:none;font:bold 16px/36px arial,sans-serif;text-align:center;color:#000",
                            title: "float:left",
                            counter: "float:right;margin-left:8px;"
                        },
                        K = function (N) {
                            return N.hover(function () {
                                e(this).css("color", "#bbb")
                            }, function () {
                                e(this).css("color", "#444")
                            })
                        },
                        L = {};
                    if (m === 8) {
                        H.nextholder += "background:#000;filter:alpha(opacity=0);";
                        H.prevholder += "background:#000;filter:alpha(opacity=0);"
                    }
                    e.each(H, function (N, O) {
                        J += ".galleria-" + I + N + "{" + O + "}"
                    });
                    c.insertStyleTag(J);
                    e.each(E.split(" "), function (N, O) {
                        C.addElement("lightbox-" + O);
                        F[O] = u.elems[O] = C.get("lightbox-" + O)
                    });
                    u.image = new i.Picture();
                    e.each({
                        box: "shadow content close prevholder nextholder",
                        info: "title counter",
                        content: "info image",
                        prevholder: "prev",
                        nextholder: "next"
                    }, function (O, P) {
                        var N = [];
                        e.each(P.split(" "), function (Q, R) {
                            N.push(I + R)
                        });
                        L[I + O] = N
                    });
                    C.append(L);
                    e(F.image).append(u.image.container);
                    e(s().body).append(F.overlay, F.box);
                    K(e(F.close).bind(f(), u.hide).html("&#215;"));
                    e.each(["Prev", "Next"], function (Q, O) {
                        var P = e(F[O.toLowerCase()]).html(/v/.test(O) ? "&#8249;&nbsp;" : "&nbsp;&#8250;"),
                            N = e(F[O.toLowerCase() + "holder"]);
                        N.bind(f(), function () {
                            u["show" + O]()
                        });
                        if (m < 8) {
                            P.show();
                            return
                        }
                        N.hover(function () {
                            P.show()
                        }, function (R) {
                            P.stop().fadeOut(200)
                        })
                    });
                    e(F.overlay).bind(f(), u.hide)
                },
                rescale: function (I) {
                    var H = Math.min(e(l).width() - 40, u.width),
                        E = Math.min(e(l).height() - 60, u.height),
                        G = Math.min(H / u.width, E / u.height),
                        F = (u.width * G) + 40,
                        K = (u.height * G) + 60,
                        J = {
                            width: F,
                            height: K,
                            marginTop: Math.ceil(K / 2) * -1,
                            marginLeft: Math.ceil(F / 2) * -1
                        };
                    if (I) {
                        e(u.elems.box).css(J)
                    } else {
                        e(u.elems.box).animate(J, C._options.lightboxTransitionSpeed, C._options.easing, function () {
                            var M = u.image,
                                L = C._options.lightboxFadeSpeed;
                            C.trigger({
                                type: i.LIGHTBOX_IMAGE,
                                imageTarget: M.image
                            });
                            e(M.container).show();
                            c.show(M.image, L);
                            c.show(u.elems.info, L)
                        })
                    }
                },
                hide: function () {
                    u.image.image = null;
                    e(l).unbind("resize", u.rescale);
                    e(u.elems.box).hide();
                    c.hide(u.elems.info);
                    c.hide(u.elems.overlay, 200, function () {
                        e(this).hide().css("opacity", C._options.overlayOpacity);
                        C.trigger(i.LIGHTBOX_CLOSE)
                    })
                },
                showNext: function () {
                    u.show(C.getNext(u.active))
                },
                showPrev: function () {
                    u.show(C.getPrev(u.active))
                },
                show: function (E) {
                    u.active = E = typeof E === "number" ? E : C.getIndex();
                    if (!u.initialized) {
                        u.init()
                    }
                    e(l).unbind("resize", u.rescale);
                    var G = C.getData(E),
                        F = C.getDataLength();
                    c.hide(u.elems.info);
                    u.image.load(G.image, function (H) {
                        u.width = H.original.width;
                        u.height = H.original.height;
                        e(H.image).css({
                            width: "100.5%",
                            height: "100.5%",
                            top: 0,
                            zIndex: 99998
                        });
                        c.hide(H.image);
                        u.elems.title.innerHTML = G.title;
                        u.elems.counter.innerHTML = (E + 1) + " / " + F;
                        e(l).resize(u.rescale);
                        u.rescale()
                    });
                    e(u.elems.overlay).show();
                    e(u.elems.box).show()
                }
            };
            return this
        };
    i.prototype = {
        constructor: i,
        init: function (w, v) {
            var u = this;
            v = r(v);
            o.push(this);
            this._original = {
                target: w,
                options: v,
                data: null
            };
            this._target = this._dom.target = w.nodeName ? w : e(w).get(0);
            if (!this._target) {
                i.raise("Target not found.");
                return
            }
            this._options = {
                autoplay: false,
                carousel: true,
                carouselFollow: true,
                carouselSpeed: 400,
                carouselSteps: "auto",
                clicknext: false,
                dataConfig: function (x) {
                    return {}
                },
                dataSelector: "img",
                dataSource: this._target,
                debug: b,
                easing: "galleria",
                extend: function (x) {},
                height: "auto",
                idleTime: 3000,
                idleSpeed: 200,
                imageCrop: false,
                imageMargin: 0,
                imagePan: false,
                imagePanSmoothness: 12,
                imagePosition: "50%",
                keepSource: false,
                lightbox: false,
                lightboxFadeSpeed: 200,
                lightboxTransitionSpeed: 400,
                linkSourceTmages: true,
                maxScaleRatio: b,
                minScaleRatio: b,
                overlayOpacity: 0.85,
                overlayBackground: "#0b0b0b",
                pauseOnInteraction: true,
                popupLinks: false,
                preload: 2,
                queue: true,
                show: 0,
                showInfo: true,
                showCounter: true,
                showImagenav: true,
                thumbCrop: true,
                thumbEventType: f(),
                thumbFit: true,
                thumbMargin: 0,
                thumbQuality: "auto",
                thumbnails: true,
                transition: "fade",
                transitionInitial: b,
                transitionSpeed: 400,
                width: "auto"
            };
            if (v && v.debug === true) {
                d = true
            }
            e(this._target).children().hide();
            if (typeof i.theme === "object") {
                this._init()
            } else {
                c.wait({
                    until: function () {
                        return typeof i.theme === "object"
                    },
                    success: function () {
                        u._init.call(u)
                    },
                    error: function () {
                        i.raise("No theme found.", true)
                    },
                    timeout: 5000
                })
            }
        },
        _init: function () {
            var u = this;
            if (this._initialized) {
                i.raise("Init failed: Gallery instance already initialized.");
                return this
            }
            this._initialized = true;
            if (!i.theme) {
                i.raise("Init failed: No theme found.");
                return this
            }
            e.extend(true, this._options, i.theme.defaults, this._original.options);
            this.bind(i.DATA, function () {
                this._original.data = this._data;
                this.get("total").innerHTML = this.getDataLength();
                var y = this.$("container");
                var x = {
                    width: 0,
                    height: 0
                };
                var w = c.create("galleria-image");
                c.wait({
                    until: function () {
                        e.each(["width", "height"], function (B, A) {
                            if (u._options[A] && typeof u._options[A] === "number") {
                                x[A] = u._options[A]
                            } else {
                                x[A] = Math.max(c.parseValue(y.css(A)), c.parseValue(u.$("target").css(A)), y[A](), u.$("target")[A]())
                            }
                        });
                        var z = function () {
                                return true
                            };
                        if (u._options.thumbnails) {
                            u.$("thumbnails").append(w);
                            z = function () {
                                return !!e(w).height()
                            }
                        }
                        return z() && x.width && x.height > 10
                    },
                    success: function () {
                        e(w).remove();
                        y.width(x.width);
                        y.height(x.height);
                        if (i.WEBKIT) {
                            l.setTimeout(function () {
                                u._run()
                            }, 1)
                        } else {
                            u._run()
                        }
                    },
                    error: function () {
                        i.raise("Width & Height not found.", true)
                    },
                    timeout: 2000
                })
            });
            var v = false;
            this.bind(i.READY, (function (w) {
                return function () {
                    c.show(this.get("counter"));
                    if (this._options.carousel) {
                        this._carousel.bindControls()
                    }
                    if (this._options.autoplay) {
                        this.pause();
                        if (typeof this._options.autoplay === "number") {
                            this._playtime = this._options.autoplay
                        }
                        this.trigger(i.PLAY);
                        this._playing = true
                    }
                    if (w) {
                        if (typeof this._options.show === "number") {
                            this.show(this._options.show)
                        }
                        return
                    }
                    w = true;
                    if (this._options.clicknext) {
                        e.each(this._data, function (x, y) {
                            delete y.link
                        });
                        this.$("stage").css({
                            cursor: "pointer"
                        }).bind(f(), function (x) {
                            if (u._options.pauseOnInteraction) {
                                u.pause()
                            }
                            u.next()
                        })
                    }
                    if (i.History) {
                        i.History.change(function (x) {
                            var y = parseInt(x.value.replace(/\//, ""), 10);
                            if (isNaN(y)) {
                                l.history.go(-1)
                            } else {
                                u.show(y, b, true)
                            }
                        })
                    }
                    i.theme.init.call(this, this._options);
                    this._options.extend.call(this, this._options);
                    if (/^[0-9]{1,4}$/.test(n) && i.History) {

                        this.show(n, b, true)
                    } else {
                        if (this._data[this._options.show]) {
                            this.show(this._options.show)
                        }
                    }
                }
            }(v)));
            this.append({
                "info-text": ["info-title", "info-description"],
                info: ["info-text"],
                "image-nav": ["image-nav-right", "image-nav-left"],
                stage: ["images", "loader", "counter", "image-nav"],
                "thumbnails-list": ["thumbnails"],
                "thumbnails-container": ["thumb-nav-left", "thumbnails-list", "thumb-nav-right"],
                container: ["stage", "thumbnails-container", "info", "tooltip"]
            });
            c.hide(this.$("counter").append(this.get("current"), " / ", this.get("total")));
            this.setCounter("&#8211;");
            c.hide(u.get("tooltip"));
            e.each(new Array(2), function (w) {
                var x = new i.Picture();
                e(x.container).css({
                    position: "absolute",
                    top: 0,
                    left: 0
                });
                u.$("images").append(x.container);
                u._controls[w] = x
            });
            this.$("images").css({
                position: "relative",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%"
            });
            this.$("thumbnails, thumbnails-list").css({
                overflow: "hidden",
                position: "relative"
            });
            this.$("image-nav-right, image-nav-left").bind(f(), function (x) {
                if (u._options.clicknext) {
                    x.stopPropagation()
                }
                if (u._options.pauseOnInteraction) {
                    u.pause()
                }
                var w = /right/.test(this.className) ? "next" : "prev";
                u[w]()
            });
            e.each(["info", "counter", "image-nav"], function (w, x) {
                if (u._options["show" + x.substr(0, 1).toUpperCase() + x.substr(1).replace(/-/, "")] === false) {
                    c.moveOut(u.get(x.toLowerCase()))
                }
            });
            this.load();
            if (!this._options.keep_source && !m) {
                this._target.innerHTML = ""
            }
            this.$("target").append(this.get("container"));
            if (this._options.carousel) {
                this.bind(i.THUMBNAIL, function () {
                    this.updateCarousel()
                })
            }
            return this
        },
        _createThumbnails: function () {
            this.get("total").innerHTML = this.getDataLength();
            var B, u, v, A, F, G = this,
                w = this._options,
                y = (function () {
                    var H = G.$("thumbnails").find(".active");
                    if (!H.length) {
                        return false
                    }
                    return H.find("img").attr("src")
                }()),
                x = typeof w.thumbnails === "string" ? w.thumbnails.toLowerCase() : null,
                C = function (H) {
                    return t.defaultView && t.defaultView.getComputedStyle ? t.defaultView.getComputedStyle(v.container, null)[H] : F.css(H)
                },
                D = function (J, I, H) {
                    return function () {
                        e(H).append(J);
                        G.trigger({
                            type: i.THUMBNAIL,
                            thumbTarget: J,
                            index: I
                        })
                    }
                },
                E = function (I) {
                    if (w.pauseOnInteraction) {
                        G.pause()
                    }
                    var H = e(I.currentTarget).data("index");
                    if (G.getIndex() !== H) {
                        G.show(H)
                    }
                    I.preventDefault()
                },
                z = function (H) {
                    H.scale({
                        width: H.data.width,
                        height: H.data.height,
                        crop: w.thumbCrop,
                        margin: w.thumbMargin,
                        complete: function (K) {
                            var M = ["left", "top"],
                                J = ["Width", "Height"],
                                I, L;
                            e.each(J, function (N, O) {
                                I = O.toLowerCase();
                                if ((w.thumbCrop !== true || w.thumbCrop === I) && w.thumbFit) {
                                    L = {};
                                    L[I] = K[I];
                                    e(K.container).css(L);
                                    L = {};
                                    L[M[N]] = 0;
                                    e(K.image).css(L)
                                }
                                K["outer" + O] = e(K.container)["outer" + O](true)
                            });
                            c.toggleQuality(K.image, w.thumbQuality === true || (w.thumbQuality === "auto" && K.original.width < K.width * 3));
                            G.trigger({
                                type: i.THUMBNAIL,
                                thumbTarget: K.image,
                                index: K.data.order
                            })
                        }
                    })
                };
            this._thumbnails = [];
            this.$("thumbnails").empty();
            for (B = 0; this._data[B]; B++) {
                A = this._data[B];
                if (w.thumbnails === true) {
                    v = new i.Picture(B);
                    u = A.thumb || A.image;
                    this.$("thumbnails").append(v.container);
                    F = e(v.container);
                    v.data = {
                        width: c.parseValue(C("width")),
                        height: c.parseValue(C("height")),
                        order: B
                    };
                    if (w.thumbFit && w.thumbCrop !== true) {
                        F.css({
                            width: 0,
                            height: 0
                        })
                    } else {
                        F.css({
                            width: v.data.width,
                            height: v.data.height
                        })
                    }
                    v.load(u, z);
                    if (w.preload === "all") {
                        v.add(A.image)
                    }
                } else {
                    if (x === "empty" || x === "numbers") {
                        v = {
                            container: c.create("galleria-image"),
                            image: c.create("img", "span"),
                            ready: true
                        };
                        if (x === "numbers") {
                            e(v.image).text(B + 1)
                        }
                        this.$("thumbnails").append(v.container);
                        l.setTimeout((D)(v.image, B, v.container), 50 + (B * 20))
                    } else {
                        v = {
                            container: null,
                            image: null
                        }
                    }
                }
                e(v.container).add(w.keepSource && w.linkSourceImages ? A.original : null).data("index", B).bind(w.thumbEventType, E);
                if (y === u) {
                    e(v.container).addClass("active")
                }
                this._thumbnails.push(v)
            }
        },
        _run: function () {
            var u = this;
            u._createThumbnails();
            c.wait({
                until: function () {
                    if (i.OPERA) {
                        u.$("stage").css("display", "inline-block")
                    }
                    u._stageWidth = u.$("stage").width();
                    u._stageHeight = u.$("stage").height();
                    return (u._stageWidth && u._stageHeight > 50)
                },
                success: function () {
                    u.trigger(i.READY)
                },
                error: function () {
                    i.raise("Stage measures not found", true)
                }
            })
        },
        load: function (x, u, w) {
            var v = this;
            this._data = [];
            this._thumbnails = [];
            this.$("thumbnails").empty();
            if (typeof u === "function") {
                w = u;
                u = null
            }
            x = x || this._options.dataSource;
            u = u || this._options.dataSelector;
            w = w || this._options.dataConfig;
            if (x.constructor === Array) {
                if (this.validate(x)) {
                    this._data = x;
                    this._parseData().trigger(i.DATA)
                } else {
                    i.raise("Load failed: JSON Array not valid.")
                }
                return this
            }
            e(x).find(u).each(function (A, z) {
                z = e(z);
                var C = {},
                    B = z.parent(),
                    y = B.attr("href");
                C.image = C.big = y;
                v._data.push(e.extend({
                    title: z.attr("title"),
                    thumb: z.attr("src"),
                    image: z.attr("src"),
                    big: z.attr("src"),
                    description: z.attr("alt"),
                    link: z.attr("longdesc"),
                    original: z.get(0)
                }, C, w(z)))
            });
            if (this.getDataLength()) {
                this.trigger(i.DATA)
            } else {
                i.raise("Load failed: no data found.")
            }
            return this
        },
        _parseData: function () {
            var u = this;
            e.each(this._data, function (v, w) {
                if ("thumb" in w === false) {
                    u._data[v].thumb = w.image
                }
                if (!"big" in w) {
                    u._data[v].big = w.image
                }
            });
            return this
        },
        splice: function () {
            Array.prototype.splice.apply(this._data, c.array(arguments));
            return this._parseData()._createThumbnails()
        },
        push: function () {
            Array.prototype.push.apply(this._data, c.array(arguments));
            return this._parseData()._createThumbnails()
        },
        _getActive: function () {
            return this._controls.getActive()
        },
        validate: function (u) {
            return true
        },
        bind: function (v, u) {
            v = a(v);
            this.$("container").bind(v, this.proxy(u));
            return this
        },
        unbind: function (u) {
            u = a(u);
            this.$("container").unbind(u);
            return this
        },
        trigger: function (u) {
            u = typeof u === "object" ? e.extend(u, {
                scope: this
            }) : {
                type: a(u),
                scope: this
            };
            this.$("container").trigger(u);
            return this
        },
        addIdleState: function (v, u) {
            this._idle.add.apply(this._idle, c.array(arguments));
            return this
        },
        removeIdleState: function (u) {
            this._idle.remove.apply(this._idle, c.array(arguments));
            return this
        },
        enterIdleMode: function () {
            this._idle.hide();
            return this
        },
        exitIdleMode: function () {
            this._idle.showAll();
            return this
        },
        enterFullscreen: function (u) {
            this._fullscreen.enter.apply(this, c.array(arguments));
            return this
        },
        exitFullscreen: function (u) {
            this._fullscreen.exit.apply(this, c.array(arguments));
            return this
        },
        toggleFullscreen: function (u) {
            this._fullscreen[this.isFullscreen() ? "exit" : "enter"].apply(this, c.array(arguments));
            return this
        },
        bindTooltip: function (u, v) {
            this._tooltip.bind.apply(this._tooltip, c.array(arguments));
            return this
        },
        defineTooltip: function (u, v) {
            this._tooltip.define.apply(this._tooltip, c.array(arguments));
            return this
        },
        refreshTooltip: function (u) {
            this._tooltip.show.apply(this._tooltip, c.array(arguments));
            return this
        },
        openLightbox: function () {
            this._lightbox.show.apply(this._lightbox, c.array(arguments));
            return this
        },
        closeLightbox: function () {
            this._lightbox.hide.apply(this._lightbox, c.array(arguments));
            return this
        },
        getActiveImage: function () {
            return this._getActive().image || b
        },
        getActiveThumb: function () {
            return this._thumbnails[this._active].image || b
        },
        getMousePosition: function (u) {
            return {
                x: u.pageX - this.$("container").offset().left,
                y: u.pageY - this.$("container").offset().top
            }
        },
        addPan: function (C) {
            if (this._options.imageCrop === false) {
                return
            }
            C = e(C || this.getActiveImage());
            var M = this,
                L = C.width() / 2,
                I = C.height() / 2,
                K = parseInt(C.css("left"), 10),
                J = parseInt(C.css("top"), 10),
                w = K || 0,
                v = J || 0,
                H = 0,
                G = 0,
                A = false,
                F = c.timestamp(),
                u = 0,
                z = 0,
                E = function (N, y, O) {
                    if (N > 0) {
                        z = Math.round(Math.max(N * -1, Math.min(0, y)));
                        if (u !== z) {
                            u = z;
                            if (m === 8) {
                                C.parent()["scroll" + O](z * -1)
                            } else {
                                var x = {};
                                x[O.toLowerCase()] = z;
                                C.css(x)
                            }
                        }
                    }
                },
                B = function (x) {
                    if (c.timestamp() - F < 50) {
                        return
                    }
                    A = true;
                    L = M.getMousePosition(x).x;
                    I = M.getMousePosition(x).y
                },
                D = function (x) {
                    if (!A) {
                        return
                    }
                    H = C.width() - M._stageWidth;
                    G = C.height() - M._stageHeight;
                    K = L / M._stageWidth * H * -1;
                    J = I / M._stageHeight * G * -1;
                    w += (K - w) / M._options.imagePanSmoothness;
                    v += (J - v) / M._options.imagePanSmoothness;
                    E(G, v, "Top");
                    E(H, w, "Left")
                };
            if (m === 8) {
                C.parent().scrollTop(v * -1).scrollLeft(w * -1);
                C.css({
                    top: 0,
                    left: 0
                })
            }
            this.$("stage").unbind("mousemove", B).bind("mousemove", B);
            c.addTimer("pan", D, 50, true);
            return this
        },
        proxy: function (v, u) {
            if (typeof v !== "function") {
                return function () {}
            }
            u = u || this;
            return function () {
                return v.apply(u, c.array(arguments))
            }
        },
        removePan: function () {
            this.$("stage").unbind("mousemove");
            c.clearTimer("pan");
            return this
        },
        addElement: function (v) {
            var u = this._dom;
            e.each(c.array(arguments), function (x, w) {
                u[w] = c.create("galleria-" + w)
            });
            return this
        },
        attachKeyboard: function (u) {
            this._keyboard.attach.apply(this._keyboard, c.array(arguments));
            return this
        },
        detachKeyboard: function () {
            this._keyboard.detach.apply(this._keyboard, c.array(arguments));
            return this
        },
        appendChild: function (v, u) {
            this.$(v).append(this.get(u) || u);
            return this
        },
        prependChild: function (v, u) {
            this.$(v).prepend(this.get(u) || u);
            return this
        },
        remove: function (u) {
            this.$(c.array(arguments).join(",")).remove();
            return this
        },
        append: function (w) {
            var v, u;
            for (v in w) {
                if (w.hasOwnProperty(v)) {
                    if (w[v].constructor === Array) {
                        for (u = 0; w[v][u]; u++) {
                            this.appendChild(v, w[v][u])
                        }
                    } else {
                        this.appendChild(v, w[v])
                    }
                }
            }
            return this
        },
        _scaleImage: function (v, u) {
            u = e.extend({
                width: this._stageWidth,
                height: this._stageHeight,
                crop: this._options.imageCrop,
                max: this._options.maxScaleRatio,
                min: this._options.minScaleRatio,
                margin: this._options.imageMargin,
                position: this._options.imagePosition
            }, u);
            (v || this._controls.getActive()).scale(u);
            return this
        },
        updateCarousel: function () {
            this._carousel.update();
            return this
        },
        rescale: function (x, u, v) {
            var w = this;
            if (typeof x === "function") {
                v = x;
                x = b
            }
            var y = function () {
                    w._stageWidth = x || w.$("stage").width();
                    w._stageHeight = u || w.$("stage").height();
                    w._scaleImage();
                    if (w._options.carousel) {
                        w.updateCarousel()
                    }
                    w.trigger(i.RESCALE);
                    if (typeof v === "function") {
                        v.call(w)
                    }
                };
            if (i.WEBKIT && !x && !u) {
                c.addTimer("scale", y, 5)
            } else {
                y.call(w)
            }
            return this
        },
        refreshImage: function () {
            this._scaleImage();
            if (this._options.imagePan) {
                this.addPan()
            }
            return this
        },
        show: function (v, u, w) {
            if (v === false || (!this._options.queue && this._queue.stalled)) {
                return
            }
            v = Math.max(0, Math.min(parseInt(v, 10), this.getDataLength() - 1));
            u = typeof u !== "undefined" ? !! u : v < this.getIndex();
            w = w || false;
            if (!w && i.History) {
                i.History.value(v.toString());
                return
            }
            this._active = v;
            Array.prototype.push.call(this._queue, {
                index: v,
                rewind: u
            });
            if (!this._queue.stalled) {
                this._show()
            }
            return this
        },
        _show: function () {
            var G = this,
                E = this._queue[0],
                C = this.getData(E.index);
            if (!C) {
                return
            }
            var u = this.isFullscreen() && "big" in C ? C.big : C.image,
                A = this._controls.getActive(),
                D = this._controls.getNext(),
                z = D.isCached(u),
                v = this._thumbnails[E.index];
            var x = function () {
                    var H;
                    G._queue.stalled = false;
                    c.toggleQuality(D.image, G._options.imageQuality);
                    e(A.container).css({
                        zIndex: 0,
                        opacity: 0
                    });
                    e(D.container).css({
                        zIndex: 1,
                        opacity: 1
                    });
                    G._controls.swap();
                    if (G._options.imagePan) {
                        G.addPan(D.image)
                    }
                    if (C.link || G._options.lightbox) {
                        e(D.image).css({
                            cursor: "pointer"
                        }).bind(f(), function () {
                            if (C.link) {
                                if (G._options.popupLinks) {
                                    H = l.open(C.link, "_blank")
                                } else {
                                    l.location.href = C.link
                                }
                                return
                            }
                            G.openLightbox()
                        })
                    }
                    Array.prototype.shift.call(G._queue);
                    if (G._queue.length) {
                        G._show()
                    }
                    G._playCheck();
                    G.trigger({
                        type: i.IMAGE,
                        index: E.index,
                        imageTarget: D.image,
                        thumbTarget: v.image
                    })
                };
            if (this._options.carousel && this._options.carouselFollow) {
                this._carousel.follow(E.index)
            }
            if (this._options.preload) {
                var w, B, y = this.getNext(),
                    C;
                try {
                    for (B = this._options.preload; B > 0; B--) {
                        w = new i.Picture();
                        C = G.getData(y);
                        w.add(this.isFullscreen() && "big" in C ? C.big : C.image);
                        y = G.getNext(y)
                    }
                } catch (F) {}
            }
            c.show(D.container);
            e(G._thumbnails[E.index].container).addClass("active").siblings(".active").removeClass("active");
            G.trigger({
                type: i.LOADSTART,
                cached: z,
                index: E.index,
                imageTarget: D.image,
                thumbTarget: v.image
            });
            D.load(u, function (H) {
                G._scaleImage(H, {
                    complete: function (I) {
                        c.show(I.container);
                        if ("image" in A) {
                            c.toggleQuality(A.image, false)
                        }
                        c.toggleQuality(I.image, false);
                        G._queue.stalled = true;
                        G.removePan();
                        G.setInfo(E.index);
                        G.setCounter(E.index);
                        G.trigger({
                            type: i.LOADFINISH,
                            cached: z,
                            index: E.index,
                            imageTarget: I.image,
                            thumbTarget: G._thumbnails[E.index].image
                        });
                        var K = A.image === null && G._options.transitionInitial ? G._options.transitionInitial : G._options.transition;
                        if (K in j === false) {
                            x()
                        } else {
                            var J = {
                                prev: A.image,
                                next: I.image,
                                rewind: E.rewind,
                                speed: G._options.transitionSpeed || 400
                            };
                            j[K].call(G, J, x)
                        }
                    }
                })
            })
        },
        getNext: function (u) {
            u = typeof u === "number" ? u : this.getIndex();
            return u === this.getDataLength() - 1 ? 0 : u + 1
        },
        getPrev: function (u) {
            u = typeof u === "number" ? u : this.getIndex();
            return u === 0 ? this.getDataLength() - 1 : u - 1
        },
        next: function () {
            if (this.getDataLength() > 1) {
                this.show(this.getNext(), false)
            }
            return this
        },
        prev: function () {
            if (this.getDataLength() > 1) {
                this.show(this.getPrev(), true)
            }
            return this
        },
        get: function (u) {
            return u in this._dom ? this._dom[u] : null
        },
        getData: function (u) {
            return u in this._data ? this._data[u] : this._data[this._active]
        },
        getDataLength: function () {
            return this._data.length
        },
        getIndex: function () {
            return typeof this._active === "number" ? this._active : false
        },
        getStageHeight: function () {
            return this._stageHeight
        },
        getStageWidth: function () {
            return this._stageWidth
        },
        getOptions: function (u) {
            return typeof u === "undefined" ? this._options : this._options[u]
        },
        setOptions: function (u, v) {
            if (typeof u === "object") {
                e.extend(this._options, u)
            } else {
                this._options[u] = v
            }
            return this
        },
        play: function (u) {
            this._playing = true;
            this._playtime = u || this._playtime;
            this._playCheck();
            this.trigger(i.PLAY);
            return this
        },
        pause: function () {
            this._playing = false;
            this.trigger(i.PAUSE);
            return this
        },
        playToggle: function (u) {
            return (this._playing) ? this.pause() : this.play(u)
        },
        isPlaying: function () {
            return this._playing
        },
        isFullscreen: function () {
            return this._fullscreen.active
        },
        _playCheck: function () {
            var v = this,
                y = 0,
                u = 20,
                w = c.timestamp(),
                z = "play" + this._id;
            if (this._playing) {
                c.clearTimer(z);
                var x = function () {
                        y = c.timestamp() - w;
                        if (y >= v._playtime && v._playing) {
                            c.clearTimer(z);
                            v.next();
                            return
                        }
                        if (v._playing) {
                            v.trigger({
                                type: i.PROGRESS,
                                percent: Math.ceil(y / v._playtime * 100),
                                seconds: Math.floor(y / 1000),
                                milliseconds: y
                            });
                            c.addTimer(z, x, u)
                        }
                    };
                c.addTimer(z, x, u)
            }
        },
        setIndex: function (u) {
            this._active = u;
            return this
        },
        setCounter: function (v) {
            if (typeof v === "number") {
                v++
            } else {
                if (typeof v === "undefined") {
                    v = this.getIndex() + 1
                }
            }
            this.get("current").innerHTML = v;
            if (m) {
                var x = this.$("counter"),
                    u = x.css("opacity"),
                    w = x.attr("style");
                if (w && parseInt(u, 10) === 1) {
                    x.attr("style", w.replace(/filter[^\;]+\;/i, ""))
                } else {
                    this.$("counter").css("opacity", u)
                }
            }
            return this
        },
        setInfo: function (v) {
            var u = this,
                w = this.getData(v);
            e.each(["title", "description"], function (x, y) {
                var z = u.$("info-" + y);
                if ( !! w[y]) {
                    z[w[y].length ? "show" : "hide"]().html(w[y])
                } else {
                    z.empty().hide()
                }
            });
            return this
        },
        hasInfo: function (v) {
            var u = "title description".split(" "),
                w;
            for (w = 0; u[w]; w++) {
                if ( !! this.getData(v)[u[w]]) {
                    return true
                }
            }
            return false
        },
        jQuery: function (x) {
            var u = this,
                v = [];
            e.each(x.split(","), function (y, z) {
                z = e.trim(z);
                if (u.get(z)) {
                    v.push(z)
                }
            });
            var w = e(u.get(v.shift()));
            e.each(v, function (y, z) {
                w = w.add(u.get(z))
            });
            return w
        },
        $: function (u) {
            return this.jQuery.apply(this, c.array(arguments))
        }
    };
    e.each(q, function (u, w) {
        var v = /_/.test(w) ? w.replace(/_/g, "") : w;
        i[w.toUpperCase()] = "galleria." + v
    });
    e.extend(i, {
        IE9: m === 9,
        IE8: m === 8,
        IE7: m === 7,
        IE6: m === 6,
        IE: !! m,
        WEBKIT: /webkit/.test(p),
        SAFARI: /safari/.test(p),
        CHROME: /chrome/.test(p),
        QUIRK: (m && t.compatMode && t.compatMode === "BackCompat"),
        MAC: /mac/.test(navigator.platform.toLowerCase()),
        OPERA: !! l.opera,
        IPHONE: /iphone/.test(p),
        IPAD: /ipad/.test(p),
        ANDROID: /android/.test(p),
        TOUCH: !! (/iphone/.test(p) || /ipad/.test(p) || /android/.test(p))
    });
    i.addTheme = function (x, w) {
        if (!x.name) {
            i.raise("No theme name specified")
        }
        if (typeof x.defaults !== "object") {
            x.defaults = {}
        } else {
            x.defaults = r(x.defaults)
        }
        var u = false,
            v;
        if (typeof x.css === "string") {
            e("link").each(function (y, z) {
                v = new RegExp(x.css);
                if (v.test(z.href)) {
                    u = true;
                    i.theme = x;
                    return false
                }
            });
            if (!u) {
                e("script").each(function (z, y) {
                    v = new RegExp("galleria\\." + x.name.toLowerCase() + "\\.");
                    if (v.test(y.src)) {
                        u = y.src.replace(/[^\/]*$/, "") + x.css;
                        c.addTimer("css", function () {
                            c.loadCSS(u, "galleria-theme", function () {
                                i.theme = x
                            })
                        }, 1)
                    }
                })
            }
            if (!u) {
                if (w) {
                    i.raise("No theme CSS loaded")
                } else {
                    i.theme = x
                }
            }
        } else {
            i.theme = x
        }
        return x
    };
    i.loadTheme = function (x, v) {
        var u = false,
            w = o.length;
        i.theme = b;
        c.loadScript(x, function () {
            u = true
        });
        c.wait({
            until: function () {
                return u
            },
            error: function () {
                i.raise("Theme at " + x + " could not load, check theme path.", true)
            },
            success: function () {
                if (w) {
                    var y = [];
                    e.each(i.get(), function (A, z) {
                        var C = e.extend(z._original.options, {
                            data_source: z._data
                        }, v);
                        z.$("container").remove();
                        var B = new i();
                        B._id = z._id;
                        B.init(z._original.target, C);
                        y.push(B)
                    });
                    o = y
                }
            },
            timeout: 2000
        })
    };
    i.get = function (u) {
        if ( !! o[u]) {
            return o[u]
        } else {
            if (typeof u !== "number") {
                return o
            } else {
                i.raise("Gallery index " + u + " not found")
            }
        }
    };
    i.addTransition = function (u, v) {
        j[u] = v
    };
    i.utils = c;
    i.log = function () {
        try {
            l.console.log.apply(l.console, c.array(arguments))
        } catch (u) {
            try {
                l.opera.postError.apply(l.opera, arguments)
            } catch (v) {
                l.alert(c.array(arguments).split(", "))
            }
        }
    };
    i.raise = function (w, v) {
        if (d || v) {
            var u = v ? "Fatal error" : "Error";
            throw new Error(u + ": " + w)
        }
    };
    i.Picture = function (u) {
        this.id = u || null;
        this.image = null;
        this.container = c.create("galleria-image");
        e(this.container).css({
            overflow: "hidden",
            position: "relative"
        });
        this.original = {
            width: 0,
            height: 0
        };
        this.ready = false;
        this.loaded = false
    };
    i.Picture.prototype = {
        cache: {},
        add: function (z) {
            var w = 0,
                v = this,
                y = new Image(),
                u = function () {
                    e(y).load(x).attr("src", "")
                },
                x = function () {
                    newSrc = e(this).attr("src");
                    if ((!this.width || !this.height) && w < 1000) {
                        w++;
                        e(y).load(x).attr("src", newSrc + "?" + new Date().getTime())
                    }
                    v.original = {
                        height: this.height,
                        width: this.width
                    };
                    v.cache[z] = newSrc;
                    v.loaded = true
                };
            e(y).css("display", "block");
            if (v.cache[z]) {
                y.src = v.cache[z];
                x.call(y);
                return y
            }
            e(y).load(x).error(u).attr("src", z);
            return y
        },
        show: function () {
            c.show(this.image)
        },
        hide: function () {
            c.moveOut(this.image)
        },
        clear: function () {
            this.image = null
        },
        isCached: function (u) {
            return !!this.cache[u]
        },
        load: function (v, w) {
            var u = this;
            e(this.container).empty(true);
            this.image = this.add(v);
            c.hide(this.image);
            e(this.container).append(this.image);
            c.wait({
                until: function () {
                    return u.loaded && u.image.complete && u.original.width && u.image.width
                },
                success: function () {
                    l.setTimeout(function () {
                        w.call(u, u)
                    }, 50)
                },
                error: function () {
                    l.setTimeout(function () {
                        w.call(u, u)
                    }, 50);
                    i.raise("image not loaded in 30 seconds: " + v)
                },
                timeout: 30000
            });
            return this.container
        },
        scale: function (w) {
            w = e.extend({
                width: 0,
                height: 0,
                min: b,
                max: b,
                margin: 0,
                complete: function () {},
                position: "center",
                crop: false
            }, w);
            if (!this.image) {
                return this.container
            }
            var x, u, v = this,
                y = e(v.container);
            c.wait({
                until: function () {
                    x = w.width || y.width() || c.parseValue(y.css("width"));
                    u = w.height || y.height() || c.parseValue(y.css("height"));
                    return x && u
                },
                success: function () {
                    var D = (x - w.margin * 2) / v.original.width,
                        z = (u - w.margin * 2) / v.original.height,
                        F = {
                            "true": Math.max(D, z),
                            width: D,
                            height: z,
                            "false": Math.min(D, z)
                        },
                        B = F[w.crop.toString()];
                    if (w.max) {
                        B = Math.min(w.max, B)
                    }
                    if (w.min) {
                        B = Math.max(w.min, B)
                    }
                    e(v.container).width(x).height(u);
                    e.each(["width", "height"], function (I, H) {
                        e(v.image)[H](v.image[H] = v[H] = Math.round(v.original[H] * B))
                    });
                    var G = {},
                        A = {},
                        C = function (L, J, K) {
                            var I = 0;
                            if (/\%/.test(L)) {
                                var M = parseInt(L, 10) / 100,
                                    H = v.image[J] || e(v.image)[J]();
                                I = Math.ceil(H * -1 * M + K * M)
                            } else {
                                I = c.parseValue(L)
                            }
                            return I
                        },
                        E = {
                            top: {
                                top: 0
                            },
                            left: {
                                left: 0
                            },
                            right: {
                                left: "100%"
                            },
                            bottom: {
                                top: "100%"
                            }
                        };
                    e.each(w.position.toLowerCase().split(" "), function (H, I) {
                        if (I === "center") {
                            I = "50%"
                        }
                        G[H ? "top" : "left"] = I
                    });
                    e.each(G, function (H, I) {
                        if (E.hasOwnProperty(I)) {
                            e.extend(A, E[I])
                        }
                    });
                    G = G.top ? e.extend(G, A) : A;
                    G = e.extend({
                        top: "50%",
                        left: "50%"
                    }, G);
                    e(v.image).css({
                        position: "relative",
                        top: C(G.top, "height", u),
                        left: C(G.left, "width", x)
                    });
                    v.show();
                    v.ready = true;
                    w.complete.call(v, v)
                },
                error: function () {
                    i.raise("Could not scale image: " + v.image.src)
                },
                timeout: 1000
            });
            return this
        }
    };
    e.extend(e.easing, {
        galleria: function (v, w, u, y, x) {
            if ((w /= x / 2) < 1) {
                return y / 2 * w * w * w * w + u
            }
            return -y / 2 * ((w -= 2) * w * w * w - 2) + u
        },
        galleriaIn: function (v, w, u, y, x) {
            return y * (w /= x) * w * w * w + u
        },
        galleriaOut: function (v, w, u, y, x) {
            return -y * ((w = w / x - 1) * w * w * w - 1) + u
        }
    });
    e.fn.galleria = function (u) {
        return this.each(function () {
            var v = new i();
            v.init(this, u)
        })
    };
    l.Galleria = i
}(jQuery));
(function (a) {
    Galleria.addTheme({
        name: "classic",
        author: "Galleria",
        css: "galleria.classic.css",
        defaults: {
            transition: "slide",
            thumbCrop: "height",
            _toggleInfo: false
        },
        init: function (b) {
            this.addElement("info-link", "info-close");
            this.append({
                info: ["info-link", "info-close"]
            });
            var d = this.$("info-link,info-close,info-text"),
                e = Galleria.TOUCH,
                c = e ? "touchstart" : "click";
            this.$("loader,counter").show().css("opacity", 0.4);
            if (!e) {
                this.addIdleState(this.get("counter"), {
                    opacity: 0
                })
            }
            if (b._toggleInfo === true) {
                d.bind(c, function () {
                    d.toggle()
                })
            } else {
                d.show();
                this.$("info-link, info-close").hide()
            }
            this.bind("thumbnail", function (f) {
                if (!e) {
                    a(f.thumbTarget).css("opacity", 0.6).parent().hover(function () {
                        a(this).not(".active").children().stop().fadeTo(100, 1)
                    }, function () {
                        a(this).not(".active").children().stop().fadeTo(400, 0.6)
                    });
                    if (f.index === b.show) {
                        a(f.thumbTarget).css("opacity", 1)
                    }
                }
            });
            this.bind("loadstart", function (f) {
                if (!f.cached) {
                    this.$("loader").show().fadeTo(200, 0.4)
                }
                this.$("info").toggle(this.hasInfo());
                a(f.thumbTarget).css("opacity", 1).parent().siblings().children().css("opacity", 0.6)
            });
            this.bind("loadfinish", function (f) {
                this.$("loader").fadeOut(200)
            })
        }
    })
}(jQuery));
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
                        if (j.contains(i.getNorthEast()) && j.contains(i.getSouthWest())) {
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