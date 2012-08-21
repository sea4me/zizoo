var map, geocoder, marker, cm_marker, center;

var AutocompleteCache = {
    currentSuggestions: null
};

/* Mimic google.maps.LatLng
 */
function GeocoderLatLng(lat, lng) {
	this.latVal = lat;
	this.lngVal = lng;
}

GeocoderLatLng.prototype.lat = function() {
	return this.latVal;
};

GeocoderLatLng.prototype.lng = function() {
	return this.lngVal;
};

var PostRoom = {
    errors: [],
	fieldsToClearOnSubmit: [],
    localized_hiw_video_code: 'SaOFuW011G8',
    totalSteps: 2,
    hostingLat: 0.0,
    hostingLng: 0.0,
	useAlternateMap: false,

    //this is where center of map will start, can be overridden on page load
    defaultLat: 20.00,
    defaultLng: -32.00,
    mapZoomLevel: 10, //todo - tighten this up if location is specified
    mapInitialized: false,
    recentResult: null,
    lastCurrency: '',
    ADDRESS_TYPES: {
        // When we get these, allow the user to place their own point on the map
        pinpointable: ['route', //route ~== a street with no number
                    'locality',
                    'sublocality',
                    'postal_code',
                    'administrative_area_level_2',
                    'administrative_area_level_3',
                    'neighborhood'],
        // Addresses allowed based on bounding box size
        boundable: ['natural_feature']
    },

    init: function(opts) {
		var $directionsField = $("#hosting_directions");
		var $userDefinedLoc = $("#address_user_defined_location");
		$(".post_room_step2, #post_room_submit_button").hide();

        Cogzidel.Utils.initHowItWorksLightbox('#how_it_works_vid_screenshot', PostRoom.localized_hiw_video_code);

        jQuery('#post_room_submit_button').click(function(){
            jQuery('#new_room_form').submit();
        });

		jQuery('#new_room_form').submit(function() {
		    return PostRoom.validateSubmit();
		});
        
        jQuery('input.validation_error, textarea.validation_error').live( Cogzidel.Utils.keyPressEventName, function(e) {
            jQuery(e.currentTarget).removeClass('validation_error');
        });

        Cogzidel.Utils.setInnerText(PostRoom.fieldsToClearOnSubmit);

        //sometimes active gets added due to page rendering
        if(jQuery('#email_address_field').val() == jQuery('#email_address_field').attr('defaultValue')){
            jQuery('#email_address_field').removeClass('active');
        }

        PostRoom.initMap();
        PostRoom.lastCurrency = jQuery('#hosting_native_currency').val();
        PostRoom.interceptEnterOnLocationBar();

        //only allow 35 characters
        jQuery('#hosting_name').bind( Cogzidel.Utils.keyPressEventName, function(e) {
            Cogzidel.Utils.textCounter(jQuery("#hosting_name"),jQuery("#letter_count"),35);
        });

        jQuery('#hosting_room_type').bind('change', function(e) {
           PostRoom.getPricingRecommendation(); 
        });
        
        jQuery('#hosting_native_currency').bind('change', function(e) {
            var new_currency= jQuery("#hosting_native_currency").val();
            var price_field = jQuery("#hosting_price_native");
            
            if(!isNaN(parseInt(price_field.val(), 10))) {
                price_field.val(Cogzidel.Currency.convert(price_field.val(), PostRoom.lastCurrency, new_currency, true));
            }

            jQuery("#price_suggestion_low_text").html(Cogzidel.Currency.convert(jQuery("#price_suggestion_low_text").html(), PostRoom.lastCurrency, new_currency, true));
            jQuery("#price_suggestion_high_text").html(Cogzidel.Currency.convert(jQuery("#price_suggestion_high_text").html(), PostRoom.lastCurrency, new_currency, true));
            jQuery(".currency_symbol").html(Cogzidel.Currency.getSymbolForCurrency(new_currency));

            PostRoom.lastCurrency = new_currency; 
        });

        jQuery('#change_location_link').live('click', function(){
            jQuery(this).hide();
            PostRoom.resetLocation();
            setTimeout(function(){
				$('#location_search').val('').show().focus().addClass('active');
				$('#location_search_label').show();
			}, 1);
            return false;
        });

        PostRoom.enableAutocomplete();
        geocoder = new google.maps.Geocoder(PostRoom.hostingLat, PostRoom.hostingLng);

        if (opts.location_search) {
            jQuery('#location_search').val(opts.location_search);
            jQuery('#location_search').addClass('active');
            PostRoom.selectFirst();
        }

		$("#exact_address_1").change(function() {
			if ($(this).is(":checked")) {
				$directionsField.parent().hide();
				$directionsField.attr("disabled", "disabled");
				$userDefinedLoc.attr("disabled", "disabled");
			}
		});

		$("#exact_address_2").change(function() {
			if ($(this).is(":checked")) {
				$directionsField.parent().show();
				$directionsField.removeAttr("disabled");
				$userDefinedLoc.removeAttr("disabled");
			}
		});

		function checkFlatMonthly() {
			var startDate = new Date($("#sublet_checkin").val());
			var endDate = new Date($("#sublet_checkout").val());

			if ((endDate - startDate) > PostRoom.SUBLET_CROSSOVER_MS) {
				$("#per-month-span").show();
				$("#flat-rate-span").hide();
			} else {
				$("#per-month-span").hide();
				$("#flat-rate-span").show();
			}
		}

		$("#new_room_form").cogzidelInputDateSpan({
			checkin: "#sublet_checkin",
			checkout: "#sublet_checkout",
			onCheckinClose: checkFlatMonthly,
			onCheckoutClose: checkFlatMonthly
		});

		$("#is_sublet").change(function() {
			if ($(this).is(":checked")) {
				$("#per-night-span, #price_suggestion").hide();
				$("#sublet-rates, #sublet_dates").show();
			} else {
				$("#per-night-span, #price_suggestion").show();
				$("#sublet-rates, #sublet_dates").hide();
			}
		}).change();
	},

	initSublets: function(location) {
		if (location && location.address_components) {
			var components = location.address_components;
			var c, i, len;
			for (i = 0, len = components.length; i < len; i++) {
				c = components[i];
				if (c.types[0] === "locality" && ($.inArray(c.long_name, PostRoom.SUBLET_MARKETS) >= 0)) {
					$(".sublets").show();
					return;
				}
			}
		}
		$(".sublets").hide();
	},

	resetLocation: function(currentResult) {
		try {
			if (typeof currentResult !== 'undefined') {
				var newCenter = new google.maps.LatLng(currentResult.geometry.location.lat(), currentResult.geometry.location.lng());
				map.setCenter(newCenter);

				if (PostRoom.matchesResultType(currentResult.types, PostRoom.ADDRESS_TYPES.boundable)) {
					map.fitBounds(currentResult.geometry.bounds);
				} else if (PostRoom.matchesResultType(currentResult.types, PostRoom.ADDRESS_TYPES.pinpointable) === true){
					map.setZoom(12);
				} else {
					map.setZoom(4);
				}
			}
		} catch (error) {
			map.setZoom(1);
		}

		PostRoom.recentResult = null;
		PostRoom.clearMarker();
		PostRoom.hideErrors();
		$('#address_lat, #address_lng, #address_formatted_address_native, #hosting_directions').val('');
		$("#address_apt").val('').blur();
		$('#formatted_address').html('...');
		$("#exact_address_1").attr("checked", "checked").change();
		$(".post_room_step2, #post_room_submit_button").hide();
		$("#is_sublet").removeAttr("checked").change();

		Drag.reset();
		$('.vague_address_warning, #exact_address_prompt, #contact_info_section, #step1_extras').hide();
		setTimeout(function(){jQuery('#location_search').val('').focus().addClass('active');}, 1);
    },

    initMap : function(){
        if(PostRoom.mapInitialized === false){
            // Init the map
            jQuery('#map_container').show();
            center = new google.maps.LatLng(PostRoom.defaultLat, PostRoom.defaultLng);
            map = new google.maps.Map(document.getElementById("map_canvas"), {
                zoom: 1,
                scrollwheel: false,
                center: center,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false
            });

            PostRoom.mapInitialized = true;
        }
    },

    placeMarker : function(location) {
        if (marker != null){
            marker.setMap(null);
        }

		marker = new google.maps.Marker({
			position: location,
			map: map,
			icon: new google.maps.MarkerImage(
				"http://www.cogzidel.com/images/guidebook/pin_home.png",
				null,
				null,
				new google.maps.Point(14, 32))
		});
    },

    clearMarker: function() {
        if (marker != null) {
            marker.setMap(null);
        }
    },

    matchesResultType: function(types, source_types) {
        var matches = jQuery.grep(types, function(type) { 
            return (jQuery.inArray(type, source_types) >= 0);
        });

        return (matches.length > 0);
    },

    allowPinpoint: function(result) {
		var MAX_SPAN_AREA = 0.05;

		if (PostRoom.matchesResultType(result.types, PostRoom.ADDRESS_TYPES.boundable) &&
				result.geometry.bounds &&
				result.address_components.length > 1) {
			span = result.geometry.bounds.toSpan();

			// Max span area (GMap terminology) of 0.05 to prevent large
			// features like lakes and oceans from being valid
			return (span.lat() * span.lng()) <= MAX_SPAN_AREA;
		} else {
			return PostRoom.matchesResultType(result.types, PostRoom.ADDRESS_TYPES.pinpointable);
		}
    },

    hideAddressEntryBar: function() {
        $('#location_search, #location_search_label').hide();
    },

    displayLocationResult : function(result) {
		var geometry, layer, marker, pos;

        PostRoom.resetLocation(result);
        jQuery('#change_location_link').show();

        if(!PostRoom.matchesResultType(result.types, ['street_address'])) {
			if (PostRoom.altMapContainer) { PostRoom.altMapContainer.hide(); }
			$("#map_canvas").children().first().show();
            setTimeout(function(){ jQuery('#location_search').blur(); }, 10);
            if (PostRoom.allowPinpoint(result) && !PostRoom.useAlternateMap) {
                PostRoom.hideAddressEntryBar();
                Drag.initialize();
            } else {
                jQuery('#change_location_link').hide();
                jQuery('#way_too_vague').fadeIn();
            }
        } else {
			PostRoom.hideAddressEntryBar();
			PostRoom.recentResult = result;
			PostRoom.initMap();
			geometry = result.geometry;

            setTimeout(function() {
                jQuery('#address_apt').show().val('').blur();
            }, 1);

            var formatted_address_with_line_breaks = '';
            try {
                formatted_address_with_line_breaks = result.formatted_address.split(',').join('<br />');
            } catch (error) {
                //log('error with address');
            }

			PostRoom.initSublets(result);
			$('#step1_extras').show();
			$('#formatted_address').html(formatted_address_with_line_breaks);
			$('#selected_address, #step1_extras, #contact_info_section').show();
			$('#address_lat').val(geometry.location.lat());
			$('#address_lng').val(geometry.location.lng());
			$('#address_formatted_address_native').val(result.formatted_address);
			$('#location_search').removeClass('validation_error');
			$(".post_room_step2, #post_room_submit_button").show();
	        PostRoom.updatePhoneCountry(result);

			if (PostRoom.useAlternateMap) {
				$("#map_canvas").children().first().hide();

				if (!PostRoom.altMap) {
					PostRoom.altMap = new Map(308, 308);
					PostRoom.altMapContainer = $(document.createElement("div"));
					$("#map_canvas").append(PostRoom.altMapContainer);
					PostRoom.altMap.writeMapToContainer(PostRoom.altMapContainer[0]);
				}

 				PostRoom.altMapContainer.show();
				layer = PostRoom.altMap.getLayersManager().createLocalVectorLayer("");
				layer.enableAutoRedraw();
				pos = new LatLong(geometry.location.lat(), geometry.location.lng());
				var polyLineStylePen = new LineStyle(4,'fdb2f2',80);
				var polyLineStyleFill = new LineStyle(0,'ffd7fc',40);
				var circle = new Circle('circleId', pos, 100, polyLineStylePen, polyLineStyleFill, '', 'Your listing', true, false);
				layer.addShape(circle);
				layer.redraw();
				PostRoom.altMap.setCenterPosition(pos, -3);
			} else {
				if (PostRoom.altMapContainer) {PostRoom.altMapContainer.hide();}
				$("#map_canvas").children().first().show();
				PostRoom.placeMarker(geometry.location);
				map.fitBounds(geometry.viewport);
			}
        }
    },

    selectMenuItem: function(menuItem) {
        var aLink = jQuery(menuItem).children();
        var label = jQuery(aLink[0]).html();

        jQuery.each(AutocompleteCache.currentSuggestions, function(index, el){
            //iterates through the array returned from Google's autocomplete
            if(el.label == label){
                var ui = el;

                //this hacks the autocompleteselect trigger
                jQuery('#location_search').trigger('autocompleteselect', {item:ui});
                //close the dropdown
                jQuery('#location_search').autocomplete('close');
                AutocompleteCache.currentSuggestions = null;
                return true;
            }
        });
    },

    selectFirst: function() {
        //first get current suggestions
        log(AutocompleteCache.currentSuggestions);
        jQuery('#location_search').autocomplete('search');

        setTimeout(function(){
            var menuItem = jQuery('.ui-autocomplete li.ui-menu-item').first();
            PostRoom.selectMenuItem(menuItem);
        }, 1000); //need to wait for autocomplete to work
    },

    // Autocomplete for location search
    enableAutocomplete : function() {
		var $addressList = $("#didyoumean-addresses");
		var closedBySelect = false;
		var $didyoumean = $("#didyoumean");
		var $locationSearch = jQuery('#location_search');
		var locationSearchHasFocus = false;

        jQuery('.ui-autocomplete li.ui-menu-item').live('click', function(){
            PostRoom.selectMenuItem(this);
        });

		$locationSearch.focus(function() {
			locationSearchHasFocus = true;
		});

		$locationSearch.blur(function() {
			locationSearchHasFocus = false;
		});

		$locationSearch.autocomplete({
			minLength: 4,
			delay: 300,
			selectFirst: false,
			source: function(request, response) {
				var reqObj = {address: request.term};
				geocoder.geocode(reqObj, function(results, status) {
					var first, suggestions;

					if (status === google.maps.GeocoderStatus.OK) {
						first = results.length > 0 && results[0];
						if (first && PostRoom.matchesResultType(first.types, ["country", "locality"]) &&
								first.address_components[0].long_name === "Israel" ||
								(first.address_components.length > 1 && first.address_components[1].long_name === "Israel")) {
							$.get("/geocoder/atlas_ct", reqObj, function(atlasResults, atlasStatus) {
								if (atlasResults.status === google.maps.GeocoderStatus.OK) {
									suggestions = jQuery.map(atlasResults.results, function(res) {
										var loc = res.geometry.location;
										res.geometry.location = new GeocoderLatLng(
											loc.lat, loc.lng
										);
										return {'label': res.formatted_address, 'value': res};
									});

									AutocompleteCache.currentSuggestions = jQuery.map(atlasResults.results, function(res) {
										return {'label': res.formatted_address, 'value': res};
									});

									PostRoom.useAlternateMap = true;
									response(suggestions);

									if (!locationSearchHasFocus) {
										$locationSearch.trigger("autocompleteclose");
									}
								}
							});
						} else {
							suggestions = jQuery.map(results, function(res) {
								return {'label': res.formatted_address, 'value': res};
							});

							AutocompleteCache.currentSuggestions = jQuery.map(results, function(res) {
								return {'label': res.formatted_address, 'value': res};
							});
							PostRoom.useAlternateMap = false;
							response(suggestions);

							if (!locationSearchHasFocus) {
								$locationSearch.trigger("autocompleteclose");
							}
						}
					}
				});
			},
			focus: function(event, ui) {
				// Don't do anything on focus
				return false;
			}
		});

		$locationSearch.bind("autocompleteclose", function(event, ui) {
			var address, cache, i, li;
			function fakeSelect(item) {
				$locationSearch.trigger("autocompleteselect",
					{item: item, fakeSelect: true});
				AutocompleteCache.currentSuggestions = null;
			}

			// Only autoselect first item if this close event was not caused
			// by an item being selected in the menu
			if (!closedBySelect && $locationSearch.val()) {
				cache = AutocompleteCache.currentSuggestions;

				if (cache && cache.length > 1) {
					$('.vague_address_warning, #exact_address_prompt, #contact_info_section, #step1_extras').hide();
					$didyoumean.show();
					$addressList.empty();

					for (i = 0; i < cache.length; i++) {
						address = cache[i];
						li = $('<li><a href="#">' + address.label + '</a></li>').
							data("item", address);
						$addressList.append(li);
					}

					$addressList.delegate("a", "click", function() {
						fakeSelect($(this).parent().data("item"));
						$didyoumean.hide();
						$addressList.undelegate("click");
						return false;
					});
				} else if (cache) {
					fakeSelect(cache[0]);
				}
			}
			closedBySelect = false;
		});

		$locationSearch.bind("autocompleteselect", function(event, ui) {
			if (!ui.fakeSelect) {
				closedBySelect = true;
			}

			$didyoumean.hide();
			$addressList.undelegate("click");
			$locationSearch.val(ui.item.label);
			jQuery('#address_step2').show();
			PostRoom.displayLocationResult(ui.item.value);
			if (!PostRoom.useAlternateMap) {
				PostRoom.getPricingRecommendation();
			}
			return false;
		});
    },

    interceptEnterOnLocationBar : function(){
        jQuery('#location_search').bind( Cogzidel.Utils.keyPressEventName, function(e) {
            var code = e.keyCode || e.which;

            if ( code == jQuery.ui.keyCode.ENTER ){
                return false;
            }
        });
    },

    hasErrors: function() {
        return (PostRoom.errors.length > 0);
    },

    addError: function(errorTitle, errorText, elementIdToHighlight) {
        PostRoom.errors.push([errorTitle, errorText, elementIdToHighlight]);
        return true;
    },

    //warning - this function will empty errors 
	showErrors: function() {
		PostRoom.hideErrors();
		var error;
		var errorContainer = jQuery('#error_summary');
		var errorUl = errorContainer.children("ul");

		if (PostRoom.hasErrors()) {
			while(PostRoom.errors.length > 0){
				error = PostRoom.errors.shift();
				errorUl.append(['<li class="bad"><b>', error[0],'</b><br/>', error[1], '</li>'].join(''));
				$('#' + error[2]).addClass('validation_error');
			}

			errorContainer.show();
			return true;
		} else {
			return false;
		}
	},

	hideErrors: function() {
		$('#error_summary ul').empty().parent().hide();
	},

    getPricingRecommendation : function() {
        var formatted_address = jQuery("#address_formatted_address_native").val();
        
        if(!formatted_address) {
            return false;
        }
        
        var room_type = jQuery("#hosting_room_type").val();
        var en_room_type;
        
        if(room_type === Translations.private_room_phrase) {
            en_room_type = "Private room";
        }
        else if(room_type === Translations.shared_room_phrase) {
            en_room_type = 'Shared room';
        }
        else if(room_type === Translations.entire_home_phrase) {
            en_room_type = 'Entire home/apt';
        }

        if(formatted_address && formatted_address !== '' && en_room_type) {
            jQuery.ajax({
                url : Urls.ajax_worth,
                data : { 'location' : formatted_address, 'room_type' : en_room_type },
                dataType : 'json',
                success : function(data) {
                    var new_currency = jQuery("#hosting_native_currency").val();
                    
                    // slightly lower pricing suggestion for new listings
                    var average = data.avg * 0.8; 
                    var price_suggestion_low = Cogzidel.Currency.convert(Math.max(Math.round(average - data.stddev / 4), 10), 'USD', new_currency, true);
                    var price_suggestion_high = Cogzidel.Currency.convert(Math.max(Math.round(average + data.stddev / 4), 10), 'USD', new_currency, true);
                    
                    jQuery("#price_suggestion_low").val(price_suggestion_low);
                    jQuery("#price_suggestion_high").val(price_suggestion_high);
                    jQuery("#price_suggestion_low_text").html(price_suggestion_low);
                    jQuery("#price_suggestion_high_text").html(price_suggestion_high);
                    jQuery(".currency_symbol").html(Cogzidel.Currency.getSymbolForCurrency(new_currency));
                    jQuery('#price_suggestion').show();
                    jQuery('#price').hide();
                }
            });
        }
    },


	validateSubmit: function() {
		var subletStartDate, subletEndDate,
			hasValidDates, isValidDate, priceNative;

		$('.validation_error').removeClass('validation_error');
		if (PostRoom.recentResult === null) { 
			PostRoom.addError(Translations.address, Translations.address_error, 'location_search');
		}

		var email = jQuery('#hosting_email');
		var phone = jQuery('#hosting_phone');

		if (email.is(':visible') && !Cogzidel.StringValidator.validate('email', email.val())) {
			PostRoom.addError(Translations.email_address, Translations.email_address_error, 'hosting_email');
		}

		if ($('#hosting_name').val() === '') { 
			PostRoom.addError(Translations.title, Translations.room_name_error, 'hosting_name');
		}

		if ($('#hosting_description').val() === '') { 
			PostRoom.addError(Translations.description, Translations.description_error, 'hosting_description');
		}

		priceNative = $("#hosting_price_native").val();
		if (priceNative === '') { 
			PostRoom.addError(Translations.price, Translations.price_error, 'hosting_price_native');
		} else if (parseInt(priceNative, 10) < 10) {
			PostRoom.addError(Translations.price, Translations.priceTooSmall_error, "hosting_price_native");
		}

		if ($("#sublet_dates").is(":visible")) {
			hasValidDates = true;
			subletStartDate = new Date($("#sublet_checkin").val());
			subletEndDate = new Date($("#sublet_checkout").val());
			isValidDate = function isValidDate(d) {
				if (Object.prototype.toString.call(d) !== "[object Date]") {
					return false;
				}
				return !isNaN(d.getTime());
			};

			if (!isValidDate(subletStartDate)) {
				PostRoom.addError("Sublet start date", Translations.sublet_real_start, "sublet_checkin");
				hasValidDates = false;
			}

			if (!isValidDate(subletEndDate)) {
				PostRoom.addError("Sublet end date", Translations.sublet_real_end, "sublet_checkout");
				hasValidDates = false;
			}

			if (hasValidDates) {
				if (subletStartDate >= subletEndDate) {
					PostRoom.addError("Sublet end date", Translations.sublet_start_before, "sublet_checkout");
				} else if ((subletEndDate.getTime() - subletStartDate.getTime()) < (PostRoom.MINIMUM_SUBLET_STAY_MS)) {
					PostRoom.addError("Sublet end date", Translations.sublet_min_nights, "sublet_checkout");
				}
			}
		}

		if (PostRoom.hasErrors()) {
			PostRoom.showErrors();
			return false;
		} else {
			$('#hosting_submit').attr('disabled', 'disabled').css('cursor','progress');
			PostRoom.hideErrors();
			Cogzidel.Utils.clearInnerText(PostRoom.fieldsToClearOnSubmit);
			return true;
		}
	},
	
	updatePhoneCountry: function(result) {
		if (result && result.address_components) {
			var matches = jQuery.grep(result.address_components, function(component) { 
	            return (jQuery.inArray("country", component.types) >= 0);
	        });
			if (matches && matches[0])
				$('#hosting_phone_country').val(matches[0].short_name);
		}
	}
};


/*
 * * jQuery UI Autocomplete Select First Extension
 * *
 * * Copyright 2010, Scott GonzÃ¡lez (http://scottgonzalez.com)
 * * Dual licensed under the MIT or GPL Version 2 licenses.
 * *
 * * http://github.com/scottgonzalez/jquery-ui-extensions
 * */
(function($) {
    $( ".ui-autocomplete-input" ).live( "autocompleteopen", function() {
        var autocomplete = $( this ).data( "autocomplete" ),
        menu = autocomplete.menu;
        if ( !autocomplete.options.selectFirst ) {
            return;
        }
        menu.activate( $.Event({ type: "mouseenter" }), menu.element.children().first() );
    });
} (jQuery));

var Drag = {
	geocoder: null,
	marker: null,
	latLng: null,
	initialDrag: true,

    geocodePosition : function(pos) {
      geocoder.geocode({
        latLng: pos
      }, function(responses) {
        if (responses && responses.length > 0) {
          PostRoom.recentResult = responses[0];
          Drag.updateMarkerAddress(responses[0]);
        } else {
          PostRoom.recentResult = null;
          Drag.updateMarkerAddress();
        }
      });
    },

    updateMarkerPosition : function(latLng) {
        jQuery('#address_lat').val(latLng.lat());
        jQuery('#address_lng').val(latLng.lng());
    },

    updateMarkerAddress: function(result, fade) {
		var str = (typeof result === 'undefined') ? 'Cannot determine address at this location.' : result.formatted_address;
        var applyFade = ((typeof fade === 'undefined') ? false : fade);
        jQuery('#address_formatted_address_native').val(str);

        if (applyFade === true) {
            Drag.fadeOutMarkerAddress();
        } else {
            Drag.fadeInMarkerAddress();
            formatted_address_with_line_breaks = str.split(',').join('<br />');
            jQuery('#formatted_address').html(formatted_address_with_line_breaks);
        }

		if (Drag.initialDrag) {
			Drag.initialDrag = false;
		} else {
			PostRoom.initSublets(PostRoom.recentResult);
			jQuery('#exact_address_prompt').show();
			jQuery('#step1_extras').show();
			jQuery('#contact_info_section').show();
			$(".post_room_step2, #post_room_submit_button").show();
	        PostRoom.updatePhoneCountry(result);
		}
    },

	fadeOutMarkerAddress: function() {
		jQuery('#formatted_address').fadeTo(0, 0.5);
	},

	fadeInMarkerAddress: function() {
		jQuery('#formatted_address').fadeTo(0, 1.0);
	},

	initialize: function() {
		Drag.initialDrag = true;
		$('#step1_extras').hide();
		Drag.geocoder = new google.maps.Geocoder();
		Drag.latLng = map.getCenter();
		Drag.infoWindow = new google.maps.InfoWindow({
			content: Translations.not_so_vague
		});

		Drag.marker = new google.maps.Marker({
			position: Drag.latLng,
			title: Translations.your_listing,
			map: map,
			icon: new google.maps.MarkerImage(
				"http://www.cogzidel.com/images/guidebook/pin_home.png",
				new google.maps.Size(48, 36),
				null,
				new google.maps.Point(14, 32)),
			draggable: true
		});

		// Update current position info.
		Drag.updateMarkerPosition(Drag.latLng);
		Drag.geocodePosition(Drag.latLng);
		map.setZoom(15);
		Drag.infoWindow.open(map, Drag.marker);

		// Add dragging event listeners.
		google.maps.event.addListener(Drag.marker, 'dragstart', function() {
			Drag.fadeOutMarkerAddress();
			Drag.infoWindow.close();
			Drag.infoWindow.setContent("<em>" + Translations.not_so_vague_2 + "</em>");
		});

		google.maps.event.addListener(Drag.marker, 'dragend', function() {
			Drag.infoWindow.open(map, Drag.marker);
			Drag.updateMarkerPosition(Drag.marker.getPosition());
			Drag.geocodePosition(Drag.marker.getPosition());
		});
	},

	reset: function() {
		if (Drag.infoWindow) {
			Drag.infoWindow.close();
			Drag.infoWindow = null;
		}

		if (Drag.marker != null) {
			google.maps.event.clearInstanceListeners(Drag.marker);
			Drag.marker.setMap(null);
			Drag.marker = null;
		}
	}
};