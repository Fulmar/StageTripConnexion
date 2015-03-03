<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	com_tpcxsocial
 */
abstract class JHtmlTopic
{
	/**
	 * @param	int $value	The featured value
	 * @param	int $i
	 *
	 * @return	string	The anchor tag to toggle locked/unlocked topics.
	 * @since	1.6
	 */
	static function locked($value = 0, $i)
	{
		// Array of image, task, title, action
		$states	= array(
			0	=> array('disabled.png', 'topics.locked', 'COM_TPCXSOCIAL_UNLOCKED', 'COM_TPCXSOCIAL_TOGGLE_TO_LOCKED'),
			1	=> array('publish_x.png', 'topics.unlocked', 'COM_TPCXSOCIAL_LOCKED', 'COM_TPCXSOCIAL_TOGGLE_TO_UNLOCKED'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$html	= JHtml::_('image', 'admin/'.$state[0], JText::_($state[2]), NULL, true);
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'
					. $html .'</a>';

		return $html;
	}
}
