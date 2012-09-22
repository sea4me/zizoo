<style type="text/css">

    /*Credits: Dynamic Drive CSS Library */
    /*URL: http://www.dynamicdrive.com/style/ */
    .suckerdiv{
        padding:3.8em 1.5em 0 0;
        width:190px;
    }
    .suckerdiv ul{
        margin: 0;
        padding: 0;
        list-style-type: none;
        width: 190px; /* Width of Menu Items */
        border-bottom: 1px solid #ccc;
        text-align:left;
    }
    .suckerdiv ul li{
        position: relative;
    }
    /*Sub level menu items */
    .suckerdiv ul li ul{
        position: absolute;
        width: 170px; /*sub menu width*/
        top: 0;
        visibility: hidden;
    }

    /* Sub level menu links style */
    .suckerdiv ul li a{
        display: block;
        overflow: auto; /*force hasLayout in IE7 */
        color: black;
        text-decoration: none;
        background:#ccc;
        padding: 5px 5px;
        border: 1px solid #999;
        border-bottom: 0;

        color:#000;
    }

    .suckerdiv ul li a:visited{
        color: black;
    }

    .suckerdiv ul li a:hover{
        background-color: #000;
        color:#fff;
    }

    .suckerdiv .subfolderstyle{
        background: url(<?php echo base_url() . '/css/images/arrow-list.gif'; ?>) no-repeat center right;
        background-color:#ccc;
    }


    /* Holly Hack for IE \*/
    * html .suckerdiv ul li { float: left; height: 1%; }
    * html .suckerdiv ul li a { height: 1%; }
    /* End */

</style>
<script type="text/javascript">

    //SuckerTree Vertical Menu 1.1 (Nov 8th, 06)
    //By Dynamic Drive: http://www.dynamicdrive.com/style/

    var menuids=["suckertree1"] //Enter id(s) of SuckerTree UL menus, separated by commas

    function buildsubmenus(){
        for (var i=0; i<menuids.length; i++){
            var ultags=document.getElementById(menuids[i]).getElementsByTagName("ul")
            for (var t=0; t<ultags.length; t++){
                ultags[t].parentNode.getElementsByTagName("a")[0].className="subfolderstyle"
                if (ultags[t].parentNode.parentNode.id==menuids[i]) //if this is a first level submenu
                    ultags[t].style.left=ultags[t].parentNode.offsetWidth+"px" //dynamically position first level submenus to be width of main menu item
                else //else if this is a sub level submenu (ul)
                    ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
                ultags[t].parentNode.onmouseover=function(){
                    this.getElementsByTagName("ul")[0].style.display="block"
                }
                ultags[t].parentNode.onmouseout=function(){
                    this.getElementsByTagName("ul")[0].style.display="none"
                }
            }
            for (var t=ultags.length-1; t>-1; t--){ //loop through all sub menus again, and use "display:none" to hide menus (to prevent possible page scrollbars
                ultags[t].style.visibility="visible"
                ultags[t].style.display="none"
            }
        }
    }

    if (window.addEventListener)
        window.addEventListener("load", buildsubmenus, false)
    else if (window.attachEvent)
        window.attachEvent("onload", buildsubmenus)

</script>
<div id="sideBar">
    <div class="sideBar1 clsFloatLeft">
        <div class="suckerdiv">
            <ul id="suckertree1">
                <li><a href="<?php echo admin_url('backend'); ?>"><?php echo translate_admin('Dashboard'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo translate_admin('Site Settings'); ?></a>
                    <ul>
                        <li><a href="<?php echo admin_url('settings'); ?>"><?php echo translate_admin('Global Settings'); ?></a></li>

                        <li><a href="<?php echo admin_url('settings/manage_meta'); ?>"><?php echo translate_admin('Manage Meta'); ?></a></li>
                        <li><a href="<?php echo admin_url('settings/change_password'); ?>"><?php echo translate_admin('Change Password'); ?></a></li>
                        <li><a href="<?php echo admin_url('settings/how_it_works'); ?>"><?php echo translate_admin('How It Works'); ?></a></li>
                    </ul>
                </li>

                <li><a href="<?php echo admin_url('backend/users'); ?>"><?php echo translate_admin('Member Management'); ?></a></li>
                <li><a href="<?php echo admin_url('backend/lists'); ?>"><?php echo translate_admin('User Listing Management'); ?></a></li>
                <li><a href="<?php echo admin_url('payment/finance'); ?>"><?php echo translate_admin('Finance'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo translate_admin('Payment Settings'); ?></a>
                    <ul>
                        <li><a href="javascript:void(0);"><?php echo translate_admin('Payment Gateway'); ?></a>
                            <ul>
                                <li><a href="<?php echo admin_url('payment'); ?>"><?php echo translate_admin('Add Pay Gateway'); ?></a></li>
                                <li><a href="<?php echo admin_url('payment/manage_gateway'); ?>"><?php echo translate_admin('Manage Pay Gateway'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo admin_url('payment/paymode'); ?>"><?php echo translate_admin('Commission Setup'); ?></a></li>
                    </ul>
                </li>
                <li><a href="<?php echo admin_url('social/fb_settings'); ?>"><?php echo translate_admin('Facebook Connect'); ?></a></li>
                <li><a href="<?php echo admin_url('social/google_settings'); ?>"><?php echo translate_admin('Google Maps'); ?></a></li>

                <li><a href="<?php echo admin_url('page/viewPages'); ?>"><?php echo translate_admin('Manage Static Pages'); ?></a></li>

                <li><a href="<?php echo admin_url('contact'); ?>"><?php echo translate_admin('Manage Contact'); ?></a></li>
            </ul>
        </div> 
    </div>
</div>