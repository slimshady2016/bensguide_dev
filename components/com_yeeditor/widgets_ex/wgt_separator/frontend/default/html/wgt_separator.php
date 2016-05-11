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

$element_setting = $item_params['element_setting'];
$style = get_widget_frontend_style($element_setting);

?>
<div class="yee-widget yee-wgt-separator yee-text-separator yee-content-element<?php echo $element_setting['assign']=='center'?' separator-align-center':($element_setting['assign']=='right'?' separator-align-right':'')?><?php if($element_setting['ex_class']){?><?php echo ' '.$element_setting['ex_class'];?><?php }?>" 
    <?php if($style){?>style="<?php echo $style?>"<?php }?> >
		<?php if($element_setting['title']){?>
		<div <?php if($element_setting['fontsize']){?>style="font-size:<?php echo $element_setting['fontsize'];?>px;"<?php }?>><?php echo $element_setting['title'];?></div>
		<?php }?>
</div>