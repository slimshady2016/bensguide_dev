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
 
 
class AjaxquizControllerCategories extends JControllerAdmin
{


	protected $text_prefix = 'COM_AJAXQUIZ_CATEGORIES';
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function __construct($config = array())
        {
                parent::__construct($config);
				if($btn == 'backup'){
				
				
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
                JFactory::getApplication()->enqueueMessage(JText::_('Please Select Table'));
                return false;                
                }         
			}

        }

	public function getModel($name = 'Category', $prefix = 'AjaxquizModel',$config = array('ignore_request' => true)) 
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	public function saveOrderAjax()
        {
                $pks = $this->input->post->get('cid', array(), 'array');
                $order = $this->input->post->get('order', array(), 'array');

                // Sanitize the input
                JArrayHelper::toInteger($pks);
                JArrayHelper::toInteger($order);

                // Get the model
                $model = $this->getModel();

                // Save the ordering
                $return = $model->saveorder($pks, $order);

                if ($return)
                {
                        echo "1";
                }

                // Close the application
                JFactory::getApplication()->close();
        }


}
