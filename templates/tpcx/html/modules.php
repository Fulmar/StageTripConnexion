<?php

// restricted access
defined( '_JEXEC' ) or die;

/*
 * Display wrap module
 */
function modChrome_wrap( $module, &$params, &$attribs ) {
	
	$class = $params->get('moduleclass_sfx', '');
	
	/*
	 * <div>
	 * 		<div>		
	 * 			<h2></h2>
	 * 		</div>
	 * 		<div></div> 
	 * </div>
	 * 
	 */
	$output = '<div class="module ' . $class . '" >';

	if( strpos($class, 'hot') !== false || strpos($class, 'top') !== false)
		$output .= '<div class="ribbon"></div>';
                
    if($params->get('tag_id') == 'menu-magazine') {
        $output .= '<a href="' . JURI::base() . 'magazine" style="text-decoration: none;">';
    }
    
    /*$showTitleArticle = false;
    // show title of article
    if($module->module == 'mod_tpcx_annuaire' || $module->module == 'mod_custom') {
        $input = JFactory::getApplication()->input;
        
        if($input->get('view') == 'article' && $module->position == 'content-top') {
            $article =& JTable::getInstance("content");
            $article->load($input->get('id'));
            $title = $article->get("title");
            $showTitleArticle = true;
            $output .=  '<h2>' . $title . '</h2>';
        }
    }
    */
	if ($module->showtitle && !$showTitleArticle) {
	    
        // detect HP
        $app        =   JFactory::getApplication();
        $menu       =   $app->getMenu();
        $active     =   $menu->getActive();
        $hp = false;
        if( $active == $menu->getDefault() ) {
            $hp = true;    
        }
        
	   	$output .= 	'<p class="' . ($hp === true ? 'home-page' : 'title-header' ) . '">' . $module->title . '</p>';
	}
    
    if($params->get('tag_id') == 'menu-magazine') {
        $output .= '</a>';
    }

	$output .= 	$module->content;
		
	$output .= '</div>';		
	
	echo $output;
	
}

/*
 * Display various modules
 */
function modChrome_various( $module, &$params, &$attribs ) {
	
	$document 	=	JFactory::getDocument();
	$class  	= 	$params->get('moduleclass_sfx', '');
	$position 	= 	$module->position;
	$align		= 	isset($attribs['align']) ? $attribs['align'] : 'h';
	$width		= 	isset($attribs['width']) ? $attribs['width'] : 'equal';
	
	// get nb modules
	static $nb = array();
	
	if ( !isset($nb[$position]) )	
	 	$nb[$position] = 1 ; 
	else
		$nb[$position]++ ;
	
	/*
	 *	<div>
	 *		<div>
	 * 			<h2></h2>
	 *		</div> 
	 *	</div>
	 * 
	 */
	$output = '<div class="'; 
	
	if($align == 'h')
		$output .= 'float-left ';
	
	if($width == 'equal')
		$output .= 'width-' . getModuleWidth( $document->countModules($position) . ' ');
	
	if( $nb[$position] != $document->countModules($position) )	
		$output .= ' separator';
	
	$output .= '">';
	
	$output .= '<div class="module various';
	
	if($class)
		$output .= ' ' . $class;
		
	$output .= '">';
	
	if( strpos($class, 'hot') !== false || strpos($class, 'top') !== false)
			$output .= '<div class="ribbon"></div>';
	
	if ($module->showtitle)
	   	$output .= '<h2>' . $module->title . '</h2>';
	elseif( strpos($class, 'houses') !== false ) 
		$output .= '<h2>Retrouvez nos <mark>maisons</mark></h2>';
	elseif( strpos($class, 'schools') !== false ) 
		$output .= '<h2>Retrouvez nos <mark>écoles</mark></h2>';
	
	$output .= $module->content;
	
	$output .= '</div>';
	
	$output .= '</div>';
		
	echo $output;
	
}
	
?>