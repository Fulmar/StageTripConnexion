<?php
// No direct access to this file
defined('_JEXEC') or die ;

/**
 * Tpcxsocial component helper.
 */
class TpcxsocialHelper
{
    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($submenu)
    {
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_CATEGORIES'), 'index.php?option=com_tpcxsocial&view=categories', $submenu == 'categories');
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_TOPICS'), 'index.php?option=com_tpcxsocial&view=topics', $submenu == 'topics');
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_POSTS'), 'index.php?option=com_tpcxsocial&view=posts', $submenu == 'posts');
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_USERS'), 'index.php?option=com_tpcxsocial&view=users', $submenu == 'users');
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_USERS_TYPES'), 'index.php?option=com_users&view=groups', $submenu == 'types');
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_TAG_CATEGORIES'), 'index.php?option=com_tpcxsocial&view=tagcategories', $submenu == 'tagcategories');
        JSubMenuHelper::addEntry(JText::_('COM_TPCXSOCIAL_SUBMENU_TAG'), 'index.php?option=com_tpcxsocial&view=tags', $submenu == 'tags');
        // set some global property
        $document = JFactory::getDocument();
        if ($submenu == 'categories') {
            $document->setTitle(JText::_('COM_TPCXSOCIAL_MANAGER_CATEGORIES'));
        }
    }

    /**
     * Get a list of the user groups for filtering.
     *
     * @return  array  An array of JHtmlOption elements.
     *
     * @since   1.6
     */
    static function getGroups()
    {
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level' .
            ' FROM #__usergroups AS a' .
            ' LEFT JOIN '.$db->quoteName('#__usergroups').' AS b ON a.lft > b.lft AND a.rgt < b.rgt' .
            ' GROUP BY a.id, a.title, a.lft, a.rgt' .
            ' ORDER BY a.lft ASC'
        );
        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum())
        {
            JError::raiseNotice(500, $db->getErrorMsg());
            return null;
        }

        foreach ($options as &$option)
        {
            $option->text = str_repeat('- ', $option->level).$option->text;
        }

        return $options;
    }

    /**
     * Get a list of filter options for the blocked state of a user.
     *
     * @return  array  An array of JHtmlOption elements.
     *
     * @since   1.6
     */
    static function getStateOptions()
    {
        // Build the filter options.
        $options = array();
        $options[] = JHtml::_('select.option', '0', JText::_('JENABLED'));
        $options[] = JHtml::_('select.option', '1', JText::_('JDISABLED'));

        return $options;
    }

    /**
     * Get a list of filter options for the activated state of a user.
     *
     * @return  array  An array of JHtmlOption elements.
     *
     * @since   1.6
     */
    static function getActiveOptions()
    {
        // Build the filter options.
        $options = array();
        $options[] = JHtml::_('select.option', '0', JText::_('COM_TPCXSOCIAL_ACTIVATED'));
        $options[] = JHtml::_('select.option', '1', JText::_('COM_TPCXSOCIAL_UNACTIVATED'));

        return $options;
    }

    /**
     * Creates a list of range options used in filter select list
     * used in com_users on users view
     *
     * @return  array
     *
     * @since   2.5
     */
    public static function getRangeOptions()
    {
        $options = array(
            JHtml::_('select.option', 'today', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_TODAY')),
            JHtml::_('select.option', 'past_week', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_PAST_WEEK')),
            JHtml::_('select.option', 'past_1month', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_PAST_1MONTH')),
            JHtml::_('select.option', 'past_3month', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_PAST_3MONTH')),
            JHtml::_('select.option', 'past_6month', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_PAST_6MONTH')),
            JHtml::_('select.option', 'past_year', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_PAST_YEAR')),
            JHtml::_('select.option', 'post_year', JText::_('COM_TPCXSOCIAL_OPTION_RANGE_POST_YEAR')),
        );
        return $options;
    }
    
    /**
     * Retrieve a list of categories for filtering
     *
     * @return  array
     *
     * @since   2.5
     */
    public function getCategoriesFilter()
    {
        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);

        $query->select('a.id AS value, a.title AS text, a.level');
        $query->from('#__tpcxsocial_forum_categories AS a');
        $query->join('LEFT', $db->quoteName('#__tpcxsocial_forum_categories').' AS b ON a.lft > b.lft AND a.rgt < b.rgt');
        
        $query->where('a.published IN (0,1)');
        $query->group('a.id, a.title, a.level, a.lft, a.rgt, a.parent_id');
        $query->order('a.lft ASC');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();
        
        // Pad the option text with spaces using depth level as a multiplier.
        for ($i = 0, $n = count($options); $i < $n; $i++)
        {
            // Translate ROOT
            if ($options[$i]->level == 0) {
                $options[$i]->text = JText::_('JOPTION_SELECT_CATEGORY');
                $options[$i]->value = '';
            }

            $options[$i]->text = str_repeat('- ', $options[$i]->level).$options[$i]->text;
        }
        
        return $options;
    }
    
    /**
     * Retrieve a list of categories for filtering
     *
     * @return  array
     *
     * @since   2.5
     */
    public function getCategoriesTagFilter()
    {
        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);

        $query->select('c.id AS value, c.title AS text');
        $query->from('#__tpcxsocial_forum_tags_categories AS c');
        
        $query->where('c.published IN (0,1)');
        $query->group('c.id, c.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();
        
        $firstitem = array(
            "text" => JText::_('JOPTION_SELECT_CATEGORY'),
            "value" => ''
        );
        
        array_unshift($options, $firstitem);
        
        return $options;
    }

}
