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



defined('JPATH_BASE') or die();



jimport('joomla.form.helper');

JFormHelper::loadFieldClass('list');



class JFormFieldCategory extends JFormFieldList {

	protected $type = 'Category'; //the form field type

    var $options = array();

    protected function getInput() {

		// Initialize variables.

		$html = array();

		$attr = '';

		// Initialize some field attributes.

		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".

		if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {

			$attr .= ' disabled="disabled"';

		}

		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';

		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		// Initialize JavaScript field attributes.

		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		// Get the field options.

		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with a hidden input to store the value.

		if ((string) $this->element['readonly'] == 'true') {

			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);

			$html[] = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"/>';

		}

		// Create a regular list.

		else {

		    if($options){

				$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);

            } else {

               return '<select id="jform_params_k2_categories"><option>No Quiz Found.</option></select>';

            }

		}

		

		return implode($html);

	}

    protected function getOptions() {

        // Initialize variables.

        $session = JFactory::getSession();

        $attr = '';

        // Initialize some field attributes.

        $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';

        // To avoid user's confusion, readonly="true" should imply disabled="true".

        if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {

            $attr .= ' disabled="disabled"';

        }

        $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';

        $attr .= $this->multiple ? ' multiple="multiple"' : '';

        // Initialize JavaScript field attributes.

        $attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

        $db = JFactory::getDBO();

        // generating query

		$db->setQuery("SELECT c.id AS id, c.title AS title FROM #__ajaxquiz_category AS c WHERE published = 1");

 		// getting results

   		$results = $db->loadObjectList();

   		

		if(count($results)){

  	     	// iterating

			$temp_options = array();

			

			foreach ($results as $item) {

				array_push($temp_options, array($item->id, $item->title, ''));	

			}

			foreach ($temp_options as $option) {

        		if($option[2] == 0) {

        	    	$this->options[] = JHtml::_('select.option', $option[0], $option[1]);

        	    	$this->recursive_options($temp_options, 1, $option[0]);

        	    }

        	}		

            return $this->options;

		} else {	

            return $this->options;

		}

	}

 	// bind function to save

    function bind( $array, $ignore = '' ) {

        if (key_exists( 'field-name', $array ) && is_array( $array['field-name'] )) {

        	$array['field-name'] = implode( ',', $array['field-name'] );

        }

        

        return parent::bind( $array, $ignore );

    }

    function recursive_options($temp_options, $level, $parent){

		foreach ($temp_options as $option) {

      		if($option[2] == $parent) {

		  		$level_string = '';

		  		for($i = 0; $i < $level; $i++) $level_string .= '- - ';

        	    $this->options[] = JHtml::_('select.option',  $option[0], $level_string . $option[1]);

       	    	$this->recursive_options($temp_options, $level+1, $option[0]);
			}
       	}
    }
}