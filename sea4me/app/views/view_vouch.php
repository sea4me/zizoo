<!--  Required external style sheets -->
<style>


#user_result_list {
	border-spacing:2px 2px
}
#user_result_list th {
	height:23px;
	text-align:center;
	vertical-align:middle;
	background-color:#f1f3e8;
	font-weight:bold
}
#user_result_list tr.hover td {
	background-color:#f6f7ef;
	cursor:pointer
}
#user_result_list td {
	padding:2px 0 1px;
	border-bottom:thin dashed #bcb8b8
}
#user_result_list td .first-line {
	height:17px;
	overflow:hidden
}
#user_result_list td.place_image {
	width:70px
}
#user_result_list td.host_image {
	width:50px;
	text-align:center;
	vertical-align:middle
}
#user_result_list td.main {
	width:235px;
	padding-left:20px;
	vertical-align:top
}
#user_result_list td.main div.letter {
	float:left;
	width:20px
}
#user_result_list td.main div.non-letter {
	float:left;
	width:230px
}
#user_result_list td.main .title {
	font-size:13px;
	font-weight:bold
}
#user_result_list td.address {
	font-weight:bold;
	background-color:#cfe5ff;
	border-bottom:none;
	padding:6px
}
#user_result_list td.address .distance {
	color:#fc3947
}
#user_result_list td.space {
	width:90px;
	vertical-align:top;
	text-align:center;
	color:#7e7979
}
#user_result_list td.accommodates {
	width:120px;
	vertical-align:top;
	text-align:center;
	color:#7e7979
}
#user_result_list td.reviews {
	width:115px;
	vertical-align:top;
	text-align:center;
	color:#7e7979
}
#user_result_list td.price {
	width:85px;
	vertical-align:middle;
	text-align:right;
	font-size:26px;
	font-weight:bold;
	color:#323232
}
#user_result_list td.place_image .thumbnail {
	position:relative;
	z-index:0
}
#user_result_list td.place_image .thumbnail:hover {
	background-color:transparent;
	z-index:50
}
#user_result_list td.place_image .thumbnail span {
	position:absolute;
	height:auto;
	left:-1000px;
	padding:2px;
	background:#B5AE85;
	visibility:hidden;
	color:black;
	text-decoration:none
}
#user_result_list td.place_image .thumbnail span img {
	border-width:0
}
#user_result_list td.place_image .thumbnail:hover span {
	visibility:visible;
	left:0
}
</style>
<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/silver.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<!-- End of style sheet inclusion -->
<div id="command_center">

<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />
<?php // $this->load->view('includes/dash_header'); ?>
	<?php
         $user_id=$this->input->get('id');
         $this->db->where('id',$user_id);
         $res=$this->db->select();
         $val=$res->get('users');
         $data=$val->result();
		 $mem_from="";
		 $user_name="";
        foreach($data as $user)
		{
			$member_joined=$user->created;
			$user_name=$user->username;
		}
	    $member_from=date("M Y",strtotime($member_joined));
    ?>	

  
	
    <div id="dashboard" class="clsDes_Top_Spac">
    <div>
      <div class="clsH1_long_Border">
        <h1>
    	<? echo ucfirst($user_name);?><span style="float:right; font-size:18px; padding-right: 10px; font-weight:normal;"><?php echo translate("Member from"); ?> <?php echo $member_from;?></span> </h1></div>
        <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
        <div id="left" style="overflow:hidden;">
            <div id="user_box" class="box">
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
                <div class="top">&nbsp;</div>
                <div class="middle">

                    <div id="user_pic" onClick="show_ajax_image_box();">
	
			            
                            <img alt="" height="209" src="<?php echo $this->Gallery->profilepic($user_id); ?>" title="" width="209" />
                        	
							<?php
                                //Get the Firend List
								$this->db->where('user_id',$user_id);
								$list=$this->db->select();
								$getlist=$list->get('list');
								$frnd_list=$getlist->result();

							?>
                             <?php echo form_open('func/vouch');?>
                     </div>
     				<h1>

                    <span style="font-size:.55em; font-weight:bold; margin-top:5px; display:block;"><?php echo anchor('func/editConfirm/1','My List')?></span></h1>
                    

             
                </div><!-- middle -->
                <div class="bottom">&nbsp;</div>
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
            </div><!-- /user -->

                <!--<div id="quick_links" class="box">
                    <div class="top">&nbsp;</div>
                    <div class="middle">
                        <h2><?php translate("Quick Links",$this->session->userdata('lang'));?></h2>
                        <ul>

                                <li><a href=<?php echo base_url().'func/hosting'; ?>><?php translate("View/Edit Listings",$this->session->userdata('lang'));?></a></li>
                                <li><a href=<?php echo base_url().'func/reserve'; ?>><?php translate("Reservations",$this->session->userdata('lang'));?></a></li>
                                
                        </ul>

                    </div>
                    <div class="bottom">&nbsp;</div>
                </div>--><!-- /snapshot -->

       <!--      <div id="snapshot" class="box">
                    <div class="top">&nbsp;</div>
                    <div class="middle">
                        <h2>Snapshot</h2>
                        <ul>

                            <li class="clearfix">
                                <div class="stat_name">All Page Views</div><div class="stat_value"> 0 </div>
                            </li>
                        </ul>
                    </div>
                    <div class="bottom">&nbsp;</div>
                </div><!-- /snapshot -->  


        </div><!-- /left -->

         
       <div id="main" style="float:right;">

                <div class="middle Padding_Bttm_PTag">
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
               		<div class="clsBoder3"><h1>Vouch for <? echo ucfirst($user_name);?></h1></div> 
               		<p style="font-weight:normal; font-style:italic; font-size:16px;">
                  <?php echo translate("Please write a few sentences explaining why"); ?> &nbsp;<? echo ucfirst($user_name);?> &nbsp;<?php echo translate("is a great person."); ?>
                 </p>
                    
                    <p><?php echo translate("Enter your recommendation here and then click the Recommend button."); ?> </p>
                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                     <input type="hidden" name="friend_id" value="<?php echo $this->dx_auth->get_user_id();?>">
                    <p><textarea id="recommend" name="message" cols="75">
                    
                    </textarea></p>
                   
                    <p><input type="submit" name="friends_recommend" value="<?php echo translate("Recommend"); ?>" class="V3_button"/></p>
                   <?php echo form_close();?>
                    
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
        
                 <div class="middle">
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
                	<div class="clsBoder3"><h1><?php echo translate("My Listing"); ?></h1></div>
<table id="user_result_list">

<tbody>
   
    <?php
	
	  if(!empty($frnd_list))
	  {
		 foreach($frnd_list as $list)
			 {?>
		<tr class="even" id="room_175408">
										
			<td class="place_image">
				<a class="thumbnail" href="<?php echo base_url().'rooms/'. $list->id?>"><img width="75" height="50" title="Test room" src="<?php echo base_url().'images/no_photos.png';?>" alt="Test room"><span><img width="216" height="144" title="Test room" src="<?php  echo base_url().'images/no_photos.png';?>" alt="Test room"></span></a>
			</td>
			<td class="main">
				<div class="first-line title"><a href="<?php echo base_url().'rooms/'. $list->id?>"><?php echo $list->title;?></a></div>
					<div><?php echo $list->address;?></div>
			</td>
			<td class="space">
				<div class="first-line">&nbsp;</div>
				<?php echo $list->room_type;?>
			</td>
			<td class="accommodates">
				<div class="first-line">&nbsp;</div>
				<?php echo $list->capacity;?>
			</td>
			<td class="reviews">
				<div class="first-line">&nbsp;</div>
					<div>
						<img src="http://s3.muscache.com/1300304855/images/icons/recommendation.png" alt="Recommendation">
						1 friend
					</div>
			</td>
			<td class="price"><?php echo '$'.$list->price;?></td>
		</tr>
		<? }
		}else{ echo translate("There is no List");}?>
</tbody></table>
              </div>
        <div class="BottomPannel">
        	<div class="clsBottom_Left">
            	<div class="clsBottom_Right">
                	<div class="clsBottom_Mid">
                    </div>
                </div>
            </div>
        </div>
        </div>  </div>
                <!--List-->
                
                
                <!--Recommendation-->
                 <div class="middle">
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
                	<div class="clsBoder3"><h1><?php echo translate("Recommendations"); ?></h1></div>

<table style="width:100%;" class="quotes" id="user_result_list">
    <tbody>
     <?php 
     
         $this->db->where("user_id",$user_id);
         $this->db->select();
         $result=$this->db->get("recommends");
         $query=$result->result();
      if(!empty($query))
	  {
         foreach($query as $row)
         {
    ?>	 	
    
    <tr>
        <td width="80">
            <div><a onclick="window.open(this.href);return false;" href="<?php base_url();?>"><img width="50" height="50" title="Mahes W" src="<?php echo $this->Gallery->profilepic($row->friend_id);  ?>" alt="Mahes W"></a></div>
            <div>
            <a target="blank" href="<?php echo base_url().'func/vouch?id='.$row->friend_id;?>"><?php echo $row->friend_name;?></a>
            [<a onclick="if (confirm('Are you sure that you want to delete that recommendation?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;f.submit(); };return false;" href="<?php echo base_url().'func/deleteRecommend?dlt='.$row->friend_id.'&id='.$user_id?>">X</a>]
        </td>
        <td>
            <div class="bubble">
                <div class="inner"><div class="content trans">
                    <?php echo $row->message;?>
                </div>
            </div>
                </td>
            </tr>
	<?php }
	 }else{ echo translate("There is no Recommend");}?>
</tbody></table>
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
                <!--Recommendation-->

        </div>
        <!-- /main -->
            <div class="clear"></div>
    </div><!-- /dashboard -->
</div><!-- /command_center -->