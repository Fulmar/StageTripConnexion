<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();
$baseurl = JURI::base();

$template = $app->getTemplate();

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    var baseUrl = '<?php echo $baseurl; ?>';
    var templateUrl = '<?php echo $baseurl . '/templates/' . $template; ?>';
</script>
<script src="<?php echo $baseurl . '/templates/' . $template . '/js/functions.js'; ?>"></script>
<style>
<!--
/* ==========================================================================
                                    Mappemonde
   ========================================================================== */
.box-mappemonde {
    
}

.box-mappemonde h2 {
    color: #04a4a3;
    font: italic 700 16px/100% "LatoBoldItalic", sans-serif;
}

.box-mappemonde p.intro,
.box-mappemonde #data {
    color: #535353;
    font: 400 14px/100% "LatoRegular", sans-serif;
}

.box-mappemonde .mappemonde {
    list-style: none;
    position: relative;
    margin: 0;
    padding: 0;
    width: 661px;
    height: 397px;
    background: url('../images/mappemonde-area.png') top left no-repeat;
}

.box-mappemonde .mappemonde li {
    margin: 0;
    padding: 0;
    display: block;
    position: absolute;
}

.box-mappemonde .mappemonde li a {
    display: block;
    text-indent: -9999px;
    text-decoration: none;
}

.box-mappemonde .mappemonde li.afrique {
    left: 195px;
    top: 181px;
    width: 206px;
    height: 145px;
}
.box-mappemonde .mappemonde li.afrique a { height: 145px; }
.box-mappemonde .mappemonde li.afrique:hover {
    background: url('../images/mappemonde-area.png') 0 -397px no-repeat;
}

.box-mappemonde .mappemonde li.europe {
    left: 284px;
    top: 32px;
    width: 253px;
    height: 163px;
}
.box-mappemonde .mappemonde li.europe a { height: 163px; }
.box-mappemonde .mappemonde li.europe:hover {
    background: url('../images/mappemonde-area.png') -206px -397px no-repeat;
}

.box-mappemonde .loader {
    text-align: center;
    display: none;
}

.box-mappemonde .list-pays {
    overflow-y: scroll;
    height: 100px;
    margin-top: 10px;
}

.box-mappemonde .list-pays ul {
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
    width: 140px;
    padding-left: 20px;
    border-left: 1px solid #dadada;
}

.box-mappemonde .list-pays ul:first-child {
    margin-left: 0;
    border-left: none;
}

.box-mappemonde .list-pays ul li a {
    color: #535353;
    text-decoration: none;
    font: 400 13px/100% "LatoRegular", sans-serif;
}

.box-mappemonde .list-pays ul li a:hover {
    color: #04a4a3;
    cursor: pointer;
    font: 700 13px/100% "LatoBold", sans-serif;
}

-->
</style>
</head>

<body>

	<div class="box-mappemonde">
	    
	    <script>
	        function preload(arrayOfImages) {
	            $(arrayOfImages).each(function() {
	                $('<img/>')[0].src = this;
	                // Alternatively you could use:
	                // (new Image()).src = this;
	            });
	        }
	
	        // Usage:
	        preload(['<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-europe.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-amerique-centrale.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-afrique.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-amerique-nord.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-amerique-sud.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-asie.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-moyen-orient.png'; ?>',
	            '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-oceanie.png'; ?>']);
	    </script>
	    
	    <h2>Rechercher sur la mappemonde :</h2>
	    
	    <p class="intro">Sélectionnez un continent pour afficher sous la mappemonde la liste des pays et cliquez sur l’un d’eux pour afficher nos partenaires sur cette destination :</p>
	    
	    <div class="mappemonde-area">
	    
	        <img id="imgmap" src="<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>" alt="imagemap" usemap="#map" border="0">
	    
	        <map name="map">
	             
	        
	             <area shape="poly"
	                coords="265,102,290,171,289,181,290,187,306,183,322,181,329,186,342,190,355,191,348,180,358,177,360,165,368,170,379,173,396,184,397,172,404,167,405,141,420,135,425,123,422,114,418,99,421,93,421,86,417,81,407,76,406,66,415,48,426,43,428,37,426,35,414,40,398,65,356,74,345,74,279,95,266,99,265,102"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-europe.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('5')" />
	                
	            <area shape="poly"
	                coords="133,219,127,225,130,229,146,231,158,242,168,243,171,242,186,222,183,218,171,214,157,213,146,216,133,219"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-amerique-centrale.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('105')" />
	             
	             <area shape="poly"
	                coords="296,189,287,195,279,210,276,217,277,230,282,255,314,264,326,266,326,284,328,292,332,304,339,321,356,322,389,302,396,282,392,244,398,238,392,235,376,226,370,214,368,204,360,194,346,195,325,184,311,185,296,189"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-afrique.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('8')" />
	                
	            <area shape="poly"
	                coords="109,21,86,40,37,71,19,87,17,101,28,136,48,123,66,128,77,151,87,158,86,181,97,196,108,212,129,227,136,220,136,204,161,209,163,194,175,184,193,169,216,160,210,144,204,137,235,111,254,93,271,79,276,52,276,34,270,20,150,18,109,21"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-amerique-nord.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('10')" />
	                
	            <area shape="poly"
	                coords="178,233,166,240,161,256,159,270,168,283,175,288,171,337,172,353,173,369,193,371,189,356,191,343,237,300,240,278,248,269,236,258,218,248,203,240,195,235,178,233"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-amerique-sud.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('9')" />
	            
	            <area shape="poly"
	                coords="490,30,471,42,429,64,423,75,419,97,421,119,426,125,404,143,399,164,396,174,398,181,409,187,415,202,419,211,441,244,449,241,474,251,493,272,507,274,557,273,563,266,549,259,555,192,564,174,585,150,619,118,637,106,643,101,621,82,572,49,555,40,490,30"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-asie.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('6')" />
	                
	            <area shape="poly"
	                coords="351,177,351,186,364,195,367,200,385,235,411,224,419,211,420,201,387,180,368,173,351,177"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-moyen-orient.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('96')" />
	                
	            <area shape="poly"
	                coords="526,281,509,293,504,299,504,315,515,332,524,352,566,347,598,352,613,336,612,326,603,321,573,275,563,265,538,277,526,281"
	                onmouseover="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-oceanie.png'; ?>';"
	                onmouseout="document.getElementById('imgmap').src = '<?php echo $baseurl. 'templates/' . $template . '/images/mappemonde/mappemonde-area-html.png'; ?>';" 
	                href="javascript:void(0);"
	                onclick="getListPaysMappemonde('7')" />
	             
	        </map>
	    
	    </div>
	    
	    <div class="loader">
	        <img src="<?php echo JURI::base() . 'templates/' . $template . '/images/ajax-loader.gif'; ?>" alt="" />
	    </div>
        
        <div id="dataMappemonde" style="display: none; position: absolute; background: #ffffff; width: 100%; top: 450px; padding: 5px; text-align: center;">
            <div id="data">Vous souhaitez rechercher un partenaire ou un produit d'un partenaire ?<br />
                <div style="text-align: center; margin-top: 20px;" class="clearfix">
                    <a href="" id="btn-choix-partenaire-mappemonde" style="float: left; width: 300px; display: block;"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/btn-choix-partenaire.png'; ?>" alt="" /></a>
                    <a href="" id="btn-choix-produit-mappemonde" style="float: left; width: 300px; display: block;"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/btn-choix-produit.png'; ?>" alt="" /></a>
                </div>
            </div>
        </div>
	    
	    <div class="list-pays">
	        
	    </div>
	
	</div>

</body>
</html>