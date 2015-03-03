<?php
/**
 * @package		TpCx
 * @subpackage	mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

class modTpcxNewsletterHelper
{
	static function insertNewsletter($civilite = '', $nom = '', $prenom = '', $telephone = '', $email, $provenance, $newsletter, $newsletterPartenaire = 0)
    {
        //get database
        $db     = JFactory::getDbo();
        
        $check = "SELECT *
                  FROM tpcx_newsletter
                  WHERE email = '" . $email . "'";
                  
        $db->setQuery($check);
        $rows = $db->loadObjectList();
        
        if(count($rows) > 0) {
            $query = "UPDATE tpcx_newsletter
                      SET civilite = '" . $civilite . "',
                      nom = " . $db->quote($nom) . ",
                      prenom = " . $db->quote($prenom) . ",
                      telephone = " . $db->quote($telephone) . ",
                      newsletter = '" . $newsletter . "',
                      partenaire = '" . $newsletterPartenaire . "',
                      modified = NOW()
                      WHERE email = '" . $email . "';";
        } else {
            $query = "INSERT INTO tpcx_newsletter (civilite, nom, prenom, telephone, email, provenance, newsletter, partenaire, date)
                      VALUES ('" . $civilite . "', " . $db->quote($nom) . ", " . $db->quote($prenom) . ", " . $db->quote($telephone) . ",
                      '" . $email . "', '" . $provenance . "', '" . $newsletter . "', '" . $newsletterPartenaire . "', NOW());";
        }
        
        $db->setQuery($query);
        
        if($db->query())
            return true;
    }
}
