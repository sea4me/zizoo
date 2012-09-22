(function(jQuery) {

    jQuery.fn.validatePhone = (function(defaultCountry) {		
		
        phone = jQuery(this);
        country = jQuery('#'+phone.attr('id')+'_country');
        countrySelector = jQuery('#'+phone.attr('id')+'_country_selector');
        feedback = jQuery('#'+phone.attr('id')+'_feedback');
        popup = jQuery('#'+phone.attr('id')+'_popup');
		
        if (!phone.is(":visible"))
            return;
	
        if (!defaultCountry && country.val())
            defaultCountry = country.val();
        else if (!defaultCountry)
            defaultCountry = 'US'

        try {
		
            if (phone.attr('value') == '') {
                // TODO: Clear feedback
                country.attr('value', '');
                popup.css('display', 'none');
                return true;	
            }
	
            var phoneUtil = i18n.phonenumbers.PhoneNumberUtil.getInstance();
            var number = phoneUtil.parseAndKeepRawInput(phone.attr('value'), defaultCountry);
            var countryCode = phoneUtil.getRegionCodeForNumber(number);
            var formattedNumber = phoneUtil.format(number, i18n.phonenumbers.PhoneNumberFormat.E164);

            if (formattedNumber && countryCode) {
                phone.attr('value', formattedNumber);
                country.attr('value', countryCode);
                countrySelector.attr('value', countryCode);
                popup.css('display', 'none');
                return true;
            } else {		
                throw('');
            }
		
        } catch (e) {
            feedbackBody = '';
            if (e != '')
                feedbackBody += "<p><b>"+e+".</b></p>";
            feedbackBody += "<p>Sorry, but we do not recognize your phone number. Please help us by selecting your country.</p><p>Ensure that you have provided your full phone number, including area code, and country code if you have it available.</p><p>If you are still unable to successfully enter your phone number, please contact <a href='mailto:support@cogzidel.com'>support@cogzidel.com</a>.</p>";
            feedback.html(feedbackBody);
            if (country.val())
                countrySelector.val(country.val());
				
            popup.css('top', phone.offset().top+phone.outerHeight(true)+1).css('left', phone.offset().left+((phone.outerWidth(true)-popup.outerWidth(true))/2));
			
            phone.closest('form').find('div.validated_phone_popup').css('display', 'none'); // hide all other popups
            popup.css('display', 'block');
            return false;
        }
    });

    jQuery.fn.validatedPhone = (function() {
		
        this.addClass('validated_phone_input');
		
        countryModal = jQuery("<div></div>");
        countryModal.attr('id', this.attr('id')+"_popup").attr('class', 'validated_phone_popup').css('display', 'none');
        countryModal.appendTo('body');
		
        jQuery('#'+this.attr('id')+'_country_selector').css('display', 'inherit').appendTo(countryModal);
        jQuery("<div id='"+this.attr('id')+"_feedback'></div>").appendTo(countryModal);
		
        this.blur(function() {
            jQuery(this).validatePhone(jQuery('#'+jQuery(this).attr('id')+'_country_selector').attr('value'));
        });
		
        jQuery('#'+jQuery(this).attr('id')+'_country_selector').change(function() {
            jQuery('#'+jQuery(this).attr('id').replace('_country_selector', '')).validatePhone(jQuery(this).attr('value'));
        });
		
        // Only bind this function once, even if validatedPhone is called multiple times.
        this.closest('form').unbind('submit.validated_phone');
        this.closest('form').bind('submit.validated_phone', function() {
            validFields = jQuery(this).find('input.validated_phone_input').map(function() {
                if (!jQuery(this).validatePhone()) {
                    jQuery(this).focus();
                    return 'f';
                } else {
                    return 't';
                }
            });
            return (jQuery.inArray('f', validFields) < 0);
        });
		
        this.validatePhone();
		
        return this;

    });
	
})(jQuery);