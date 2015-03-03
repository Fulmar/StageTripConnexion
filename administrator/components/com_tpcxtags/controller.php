<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of HelloWorld component
 */
class TpcxtagsController extends JController
{
    /**
     * display task
     *
     * @return void
     */
    function display($cachable = false) 
    {
        // set default view if not set
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'tpcxtags'));
 
                // call parent behavior
        parent::display($cachable);
    }
    
    function exportcsv() 
    {
        $app    = JFactory::getApplication('site');
        
        $ids    = JRequest::getVar('cid', array(), '', 'array');
        
        echo "id;email;provenance;newsletter;partenaire;date";
        echo "\n";
        
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('tpcx_newsletter');
        $query->where('id IN (' . implode(", ", $ids) . ')');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        foreach($results as $result):
            echo $result->id;
            echo ";";    
            echo $result->email;
            echo ";";
            echo $result->provenance;
            echo ";";
            echo $result->newsletter;
            echo ";";
            echo $result->partenaire;
            echo ";";
            echo $result->date;
            echo "\n";
        endforeach;
        
        header("Content-type: application/vnd.ms-excel"); 
        header("Content-disposition: attachment; filename=\"newsletter.csv\"");
        
        $app->close();
        //$this->setRedirect('index.php?option=com_tpcxtags&view=newsletter');
        
    }
}