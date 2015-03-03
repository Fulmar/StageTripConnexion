<?php
	 
// restricted access
defined( '_JEXEC' ) or die;

/**
 * get css width according to a number of item to display
 * 
 * @param $nb number of module to display 
 */
function getCssWidth($nb) {
	
	switch ($nb) {		
		case 1 :
				return '100';
				break;				 
		case 2 :
				return '50';
				break;
		case 3 : 
				return '33';
				break;
		case 4 :
				return '25';
				break;
		case 5 :
				return '20';
				break;		
		default :
				return '100';
		
	}
	
}