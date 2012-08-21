<?php error_reporting(E_ALL ^ E_NOTICE);
 ?>
<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />
<?php if($this->uri->segment(3) != $this->dx_auth->get_user_id()): ?>
<h1><?php echo translate("Sorry you are not authorised to view this page"); ?></h1>
<?php else: ?>

<?php $query = $this->db->get_where('profiles' , array('id' => $this->uri->segment(3)));
	$q = array();	
	$q = $query->result();
	
	$email_id = $this->db->get_where('users' , array('id' => $this->uri->segment(3)))->row()->email;

?>
<div class="clsNew_Common_Bg">

<div id="edit_profile">
<div class="clsDisign_Box">
        <div class="clsTop_Pannel">
        	<div class="clsTop_Left">
            	<div class="clsTop_Right">
                	<div class="clsTop_Mid">
                    </div>
                </div>
            </div>
        </div>
        <div class="CenterPannel">
	<div id="content" style='position:relative;'>
		
		        
 <div class="clsH1_long_Border">
            <h1><?php echo translate("About You"); ?></h1></div>
            <div class="section" id="person_section">   
             <div style="float:left;width:250px; position:relative;">
            	 <div class="clsDisign_Box">
        		<div class="clsTop_Pannel">
        	<div class="clsTop_Left">
            	<div class="clsTop_Right">
                	<div class="clsTop_Mid">
                    </div>
                </div>
            </div>
        </div>
        		<div class="CenterPannel">
            
                    <div id="user_box">


                           
        <div class="clsSide_border_Samll">
						 <h2><?php echo translate("Upload Photo"); ?></h2>
							<div style="text-align:center;" id="user_pic" onclick="show_ajax_image_box();"> <img alt="" src="<?php echo $this->Gallery->profilepic($this->dx_auth->get_user_id(),2); ?>" title=""  /> </div>
        </div>
                		
						 <?php echo form_open_multipart('profiles/userphoto/'.$this->uri->segment(3)); ?>
                		
         <input id="upload123" name="upload123" type="file" />

					   	<input id="upload" name="upload" value="Hello" type="hidden" />
          <input id="upload_image_submit_button" type="submit" value="<?php echo translate("Upload Photo"); ?>" />
        <?php form_close(); ?>
                        
                        <!-- <a href="javascript:void(0);" onclick="$('ajax_upload_container').toggle();" style="font-size:16px;">Upload a Profile Photo!</a> -->

                    </div>

                    <br />

               
                </div>
                <div class="BottomPannel">
        	<div class="clsBottom_Left">
            	<div class="clsBottom_Right">
                	<div class="clsBottom_Mid">
                    </div>
                </div>
            </div>
        </div>
        		</div> </div>
              
               <div style="float:right; width:690px;">
                <div class="clsDisign_Box">
        <div class="clsTop_Pannel">
        	<div class="clsTop_Left">
            	<div class="clsTop_Right">
                	<div class="clsTop_Mid">
                    </div>
                </div>
            </div>
        </div>
        <div class="CenterPannel">
				<?php echo form_open("profiles/prof/".$this->uri->segment(3),'id="userprofile"')?>		
                <div class="clsTab_Edit_UserPro">

                    <table>
                        <tr><td class="label"><?php echo translate("Name:"); ?></td><td><input class="name_input" style="margin:0 10px 0 0;" id="user_first_name" name="Fname" size="30" type="text" value=<?php if($q[0]->Fname) echo $q[0]->Fname; else echo '""'; ?> /><input class="name_input" id="user_last_name" name="Lname" size="30" type="text" value=<?php if($q[0]->Lname) echo $q[0]->Lname; else echo '""'; ?> /></td></tr>
                        <tr><td class="label"><?php echo translate("Email:"); ?></td><td><input class="private_lock" id="user_email" name="email" size="30" type="text" value=<?php echo $email_id ; ?> /></td></tr>
                        
                        <tr><td class="label"><?php echo translate("Where You Live:"); ?></td><td><input id="user_profile_info_current_city" name="live" value=<?php if($q[0]->live) echo $q[0]->live; else echo '""'; ?> size="30" type="text" /><br /><span style="color:#9c9c9c; text-style:italic; font-size:11px;">e.g. Paris, FR / Brooklyn, NY / Chicago, IL</span><br /></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo translate("Work:"); ?></td><td><input id="user_profile_info_employer" name="work" size="30" type="text" value=<?php if($q[0]->live) echo $q[0]->work; else echo '""'; ?> /></td>
						</tr>
						<tr>

							<td class="label" valign="top"><?php echo translate("Phone Number:"); ?></td>
							<td>
								<select id='user_phone_country_selector' style='display:none;'>
									<option value="">Unspecified</option>
<option value="AF">Afghanistan</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>

<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AU">Australia</option>

<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>

<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia</option>
<option value="BA">Bosnia</option>
<option value="BW">Botswana</option>
<option value="BV">Bouvet Island</option>
<option value="BR">Brazil</option>
<option value="IO">British Indian Ocean Territory</option>

<option value="BN">Brunei Darussalam</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="KH">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>

<option value="CF">Central African Republic</option>
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos (Keeling) Islands</option>
<option value="CO">Colombia</option>
<option value="KM">Comoros</option>
<option value="CG">Congo</option>

<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="CI">Cote D'ivoire</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>

<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">El Salvador</option>
<option value="GQ">Equatorial Guinea</option>
<option value="R">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>

<option value="FK">Falkland Islands (Malvinas)</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="GF">French Guiana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="GA">Gabon</option>

<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GH">Ghana</option>
<option value="GI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>

<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard and Mc Donald Islands</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong</option>

<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN" selected="selected">India</option>
<option value="ID">Indonesia</option>
<option value="IR">Iran</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>

<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KR">South Korea</option>
<option value="XK">Kosovo</option>
<option value="KW">Kuwait</option>

<option value="KG">Kyrgyzstan</option>
<option value="LA">Lao</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>

<option value="LU">Luxembourg</option>
<option value="ME">Montenegro</option>
<option value="MO">Macau</option>
<option value="MK">Macedonia</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>

<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia</option>
<option value="MD">Moldova</option>

<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar</option>
<option value="NA">Namibia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>

<option value="NL">Netherlands</option>
<option value="AN">Netherlands Antilles</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>

<option value="MP">Northern Mariana Islands</option>
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PA">Panama</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="PE">Peru</option>

<option value="PH">Philippines</option>
<option value="PN">Pitcairn</option>
<option value="PL">Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="RE">Reunion</option>
<option value="RO">Romania</option>
<option value="RS">Serbia</option>

<option value="RU">Russian Federation</option>
<option value="RW">Rwanda</option>
<option value="KN">Saint Kitts and Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="VC">Saint Vincent and The Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="ST">Sao Tome and Principe</option>
<option value="SA">Saudi Arabia</option>

<option value="SN">Senegal</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="SK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>

<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SH">St. Helena</option>
<option value="PM">St. Pierre and Miquelon</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen Islands</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>

<option value="CH">Switzerland</option>
<option value="SY">Syrian Arab Republic</option>
<option value="TW">Taiwan</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania</option>
<option value="TH">Thailand</option>
<option value="TG">Togo</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>

<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turks and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="AE">United Arab Emirates</option>

<option value="GB">United Kingdom</option>
<option value="US">United States</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VA">Vatican City State</option>
<option value="VE">Venezuela</option>
<option value="VN">Viet Nam</option>
<option value="VG">Virgin Islands (British)</option>

<option value="VI">Virgin Islands (U.S.)</option>
<option value="WF">Wallis and Futuna Islands</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>
								</select>
								<input autocomplete="off" class="private_lock" id="user_phone" name="phnum" size="30" type="text" value=<?php if($q[0]->phnum) echo $q[0]->phnum; else echo '""'; ?> />
								<input id="user_phone_country" name="phcountry" type="hidden" />

							</td>
						</tr>
						        <tr>
                                	<td style="vertical-align:top;"><?php echo translate("Describe Yourself"); ?> :</td>
                                    <td><textarea cols="40" id="user_profile_info_about" name="desc" rows="20" style="width:250px;height:200px;"><?php if($q[0]->describe) echo $q[0]->describe; ?></textarea></td>
                                </tr>                
                    </table>
                    
                </div>
                
                
                <br />
                <div class="buttons">
                <p><input class="v3_button" name="commit" type="submit" value="<?php echo translate("Save Changes"); ?>" />
             

                
                
                or <?php echo anchor('home',translate("Cancel")); ?>&nbsp;&nbsp;&nbsp;</p>
            </div>
                </div>
                <div class="BottomPannel">
        	<div class="clsBottom_Left">
            	<div class="clsBottom_Right">
                	<div class="clsBottom_Mid">
                    </div>
                </div>
            </div>
        </div>
                </div>
                
            </div>
            <div style="clear:both;"></div>
		
            <!-- buttons -->
</div>
		<!-- fields for user_profile_info -->
</form>	</div>
</div>
        <div class="BottomPannel">
        	<div class="clsBottom_Left">
            	<div class="clsBottom_Right">
                	<div class="clsBottom_Mid">
                    </div>
                </div>
            </div>
        </div>
        </div>

</div>
</div>


<?php endif; ?>
<!-- End of the page scripts -->

<script type="text/javascript">
jQuery("#user_pic").hover(
    function(){$('edit_image_hover').appear({duration: 0.1, from: 0.0, to: 0.7});},
    function(){$('edit_image_hover').fade({duration: 0.1, from: 0.7, to: 0.0});}
);

</script>

    <script type="text/javascript">
    
if ((navigator.userAgent.indexOf('iPhone') == -1) && (navigator.userAgent.indexOf('iPod') == -1) && (navigator.userAgent.indexOf('iPad') == -1)) {
    jQuery(document).ready(function() {
        LazyLoad.js([
			"<?php echo base_url().'css/views/jquery.autocomplete_custom.pack.js'; ?>",
			"<?php echo base_url().'css/views/en_autocomplete_data.js'; ?>"],
			function() {
            	jQuery("#user_profile_info_current_city").autocomplete(autocomplete_terms, {
	                minChars: 1, width: 258, max:20, matchContains: false, autoFill: true,
	                formatItem: function(row, i, max) {
	                    //to show counts, uncomment
	                    //return row.k + " <span class='autocomplete_extra_info'>(" + row.c + ")</span>";
	                    return row.k;
	                },
	                formatMatch: function(row, i, max) {
	                    return row.k;
	                },
	                formatResult: function(row) {
	                    return row.k;
	                }
	            });
	        }
		);
    });
}
			window.fbAsyncInit = function() {
				FB.init({
					appId  : '02e3aebb07b4f37b41893ae7713c8fdc',
					status : true, // check login status
					cookie : true, // enable cookies to allow the server to access the session
					xfbml  : true  // parse XFBML
				});

				FB.getLoginStatus(function(response) {
					if (response && (response.status !== "unknown")) {
						jQuery.cookie("fbs", response.status);
					} else {
						jQuery.cookie("fbs", null);
					}
				});
			};

			(function() {
				var e = document.createElement('script');
				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
				e.async = true;
				document.getElementById('fb-root').appendChild(e);
			}());


    </script>

	<script type="text/javascript" charset="utf-8">NREUMQ.push(["nrf2","beacon-3.newrelic.com","fc09a36731",2237,"dlwMQktaWAgBEB1HQFBBERlcUV0Q",0,105])</script>

<!-- End of those scripts -->