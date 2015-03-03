<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Tpcxsocial Controller
 */
class TpcxsocialControllerPosts extends JControllerAdmin
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

}
