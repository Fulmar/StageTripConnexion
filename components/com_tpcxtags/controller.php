<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
jimport('joomla.mail.mail');

/**
 * Hello World Component Controller
 */
class TpcxtagsController extends JController
{
    public function listpays()
    {
        $app    = JFactory::getApplication('site');
           
        $continent_id = JRequest::getVar( 'continent_id' );
        
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category, subcategory');
        $query->from('#__tpcxtags');
        $query->order('tag ASC');
		$query->where('category = "pays"');
        
        if($continent_id)
            $query->where('subcategory = "' . $continent_id . '"');
        
        $db->setQuery($query);

        $items = $db->loadObjectList();
        
        echo json_encode($items);
        
        $app->close();
        
    }
	
	public function listthematique()
    {
        $app    = JFactory::getApplication('site');
           
        $continent_id = JRequest::getVar( 'continent_id' );
		$pays_id	  = JRequest::getVar( 'pays_id' );
        
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $articlesContinents = array();
        $articlesPays = array();
		
        if($continent_id) {
        	$query = $db->getQuery(true);
			
        	$query->select('user_id');
        	$query->from('#__user_profiles');
            $query->where('(profile_key LIKE ' . $db->Quote('tpcxtagarticle.listcontinents'));
			$query->where('profile_value LIKE "%\"' . $continent_id . '\"%")');
			
			$db->setQuery($query);
			
			$articlesContinents = $db->loadResultArray();
		}
		
		if($pays_id) {
			$query = $db->getQuery(true);
			
        	$query->select('user_id');
        	$query->from('#__user_profiles');
            $query->where('(profile_key LIKE ' . $db->Quote('tpcxtagarticle.listpays'));
			$query->where('profile_value LIKE "%\"' . $pays_id . '\"%")');
			
			if($continent_id) {
				$query->where('user_id IN (' . implode(', ', $articlesContinents) . ')');
			}
			
			$db->setQuery($query);
			
			$articlesPays = $db->loadResultArray();
		}
		
		$articles = $articlesPays;
		
		$items = array();
		
		// get all thematiques name / id
		if(sizeof($articles) > 0) {
			$query = $db->getQuery(true);
			
        	$query->select('profile_value');
        	$query->from('#__user_profiles');
			$query->where('profile_key LIKE ' . $db->Quote('tpcxtagarticle.listthematiques'));
            $query->where('user_id IN (' . implode(', ', $articles) . ')');
			
			$db->setQuery($query);
			
			$articlesThematiques = $db->loadResultArray();
			
			$results = array();
			foreach($articlesThematiques as $value) {
				// delete [ ]
				$value = substr($value, 1, -1);
				// explode for all values
				$arr = explode(",", $value);
				// delete double quote
				foreach($arr as $value) {
					$results[] = trim($value, '"');
				}
			}
			
			$results = array_unique($results);
			
			$query = $db->getQuery(true);
        
	        $query->select('id, tag, category, subcategory');
	        $query->from('#__tpcxtags');
			$query->where('id IN (' . implode(', ', $results) . ')');
	        $query->order('tag ASC');
			
			$db->setQuery($query);
			
			$items = $db->loadObjectList();
			
		}
		
        echo json_encode($items);
        
        $app->close();
        
    }
    
    public function sendFormTravel()
    {
        $app    = JFactory::getApplication('site');
        
        $url_redirection = JRequest::getVar('url_redirection');
        //$email_send = JRequest::getVar('email_send');
        $email_send = array('vautour.fabien@gmail.com', 'fvautour@outlook.com');
        //$email_send = array('bruno@tripconnexion.com', 'guillaume@tripconnexion.com', 'julie.florenson@tripconnexion.com');
        
        JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_tpcxtags/models', 'TpcxtagsModel');
        $model = JModelLegacy::getInstance('Articles', 'TpcxtagsModel', array('ignore_request' => true));
        
        $choixPays1 = $model->getItem(JRequest::getVar('choix-pays-1'), 'tag') . ' (' . JRequest::getVar('choix-pays-1') . ')';
        $choixPays2 = '';
        if(JRequest::getVar('choix-pays-2'))
            $choixPays2 = $model->getItem(JRequest::getVar('choix-pays-2'), 'tag') . ' (' . JRequest::getVar('choix-pays-2') . ')';
        $choixPays3 = '';
        if(JRequest::getVar('choix-pays-3'))
            $choixPays3 = $model->getItem(JRequest::getVar('choix-pays-3'), 'tag') . ' (' . JRequest::getVar('choix-pays-3') . ')';
        
        $dateDepart = JRequest::getVar('date-depart');
        $dureePrevue = JRequest::getVar('duree-prevue');
        $plusOuMoins = JRequest::getVar('plus-ou-moins');
        
        $nombreAdultes = JRequest::getVar('nombre-adultes');
        $nombreEnfants_2_12 = JRequest::getVar('nombre-enfants-2-12');
        $nombreEnfantsMoins_12 = JRequest::getVar('nombre-enfants-moins-12');
        
        $envies = JRequest::getVar('envies');
        $visitePays1 = JRequest::getVar('visite-pays1');
        $visitePays2 = JRequest::getVar('visite-pays2');
        $visitePays3 = JRequest::getVar('visite-pays3');
        $faconVoyager = JRequest::getVar('facon-voyager');
        $guide = JRequest::getVar('guide');
        
        $thematique = JRequest::getVar('thematique');
        if(is_array($thematique) && count($thematique) > 0)
            $thematique = implode(", ", $thematique);
        
        $thematiqueAutre = JRequest::getVar('thematique-autres-text');
        
        $hebergement = JRequest::getVar('hebergement');
        if(is_array($hebergement) && count($hebergement) > 0)
            $hebergement = implode(", ", $hebergement);
        
        $repas = JRequest::getVar('repas');
        $billetAvion = JRequest::getVar('billet-avion');
        
        $budget = JRequest::getVar('budget');
        $civilite = JRequest::getVar('civilite');
        $nom = JRequest::getVar('nom');
        $prenom = JRequest::getVar('prenom');
        $email = JRequest::getVar('email');
        $telephone = JRequest::getVar('telephone');
        
        // newsletter
        require_once JPATH_SITE . '/modules/mod_tpcx_newsletter/helper.php';
        
        $newsletter = JRequest::getVar('newsletter');
        $newsletterPartenaire = JRequest::getVar('newsletter-partenaire');
        
        $provenance = JRequest::getVar('provenance');
        $insertEmail = modTpcxNewsletterHelper::insertNewsletter($civilite, $nom, $prenom, $telephone, $email, $provenance, $newsletter, $newsletterPartenaire);
        
        $remarques = JRequest::getVar('remarques');
        
        // insert BDD
        $dateDepartBDD = substr($dateDepart, 6, 4) . "-" . substr($dateDepart, 3, 2) . "-" . substr($dateDepart, 0, 2);
        $db     = JFactory::getDbo();
        $query = "INSERT INTO joomla_tpcx_projet_voyage (created, ipaddress, pays1, pays2, pays3, date_depart, duree_voyage,
                    plus_ou_moins, nb_adultes, nb_enfant_2_12, nb_enfant_moins_12, envies, visite_pays1, visite_pays2, visite_pays3,
                    facon_voyager, guide, thematique, thematique_autre, hebergement, repas, billet_avion, budget, civilite,
                    nom, prenom, email, telephone, remarques, source)
                      VALUES (NOW(), " . $db->quote($_SERVER['REMOTE_ADDR']) . ", " . $db->quote($choixPays1) . ",
                      " . $db->quote($choixPays2) . ", " . $db->quote($choixPays3) . ", " . $db->quote($dateDepartBDD) . ", 
                      " . $db->quote($dureePrevue) . ", " . $db->quote($plusOuMoins) . ", " . $db->quote($nombreAdultes) . ", 
                      " . $db->quote($nombreEnfants_2_12) . ", " . $db->quote($nombreEnfantsMoins_12) . ", " . $db->quote($envies) . ", 
                      " . $db->quote($visitePays1) . ", " . $db->quote($visitePays2) . ", " . $db->quote($visitePays3) . ", 
                      " . $db->quote($faconVoyager) . ", " . $db->quote($guide) . ", " . $db->quote($thematique) . ",
                      " . $db->quote($thematiqueAutre) . ", " . $db->quote($hebergement) . ", " . $db->quote($repas) . ", 
                      " . $db->quote($billetAvion) . ", " . $db->quote($budget) . ", " . $db->quote($civilite) . ", 
                      " . $db->quote($nom) . ", " . $db->quote($prenom) . ", " . $db->quote($email) . ",
                      " . $db->quote($telephone) . ", " . $db->quote($remarques) . ", " . $db->quote($_SESSION['utm_source']) . ");";
       
        $db->setQuery($query);
        
        $db->query();
        
        $html = 'Bonjour,<br />
        <br />
        Un nouveau projet de voyage a été émis par un internaute.<br />
        <br />
        Nous t\'invitons donc à prendre contact avec le voyageur au plus vite en lui rappelant bien que tu fais suite à sa demande sur <strong>TripConnexion</strong><br />';
        
        $html .= '<br />';
        $html .= 'Voici son projet:<br /><br />';
        $html .= '<strong>Choix pays 1 :</strong> ' . $choixPays1 . '<br />';
        if($choixPays2 != '')
            $html .= '<strong>Choix pays 2 :</strong> ' . $choixPays2 . '<br />';
        if($choixPays3 != '')
            $html .= '<strong>Choix pays 3 :</strong> ' . $choixPays3 . '<br />';
        $html .= '<strong>Date de départ :</strong> ' . $dateDepart . '<br />';
        $html .= '<strong>Durée prévue :</strong> ' . $dureePrevue . ' jour' . ($dureePrevue > 1 ? 's' : '') . '<br />';
        $html .= '<strong>A plus ou moins :</strong> ' . $plusOuMoins . ' jour' . ($plusOuMoins > 1 ? 's' : '') . '<br />';
        $html .= '<strong>Nombre d\'adultes :</strong> ' . $nombreAdultes . '<br />';
        $html .= '<strong>Nombre d\'enfants de 2 à 12 ans :</strong> ' . $nombreEnfants_2_12 . '<br />';
        $html .= '<strong>Nombre d\'enfants de moins de 2 ans :</strong> ' . $nombreEnfantsMoins_12 . '<br />';
        $html .= '<br />---------------------------------------------------------------------------<br /><br />';
        $html .= '<strong>Envies :</strong> ' . nl2br($envies) . '<br /><br />';
        $html .= '<strong>Pays "' . $choixPays1 . '" déjà visité :</strong> ' . ($visitePays1 == 1 ? 'Oui' : 'Non') . '<br />';
        if($choixPays2 != '')
            $html .= '<strong>Pays "' . $choixPays2 . '" déjà visité :</strong> ' . ($visitePays2 == 1 ? 'Oui' : 'Non') . '<br />';
        if($choixPays3 != '')
            $html .= '<strong>Pays "' . $choixPays3 . '" déjà visité :</strong> ' . ($visitePays3 == 1 ? 'Oui' : 'Non') . '<br />';
        $html .= '<strong>Façon de voyager :</strong> ' . $faconVoyager . '<br />';
        $html .= '<strong>Guide :</strong> ' . $guide . '<br />';
        $html .= '<strong>Thématique :</strong> ' . $thematique . '<br />';
        $html .= '<strong>Thématique autre :</strong> ' . $thematiqueAutre . '<br />';
        $html .= '<strong>Hébergement :</strong> ' . $hebergement . '<br />';
        $html .= '<strong>Repas :</strong> ' . $repas . '<br />';
        $html .= '<strong>Billet d\'avion :</strong> ' . ($billetAvion == 1 ? 'Oui' : 'Non') . '<br />';
        $html .= '<strong>Budget par jour et par personne :</strong> ' . $budget . ' €/pers<br />';
        $html .= '<br />---------------------------------------------------------------------------<br /><br />';
        $html .= '<strong>Civilité :</strong> ' . $civilite . '<br />';
        $html .= '<strong>Nom :</strong> ' . $nom . '<br />';
        $html .= '<strong>Prénom :</strong> ' . $prenom . '<br />';
        $html .= '<strong>Email :</strong> ' . $email . '<br />';
        $html .= '<strong>Téléphone :</strong> ' . $telephone . '<br />';
        $html .= '<strong>Remarques :</strong> ' . nl2br($remarques) . '<br />';
        $html .= '<br />';
        $html .= '<strong>Son IP :</strong> http://www.ipgetinfo.com/?mode=ip&lang=fr&ip=' . $_SERVER['REMOTE_ADDR'];
        $html .= '<br />';
        if(!empty($_SESSION['utm_source'])) {
            $html .= 'Source : ' . $_SESSION['utm_source'] . '<br />';
        }
        $html .= '<br />';
        $html .= 'L\'équipe de <strong>TripConnexion</strong>.<br />';
        $html .= '<img src="http://www.tripconnexion.com/images/divers/ecard/tripconnexion_direct_acteurs_locaux-400.jpg" alt="" width="400" height="99" />';
        
        $subject_countries = $model->getItem(JRequest::getVar('choix-pays-1'), 'tag');
        if($choixPays2 != '')
            $subject_countries .= " - " . $model->getItem(JRequest::getVar('choix-pays-2'), 'tag');
        if($choixPays3 != '')
            $subject_countries .= " - " . $model->getItem(JRequest::getVar('choix-pays-3'), 'tag');    
        
        $subject = $nom . " " . $prenom . " - " . $subject_countries . " - Projet via TripConnexion";
        
        $mail = new JMail();
        $mail->sendMail("bruno@tripconnexion.com", "Trip Connexion", $email_send, $subject, $html, true);
        
        $htmlInternaute = "Bonjour " . $prenom . ",<br />
<br />
Nous avons bien pris en compte votre projet de voyage. Nous allons de suite faire suivre votre demande à tous nos partenaires susceptibles d'y répondre. Ce sont dorénavant eux qui vont revenir vers vous.<br />
<br />
Sachez que nos partenaires vont consacrer du temps à votre demande pour établir une proposition qui vous conviendra au mieux. Certains vont vous solliciter pour obtenir plus d'informations et ainsi mieux connaître vos attentes.<br />
Merci de prendre le temps de leur répondre, y compris pour leur signifier le cas échéant que vous avez changé de projet.<br />
<br />
Nous vous rappelons que TripConnexion n’est pas une agence de voyages. Nous sommes un guide de voyage en ligne qui vous permet d’être contacté rapidement et gratuitement par des experts locaux. En effet, TripConnexion ne touche aucune commission sur le voyage que vous pourriez éventuellement organiser auprès de nos partenaires, <strong>c’est du véritable voyage en direct !</strong><br />
<br />
Merci encore de nous avoir contactés et à très bientôt sur <a href='" . JURI::base() . "?utm_source=ecard&utm_medium=mail&utm_campaign=ecardprojetdevoyage' target='_blank'>TripConnexion.com</a>.<br />
<br />
L'équipe de <a href='" . JURI::base() . "' target='_blank'><font color='#04a4a3'>TripConnexion</font></a><br />
<a href='http://www.tripconnexion.com/?utm_source=ecard&utm_medium=mail&utm_campaign=ecardprojetdevoyage' target='_blank'><img src='" . JURI::base() . "templates/tpcx/images/logo-email.png' border='0' alt='' /></a>
<table border='0' cellpadding='0' cellspacing='0'>
<tr>
<td><font color='#741b47'>&nbsp; &nbsp; Julie FLORENSON</font></td>
</tr>
<tr>
<td><a href='mailto:julie.florenson@tripconnexion.com' target='_blank'>julie.florenson@<wbr>tripconnexion.com</a>&nbsp;|&nbsp;
<font color='#0000ff'><u>+33 (0)9 84 46 43 19</u></font></td>
</tr>
<tr>
<td><a href='http://www.tripconnexion.com/' target='_blank'>www.tripconnexion.com</a></td>
</tr>
<tr>
<td>
    <a href='https://www.facebook.com/Tripconnexion' target='_blank'>
        <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/facebook_circle_gray-32.png' alt='Facebook' class='CToWUd'>
    </a>
    <a href='https://twitter.com/TripConnexion' target='_blank'>
        <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/twitter_circle_gray-32.png' alt='Twitter' class='CToWUd'>
    </a>
    <a href='http://www.pinterest.com/tripconnexion/' target='_blank'>
        <img src='http://www.tripconnexion.com/images/divers/ecard/1404152923_pinterest-icon-circle-grey.png' alt='TripConnexion sur Pinterest' class='CToWUd'>
    </a>
    <a href='http://google.com/+Tripconnexion-voyage' target='_blank'>
        <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/google_circle_gray-32.png' alt='Google +' class='CToWUd'>
    </a>
    <a href='https://www.youtube.com/channel/UCC5jiEqxh5irrsMeaCF_QFA' target='_blank'>
        <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/youtube_circle_gray-32.png' alt='Youtube' class='CToWUd'>
    </a>
</td>
</tr>
</table>
";
        
        $object = $prenom . ", votre projet de voyage : " . $model->getItem(JRequest::getVar('choix-pays-1'), 'tag');
        if($choixPays2 != '')
            $object .= ' / ' . $model->getItem(JRequest::getVar('choix-pays-2'), 'tag');
        if($choixPays3 != '')
            $object .= ' / ' . $model->getItem(JRequest::getVar('choix-pays-3'), 'tag');
        
        $mail = new JMail();
        $mail->sendMail("julie.florenson@tripconnexion.com", "Julie de TripConnexion", $email, $object, $htmlInternaute, true);
        
        $app->redirect($url_redirection);
    }

    public function mappemonde($tpl = null) 
    {
        $app    = JFactory::getApplication('site');
        
        // Display the view
        parent::display($tpl);
        
        $app->close();
    }
	
	public function insertNewsletter()
	{
		$app    = JFactory::getApplication('site');
		
		$email = JRequest::getVar( 'email' );
		$provenance = JRequest::getVar( 'provenance' );

		// newsletter
        require_once JPATH_SITE . '/modules/mod_tpcx_newsletter/helper.php';
		
		$msgConfirm = false;
	    $insertEmail = modTpcxNewsletterHelper::insertNewsletter('', '', '', '', $email, $provenance, 1);
	    if($insertEmail) {
	        $msgConfirm = true;
	    }
		$msgConfirm = true;
        
        echo json_encode('Votre abonnement à la newsletter a bien été pris en compte.');
        
        $app->close();
	}
	
	public function checkproduct()
    {
        $app    = JFactory::getApplication('site');
           
        $continent_id = JRequest::getVar( 'continent_id' );
        $pays_id = JRequest::getVar( 'pays_id' );
        $thematique_id = JRequest::getVar( 'thematique_id' );
        
        $model = JModelLegacy::getInstance('Articles', 'TpcxtagsModel', array('ignore_request' => true));
        
        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);
        
        $model->setState('filter.published', 1);
        $model->setState('filter.category_id', 10);
        $model->setState('filter.continent', $continent_id);
        $model->setState('filter.pays', $pays_id);
        $model->setState('filter.thematique', $thematique_id);
        
        $items = $model->getItems();
        
        echo json_encode(count($items));
        
        $app->close();
        
    }
    
    public function listtags()
    {
        $app    = JFactory::getApplication('site');
        
        $term = JRequest::getVar( 'term' );
        
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category, subcategory');
        $query->from('#__tpcxtags');
        $query->order('tag ASC');
        
        if($term)
            $query->where('tag LIKE "%' . $term . '%"');
        
        $db->setQuery($query);

        $items = $db->loadObjectList();
        
        echo json_encode($items);
        
        $app->close();
        
    }

    public function accountcreate()
    {
        $app    = JFactory::getApplication('site');
        
        $response = array();
        $response['error'] = false;
        
        $db     = JFactory::getDbo();
        
        $civilite = JRequest::getVar( 'civilite' );
        $nom = JRequest::getVar( 'nom' );
        $prenom = JRequest::getVar( 'prenom' );
        $email = JRequest::getVar( 'email' );
        $newsletter = JRequest::getVar( 'newsletter' );
        $selection = JRequest::getVar( 'selection' );
        
        $db->setQuery(
            'SELECT * FROM joomla_tpcx_account_users WHERE email = "' . $email . '"'
        );
        $db->query();
        if($db->getNumRows() > 0) {
            $response['error'] = true;
            $response['errorMsg'] = 'Vous êtes déjà inscrit.';
            
            header('Content-type: application/json');
            echo json_encode($response);
            $app->close();
        }
        
        $db->setQuery(
            'INSERT INTO joomla_tpcx_account_users (selection, civilite, nom, prenom, email, address_ip, created)' . 
            ' VALUES (' . $db->quote($selection) . ', ' . $db->quote($civilite) . ', ' . $db->quote($nom) . ', ' . $db->quote($prenom) . ', "' . $email . '", "' . $_SERVER['REMOTE_ADDR'] . '", NOW())'
        );
        
        if($db->query()) {
            // newsletter
            if($newsletter == 1) {
                require_once JPATH_SITE . '/modules/mod_tpcx_newsletter/helper.php';
                $insertEmail = modTpcxNewsletterHelper::insertNewsletter($civilite, $nom, $prenom, '', $email, "FORM_PRE_INSCRIPTION", 1, 0);
            }    
        }
        
        header('Content-type: application/json');
        echo json_encode($response);

        $app->close();
    }
}