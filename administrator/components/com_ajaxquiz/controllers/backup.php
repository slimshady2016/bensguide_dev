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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
//echo "controller";
//exit();
/**
 * Ajaxquiz Component Categories Controller
 *
 * @package Joomla
 * @subpackage EventList
 * @since 0.9
 */
 class AjaxquizControllerBackup extends JControllerAdmin
{
    function __construct()
    {
        parent::__construct();        
        $btn = JRequest::setVar( 'export_btn' );        
        $option = JRequest::setVar( 'export_option' );                
        if($btn == 'backup'){
				//echo "controller";
                if($option == 'category'){        
                  $model = $this->getModel('export');        
                  $model->cat_export();                  
                  }                 
                 if($option == 'question'){        
                  $model = $this->getModel('export');        
                  $model->ques_export();                  
                  }                  
                 if($option == 'answer'){        
                  $model = $this->getModel('export');        
                  $model->ans_export();                  
                  }                    
                  if($option == 'result'){        
                  $model = $this->getModel('export');        
                  $model->rst_export();                  
                  }                   
                if($option == '0'){  
				$this->setRedirect( 'index.php?option=com_ajaxquiz&view=backup', JText::_("PLEASE_SELECT_TABLE") );				
                //JFactory::getApplication()->enqueueMessage(JText::_('Please Select Table'));
                return false;                
                }         
        }
                
    
        $del_btn = JRequest::setVar( 'delete_btn' );        
        if($del_btn == 'delete'){        
                    $model = $this->getModel('export');            
                     $model->delete();  
		 $this->setRedirect( 'index.php?option=com_ajaxquiz&view=backup', JText::_("ALL_DATA_DELETED") );
        
        }
    }
	
}
?>