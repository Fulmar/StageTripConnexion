<?php
define('_JEXEC', 1);
define('JPATH_BASE', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_BASE .DS.'includes'.DS.'defines.php');
require_once(JPATH_BASE .DS.'includes'.DS.'framework.php');
$mainframe = JFactory::getApplication('site');
$session = JFactory::getSession();

$sessionvar = $session->get('captcha_verification', '', md5('chrono'));
$captcha_verification = strtolower($_POST['captcha']);

if(md5($captcha_verification) == $sessionvar){
    echo 'ok';
} else {
    echo 'notok';
}

?>