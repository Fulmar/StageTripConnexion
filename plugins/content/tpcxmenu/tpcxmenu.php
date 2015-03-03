<?php
/**
 * @package     Joomla.Site
 * @subpackage  plg_content_tpcxtag
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.utilities.date');

/**
 * An example custom profile plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  User.profile
 * @version     1.6
 */
class plgContentTpcxmenu extends JPlugin
{
    /**
     * Constructor
     *
     * @access      protected
     * @param       object  $subject The object to observe
     * @param       array   $config  An array that holds the plugin configuration
     * @since       2.5
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * Example after save content method
     * Article is passed by reference, but after the save, so no changes will be saved.
     * Method is called right after the content is saved
     *
     * @param   string      The context of the content passed to the plugin (added in 1.6)
     * @param   object      A JTableContent object
     * @param   bool        If the content is just about to be created
     * @since   2.5
     */
    public function onContentAfterSave($context, &$article, $isNew)
    {
        if($context != 'com_content.article')
            return false;
        
        $catid = $article->catid;
        
        $params = array();

        if($catid == $this->params->get('catidmagazine')) {
            $menutype = $this->params->get('menutypemagazine');
            $params['pageclass_sfx'] = 'magazine';
        } elseif($catid == $this->params->get('catidpartenaire')) {
            $menutype = $this->params->get('menutypepartenaire');
            $params['pageclass_sfx'] = 'partenaire';
        } elseif($catid == $this->params->get('catidproduit')) {
            $menutype = $this->params->get('menutypeproduit');
            $params['pageclass_sfx'] = 'produit';
        } else {
            // Article is not in category magazine or partenaire
            $this->deleteItemMenu($article->id);
            return false;
        }
        
        // meta
        //$params['menu-meta_description'] = $article->metadesc;
        //$params['menu-meta_keywords'] = $article->metakey;
        
        $params = (object) $params;
        
        $component = JComponentHelper::getComponent('com_content');
        $app = JFactory::getApplication();
        
        // create item menu
        $published = ($article->state == 1 ? 1 : 0);
        $data = array(
                'menutype' => $menutype,
                'title' => $article->title,
                'alias' => $article->alias,
                'type' => 'component',
                'component_id' => $component->id,
                'link' => 'index.php?option=com_content&view=article&id=' . $article->id,
                'language' => '*',
                'published' => $published,
                'parent_id' => 1,
                'level' => 1,
                'params' => json_encode($params),
        );
        
        $isNew  = true;
        $db     = JFactory::getDbo();
        $table  = JTable::getInstance('Menu', 'JTable', array());
        
        // Check if alias exist
        $query  = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__menu').' AS a');
        $query->where('type = "component"');
        $query->where('link != "index.php?option=com_content&view=article&id=' . $article->id . '"');
        $query->where('alias = "' . $article->alias . '"');
        
        $db->setQuery($query);

        $rows = $db->loadObjectList();
        if(count($rows) > 0) {
            $ids = array();
            foreach($rows as $row)
                $ids[] = $row->id;
            
            $ids = implode(",", $ids);
                
            throw new Exception("L'alias choisi pour l'article existe déjà dans un / ou pluiseurs item(s) de menu : " . $ids);
            return false;
        }
        
        // Check if menu exist
        $query  = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__menu').' AS a');
        $query->where('type = "component"');
        $query->where('link = "index.php?option=com_content&view=article&id=' . $article->id . '"');
        
        $db->setQuery($query);

        $row = $db->loadObject();
        
        // Load the row if saving an existing item.
        if ($row) {
            $table->load($row->id);
            $isNew = false;
        }
        
        $table->setLocation($data['parent_id'], 'last-child');
        
        // Bind the data.
        if (!$table->bind($data)) {
            throw new Exception($table->getError());
            return false;
        }
        
        // Check the data.
        if (!$table->check()) {
            throw new Exception($table->getError());
            return false;
        }

        // Store the data.
        if (!$table->store()) {
            throw new Exception($table->getError());
            return false;
        }

        return true;
    }
    
    /**
     * Delete an item menu
     *
     * @param   string      $articleId  Article id of item menu to delete
     * @since   2.5
     */
    public function deleteItemMenu($articleId)
    {
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        $query->delete();
        $query->from($db->quoteName('#__menu'));
        $query->where('type = "component"');
        $query->where('link = "index.php?option=com_content&view=article&id=' . $articleId . '"');
        $query->where('(menutype = "' . $this->params->get('menutypemagazine') . '" OR menutype = "' . $this->params->get('menutypepartenaire') . '")');
        $db->setQuery($query);

        if (!$db->query())
        {
            throw new Exception($db->getErrorMsg());
        }
        
        return true;
    }
    
    /**
     * Finder after delete content method
     * Article is passed by reference, but after the save, so no changes will be saved.
     * Method is called right after the content is saved
     *
     * @param   string      The context of the content passed to the plugin (added in 1.6)
     * @param   object      A JTableContent object
     * @since   2.5
     */
    public function onContentAfterDelete($context, $article)
    {
        if($context != 'com_content.article')
            return false;
        
        $articleId  = $article->id;
        
        $catid = $article->catid;
        
        if($catid != $this->params->get('catidmagazine') && $catid != $this->params->get('catidpartenaire')) {
            // Article is not in category magazine or partenaire
            return false;
        }
        
        if ($articleId)
        {
            try
            {
                $this->deleteItemMenu($articleId);
            }
            catch (JException $e)
            {
                $this->_subject->setError($e->getMessage());
                return false;
            }
        }

        return true;
    }
    
    /**
     * unpublish / publish the item menu of the article
     *
     * @param   string   $context  The context for the content passed to the plugin.
     * @param   array    $pks      A list of primary key ids of the content that has changed state.
     * @param   integer  $value    The value of the state that the content has been changed to.
     * @since   2.5
     */
    public function onContentChangeState($context, $pks, $value)
    {
        if($context != 'com_content.article')
            return true;

        $published = ($value == 1 ? 1 : 0);
        
        $db     = JFactory::getDbo();
        
        // List items requiring changing state
        $query  = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__menu').' AS a');
        $query->where('type = "component"');
        
        foreach($pks as $id)
            $query->where('link = "index.php?option=com_content&view=article&id=' . $id . '"');
        
        $db->setQuery($query);

        $rows = $db->loadObjectList();
        
        if($rows > 0) {
            foreach($rows as $row) {
                $table  = JTable::getInstance('Menu', 'JTable', array());
                $table->load($row->id);
                $table->set('published', $published);
                
                // Check the data.
                if (!$table->check()) {
                    throw new Exception($table->getError());
                    return false;
                }
        
                // Store the data.
                if (!$table->store()) {
                    throw new Exception($table->getError());
                    return false;
                }
            }
            
        }
        
        return true;
    }
    
}
