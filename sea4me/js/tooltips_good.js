/* initialize every <a> tag on the page with class="tooltip" */
this.tooltip = function(){  
    /* CONFIG */
        xOffset = 20;
        yOffset = 20;
        // these 2 variable determine popup's distance from the cursor
        // you might want to adjust to get the right result
    /* END CONFIG */
    jQuery("a.tooltip").hover(function(e){
        this.t = this.title;
        this.title = "";
        jQuery("body").append("<p id='tooltip'>"+ this.t.replace(/\n/g, '<br />') +"</p>");
        jQuery("#tooltip")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px")
            .fadeIn("fast");
    },
    function(){
        this.title = this.t;
        jQuery("#tooltip").remove();
    }); 
    jQuery("a.tooltip").mousemove(function(e){
        jQuery("#tooltip").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px");
    });
};

// starting the script on page load
jQuery(document).ready(function(){
    tooltip();
});