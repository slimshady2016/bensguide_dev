<?php
// INDEX PAGES
defined('_JEXEC') or die;
$app = JFactory::getApplication();

// Define Age of person
session_start();

// get url parameter to define Age value

if($_SESSION['Age']){
	$_SESSION['Age'] = $_SESSION['Age'];
	} else {
			$_SESSION['Age'] = 'ben4_8';
		}
// Define variables by age
	if ($_SESSION['Age'] == 'ben4_8'){
        
		$main_menu = '<jdoc:include type="modules" name="main-menu" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav" />';
	}
	if ($_SESSION['Age'] == 'ben9_13'){
		
		$main_menu = '<jdoc:include type="modules" name="main-menu9-13" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav9-13" />';
	}
	if ($_SESSION['Age'] == 'ben14more'){
		
		$main_menu = '<jdoc:include type="modules" name="main-menu14more" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav14more" />';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>

 <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <!-- Load Joomla system head -->
	<jdoc:include type="head" />

    <!--Load of CSS -->
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/general.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/minbutton.css" type="text/css" />
    <!-- Reset -->
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/skel-noscript.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles.css" type="text/css" />
            
    <!--Load of JS effects-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/fancybox/jquery.fancybox.js"></script>
    
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/minbutton.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <script><!--Renders HTML5 elements in IE8-->
            'article aside footer header nav section time'.replace(/\w+/g, function(n) { document.createElement(n) })
        </script>
         <script type="text/javascript">
		jQuery(document).ready(function() {
			// Get rid of border in links with images
        jQuery("img").parent().css( "border", "none" );
        
        		jQuery(document).ready(function()
			{
				jQuery('.hasPopover').popover({"html": true,"trigger": "hover focus","container": "body"});
			});
		});
		
        </script
	
    
	<script src="templates/bentest/js/minbutton.js"></script>
    
    <script src="templates/bentest/js/fancybox/jquery.fancybox.js"></script>
    
    <script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox({
				fitToView: false,
            autoSize: false,
            autoDimensions: false,
            width: 800,
            height: 600,
            title: 'Ben\'s Guides Games',
			 closeEffect : 'none',
				/*afterClose  : function() { 
					window.location.reload();
				},*/
            helpers: {
                title: {
                    type: 'float'
                },
            },
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
		});
		</script>
         <script type="text/javascript">
		$(document).ready(function() {
			// Get rid of border in links with images
        $( "img" ).parent().css( "border", "none" );
		});
        </script>
		
	      <!--[if lt IE 9]>
	<style>
    header, .mobileNav, #contentLayer, #minbutton{
    	display: none;
    }
    </style>
<![endif]-->
<script>
$(document).ready(function () {

    $('.fancybox').fancybox();

    $('a').on('click touchend', function (e) {
        var fancy = this.className.indexOf('fancybox') != -1;
        if (fancy) {
            $(this.className).trigger("click")
        } else {
            // var el = $(this); 
            // var link = el.attr('href'); // simply use this.href
            window.location = this.href;
            return false;
        }
    });
});
</script>
<style>
#content_noindex{background:fixed;top: 0px; bottom: 0px; width: 100%;height:auto;}
</style>
</head>
    
<body class="homepage  error-page" id="home">
<div id="fixedbg"></div> <!--Fixed background for ipad-->
    <!--This wrapping container is used to get the width of the whole content-->
    <div id="container">

        <!-- min Button-->
        <header>
            <div id="minbutton">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </header><!-- END min Button-->
        
        <!-- Menu mobile -->
        <nav class="mobileNav">
        <?php echo $mobile_menu ?>
        </nav>
        <div id="contentLayer"></div>
        <!-- END Menu mobile -->

    <!--The content of the site-->
    <div id="content">

            <div id="utility-wrapper">
                <!-- Header -->
                <div id="utility" class="container">
                    <!-- Nav -->
                    <div class="utility-nav-left">
                        <jdoc:include type="modules" name="top-nav-left" />
                    </div>
                    <div class="utility-nav-right">
                        <jdoc:include type="modules" name="top-nav-right" />
                    </div>
                </div>
            </div>

<!-- Header Wrapper -->
    <div id="header-wrapper">
        <!-- Header -->
        <div id="header" class="container">
            <!-- Logo -->
            <h1 id="logo"><a href="<?php echo $this->baseurl?>"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/ben-logo.png"/></a></h1>   
                     
            <!-- Nav -->
            <nav id="nav">
            <?php echo $main_menu ?>
            </nav>
            
        </div><!-- END  header-->
    </div><!-- END header-wrapper -->
     
        <!-- Features 1 -->
        <div class="container">
		 <div class="inner-text-wrapper"> 
                    
                    <div id="content">
                      <jdoc:include type="message" />
                      <jdoc:include type="component" />
                    </div>
                </div>	<!-- END inner-text-wrapper -->
            
           <div class="ben">
                       <img class="ben-avatar" src="<?php echo $this->baseurl?>/images/404.png" alt="" />
                    </div><!-- END ben -->
        </div><!-- END container -->
    </div><!-- END wrapper-noindex -->

			<!-- Footer Wrapper -->
            <div id="footer-wrapper">
                <!-- Footer -->
                    <div id="footer" class="container">
                        <div class="row">
                            <section class="12u">
                            <div class="row no-collapse-1 footer-text">
                                <div class="ftext">Let us know what you think about the new Ben's Guide!</div>
                                <div class="learn-more"><jdoc:include type="modules" name="learn-more" /></div>
                            </div>
                            </section>
                        </div>
                    </div> 
            </div><!-- END Footer Wrapper -->
		</div><!-- END content -->
    </div><!-- END container -->
	</body>
</html>
