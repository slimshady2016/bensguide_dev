<?php
defined('_JEXEC') or die;
$app = JFactory::getApplication();

// Define Age of person
session_start();

// get url parameter to define Age value

if($_SESSION['Age']){
	$_SESSION['Age'] = $_SESSION['Age'];
	} else {
			$_SESSION['Age'] = 'bentest4_8';
		}
// Define variables by age
	if ($_SESSION['Age'] == 'bentest4_8'){
        
		$main_menu = '<jdoc:include type="modules" name="main-menu" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav" />';
	}
	if ($_SESSION['Age'] == 'bentest9_13'){
		
		$main_menu = '<jdoc:include type="modules" name="main-menu9-13" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav9-13" />';
	}
	if ($_SESSION['Age'] == 'bentest14more'){
		
		$main_menu = '<jdoc:include type="modules" name="main-menu14more" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav14more" />';
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" style="border: 0;
font-family: inherit;
font-size: 100%;
font-style: inherit;
font-weight: inherit;
margin: 0;
outline: 0;
padding: 0;
vertical-align: baseline;display: block; height: 100px; overflow: scroll;" >
<head>
	<!-- METAS -->
 	<meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <!-- Load Joomla system head -->
	<jdoc:include type="head" />

    <!--Load of CSS -->
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/general.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/minbutton123.css" type="text/css" />
    <!-- Reset -->
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/skel-noscript123.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles123.css" type="text/css" />
    <style>
    /* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}</style>
            
    <!--Load of JS effects-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/minbutton.js"></script>
    
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
</head>

<body class="homepage" id="home" style="display: block; line-height: 1.8em;
margin: 0;
padding: 0;
height: 100px; overflow-x: hidden !important;
overflow-y: hidden !important;">
<div id="fixedbg">
    </div> <!--Fixed background for ipad-->
    <!--This wrapping container is used to get the width of the whole content-->
    <div id="container" style="display: block; height: 100%;">

        <!-- min Button-->
          <!-- Menu mobile -->
        <nav class="mobileNav" style="display: block; left: 0px;
position: absolute;
width: 70%; background: #3E3C3D;
background: -moz-linear-gradient(top, #3e3c3d 0%, #2d2c2d 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3E3C3D), color-stop(100%,#2D2C2D));
background: -webkit-linear-gradient(top, #3E3C3D 0%,#2D2C2D 100%);
background: -o-linear-gradient(top, #3e3c3d 0%,#2d2c2d 100%);
background: -ms-linear-gradient(top, #3e3c3d 0%,#2d2c2d 100%);
background: linear-gradient(to bottom, #3E3C3D 0%,#2D2C2D 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3e3c3d', endColorstr='#2d2c2d',GradientType=0 );
height:auto%;
-webkit-overflow-scrolling: touch;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
overflow: hidden !Important;">
        <?php echo $mobile_menu ?>
            <!--<jdoc:include type="modules" name="mobileNav" />-->
        </nav>
        <header style="position: fixed;
z-index: 2;
width: 100%;display: block;margin: 0;
padding: 0;">
            <div id="minbutton" style="border: 1px solid #2CA1CC;
border-radius: 3px 3px 3px 3px;
cursor: pointer;
display: block;
height: 24px;
padding: 3px 4px 3px;
position: relative;
top: 9px;
left: 4%;
width: 25px;
background: #57BFE5;
background: -moz-linear-gradient(top, #57bfe5 0%, #32b4e6 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#57BFE5), color-stop(100%,#32B4E6));
background: -webkit-linear-gradient(top, #57BFE5 0%,#32B4E6 100%);
background: -o-linear-gradient(top, #57bfe5 0%,#32b4e6 100%);
background: -ms-linear-gradient(top, #57bfe5 0%,#32b4e6 100%);
background: linear-gradient(to bottom, #57BFE5 0%,#32B4E6 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#57bfe5', endColorstr='#32b4e6',GradientType=0 );">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </header><!-- END min Button-->
        
        <div id="contentLayer" style="display: block; height: 100%;"></div>
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
                    <h1 id="logo">
                    	<jdoc:include type="modules" name="main-logo" />
                    </h1>
                    
                    <!-- Nav -->
                    <nav id="nav">
                    <?php echo $main_menu ?>
                    	<!--<jdoc:include type="modules" name="main-menu" />-->
                    </nav>
                </div><!-- END Header -->
                
            </div><!-- END Header Wrapper -->
                
            <!-- Features 1 -->
            <div class="wrapper">
            
                <div class="container">
                	<jdoc:include type="component" />
                    <div class="ben">
                        <div class="row badge">
                        	<a href="arlington-adventures?age=bentest4_8"><img src="templates/bentest/images/appenties.png" alt="" /></a><br />
                            <a href="arlington-national-cemetery-9-13?age=bentest9_13"><img src="templates/bentest/images/journeyman.png" alt="" /></a><br />
                            <a href="arlington-national-cemetery-14more?age=bentest14more"><img src="templates/bentest/images/master.png" alt="" /></a>
                        </div>
                        <img class="ben-avatar" src="templates/bentest/images/ben.png" alt="" />
                    </div><!-- END ben -->
                </div><!-- END Container -->
                
            </div><!-- END Wrapper -->
    
            <!-- Footer Wrapper -->
            <div id="footer-wrapper">
            
                <!-- Footer -->
                <div id="footer" class="container">
                    <div class="row">
                        <section class="12u">
                            <div class="row no-collapse-1 footer-text">
                                <div class="ftext">Hey kids, we just added new Learning Adventures!</div>
                                <div class="learn-more">
                                	<jdoc:include type="modules" name="learn-more" />
                                </div>
                            </div>
                        </section>
                    </div>
                </div><!-- END Footer -->
                
            </div><!-- END Footer Wrapper -->
            
        </div><!-- END  content-->
        
    </div><!-- END container -->
</body>  
</html>