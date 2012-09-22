<!-- Required css stylesheets -->

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<?php
$this->load->view('includes/dash_header');
$this->load->view('includes/hosting_header');
?>
<div class="box">
    <div class="top"></div>
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
                <div class="clsH1_long_Border"><h1><?php echo translate("Promote Your Listing"); ?></h1></div>

                <?php echo translate("Want more inquiries? Here are some easy steps:"); ?> 
                <br>
                1. <a href="<?php echo base_url() ?>func/points"><?php echo translate("Increase Search Ranking"); ?>  </a>- <?php echo translate("Tips on how to appear higher in the search results on"); ?> <?php echo $this->dx_auth->get_site_title(); ?>.

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



