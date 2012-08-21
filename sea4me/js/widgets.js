(function (a) {
    AvailabilityWidget = function (c, b) {
        if (c) {
            this.init(c, b)
        }
    };
    a.extend(AvailabilityWidget.prototype, {
        name: "availabilityWidget",
        init: function (c, b) {
            this.buttonContent = b;
            this.buttonStates = {
                active: {
                    status: "active",
                    next_status: "inactive"
                },
                inactive: {
                    status: "inactive",
                    next_status: "active"
                }
            };
            this.element = a(c);
            a.data(c, this.name, this);
            if (this.element.attr("data-has-availability") == "true") {
                this.setActive()
            } else {
                this.setInactive()
            }
            var e = function (f) {
                    f.data.hidePanel()
                };
            var d = this;
            this.element.hover(function () {
                jQuery(document).unbind("click", e)
            }, function () {
                jQuery(document).bind("click", d, e)
            })
        },
        togglePanel: function () {
            if (this.element.hasClass("expanded")) {
                this.hidePanel()
            } else {
                this.showPanel()
            }
        },
        hidePanel: function () {
            this.element.find(".toggle-info").hide();
            this.element.removeClass("expanded")
        },
        showPanel: function () {
            this.element.find(".toggle-info").show();
            this.element.addClass("expanded")
        },
        setActive: function () {
            var b = a.extend(true, {}, this.buttonContent.active, this.buttonStates.active, {
                url: this.element.attr("data-unavailable-url")
            });
            this.detachListeners();
            this.element.html(a("#availability_button_template").jqote(b, "*"));
            this.attachListeners()
        },
        setInactive: function () {
            var b = a.extend(true, {}, this.buttonContent.inactive, this.buttonStates.inactive, {
                url: this.element.attr("data-available-url")
            });
            this.detachListeners();
            this.element.html(a("#availability_button_template").jqote(b, "*"));
            this.attachListeners()
        },
        attachListeners: function () {
            var b = this;
            this.element.find("span.icon").bind("click", function () {
                b.togglePanel()
            });
            this.element.find(".toggle-action").bind("click", function () {
                b.hidePanel();
                b.element.find("span.icon").addClass("widget-spinner").children("span.label").html("Saving");
                a("#availability-error-message").html("");
                a.ajax({
                    url: a(this).attr("href"),
                    dataType: "json",
                    type: "POST",
                    success: function (c) {
                        b.element.find("span.icon").removeClass("widget-spinner");
                        if (c.result == "available") {
                            b.setActive()
                        } else {
                            if (c.result == "unavailable") {
                                b.setInactive()
                            } else {
                                if (c.result == "error") {
                                    b.setInactive();
                                    var d = a("#availability-error-message");
                                    d.html(c.message);
                                    d.slideDown(1000)
                                }
                            }
                        }
                    }
                });
                return false
            })
        },
        detachListeners: function () {
            this.element.find("span.icon").unbind("click");
            this.element.find(".toggle-action").unbind("click")
        }
    });
    a.fn.availabilityWidget = function (c) {
        var b = a.makeArray(arguments),
            d = b.slice(1);
        return this.each(function () {
            var e = a.data(this, "availabilityWidget");
            if (e) {
                if (typeof c === "string") {
                    e[c].apply(e, d)
                } else {
                    if (e.update) {
                        e.update.apply(e, b)
                    }
                }
            } else {
                new AvailabilityWidget(this, c)
            }
        })
    }
})(jQuery);
var CogzidelRoomEdit = {
    init: function (e) {
        var d = e.exactCoords;
        var h = e.fuzzyCoords;
        var g = new google.maps.InfoWindow({
            content: e.supportContent,
            maxWidth: 150,
            zIndex: 0
        });
        jQuery(".address-support-link").click(function () {
            if (window._gaq) {
                _gaq.push(["_trackEvent", "EditListing", "AddressContactSupport", "", parseInt(jQuery(this).attr("data-res-count"), 10)])
            }
        });
        var a = jQuery("#private-map");
        a.cogzidelMap({
            position: d,
            onMarkerClick: function (i) {
                g.open(i.map, i.marker)
            }
        });
        var c = jQuery("#private-map").cogzidelMap().map;
        google.maps.event.addListener(c, "click", function () {
            g.close()
        });
        var b = jQuery("#public-map");
        b.cogzidelMap({
            position: h,
            isFuzzy: true,
            accuracy: e.accuracy
        });
        var f = new google.maps.StreetViewPanorama(document.getElementById("street-view-colorbox"), {
            position: h,
            visible: false,
            scrollwheel: false,
            enableCloseButton: false,
            pov: {
                heading: 265,
                zoom: 1,
                pitch: 0
            }
        });
        jQuery("#address_street_view").change(function () {
            if (jQuery(this).val() === "0") {
                jQuery("#street-view-link").hide()
            } else {
                jQuery("#street-view-link").show()
            }
        });
        jQuery("#street-view-link").colorbox({
            href: "#street-view-colorbox",
            inline: true,
            onComplete: function () {
                if (jQuery("#address_street_view").val() === "1") {
                    f.setPosition(h);
                    f.setVisible(true)
                } else {
                    if (jQuery("#address_street_view").val() === "2") {
                        f.setPosition(d);
                        f.setVisible(true)
                    }
                }
            },
            onCleanup: function () {
                f.setVisible(false)
            }
        });
        jQuery("#edit-address").click(function (o) {
            var x, u, k, w;
            var s, m;
            var q = ["street_address", "premise", "sub_premise"];
            var j = jQuery(".map-description.public .address").toggle();
            var r = jQuery(this).hide();
            var n = r.closest(".map-description").find(".address");
            var t = jQuery("#edit_address_message");
            var v = [];
            var l = jQuery('<input type="hidden" name="address[formatted_address_native]" />').appendTo("#hosting_edit_form");

            function p() {
                var y = j.filter(".full");
                n.html(l.val());
                y.html(y.attr("data-message-refresh"));
                i()
            }
            function i() {
                r.show();
                jQuery("#cancel-edit-address").hide();
                s.remove();
                n.show();
                j.toggle();
                t.hide();
                l.remove();
                t = s = l = v = u = k = null;
                CogzidelDashboard.removeListener("info", p)
            }
            s = jQuery('<input type="text" value="' + n.html() + '" />');
            n.hide();
            n.after(s);
            x = new google.maps.places.Autocomplete(s[0], {
                types: ["geocode"]
            });
            x.bindTo("bounds", a.cogzidelMap().map);
            u = a.cogzidelMap().marker.getPosition();
            k = b.cogzidelMap().marker.getCenter();
            jQuery("#cancel-edit-address").show().one("click", function (y) {
                a.cogzidelMap().setMarkerPosition(u);
                b.cogzidelMap().setMarkerPosition(k);
                i();
                y.preventDefault()
            });
            google.maps.event.addListener(x, "place_changed", function () {
                var z, B;
                var y = x.getPlace();
                var A = y.types && y.types[0];
                if (y && y.geometry.location) {
                    B = y.geometry.location;
                    a.cogzidelMap().setMarkerPosition(B);
                    b.cogzidelMap().setMarkerPosition(B)
                }
                l.data("pac", true).val(y.formatted_address);
                for (z = 0; z < q.length; z++) {
                    if (A === q[z]) {
                        s.removeClass("error");
                        v = [];
                        t.removeClass("bad").addClass("good").html(t.attr("data-message-good")).fadeIn("slow");
                        return
                    }
                }
                s.addClass("error");
                v.push(s.val());
                if (v.length > 3) {
                    t.removeClass("good").addClass("bad").html(t.attr("data-message-contact")).fadeIn("slow")
                } else {
                    t.removeClass("good").addClass("bad").html(t.attr("data-message-accuracy")).fadeIn("slow")
                }
            });
            s.keypress(function (y) {
                if (y.keyCode === 13) {
                    y.preventDefault()
                }
            });
            s.blur(function () {
                if (!l.data("pac") && (w !== s.val())) {
                    l.val(s.val());
                    if (s.val() !== n.html()) {
                        jQuery(this).addClass("error");
                        v.push(s.val());
                        if (v.length > 3) {
                            t.removeClass("good").addClass("bad").html(t.attr("data-message-contact")).fadeIn("slow")
                        } else {
                            t.removeClass("good").addClass("bad").html(t.attr("data-message-find")).fadeIn("slow")
                        }
                    }
                }
            });
            s.focus(function () {
                w = s.val();
                l.data("pac", null)
            });
            if (CogzidelDashboard) {
                CogzidelDashboard.addListener("info", p)
            }
            s.focus();
            o.preventDefault()
        })
    }
};