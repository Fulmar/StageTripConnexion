<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class PlgContentTpcxField extends JPlugin
{
    /**
     * Constructor - note in Joomla 2.5 PHP4.x is no longer supported so we can use this.
     *
     * @access      protected
     * @param       object  $subject The object to observe
     * @param       array   $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
            parent::__construct($subject, $config);
            $this->loadLanguage();
    }
    
    /**
     * @param   JForm   $form   The form to be altered.
     * @param   array   $data   The associated data for the form.
     *
     * @return  boolean
     * @since   2.5
     */
    function onContentPrepareForm($form, $data)
    {
        $app = JFactory::getApplication();
        $option = $app->input->get('option');
        $view = $app->input->get('view');
        
        if($option != 'com_content' && $view != 'article') {
            return;
        }
        
        JForm::addFormPath(__DIR__ . '/tpcxfield');
        $form->loadFile('tpcxfield', false);
        
        return true;
    }
    
    /**
     * @param   string  $context    The context for the data
     * @param   int     $data       The user id
     * @param   object
     *
     * @return  boolean
     * @since   1.6
     */
    function onContentPrepareData($context, $data)
    {
        // Check we are manipulating a valid form.
        if ($context != 'com_content.article') {
            return true;
        }

        if (is_object($data)) {
            $articleId = isset($data->id) ? $data->id : 0;
            
            if($articleId > 0) {
                
                // Load the data from the database.
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                
                $query->select('f.*');
                $query->from('#__tpcx_article_field as f');
                
                $query->where('f.content_id = ' . $db->Quote($articleId));
                
                $db->setQuery($query);
                $result = $db->loadObject();
     
                // Check for a database error.
                if ($db->getErrorNum()) {
                   $this->_subject->setError($db->getErrorMsg());
                   return false;
                }
                
                // Merge the data.
                $data->fields = array();
     
                if($result) {
                    $data->fields['image_header'] = $result->image_header;
                }

            } else {
                $data->fields = array();
            }
            
        }
        
        return true;
    }

    /**
     * tpcxfield after save content method
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
        // Check we are manipulating a valid form.
        if ($context != 'com_content.article') {
            return true;
        }
        
        $articleId = $article->id;
        
        if ($articleId && isset($article->fields) && (count($article->fields))) {
            
            try {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                
                // delete rows        
                $this->deleteRow($articleId);        
                
                $query->clear();
                
                // insert rows
                $query->insert('#__tpcx_article_field');
                $query->values($db->quote($articleId) . ', ' . $db->quote($article->fields['image_header']));
                $db->setQuery($query);
     
                if (!$db->query()) {
                   throw new Exception($db->getErrorMsg());
                }
             } catch (JException $e) {
                $this->_subject->setError($e->getMessage());
                return false;
             }
                
        }
        
        return true;
    }

    /**
     * tpcxfield after delete content method
     * Article is passed by reference, but after the save, so no changes will be saved.
     * Method is called right after the content is saved
     *
     * @param   string      The context of the content passed to the plugin (added in 1.6)
     * @param   object      A JTableContent object
     * @since   2.5
     */
    public function onContentAfterDelete($context, $article)
    {
        
        $articleId  = $article->id;
        if ($articleId)
        {
            try {
                $this->deleteRow($articleId);
            } catch (JException $e) {
                $this->_subject->setError($e->getMessage());
                return false;
            }
        }

        return true;
    }
    
    /**
     * Delete row of the relation
     */
    public function deleteRow($articleId)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
          
        $query->delete('#__tpcx_article_field');
        $query->where('content_id = ' . $db->Quote($articleId));
        $db->setQuery($query);
        if (!$db->query()) {
           throw new Exception($db->getErrorMsg());
        }
    }
}
?>