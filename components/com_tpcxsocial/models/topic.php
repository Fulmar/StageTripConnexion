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
class TpcxsocialModelTopic extends JModelForm
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
    public function getTable($type = 'Topic', $prefix = 'TpcxsocialTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }
    
    /**
     * Method to get the registration form.
     *
     * The base form is loaded from XML and then an event is fired
     * for users plugins to extend the form with extra fields.
     *
     * @param   array   $data       An optional array of data for the form to interogate.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  JForm   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_tpcxsocial.topic', 'topic', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = (array)JFactory::getApplication()->getUserState('com_tpcxsocial.topic.data', array());
        return $data;
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
        
        $data['published'] = 1;
        
        $tags_value = explode(",", $data['tags_value']);
        $categories = array();
        $tags = array();
        foreach($tags_value as $tag) {
            if(preg_match('/^c(1-9)*/', $tag)) {
                $categories[] = $tag;
            }
            if(preg_match('/^t(1-9)*/', $tag)) {
                $tags[] = $tag;
            }
        }
        
        if($table->save($data)) {
            $db = JFactory::getDbo();
            $topic_id = $table->id;
            
            // categories topic
            if(count($categories) > 0) {
                // add new relation categories
                $values = array();
                foreach($categories as $id) {
                    $values[] = "('" . $topic_id . "', '" . str_replace('c', '', $id) . "')";
                }
                
                $values = implode(", ", $values);
                
                $db->setQuery(
                    "INSERT INTO #__tpcxsocial_forum_topics_categories VALUES " . $values
                );
                $db->query();
            }
            
            // tags
            if(count($tags) > 0) {
                // add new relation tag
                $values = array();
                foreach($tags as $id) {
                    $values[] = "('" . $topic_id . "', '" . str_replace('t', '', $id) . "')";
                }
                
                $values = implode(", ", $values);
                
                $db->setQuery(
                    "INSERT INTO #__tpcxsocial_forum_topics_tags VALUES " . $values
                );
                $db->query();
            }    
        }

        return true;
    }
}
