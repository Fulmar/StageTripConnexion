<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tpcxsocial'.DS.'tables');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class JFormFieldCategoryParent extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'CategoryParent';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		// Initialise variables.
		$options = array();
		$name = (string) $this->element['name'];

		// Let's get the id for the current item, either category or content item.
		$jinput = JFactory::getApplication()->input;
		// For categories the old category is the category id 0 for new category.
		if ($this->element['parent'])
		{
			$oldCat = $jinput->get('id',0);
			$oldParent = $this->form->getValue($name);
		}
		else
		// For items the old category is the category they are in when opened or 0 if new.
		{
			$thisItem = $jinput->get('id',0);
			$oldCat = $this->form->getValue($name);
		}

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('a.id AS value, a.title AS text, a.level');
		$query->from('#__tpcxsocial_forum_categories AS a');
		$query->join('LEFT', $db->quoteName('#__tpcxsocial_forum_categories').' AS b ON a.lft > b.lft AND a.rgt < b.rgt');

		if ($this->element['parent'])
		{
		// Prevent parenting to children of this item.
			if ($id = $this->form->getValue('id')) {
				$query->join('LEFT', $db->quoteName('#__tpcxsocial_forum_categories').' AS p ON p.id = '.(int) $id);
				$query->where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');

				$rowQuery	= $db->getQuery(true);
				$rowQuery->select('a.id AS value, a.title AS text, a.level, a.parent_id');
				$rowQuery->from('#__tpcxsocial_forum_categories AS a');
				$rowQuery->where('a.id = ' . (int) $id);
				$db->setQuery($rowQuery);
				$row = $db->loadObject();
			}
		}
		$query->where('a.published IN (0,1)');
		$query->group('a.id, a.title, a.level, a.lft, a.rgt, a.parent_id');
		$query->order('a.lft ASC');

		// Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Pad the option text with spaces using depth level as a multiplier.
        for ($i = 0, $n = count($options); $i < $n; $i++)
        {
            // Translate ROOT
            if ($options[$i]->level == 0) {
                $options[$i]->text = JText::_('JGLOBAL_ROOT_PARENT');
            }

            $options[$i]->text = str_repeat('- ', $options[$i]->level).$options[$i]->text;
        }

		if (isset($row) && !isset($options[0])) {
			if ($row->parent_id == '1') {
				$parent = new stdClass();
				$parent->text = JText::_('JGLOBAL_ROOT_PARENT');
				array_unshift($options, $parent);
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
