<?php 

defined( '_JEXEC' ) or die( 'Restricted access' );
if (($this->error->code) == '404') {
header('Location: http://yourdomain.com/404-page-not-found');
exit;
}
?>