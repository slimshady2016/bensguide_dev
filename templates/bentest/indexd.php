<?php

// LEARNING 
defined('_JEXEC') or die;
$app = JFactory::getApplication();

// Define Age of person
session_start();

// get url parameter to define Age value

if($_GET['age']){
	$_SESSION['Age'] = $_GET['age'];
	} else {
		if(!$_SESSION['Age']) {
			$_SESSION['Age'] = 'ben4_8';
			}
		}
// Define variables by age
switch($_SESSION['Age']) {
	
	case 'ben4_8':
		$mainlogo48='first';
		$mainlogo913='third';
		$mainlogo14='third';
        
		$learning_menu = '<jdoc:include type="modules" name="learning-menu" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav" />';
		break;
		
	case 'ben9_13':
		$mainlogo48='third';
		$mainlogo913='first';
		$mainlogo14='third';
        
		$learning_menu = '<jdoc:include type="modules" name="learning-menu9-13" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu9-13" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav9-13" />';
		break;
	case 'ben14more':
		$mainlogo48='third';
		$mainlogo913='third';
		$mainlogo14='first';
        
		$learning_menu = '<jdoc:include type="modules" name="learning-menu14more" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu14more" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav14more" />';
		break;
	default:
		$mainlogo48='first';
		$mainlogo913='third';
		$mainlogo14='third';
        
		$learning_menu = '<jdoc:include type="modules" name="learning-menu" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav" />';
}
	/*if ($_SESSION['Age'] == 'ben4_8'){
		$mainlogo48='first';
		$mainlogo913='third';
		$mainlogo14='third';
        
		$learning_menu = '<jdoc:include type="modules" name="learning-menu" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav" />';
	}
	if ($_SESSION['Age'] == 'ben9_13'){
		$mainlogo48='third';
		$mainlogo913='first';
		$mainlogo14='third';
		
		$learning_menu = '<jdoc:include type="modules" name="learning-menu9-13" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu9-13" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav9-13" />';
	}
	if ($_SESSION['Age'] == 'ben14more'){
		$mainlogo48='third';
		$mainlogo913='third';
		$mainlogo14='first';
		
		$learning_menu = '<jdoc:include type="modules" name="learning-menu14more" />';
		$main_menu = '<jdoc:include type="modules" name="main-menu14more" />';
		$mobile_menu = '<jdoc:include type="modules" name="mobileNav14more" />';
	}*/
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>

 <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <!-- Load Joomla system head -->
	<jdoc:include type="head" />

    <!--Load of CSS -->
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl?>/templates/system/css/general.css" type="text/css" />
    <link rel="stylesheet" href="/templates/ben-noindex/css/minbutton.css" type="text/css" />
    <!-- Reset -->
    <link rel="stylesheet" href="/templates/ben-noindex/css/skel-noscript.css" type="text/css" />
    <link rel="stylesheet" href="/templates/bentest/css/styles.css" type="text/css" />
            
    <!--Load of JS effects-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/templates/bentest/js/minbutton.js"></script>
    
</head>
	<body class="about inner">
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
            <h1 id="logo"><a href="<?php echo $this->baseurl?>"><img src="/templates/bentest/images/ben-logo-2.png"/></a></h1>
            
            <!-- Nav -->
            <!-- Nav -->
            <nav id="nav" class="learning">
            <?php echo $main_menu ?>
            </nav>
        </div><!-- END  header-->
    </div><!-- END header-wrapper -->
     
        <!-- Features 1 -->
        <div class="wrapper-noindex">
        <div class="banner_title">
                            <?php    // echo $category.'<br />'.$articletitle;?>

        <?php 
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				$parsedurl = parse_url($url);
				
				if ($parsedurl['path'] == '/index.php/component/finder/search') {
			echo '<img src="/templates/bentest/images/search-title.png" />';
            } else { echo '<img src="/templates/bentest/images/learning-title.png" class="search" />'; }
		?>
            
        </div>
        <div class="container about-content-container">
            <div class="row">
                <nav id="left-nav">
                <?php if ($parsedurl['path'] == '/index.php/component/finder/search') {
			echo '';
            } else { echo $learning_menu; }
		?>
                </nav>
			
                <!-- inner-text-wrapper -->
                <div class="inner-text-wrapper">
                    
                    <div id="content">
                      <jdoc:include type="message" />
                      <jdoc:include type="component" />
                    </div>
                    <?php if ($parsedurl['path'] == '/index.php/component/finder/search') {
			echo '';
            } else { ?>
                    
                        <jdoc:include type="modules" name="badge-menu" />
					<?php }	?>
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
                                <div class="ftext">Hey kids, we just added new Learning Adventures!</div>
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
