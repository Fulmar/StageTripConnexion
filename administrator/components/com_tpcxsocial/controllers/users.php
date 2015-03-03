<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Tpcxsocial Controller
 */
class TpcxsocialControllerUsers extends JControllerAdmin
{
    /**
     * Constructor.
     *
     * @param   array   $config An optional associative array of configuration settings.
     *
     * @return  TpcxsocialControllerUsers
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->registerTask('block',        'changeBlock');
        $this->registerTask('unblock',      'changeBlock');
    }
    
    /**
     * Proxy for getModel.
     * @since       2.5
     */
    public function getModel($name = 'User', $prefix = 'TpcxsocialModel')
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    /**
     * Method to change the block status on a record.
     *
     * @return  void
     *
     * @since   1.6
     */
    public function changeBlock()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $ids    = JRequest::getVar('cid', array(), '', 'array');
        $values = array('block' => 1, 'unblock' => 0);
        $task   = $this->getTask();
        $value  = JArrayHelper::getValue($values, $task, 0, 'int');

        if (empty($ids))
        {
            JError::raiseWarning(500, JText::_('COM_USERS_USERS_NO_ITEM_SELECTED'));
        }
        else
        {
            // Get the model.
            JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_users/models/');
            $model = $this->getModel($name = 'User', $prefix = 'UsersModel');
            
            // Change the state of the records.
            if (!$model->block($ids, $value))
            {
                JError::raiseWarning(500, $model->getError());
            }
            else
            {
                if ($value == 1)
                {
                    $this->setMessage(JText::plural('COM_USERS_N_USERS_BLOCKED', count($ids)));
                }
                elseif ($value == 0)
                {
                    $this->setMessage(JText::plural('COM_USERS_N_USERS_UNBLOCKED', count($ids)));
                }
            }
        }

        $this->setRedirect('index.php?option=com_tpcxsocial&view=users');
    }

    /**
     * Method to activate a record.
     *
     * @return  void
     *
     * @since   1.6
     */
    public function activate()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $ids    = JRequest::getVar('cid', array(), '', 'array');

        if (empty($ids))
        {
            JError::raiseWarning(500, JText::_('COM_USERS_USERS_NO_ITEM_SELECTED'));
        }
        else
        {
            // Get the model.
            JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_users/models/');
            $model = $this->getModel($name = 'User', $prefix = 'UsersModel');

            // Change the state of the records.
            if (!$model->activate($ids))
            {
                JError::raiseWarning(500, $model->getError());
            }
            else
            {
                $this->setMessage(JText::plural('COM_USERS_N_USERS_ACTIVATED', count($ids)));
            }
        }

        $this->setRedirect('index.php?option=com_users&view=users');
    }

}
