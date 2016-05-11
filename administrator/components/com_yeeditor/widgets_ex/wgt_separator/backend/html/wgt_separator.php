<?php
/*------------------------------------------------------------------------
# yeeditor - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
$element_key=$item_params['element_key'];
$element_setting=$item_params['element_setting'];
$element_attribute=$item_params['element_attribute'];
$element_shortcode=$item_params['element_shortcode'];
?>
<h5 class="yee-wgt-heading-title"><?php echo $element_attribute['name'];?></h5>
<div class="yee-wgt-separator">
    <div class="yee-text-separator yee-content-element <?php echo $element_setting['assign']=='center'?'separator-align-center':($element_setting['assign']=='right'?'separator-align-right':'')?>">
        <div><?php echo $element_setting['title'];?></div>
    </div>
</div>
    
