<?php

// LEARNING 
defined('_JEXEC') or die;
$app = JFactory::getApplication();

session_start();

	//Get Article title
	$article =& JFactory::getDocument();
	$articletitle =  $article->getTitle();

 // Get category
	$db = &JFactory::getDBO(); 
    $id = JRequest::getString('id'); 
    $db->setQuery('SELECT #__categories.title FROM #__content, #__categories WHERE #__content.catid = #__categories.id AND #__content.id = '.$id); 
    $category = $db->loadResult();
	/* Categories: 	Age 4 to 8 - Age 9 to 13 - Age 14 & more - Libraries - Games - About Ben - Legal - Parents & Educators - Citizenship */

	switch ($category) {
				 // HOME
				case "Home":
					include('home.php');
					break;
				// LIBRARIES
				case "Libraries":
					include('indexc.php');
					break;
				// ABOUT
				case "About Ben":
					include('indexc.php');
					break;
				// GAMES
				case "Games":
					include('indexc.php');
					break;
				// LEGAL
				case "Legal":
					include('indexc.php');
					break;
				// PARENTS AND EDUCATORS
				case "Parents & Educators":
					include('indexc.php');
					break;
				// CITIZENSHIP
				case "Citizenship":
					include('indexc.php');
					break;
				// LEARNING ADVENTURES
				case "menu Learning Adventures":
					include('indexd.php');
					break;
				case "Age 4 to 8":
					include('indexd.php');
					break;
				case "Age 9 to 13":
					include('indexd.php');
					break;
				case "Age 14 & more":
					include('indexd.php');
					break;
					// DEFAULT
				default:
					include('home.php');
				}
	?>