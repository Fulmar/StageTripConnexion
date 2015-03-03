<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Tpcxtags Model
 */
class TpcxtagsModelTpcxtags extends JModelList
{
    
    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'niveau', 'idcatcompet'
            );
        }
 
        parent::__construct($config);
    }
    
    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return    void
     * @since    1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
 
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
 
        // Envoie les paramètres du composant dans l'état. Inutile dans le cadre des filtres
        $params    = JComponentHelper::getParams('com_tpcxtags');
        $this->setState('params', $params);
 
        // Les arguments permettent ici de définir le champ à classer par défaut avec l'ordre de tri
        parent::populateState('id', 'asc');
    }
    
    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Create a new query object.           
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        // Select some fields
        $query->select('id, tag, category');
        // From the hello table
        $query->from('#__tpcxtags');
        
        // Champ de recherche
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) { //Possibilité de sélectionner un id précis avec par exemple la synthaxe "id:19" 
                $query->where('id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->getEscaped($search, true).'%');
                $query->where('(tag LIKE '.$search.' )');
            }
        }
        
        $query->order('tag');
        
        return $query;
    }
}