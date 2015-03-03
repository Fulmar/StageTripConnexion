<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of contacts
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tpcxsocial
 * @since       1.6
 */
class JFormFieldCategory extends JFormFieldList
{
    /**
     * The form field type.
     *
     * @var     string
     * @since   1.6
     */
    protected $type = 'Category';

    /**
     * Method to get the field options.
     *
     * @return      array   The field option objects.
     * @since       1.6
     */
    public function getOptions()
    {
        // Initialize variables.
        $options = array();
 
        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);
 
        $query->select('c.id AS value, c.title AS text');
        $query->from('#__tpcxsocial_forum_categories AS c');
        $query->order('c.title');
        $query->where('published = 1');
        $query->where('parent_id > 0');
 
        // Get the options.
        $db->setQuery($query);
 
        $options = $db->loadObjectList();
        
        $object = new stdClass();
        $object->value = '';
        $object->text = JText::_('JOPTION_SELECT_CATEGORY');
        $object->level = 0;
        
        array_unshift($options, $object);
        
        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }
 
        return $options;
    }
    
    
}

