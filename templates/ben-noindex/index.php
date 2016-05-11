<?php
// NOINDEX PAGES

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

 // Get category
	$db = &JFactory::getDBO(); 
    $id = JRequest::getString('id'); 
	$category  = NULL;
    $container_class="container about-content-container" ; 
	if(isset($id) && !is_null($id) && !empty($id) && $id != "" && $id != " "){
		$query = 'SELECT #__categories.title FROM #__content, #__categories WHERE #__content.catid = #__categories.id AND #__content.id = '.$id;
    	$db->setQuery($query); 
    	$category = $db->loadResult();
	}
	/* Categories: 	Age 4 to 8 - Age 9 to 13 - Age 14 & more - Libraries - Games - About Ben - Legal - Parents & Educators - Citizenship */
	 
	switch ($category) {
		// HOME
		case "Home":
			$locationhome = $this->baseurl;
			header('Location: '.$locationhome);
			break;
		// LIBRARIES
		case "Libraries":
			$side_menu = '<jdoc:include type="modules" name="libraries-side" />';
			$banner_title = '<div class="banner_title libraries"><img src="templates/bentest/images/libraries-title.png" />';
			$container_class="container about-content-container library-container" ;
			break;
		// ABOUT
		case "About Ben":
			$side_menu = '<jdoc:include type="modules" name="about-side" />';
			$banner_title =  '<div class="banner_title about"><img src="templates/bentest/images/about-title.png" />';
				$container_class="container about-content-container about-container" ;
			break;
		// GAMES
		case "Games":
			$side_menu = '<jdoc:include type="modules" name="games-side" />';
			$banner_title =  '<div class="banner_title games"><img src="templates/bentest/images/games-title.png" />';
				$container_class="container about-content-container games-container" ;
			break;
		// LEGAL
		case "Legal":
			$side_menu = '<jdoc:include type="modules" name="legal-side" />';
			$banner_title =  '<div class="banner_title about"><img src="templates/bentest/images/about-title.png" />';
			$container_class="container about-content-container legal-container" ;
			break;
		// PARENTS AND EDUCATORS
		case "Parents & Educators":
			$side_menu = '<jdoc:include type="modules" name="parents-side" />';
			$banner_title =  '<div class="banner_title parents"><img src="templates/bentest/images/parents-title.png" />';
			$container_class="container about-content-container parents-container" ;
			break;
		// CITIZENSHIP
		case "Citizenship":
			$side_menu = '<jdoc:include type="modules" name="citizenship-side" />';
			$banner_title =  '<div class="banner_title citizenship"><img src="templates/bentest/images/citizenship-title.png" />';
			$container_class="container about-content-container citizenship-container" ;
			break;
			
			 //Uncategorised
		case "Uncategorised":
			$side_menu = '';
			$banner_title =  '';
			break;
			
					
			
		// DEFAULT 
		default:
			$side_menu = '';
			$banner_title =  '<div class="banner_title about"><img src="templates/bentest/images/about-title.png" />';
	}
	?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>

<meta name="viewport" content="width=device-width,initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <!-- Load Joomla system head -->
	<jdoc:include type="head" />
  
    <!--Load of CSS -->
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/general.css" type="text/css" />
    <link rel="stylesheet" href="templates/bentest/css/minbutton.css" type="text/css" />
    <link rel="stylesheet" href="templates/bentest/js/fancybox/jquery.fancybox.css" type="text/css" />
    <!-- Reset -->
    <link rel="stylesheet" href="templates/bentest/css/skel-noscript.css" type="text/css" />
    <link rel="stylesheet" href="templates/bentest/css/styles.css" type="text/css" />
            

    <style type="text/css">  
    #pane { width: 60%; min-width:320px;}  
</style>
       <link rel="stylesheet" href="templates/bentest/scripts/rollbar/css/jquery.rollbar.css" media="screen" /> 
<script type="text/javascript" src="templates/bentest/scripts/rollbar/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="templates/bentest/scripts/rollbar/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="templates/bentest/scripts/rollbar/js/jquery.easing.1.3.js"></script> 
<script src="templates/bentest/js/Tocca.min.js"></script>

       <script type="text/javascript" src="templates/bentest/scripts/rollbar/js/jquery.rollbar.js"></script> 
			
	<script type="text/javascript">
        $(function(){
                var base = 'body';
                $('a[href^="#"]').each(function(){
                        var name = $(this).attr('href').substr(1);
                        var anchor = document.getElementById(name) || document.getElementsByName(name);
                        if(anchor = (anchor.item)?anchor.item(0):anchor){
                                var offset = $(base+' > .rollbar-content').height() - $(anchor).offset().top;
                                $(this).click(function(){
                                        $(base).trigger('rollbar',-offset);
                                });
                        }       
                });
        });
        
        
		
$(document).ready(function() {
  $('li a').click(function(){
     $(this).unbind("mouseenter mouseleave");
});
});
	</script>
	
	    <!--Load of JS effects-->
    <script type="text/javascript" src="templates/bentest/scripts/remove_hover_rule.js"></script> 
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="templates/bentest/js/minbutton.js"></script>
	
	    <!--Load of JS effects-->
  
   
        <!--[if lt IE 9]>
	<style>
    header, .mobileNav, #contentLayer, #minbutton{
    	display: none;
    }
    </style>
<![endif]-->

<script>
jQuery(document).ready(function () {

    jQuery('#pane').rollbar({scroll: 'vertical', zIndex:100});

   /*$('a').on('click touchend', function (e) {
        var pane = this.className.indexOf('pane') != -1;
        if (pane) {
            $(this.className).trigger("click")
        } else {
            // var el = $(this); 
            // var link = el.attr('href'); // simply use this.href
            window.location = this.href;
            return false;
        }
    }); */
    
    
   jQuery('a').bind('click touchstart tap', function(e) {
   //alert("touch");
      var el = jQuery(this);
      var link = el.attr('href');
      window.location = link;
   });
  
  
});
</script>

<style>
#content_noindex{background:fixed;top: 0px; bottom: 0px; width: 100%;height:auto;}

</style>

</head>
	<body class="inner">
<div id="fixedbgnoindex">
    </div> <!--Fixed background for ipad-->

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
    <div id="content_noindex">

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
            <h1 id="logo"><a href="<?php echo $this->baseurl?>"><img src="templates/bentest/images/ben-logo-2.png"/></a></h1>   
                     
            <!-- Nav -->
            <nav id="nav">
            <?php echo $main_menu ?>
            </nav>
            
        </div><!-- END  header-->
    </div><!-- END header-wrapper -->
     
        <!-- Features 1 -->
        <div class="wrapper-noindex">
        <?php 
		
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				$parsedurl = parse_url($url);
				
				if ($parsedurl['path'] == '/component/finder/search') {
					echo '<div class="banner_title search">';
					echo '<img src="templates/bentest/images/search-title.png" class="search" />';
            } else {
				
			 // Detect actual page to change top logo 
			 	
				$actualurl = $parsedurl['path'];
				
				if($actualurl =='/search') {
				echo '<div class="banner_title search"><img src="templates/bentest/images/search-title.png" />';	
				} else {  echo $banner_title; }
			}
		 ?>
            
        </div>
         <div class="<?php echo $container_class;?>" > 
            <div class="row">
                <nav id="left-nav"><?php echo $side_menu ?></nav>
			
                <!-- inner-text-wrapper -->
                <div id="pane" class="inner-text-wrapper"  <?php if($category == 'Uncategorised') echo ' style="background: none !important ; min-width:980px !important; padding-top : 20px; margin-top:-380px;  margin-left: auto; margin-right:auto "'  ;    ?> >
                    
                    <div id="content">
                      <jdoc:include type="message" />
                      <jdoc:include type="component" />
                    </div>
                </div>	<!-- END inner-text-wrapper -->
                </div><!-- END row -->
        </div><!-- END container about-content-container -->
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
