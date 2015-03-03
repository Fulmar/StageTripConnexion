<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$topic_id = JRequest::getInt('id');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tpcxsocial'.DS.'tables');

if($topic_id) {
    $topic = JTable::getInstance('Topic', 'TpcxsocialTable');
    $topic->load($topic_id);
    
    $categories = $topic->category_id;
    
    $category = JTable::getInstance('Category', 'TpcxsocialTable');
    $category->load($categories[0]);
}
    
$category_image = JURI::base() . 'components/com_tpcxsocial/template/images/header.jpg';
if($category && $category->images) {
    $category_image = JURI::base() . $category->images;
}

?>
<div class="header topic" style="background-image: url('<?php echo $category_image; ?>');">
    <div class="bg-top"></div>
    <div class="bg-bottom"></div>
    
</div>
