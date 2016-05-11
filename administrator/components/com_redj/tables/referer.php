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
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
* ReDJ Referer Table class
*
* @package ReDJ
*
*/
class ReDJTableReferer extends JTable
{
  function __construct(& $db)
  {
    parent::__construct('#__redj_referers', 'id', $db);
  }

}
