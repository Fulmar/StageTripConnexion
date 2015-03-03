<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Registration controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialControllerTopic extends TpcxsocialController
{
    
    /**
     * Method to save a topic data.
     *
     * @return  void
     * @since   1.6
     */
    public function save()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
        // Initialise variables.
        $app    = JFactory::getApplication();
        $model  = $this->getModel('Topic', 'TpcxsocialModel');
        $user   = JFactory::getUser();
        $userId = (int) $user->get('id');
        
        // Get the user data.
        $data = JRequest::getVar('jform', array(), 'post', 'array');
        
        // Validate the posted data.
        $form = $model->getForm();
        if (!$form) {
            JError::raiseError(500, $model->getError());
            return false;
        }
        
        // Validate the posted data.
        $data = $model->validate($form, $data);
        
        // Attempt to save the data.
        $return = $model->save($data);
        
        // Check for errors.
        if ($return === false) {
            // Redirect back to the edit screen.
            $this->setMessage(JText::sprintf('COM_TPCXSOCIAL_TOPIC_SAVE_FAILED', $model->getError()), 'warning');
            $this->setRedirect(JRoute::_(TpcxsocialHelperRoute::getRootForum(), false));
            return false;
        }
        
        $this->setMessage(JText::_('COM_TPCXSOCIAL_TOPIC_SAVE_SUCCESS'));
        $this->setRedirect(JRoute::_(TpcxsocialHelperRoute::getRootForum(), false));
    }
    
}
