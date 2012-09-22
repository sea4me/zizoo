<!-- Required css stylesheets -->

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<?php $this->load->view('includes/dash_header'); ?>
<div class="box">
    <div class="top"></div>
    <ul class="subnav">
        <li><a href="<?php echo base_url(); ?>func/account"></a><?php echo translate("Notification"); ?></li>
        <li class="active"><a href="<?php echo base_url(); ?>func/payout"><?php echo translate("Payout Preferences"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/transaction"><?php echo translate("Transaction History"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/recommendation"><?php echo translate("Get Recommendations"); ?></a></li>
    </ul>
    <div class="middle clsDes_Top_Spac">
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
                <div class="clsH1_long_Border">
                    <h1><?php echo translate("Payout Method"); ?></h1></div>
                <br>

                <?php
                $this->db->select();
                $query = $this->db->get('payout_preferences');
                $result = $query->result();
                if (!empty($result)) {
                    ?>
                    <table id="payout_methods" border="1" cellpadding="5" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <th class="name"><?php echo translate("Status"); ?></th>
                                <th class="rank"><?php echo translate("Method"); ?></th>
                                <th class="rank"><?php echo translate("Details"); ?></th>
                            </tr>
                            <?php
                            foreach ($result as $row) {
                                ?>

                                <tr>
                                    <?php if (!empty($row->default_email)) { ?>
                                        <td style="width:130px;"> <?php echo translate("Verified"); ?><b><?php echo ' (' . $row->default_email . ')'; ?></b></td>
                                    <?php } else { ?>
                                        <td style="width:130px;"> <?php echo translate("Verified"); ?><b><?php echo $row->default_email; ?></b></td>
                                    <?php } ?>
                                    <td style="width:100px;"><?php echo $row->payout_type; ?></td>
                                    <td><?php echo $row->email . '(' . $row->currency . ')' ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <div id="selPayout_Bttm">
                    <p><a href="" id="add_payment"><?php echo translate("Add Payout Method"); ?></a><a href="" id="change_default"><?php echo translate("Change Default"); ?></a></p>
                    <div style="clear:both"></div>
                </div>

                <br>


                <div id="method">
                    <div style="" id="payout_country_select">
                        <form  method="post" action="<?php echo base_url() . 'func/payoutMethod' ?>"> 

                            <?php echo translate("Our ability to pay you depends on your country of residence:"); ?>
                            <select name="country" id="country">
                                <option value="Afghanistan" >Afghanistan</option>
                                <option value="Albania" >Albania</option>
                                <option value="Algeria" >Algeria</option>
                                <option value="Andorra" >Andorra</option>
                                <option value="Angola" >Angola</option>
                                <option value="Antigua & Barbuda" >Antigua & Barbuda</option>
                                <option value="Antilles" >Antilles</option>
                                <option value="Argentina" >Argentina</option>

                                <option value="Armenia" >Armenia</option>
                                <option value="Australia" >Australia</option>
                                <option value="Austria" >Austria</option>
                                <option value="Azerbaijan" >Azerbaijan</option>
                                <option value="Azores" >Azores</option>
                                <option value="Bahamas" >Bahamas</option>
                                <option value="Bahrain" >Bahrain</option>
                                <option value="Bangladesh" >Bangladesh</option>
                                <option value="Barbados" >Barbados</option>

                                <option value="Belarus" >Belarus</option>
                                <option value="Belgium" >Belgium</option>
                                <option value="Belize" >Belize</option>
                                <option value="Benin" >Benin</option>
                                <option value="Bermuda" >Bermuda</option>
                                <option value="Bhutan" >Bhutan</option>
                                <option value="Bolivia" >Bolivia</option>
                                <option value="Bosnia & Hercegovina" >Bosnia & Hercegovina</option>

                                <option value="Botswana" >Botswana</option>
                                <option value="Brazil" >Brazil</option>
                                <option value="Brunei" >Brunei</option>
                                <option value="Bulgaria" >Bulgaria</option>
                                <option value="Burkina Faso" >Burkina Faso</option>
                                <option value="Burundi" >Burundi</option>
                                <option value="Canada" >Canada</option>
                                <option value="Cambodia" >Cambodia</option>
                                <option value="Cameron" >Cameron</option>
                                <option value="Cape Verde" >Cape Verde</option>

                                <option value="Cayman Islands" >Cayman Islands</option>
                                <option value="Central African Republic" >Central African Republic</option>
                                <option value="Chad" >Chad</option>
                                <option value="Chile" >Chile</option>
                                <option value="China" >China</option>
                                <option value="Columbia" >Columbia</option>
                                <option value="Congo" >Congo</option>
                                <option value="Costa Rica" >Costa Rica</option>
                                <option value="Croatia" >Croatia</option>

                                <option value="Cuba" >Cuba</option>
                                <option value="Cyprus" >Cyprus</option>
                                <option value="Czech Republic" >Czech Republic</option>
                                <option value="Denmark" >Denmark</option>
                                <option value="Djibkuti" >Djibkuti</option>
                                <option value="Dominican Republic" >Dominican Republic</option>
                                <option value="Ecuador" >Ecuador</option>
                                <option value="Egypt" >Egypt</option>
                                <option value="El Salvador" >El Salvador</option>

                                <option value="Eritrea" >Eritrea</option>
                                <option value="Estonia" >Estonia</option>
                                <option value="Ethiopia" >Ethiopia</option>
                                <option value="Faukland Islands" >Faukland Islands</option>
                                <option value="Fiji Islands" >Fiji Islands</option>
                                <option value="Finland" >Finland</option>
                                <option value="France" >France</option>
                                <option value="French Guiana" >French Guiana</option>
                                <option value="French Polynesia" >French Polynesia</option>

                                <option value="Gabon" >Gabon</option>
                                <option value="Gambia" >Gambia</option>
                                <option value="Georgia" >Georgia</option>
                                <option value="Germany" >Germany</option>
                                <option value="Ghana" >Ghana</option>
                                <option value="Gibraltar" >Gibraltar</option>
                                <option value="Greece" >Greece</option>
                                <option value="Greenland" >Greenland</option>
                                <option value="Grenada" >Grenada</option>

                                <option value="Guadaloupe" >Guadaloupe</option>
                                <option value="Guam" >Guam</option>
                                <option value="Guatemala" >Guatemala</option>
                                <option value="Guinea" >Guinea</option>
                                <option value="Guinea-Bissau" >Guinea-Bissau</option>
                                <option value="Guyana" >Guyana</option>
                                <option value="Haiti" >Haiti</option>
                                <option value="Honduras" >Honduras</option>
                                <option value="Hong Kong" >Hong Kong</option>

                                <option value="Hungary" >Hungary</option>
                                <option value="Iceland" >Iceland</option>
                                <option value="India" >India</option>
                                <option value="Indonesia" >Indonesia</option>
                                <option value="Iran" >Iran</option>
                                <option value="Iraq" >Iraq</option>
                                <option value="Ireland" >Ireland</option>
                                <option value="Israel" >Israel</option>
                                <option value="Italy" >Italy</option>

                                <option value="Ivory Coast" >Ivory Coast</option>
                                <option value="Jamaica" >Jamaica</option>
                                <option value="Japan" >Japan</option>
                                <option value="Jordan" >Jordan</option>
                                <option value="Kazakhstan" >Kazakhstan</option>
                                <option value="Kenya" >Kenya</option>
                                <option value="Korea" >Korea</option>
                                <option value="Korea (North)" >Korea (North)</option>
                                <option value="Korea (South)" >Korea (South)</option>

                                <option value="Kuwait" >Kuwait</option>
                                <option value="Kyrgyzstan" >Kyrgyzstan</option>
                                <option value="Laos" >Laos</option>
                                <option value="Latvia" >Latvia</option>
                                <option value="Lebanon" >Lebanon</option>
                                <option value="Lesotho" >Lesotho</option>
                                <option value="Liberia" >Liberia</option>
                                <option value="Libya" >Libya</option>
                                <option value="Liechtenstein" >Liechtenstein</option>

                                <option value="Lithuania" >Lithuania</option>
                                <option value="Luxembourg" >Luxembourg</option>
                                <option value="Macao" >Macao</option>
                                <option value="Madagascar" >Madagascar</option>
                                <option value="Malawi" >Malawi</option>
                                <option value="Malaysia" >Malaysia</option>
                                <option value="Mali" >Mali</option>
                                <option value="Malta" >Malta</option>
                                <option value="Marshall Islands" >Marshall Islands</option>

                                <option value="Martinique" >Martinique</option>
                                <option value="Mauritania" >Mauritania</option>
                                <option value="Mauritius" >Mauritius</option>
                                <option value="Melaysia" >Melaysia</option>
                                <option value="Mexico" >Mexico</option>
                                <option value="Micronesia" >Micronesia</option>
                                <option value="Moldova" >Moldova</option>
                                <option value="Monaco" >Monaco</option>
                                <option value="Mongolia" >Mongolia</option>

                                <option value="Montserrat" >Montserrat</option>
                                <option value="Morocco" >Morocco</option>
                                <option value="Mozambique" >Mozambique</option>
                                <option value="Myanmar (Burma)" >Myanmar (Burma)</option>
                                <option value="Namibia" >Namibia</option>
                                <option value="Nauru" >Nauru</option>
                                <option value="Nepal" >Nepal</option>
                                <option value="Netherlands" >Netherlands</option>
                                <option value="Netherlands Antilles" >Netherlands Antilles</option>

                                <option value="New Zealand" >New Zealand</option>
                                <option value="Nicaragua" >Nicaragua</option>
                                <option value="Niger" >Niger</option>
                                <option value="Nigeria" >Nigeria</option>
                                <option value="North Korea" >North Korea</option>
                                <option value="Northern Ireland" >Northern Ireland</option>
                                <option value="Norway" >Norway</option>
                                <option value="Oman" >Oman</option>
                                <option value="Pakistan" >Pakistan</option>

                                <option value="Panama" >Panama</option>
                                <option value="Papua New Guinea" >Papua New Guinea</option>
                                <option value="Paraguay" >Paraguay</option>
                                <option value="Peru" >Peru</option>
                                <option value="Philippines" >Philippines</option>
                                <option value="Poland" >Poland</option>
                                <option value="Portugal" >Portugal</option>
                                <option value="Puerto Rico" >Puerto Rico</option>
                                <option value="Qatar" >Qatar</option>

                                <option value="Rio Muni" >Rio Muni</option>
                                <option value="Romania" >Romania</option>
                                <option value="Russia" >Russia</option>
                                <option value="Rwanda" >Rwanda</option>
                                <option value="Samoa (USA)" >Samoa (USA)</option>
                                <option value="San Marino" >San Marino</option>
                                <option value="Saudi Arabia" >Saudi Arabia</option>
                                <option value="Senegal" >Senegal</option>
                                <option value="Seychelles" >Seychelles</option>

                                <option value="Sierra Leone" >Sierra Leone</option>
                                <option value="Singapore" >Singapore</option>
                                <option value="Slovak Republic" >Slovak Republic</option>
                                <option value="Slovenia" >Slovenia</option>
                                <option value="Solomon Islands" >Solomon Islands</option>
                                <option value="Somalia" >Somalia</option>
                                <option value="South Africa" >South Africa</option>
                                <option value="Spain" >Spain</option>
                                <option value="Sri Lanka" >Sri Lanka</option>

                                <option value="St. Kitts and Nevis" >St. Kitts and Nevis</option>
                                <option value="St. Lucia" >St. Lucia</option>
                                <option value="St. Vincent & Grenadines" >St. Vincent & Grenadines</option>
                                <option value="Sudan" >Sudan</option>
                                <option value="Surinarne" >Surinarne</option>
                                <option value="Swaziland" >Swaziland</option>
                                <option value="Sweden" >Sweden</option>
                                <option value="Switzerland" >Switzerland</option>

                                <option value="Syria" >Syria</option>
                                <option value="Tahiti" >Tahiti</option>
                                <option value="Taiwan" >Taiwan</option>
                                <option value="Tajikistan" >Tajikistan</option>
                                <option value="Tanzania" >Tanzania</option>
                                <option value="Tashken" >Tashken</option>
                                <option value="Thailand" >Thailand</option>
                                <option value="Togo" >Togo</option>
                                <option value="Tonga" >Tonga</option>

                                <option value="Trinidad & Tobago" >Trinidad & Tobago</option>
                                <option value="Tunisia" >Tunisia</option>
                                <option value="Turkey" >Turkey</option>
                                <option value="Turkmenistan" >Turkmenistan</option>
                                <option value="Uganda" >Uganda</option>
                                <option value="Ukraine" >Ukraine</option>
                                <option value="United Arab Emirates" >United Arab Emirates</option>
                                <option value="United Kingdom" >United Kingdom</option>

                                <option value="Uruguay" >Uruguay</option>
                                <option value="Uzbekistan" >Uzbekistan</option>
                                <option value="Vanuatu" >Vanuatu</option>
                                <option value="Vatican City" >Vatican City</option>
                                <option value="Venezuela" >Venezuela</option>
                                <option value="Vietnam" >Vietnam</option>
                                <option value="Virgin Islands (UK)" >Virgin Islands (UK)</option>
                                <option value="Virgin Islands (US)" >Virgin Islands (US)</option>
                                <option value="Western Sahara" >Western Sahara</option>

                                <option value="Western Somoa" >Western Somoa</option>
                                <option value="Windward Islands" >Windward Islands</option>
                                <option value="Yemen" >Yemen</option>
                                <option value="Yugoslavia" >Yugoslavia</option>
                                <option value="Zaire" >Zaire</option>
                                <option value="Zambia" >Zambia</option>
                                <option value="Zimbabwe" >Zimbabwe</option>
                            </select>
                            <input type="submit" value="<?php echo translate("Next"); ?>" name="commit" id="next" class="v3_button">
                            or <a  href="" onclick="$('payout_country_select').hide();return true;"  id="cancel"><?php echo translate("Cancel"); ?></a>
                        </form>                            </div>
                </div>
                <!--Payment Method-->

                <!--Change Default-->
                <div id="change">

                    <form action="<?php echo base_url() . 'func/setDefault' ?>" method="post">
                        <p>

                            <select name="default_email" >
                                <?php
                                foreach ($result as $default_mail) {
                                    ?>
                                    <option value="<?php echo $default_mail->email ?>"><?php echo $default_mail->email ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="submit" name="SetDefault" value="<?php echo translate("Set Default"); ?>" class="v3_button"/>
                        </p>
                    </form>
                </div>
                <!--Change Default-->


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
    <div class="bottom"></div>
</div>
</div>

<script>
    $("#method").hide();
    $("#change").hide();
		
    $("#add_payment").click(function ( event ) {
        event.preventDefault();
        $("#method").show("slow");
        $("#change").hide("slow");
    });
    $("#change_default").click(function ( event ) {
        event.preventDefault();
        $("#change").show("slow");
        $("#method").hide("slow");
    });
		 
    $('#next').click(
    function(event)
    {
        $("#payout_country_select").hide("slow");
			   
    }
);
		 
    $('#cancel').click(
    function(event)
    {
			   
			
				
    }
);
		 
		
</script>