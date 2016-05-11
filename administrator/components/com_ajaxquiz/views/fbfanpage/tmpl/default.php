<?php

/*------------------------------------------------------------------------
# component_Ajax_quiz - Ajax Quiz 
# ------------------------------------------------------------------------
# author    WebKul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.webkul.com
# Technical Support:  Forum - http://www.webkul.com/index.php?Itemid=86&option=com_kunena
-----------------------------------------------------------------------*/
 


defined('_JEXEC') or die('Restricted access');
jimport('joomla.environment.uri' );
$host = JURI::root();
$document =& JFactory::getDocument();
$document->addStyleSheet($host.'administrator/components/com_ajaxquiz/assets/fbfanpage.css');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('behavior.modal');
JHtml::_('formbehavior.chosen', 'select');

?>
<form action="<?php echo JRoute::_($host.'index.php?option=com_ajaxquiz&view=fbfanpage'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	
	<!--CODE-->
	
	<div style="margin:0 0 0 10px; padding: 0 10px 10px 10px;width:98%;float:left;">
    <h2><?php echo JText::_("FB_APP");?></h2>
    <div style="float:left;width:40%;">
        <fieldset style="padding:5px">
            <legend><?php echo JText::_("CI");?></legend>
            <?php
			
            if ($this->appProps)
            {
            ?>
                <div>
                    <div style="float:left;width:100px">
                    <?php
                    if ($this->appProps['logo_url'] != "")
                    {
                        echo '<img src="' . $this->appProps['logo_url'] . '" />';
                    }
                    else
                    {	
						echo JText::_("NO_APPLICATION_LOGO_SET");
                        //echo "No Application Logo Set";
                    }
                    ?>
                </div>
                <div style="float:left;">
                    <?php
                    if($this->appProps['id'])
                    { ?>
                        <p style="margin:0 0 5px 0;"><b><?php echo JText::_("AN" );?></b><?php echo $this->appProps['name']; ?></p>
                    <?php }
                    else
                    { ?>
                        <p style="margin:0 0 5px 0;"><b><?php echo JText::_("AN" );?><span style="color:#FF0000"><?php echo JText::_("APP_ID_NOT_SET");?></span></b></p>
                    <?php } ?>
                    <p style="margin:0 0 5px 0;"><b><?php echo JText::_("SITE_URL");?> </b><?php echo $this->appProps['website_url']; ?></p>
                    <p style="margin:0 0 5px 0;"><b><?php echo JText::_("SITE_DOMAIN");?>
					<?php 
					if($this->appProps['app_domains']){
					$domains = $this->appProps['app_domains']; 
					foreach($domains as $appd) {
					echo $appd;					
					}					
					}
					?></b></p>
                    <?php
                    $joomlaUrl = JURI::root();
					if ($this->appProps['website_url'] == "" || strpos($joomlaUrl, $this->appProps['website_url']) !== 0)
                        {
                            print "<b style=\"color:#FF1410\">\n";
                            print "<b>".JText::_('WARNING_POSSIBLE_MISCONFIGURATION')."</b><br/>".JText::_('WE_SUGGEST'). $joomlaUrl . "<br />\n";
                            print "".JText::_('VISITING')."<a target=\"_blank\" href=\"http://www.facebook.com/developers/\">".JText::_('FD')."</a><br />\n";
                            print "".JText::_('SELECT_Y_APP')." -> ".JText::_('EDIT_SETT')."<br/>\n";
                            print "".JText::_('SHOULD_CONFIGURE')."<br />\n";
                            print "</b><br/>";
                      }
                    ?>
                </div>
            </div>
            <?php
                }
                else
                {
            ?>
                    <center><b style="color:#FF1410"><?php echo JText::_('CHECK_FB');?></b><br/>
                      </center>
            <?php
                }
            ?>
            </fieldset>
			
        </div>

<div style="float:right; width:60%;">

	<fieldset style="padding:5px">
	
      <legend><?php echo JText::_('OI');?></legend><?php echo JText::_('YPT');?>
	  
	    

    <a href="https://www.facebook.com/dialog/pagetab?app_id=<?php echo $this->appProps['id'] ?>&display=popup&next=<?php echo $this->appProps['website_url'] ?>" target="_BLANK"><?php echo JText::_('CH');?></a>
	
	 <div style="clear:both;margin:10px 0;"></div>

    <div class="config_row">

        <div class="config_setting header"><?php echo JText::_('AS');?></div>

        <div class="config_option header"><?php echo JText::_('CS');?></div>

        <div class="config_description header"><?php echo JText::_('DESCRIP');?></div>

        <div style="clear: both; margin-bottom: 10px;"></div>

        <div><?php echo JText::_('YCCTSIY');?>

            <b>

            <a target="_BLANK" href="https://developers.facebook.com/apps/<?php echo $this->appProps['id'] ?>/fb-apps">

               <?php echo JText::_('FACSA');?></a>

            </b>

        </div>

    </div>

    <div class="config_row">

        <div class="config_setting"><?php echo JText::_('TN');?></div>

        <div class="config_option"><?php //echo $this->appProps['page_tab_default_name']; ?><!--edit because there is undefined error by set max  -->

        </div>

        <div class="config_description hasTip"

             title="This is the default name of the tab when added to a Facebook Page"><?php echo JText::_('INFO');?>

        </div>

        <div style="clear:both"></div>

    </div>

    <div class="config_row">

        <div class="config_setting"><?php echo JText::_('TPU');?></div>
		

        <div class="config_option"><?php echo $this->appProps['page_tab_url']; ?>

        </div>

        <div class="config_description hasTip"

             title="This is the URL that will initially be shown in the Facebook Page.<br/><br/>

                    Note: If a Reveal Page article ID is specified above, this URL will only be shown after the

                    Facebook Page has been Like'd by the user."><?php echo JText::_('INFO');?>

        </div>

        <div style="clear:both"></div>

    </div>

    <div class="config_row">

        <div class="config_setting"><?php echo JText::_('STPU');?></div>

        <div class="config_option"><?php echo $this->appProps['secure_page_tab_url']; ?>

        </div>

        <div class="config_description hasTip"

             title="This is the secure (https) URL that will initially be shown in the Facebook Page

                    Tab when a secure connection is requested.<br/><br/>

                    This value will be required by Facebook as of October 1st, 2011."><?php echo JText::_('INFO');?>

        </div>

        <div style="clear:both"></div>

    </div>

</div>

 </fieldset>


</div>



	<input type="hidden" name="option" value="com_ajaxquiz" />


	<?php echo JHTML::_( 'form.token' ); ?>

	
	
	<!--CODE-->
	



<?php else : ?>
	<div id="j-main-container">
<?php endif;?>			
		</div>					
		</table>		
	</div>	
</form>









