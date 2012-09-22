<!-- Required css stylesheets -->

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<?php $this->load->view('includes/dash_header'); ?>
<ul class="subnav" id="submenu">
    <li><a href="<?php echo base_url() ?>func/hosting"><?php echo translate("Manage Listings"); ?></a></li>
    <li><a href="<?php echo base_url() ?>func/myReservation"><?php echo translate("My Reservations"); ?></a></li>
    <li><a href="<?php echo base_url() ?>func/standbys"><?php echo translate("Standby Guests"); ?></a></li>
    <li class="active"><a href="<?php echo base_url() ?>func/promote"><?php echo translate("Promote"); ?></a></li>
    <li><a href="<?php echo base_url() . 'func/editpricing/' . $this->dx_auth->get_user_id() ?>"><?php echo translate("Pricing"); ?></a></li>
    <li><a href="<?php echo base_url() ?>func/policies"><?php echo translate("Policies"); ?></a></li>
</ul>
<div class="box clsDes_Top_Spac">
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
            <div class="top"></div>
            <div class="middle">
                <div class="clsH1_long_Border"><h1><?php echo translate("Search Results Ranking"); ?></h1></div>
                <p>
                    <?php echo translate("You can influence where in the search results your property shows up (which affects how many people see your listing). We try to give "good hosts" a higher ranking than those who are not active participants in our community. Below are your rankings for each property followed by a breakdown of some of the positive and negative influences. We update your rankings once per week."); ?>
                </p>
                <br>
                <div class="clsH1_long_Border"><h1><?php echo translate("Tips:"); ?></h1></div>

                <p>
                <ul>
                    <li><b>1. </b> <?php echo translate("The most effective way to get a higher ranking is to accept more reservations. The 'Hypothetical Rank' shows you what your rank would be if you had accepted"); ?>
                    <li><b>2.</b> <?php echo translate("4 additional reservations. You may want to decrease your price to attract additional reservations quickly, then increase the price later."); ?>
                    </li>
                    <li><b>3.</b> <?php echo translate("Behavior over 90 days ago will not influence your rank. In other words it's never too late for a fresh start."); ?></li>
                    <li><b>4.</b> <a href="<?php echo base_url() . 'func/editListing/' . $this->dx_auth->get_user_id() ?>"><?php echo translate("Add Pictures to Listings"); ?></a></li>
                    <li><b>5.</b> <a href="<?php echo base_url() . 'func/recommendation' ?>"><?php echo translate("Get Friend Recommendations"); ?></a></li>
                </ul>
                </p>
                <br>
                <div class="clsH1_long_Border"><h1><?php echo translate("Ranking:"); ?></h1></div><br>
                <table id="ranks" border="1px" width="100%" cellpadding="05" cellspacing="0">
                    <tr>
                        <th class="name"><?php echo translate("Listing"); ?></th>
                        <th class="rank"><?php echo translate("Search Rank"); ?></th>
                        <th class="rank"><?php echo translate("Hypothetical Rank"); ?></th>
                        <th class="rank"><?php echo translate("Times Viewed"); ?></th>
                        <th class="example"><?php echo translate("Example"); ?></th>
                    </tr>

                    <?php
                    if ($this->dx_auth->is_logged_in()) {

                        $id = $this->dx_auth->get_user_id();
                        $query = $this->db->get_where('list', array("user_id" => $id));
                        if ($query->num_rows > 0) {
                            foreach ($query->result() as $row) {
                                ?>          <tr>
                                    <td class="name"><a href="<?php echo base_url() . 'func/editConfirm/' . $row->id; ?>"><?php echo $row->title ?></a></td>
                                    <td class="rank">0</td>
                                    <td class="rank">0</td>
                                    <td class="rank">0</td>
                                    <td class="example"><a href="<?php echo base_url() . 'func/search?location=' . $row->address; ?>"><?php echo translate("View"); ?></a></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="name">&mdash;</td>
                                <td class="rank">0</td>
                                <td class="rank">0</td>
                                <td class="rank">0</td>
                                <td class="example"><a href="<?php echo base_url() ?>func/search"><?php echo translate("View"); ?></a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </table>
                <br>
                <div class="clsH1_long_Border"><h1><?php echo translate("You"); ?></h1></div><br>
                <p><b>1.</b> POS: <?php echo translate("Uploaded profile picture"); ?> </p>
                <div>
                    <br>
                    <div class="clsH1_long_Border"><h1>Your Listings</h1></div>
                    <p><b>1.</b> POS: <?php echo translate("Scheduled availability"); ?>  </p>
                    <div>
                    </div>



                </div>
            </div></div>
        <div class="bottom"></div>
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
</div>
<!-- Footer Scripts -->


<script src="<?php echo base_url() . 'css/views/edit_room_v2.js'; ?>" type="text/javascript"></script>

<script type="text/x-jqote-template" id="availability_button_template">
    <![CDATA[
    <span class="clearfix current-availability icon <*= this.status *>">
        <span class="label"><*= this.label *></span>
        <span class="expand"></span>
    </span>
    <div class="toggle-info" style="display: none;">
        <div class="instructions"><*= this.instructions *></div>
        <div class="toggle-action-container">
            <a href="<*= this.url *>" class="toggle-action icon <*= this.next_status *>"><*= this.toggle_label *></a>
        </div>
    </div>
    ]]>
</script>


<script type="text/javascript">
	
    var spinnerImage = new Image(); 
    spinnerImage.src = "/images/spinner.gif";
  
    VisibilityFilter = function(el, options){
        if(el)
            this.init(el, options);
    }

    jQuery.extend(VisibilityFilter.prototype, {
        name: 'visibilityFilter',

        init: function(el, options){
            this.element = $(el);
            $.data(el, this.name, this);

            var $this = this.element;
            var _ref = this;

            jQuery('#listings-filter .display-filter').click(function(){
                _ref.togglePanel();
            });

            jQuery('#listings-filter .toggle-filter a').click(function(){
                var $link = jQuery(this);

                if($link.hasClass('active'))
                    _ref.setPanelState('active');
                else if($link.hasClass('inactive'))
                    _ref.setPanelState('inactive');
                else
                    _ref.setPanelState();

                _ref.showSpinner();
                _ref.hidePanel();
            });

            var outsideClickHandler = function(eventObject){
                eventObject.data.hidePanel();
            };

   
            this.element.hover(
            function(){ jQuery(document).unbind('click', outsideClickHandler); },
            function(){ jQuery(document).bind('click', _ref, outsideClickHandler); }
        );
        },

        hidePanel: function(){
            this.element.removeClass('expand');
        },

        togglePanel: function(){
            this.element.toggleClass('expand');
        },

        showPanel: function(){
            this.element.addClass('expand');
        },

        setPanelState: function(state, showSpinner){
            if(!!showSpinner)
                this.showSpinner(); 

            this.element.removeClass('none inactive active');
            this.element.addClass(state);
        },

        showSpinner: function(){
            this.element.find('.display-filter span.icon:visible').not('.always').addClass('widget-spinner');
        },

        hideSpinner: function(){
            this.element.find('.display-filter span.widget-spinner').not('.always').removeClass('widget-spinner');
        }


    });

    jQuery.fn.visibilityFilter = function(options){

        var args = $.makeArray(arguments),
        after = args.slice(1);

        return this.each(function() {
            var instance = $.data(this, 'visibilityFilter');

            if (instance) {
                if (typeof options === "string") {
                    instance[options].apply(instance, after);
                } 
                else if (instance.update) {
                    // call update on the instance
                    instance.update.apply(instance, args);
                }
            } 
            else {
                new VisibilityFilter(this, options);
            }
        });
    }

    jQuery(document).ready(function(){
        jQuery('#post-listing-new').click(function(){
            document.location = "http://www.cogzidel.com/rooms/new";
        });

        jQuery('#listings-filter').visibilityFilter();
    });
    var buttonContent = {
        active: {
            label: "Active",
            instructions: "Hide your listing to remove it from search results:",
            toggle_label: "Hide"
        },
        inactive: {
            label: "Hidden",
            instructions: "Activate your listing to have it show up in search results:",
            toggle_label: "Activate"
        }
    };

    jQuery(document).ready(function(){
        jQuery('div.set-availability').availabilityWidget(buttonContent);
    });

</script>