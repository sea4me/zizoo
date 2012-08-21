<!-- Required css stylesheets -->

<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
   <?php
		 $this->load->view('includes/dash_header'); 
			$this->load->view('includes/hosting_header'); 
			?>
		
		 <?php if($this->dx_auth->is_logged_in())
      {
	   		 $id = $this->dx_auth->get_user_id();
	   	 $this->db->where("user_id",$id);
		 $this->db->select('id');
	  	$query = $this->db->get('list');
		$result=$query->first_row();
		//echo $result->id;
		
      }
 ?>
     <div class="clsDisign_Box" style="margin:10px 0 0 0">
        <div class="clsTop_Pannel">
        	<div class="clsTop_Left">
            	<div class="clsTop_Right">
                	<div class="clsTop_Mid">
                    </div>
                </div>
            </div>
        </div>
        <div class="CenterPannel">
  <div class="box">
  
    <div class="middle">
       <!-- sort-header dropdown-->
       <div class="sort-header clearfix">
        <span class="action_button " id="listings-filter">
          <div class="display-filter">
            <span class="icon none always"> <?php echo translate("Show:"); ?></span> 
            <span class="icon none"><?php echo translate("all listings"); ?><span class="expand"></span></span>
            <span class="icon active"><?php echo translate("active listings"); ?><span class="expand"></span></span>
            <span class="icon inactive"><?php echo translate("hidden listings"); ?><span class="expand"></span></span>
          </div>
          <div class="toggle-filter">
            <div><a href="<?php echo base_url();?>rooms/sort_by_status?f=all" class="icon none"><?php echo translate("Show all listings"); ?></a></div>
             <div><a href="<?php echo base_url();?>rooms/sort_by_status?f=active" class="icon active"><?php echo translate("Show active"); ?></a></div>
            <div><a href="<?php echo base_url();?>rooms/sort_by_status?f=hide" class="icon inactive"><?php echo translate("Show hidden"); ?></a></div>  
          </div>
        </span>

      </div>  
	           <!-- sort-header dropdown-->
      <div id="listings-container">
        <ul class="listings">
		
         	<?php if($this->dx_auth->is_logged_in()): ?>
			<?php
				$id = $this->dx_auth->get_user_id();
    $query='';
				if(!empty($sort))
				{
					if($sort == "active")
					{		    
						$this->db->where('status', 1);
					}	
					
					if($sort == "hide")
					{		    
						$this->db->where('status', 0);
					}	
				}

				$query = $this->db->get_where('list', array("user_id" => $id));
			//	echo $this->db->last_query();
				if( $query->num_rows > 0 ){
			?>
			<?php 
				foreach($query->result() as $row)
				{
					$images = $this->Gallery->get_images($row->id);
						if(count($images) == 0)
						{
							$url = base_url().'images/no_image.jpg';
						}
						else
						{
							$url = $images[0]['url'];
						} 
				
					echo '<li class="listing">
					<div class="thumbnail">';
					
					echo '<a class="image_link" href="'.base_url().'rooms/'.$row->id.'" linkindex="98"><img title="'.$row->title.'" src="'.$url.'" class="search_thumbnail"></a> </div>';
					echo '<div class="listing-info"><h3>';
					  echo anchor('rooms/'.$row->id,$row->title);
					  echo '</h3>';
					  echo '              <span class="actions">
						<span class="action_button">';
					  echo anchor('func/editListing/'.$row->id,translate("Edit Listing"),array('class' => 'icon 
		
		edit'));
					  echo '</span>
						<span class="action_button">';
						echo anchor('rooms/'.$row->id,translate("View Listing"),array('class' => 'icon view'));
						echo '</span>
						
						<span class="action_button">';
						echo anchor('func/deletelisting/'.$row->id,translate("Delete Listing"),array('class' => 'icon view'));
						echo '</span><span style="clear:both"></span>
						</div>';
     ?>
					       <p style="clear:both"> Change To : 
           <?php if($row->status == 1) { ?>
     						<a href="<?php echo base_url().'rooms/showHide?stat=1 & rid='.$row->id?>"><?php echo translate("Active"); ?></a>
											<?php } else { ?> 
           <a href="<?php echo base_url().'rooms/showHide?stat=0 & rid='.$row->id?>"><?php echo translate("Hide"); ?></a>
											<?php } ?> </p>
                          

			
                        <?php
					echo '<div class="clear"></div>
				  </li>';
				}
				}else
				{
				  echo "<p style='font-size:18px'>".translate("You don't have any listings!")."</p>
						<br/> ".translate("Listing your space on")." ".$this->dx_auth->get_site_title()." ".translate("is an easy way to  monetize any extra space you have.")."
						<br/>".translate("You'll also get to meet interesting travelers from around the world!")."
						<br/>
						<br>";
				  echo anchor('home/addlist/',translate("Post a new listing"),array('class' => 'button-glossy green'));
				  
				}
			?>
			   
			<?php endif; ?>
			
		
          </ul>
          <div style="clear:both"></div>
      </div>

    </div>
    
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

<!-- Footer Scripts -->
 <script>
				 $(".active_list").click(function ( event ) {
        		 event.preventDefault();
		 		 $(this).hide();
					$(".hide_list").show();
				
       			 });	
				 $(".hide_list").click(function ( event ) {
        		 event.preventDefault();
		 		 $(this).hide();
				 $(".active_list").show();
       			 });
</script>

<script src="<?php echo base_url().'css/views/edit_room_v2.js'; ?>" type="text/javascript"></script>

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
		  //
  //

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
    // get the arguments 
    var args = $.makeArray(arguments),
        after = args.slice(1);

    return this.each(function() {
      // see if we have an instance
      var instance = $.data(this, 'visibilityFilter');

      if (instance) {
        // call a method on the instance
        if (typeof options === "string") {
          instance[options].apply(instance, after);
        } 
        else if (instance.update) {
          // call update on the instance
          instance.update.apply(instance, args);
        }
      } 
      else {
        // create the plugin
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
		


