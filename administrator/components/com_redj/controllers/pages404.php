<?php
/**
 * ReDJ Enterprise component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package ReDJ
 * @copyright Copyright 2009 - 2014
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.8
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * ReDJ Controller Pages 404
 *
 * @package ReDJ
 *
 */
class ReDJControllerPages404 extends JControllerAdmin
{
    public function __construct($config = array())
    {
        parent::__construct($config);

        // Register Extra tasks
        $this->registerTask('copy', 'copy');
    }

    public function copy()
    {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $cid = $this->input->post->get( 'cid', array(), 'array' );
        JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_redj/tables');
        $table =& JTable::getInstance('Page404', 'ReDJTable');
        $n = count( $cid );

        if ($n > 0)
        {
          $i = 0;
          foreach ($cid as $id)
          {
            if ($table->load( (int)$id ))
            {
              $table->id            = 0;
              $table->title         = JText::_('COM_REDJ_COPY_OF') . $table->title;
              $table->hits          = 0;
              $table->checked_out   = false;

              if ($table->store()) {
                $i++;
              } else {
                JFactory::getApplication()->enqueueMessage( JText::sprintf('COM_REDJ_COPY_ERROR_SAVING', $id, $table->getError()), 'error' );
              }
            }
            else {
              JFactory::getApplication()->enqueueMessage( JText::sprintf('COM_REDJ_COPY_ERROR_LOADING', $id, $table->getError()), 'error' );
            }
          }
        }
        else {
          return JError::raiseWarning( 500, JText::_('COM_REDJ_COPY_ERROR_NO_SELECTION') );
        }

        $this->setMessage( JText::sprintf('COM_REDJ_COPY_OK', $i) );

        $this->setRedirect( 'index.php?option=com_redj&view=pages404' );
    }

    public function resetstats()
    {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $model = $this->getModel('page404');
        if(!$model->resetstats()) {
          $message = JText::sprintf('COM_REDJ_ERROR_RESETSTATS_FAILED', $model->getError());
          $this->setRedirect(JRoute::_('index.php?option=com_redj&view=pages404', false), $message, 'error');
        } else {
          $this->setRedirect( 'index.php?option=com_redj&view=pages404' );
        }
    }

    /**
     * Proxy for getModel
     */
    public function getModel($name = 'Page404', $prefix = 'ReDJModel', $config = array('ignore_request' => true))
    {
      $model = parent::getModel($name, $prefix, $config);

      return $model;
    }

}
