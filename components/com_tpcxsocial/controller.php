<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * Hello World Component Controller
 */
class TpcxsocialController extends JController
{
    /**
     * Method to display a view.
     *
     * @param   boolean         If true, the view output will be cached
     * @param   array           An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController     This object to support chaining.
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        // Get the document object.
        $document   = JFactory::getDocument();
        //$document->addStyleSheet(JURI::base() . 'components/com_tpcxsocial/template/css/social.css');
        //$document->addScript(JURI::base() . 'components/com_tpcxsocial/template/js/social.js');
                
        // Set the default view name and format from the Request.
        $vName   = JRequest::getCmd('view', 'login');
        $vFormat = $document->getType();
        $lName   = JRequest::getCmd('layout', 'default');
        
        $user = JFactory::getUser();
        
        $isLogged = TpcxsocialHelperUser::isLogged();
        
        if ($view = $this->getView($vName, $vFormat)) {
            // Do any specific processing by view.
            switch ($vName) {
                case 'registration':
                    // If the user is already logged in, redirect to the profile page.
                    if ($isLogged) {
                        // Redirect to profile page.
                        $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=profile', false));
                        return;
                    }

                    // The user is a guest, load the registration model and show the registration page.
                    $model = $this->getModel('Registration');
                    break;

                // Handle view specific models.
                case 'profile':

                    // If the user is a guest, redirect to the login page.
                    if (!$isLogged) {
                        // Redirect to login page.
                        $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=login', false));
                        return;
                    }
                    $model = $this->getModel($vName);
                    break;

                // Handle the default views.
                case 'login':
                    // If the user is already logged in, redirect to the profile page.
                    if ($isLogged) {
                        // Redirect to profile page.
                        $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=profile', false));
                        return;
                    }
                    $model = $this->getModel($vName);
                    break;

                // Handle the default views.
                case 'categories':
                case 'topics':
                case 'posts':
                    $model = $this->getModel($vName);
                    if($vName == 'topics' && $lName == 'add') {
                        $model = $this->getModel('topic');
                    }
                    break;

                default:
                    $model = $this->getModel('Login');
                    break;
            }

            // Push the model into the view (as default).
            $view->setModel($model, true);
            $view->setLayout($lName);

            // Push document object into the view.
            $view->assignRef('document', $document);

            $view->display();
        }
    }

    /*
     * Get all the tags for topic
     */
    public function getTags()
    {
        $app    = JFactory::getApplication();
        $db     = JFactory::getDbo();
        
        $style  = JRequest::getVar('style');
        $term   = JRequest::getVar('term');
        
        if($style == 'full') {
            $tags = TpcxsocialHelperTpcxsocial::getTags($term);
            $categories = TpcxsocialHelperTpcxsocial::getCategories($term);
        }
        
        $result = array_merge($tags, $categories);
        
        header('Content-type: application/json');
        $result = json_encode($result); 
        
        echo $result;
        
        $app->close();
    }
    
}