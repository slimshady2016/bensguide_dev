/**
 * Mobile Menu
 * ===========
 * Created by Thomas Zinnbauer YMC AG  |  http://www.ymc.ch
 * Date: 21.05.13
 */
/* For index page */
jQuery(document).ready(function() {
	jQuery('.mobileNav').css('display', 'none');
    //Open the menu
    jQuery("#minbutton").click(function() {			
			
        //set the width of primary content container -> content should not scale while animating
        var contentWidth = jQuery('#content').width();

        //set the content with the width that it has originally
        jQuery('#content').css('width', contentWidth);

        //display a layer to disable clicking and scrolling on the content while menu is shown
        jQuery('#contentLayer').css('display', 'block');
		jQuery('.mobileNav').css('display', 'block');
		//jQuery('header').css('z-index', '999');
        //disable all scrolling on mobile devices while menu is shown
        //jQuery('#container').bind('touchmove', function(e){e.preventDefault()});
		
		//Put navigation mobile on top
		jQuery('.mobileNav').css('z-index', '9999');
		
        //set margin for the whole container with a jquery UI animation
        jQuery("#container").animate({"marginLeft": ["70%", 'easeOutExpo']}, {
            duration: 700
        });

    });

    //close the menu
    jQuery("#contentLayer").click(function() {
        //enable all scrolling on mobile devices when menu is closed
        jQuery('#container').unbind('touchmove');
		
		// Mobile nav to back layer
		jQuery('.mobileNav').css('z-index', '0');
		jQuery('.mobileNav').css('display', 'none');
		jQuery('header').css('z-index', '1');
        //set margin for the whole container back to original state with a jquery UI animation
        jQuery("#container").animate({"marginLeft": ["0", 'easeOutExpo']}, {
            duration: 700,
            complete: function() {
                  jQuery('#content').css('width', 'auto');
                jQuery('#contentLayer').css('display', 'none');

            }
        });
    });

});