<?php
	 
// restricted access
defined( '_JEXEC' ) or die;

// app
$app		=	JFactory::getApplication();

// document html
$document 	=	JFactory::getDocument();
$document->setGenerator(false);
 
// menu infos
$menu 		= 	$app->getMenu();
$active 	=	$menu->getActive();
$menutype 	=	isset( $active ) ? $active->menutype : null;

/* css update */
$class = array();

$this->setTitle(str_replace("|", "", $this->getTitle()));

if( isset( $active ) )
	$suffix	= $active->params->get('pageclass_sfx');
	
if( isset( $suffix ) )
	$class[] = $suffix;

// hp
$hp = false;
if( $active == $menu->getDefault() ) {
	$hp = true;
	$class[] = 'hp';	
}

// landing page
$classTab = explode(' ', $suffix);
foreach($classTab as $classCSS) {
    if($classCSS == 'landing-page') {
        $hp = true;
        break;
    }
}

// right column
if( $document->countModules('right') )
	$class[] = 'rightcolumn';

if(JRequest::getVar('option') == 'com_chronoforms') {
    $class[] = 'chronoforms';
}

JHtml::_('behavior.framework', true);
JHTML::_('behavior.modal'); 