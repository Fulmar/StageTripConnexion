<?php
/**
 * @version		3.2
 * @package		DISQUS Comments for Joomla! (package)
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<span id="startOfPage"></span>

<?php if($disqusArticleCounter): ?>
<!-- DISQUS comments counter and anchor link -->
<div class="jwDisqusArticleCounter">
	<span>
		<a class="jwDisqusArticleCounterLink" href="<?php echo $output->itemURL; ?>#disqus_thread" data-disqus-identifier="<?php echo $output->disqusIdentifier; ?>"><?php echo JText::_("JW_DISQUS_VIEW_COMMENTS"); ?></a>
	</span>
	<div class="clr"></div>
</div>
<?php endif; ?>

<?php echo $row->text; ?>

<!-- DISQUS comments block -->
<div class="jwDisqusForm">
	<?php echo $output->comments; ?>
</div>

