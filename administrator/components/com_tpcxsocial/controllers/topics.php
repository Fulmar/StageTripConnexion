<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Tpcxsocial Controller
 */
class TpcxsocialControllerTopics extends JControllerAdmin
{
    /**
     * Constructor.
     *
     * @param   array   $config An optional associative array of configuration settings.
     *
     * @return  ContactControllerContacts
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->registerTask('unlocked',   'locked');
    }
    
    /**
     * Proxy for getModel.
     * @since       2.5
     */
    public function getModel($name = 'Topic', $prefix = 'TpcxsocialModel')
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    /**
     * Method to toggle the featured setting of a list of contacts.
     *
     * @return  void
     * @since   1.6
     */
    function locked()
    {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $user   = JFactory::getUser();
        $ids    = JRequest::getVar('cid', array(), '', 'array');
        $values = array('locked' => 1, 'unlocked' => 0);
        $task   = $this->getTask();
        $value  = JArrayHelper::getValue($values, $task, 0, 'int');
        // Get the model.
        $model = $this->getModel();

        if (empty($ids)) {
            JError::raiseWarning(500, JText::_('COM_TPCXSOCIAL_NO_ITEM_SELECTED'));
        } else {
            // Publish the items.
            if (!$model->locked($ids, $value)) {
                JError::raiseWarning(500, $model->getError());
            }
        }

        $this->setRedirect('index.php?option=com_tpcxsocial&view=topics');
    }

}
