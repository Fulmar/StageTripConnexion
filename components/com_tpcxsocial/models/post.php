<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

/**
 * Registration model class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialModelPost extends JModel
{
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param       type    The table type to instantiate
     * @param       string  A prefix for the table class name. Optional.
     * @param       array   Configuration array for model. Optional.
     * @return      JTable  A database object
     * @since       2.5
     */
    public function getTable($type = 'POst', $prefix = 'TpcxsocialTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to save the form data.
     *
     * @param   array       The form data.
     * @return  mixed       The user id on success, false on failure.
     * @since   1.6
     */
    public function save($data)
    {
        $table = $this->getTable();
        $db = JFactory::getDbo();
        
        $data['published'] = 1;
        
        if($table->save($data)) {
            
            // get maxs posts from topic
            $db->setQuery('SELECT MAX(posts) FROM #__tpcxsocial_forum_topics WHERE id = ' . $data['topic_id']);
            $max = $db->loadResult();

            $posts = $max+1;
            
            $db->setQuery('UPDATE #__tpcxsocial_forum_topics SET posts = "' . $posts . '" WHERE id = ' . $data['topic_id']);
            $db->query();
        }

        return true;
    }
}
