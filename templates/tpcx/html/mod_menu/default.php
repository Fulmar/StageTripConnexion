<?php

// No direct access.
defined('_JEXEC') or die;

$countLevel2 = 1;

$separatorColumn = 5;
$columnWidth = 140;
$margeColumn = 25;

$parentTagId = null;
$showDropdown = false;
?>

<ul<?php echo $class_sfx ? ' class="' . $class_sfx . '"' : ''?><?php echo $params->get('tag_id') != NULL ? ' id="' . $params->get('tag_id') . '"' : '' ?>>
	
<?php foreach ($list as $i => &$item) :
	
		$class = array();
        
        $styleSubmenu = array();
		
		$class[] = 'item';
		
        if(isset($oldParent) && $oldParent != $item->parent_id)
            $countLevel2 = 1;
        
        if($item->level == 1) {
            $app = JFactory::getApplication();
            $menu = $app->getMenu();
            $childs = $menu->getItems('parent_id', $item->id);
            $countChilds = count($childs);
            
            $nbColmn = ceil($countChilds / $separatorColumn);
            
            $minWidth = $columnWidth * $nbColmn + ($margeColumn * $nbColmn);
            
            if($item->alias == 'pays' || $item->alias == 'thematiques' || $item->alias == 'continent')
                $styleSubmenu[] = 'min-width: 305px';
            else
                $styleSubmenu[] = 'min-width: ' . $minWidth . 'px';
        }
        
        $oldParent = $item->parent_id;
        
        if($item->level == 1 && $item->alias == 'pays') {
            $showDropdown = false;
            $parentTagId = $item->id;
        }
        if($item->level == 1 && $item->alias == 'thematiques') {
            $showDropdown = false;
            $parentTagId = $item->id;
        }
        if($item->level == 1 && $item->alias == 'continent') {
            $showDropdown = false;
            $parentTagId = $item->id;
        }
        
		// add "level" class, ex : level1, level2
		if ( $item->level )
			$class[] = 'level' . $item->level;
		
		if ( $item->id == $active_id )
			$class[] = 'current';
	
		if ( $item->type == 'alias' && in_array($item->params->get('aliasoptions'),$path) || in_array($item->id, $path))
			$class[] = 'active';
			
		if ( $item->deeper || $item->parent )
			$class[] = 'deeper';
        
        if (preg_match("/MSI/", $_SERVER["HTTP_USER_AGENT"])) {
            $is_ie = true;
        } else {
            $is_ie = false;
        }
        
        if($parentTagId == $item->parent_id && !$is_ie) {
            
            if(!$showDropdown) {
                // list pays
                $app = JFactory::getApplication();
                $menu = $app->getMenu();
                $childs = $menu->getItems('parent_id', $parentTagId);
                
                echo '<select name="menu-pays" class="customSelectMenu" style="height: 16px;" onchange="document.location.href = this.value;">';
                echo '<option value="">--- Choisissez ---</option>';
                foreach($childs as $menu):
                    echo '<option value="' . $menu->flink . '">';
                        echo $menu->title;
                    echo '</option>';
                endforeach;
                
                echo '</select>';
                
                // display once
                $showDropdown = true;
            }
            
        }
        
        if($parentTagId != $item->parent_id || $is_ie) {
            
            // item general
            echo '<li id="item-'.$item->id.'" class="' . implode(' ', $class) . '">';
        
            // Render the menu item.
            switch ($item->type) :
                case 'separator':
                case 'url':
                case 'component':
                    require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
                    break;
        
                default:
                    require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                    break;
            endswitch;
        
        }

		// The next item is deeper.
		if ($item->deeper) {
			echo '<div class="submenu-container" style="' . implode(' ', $styleSubmenu) . '"><div class="submenu"><ul style="width: ' . $columnWidth . 'px;">';
		}
		// The next item is shallower.
		elseif ($item->shallower) {
		    if($parentPaysId != $item->parent_id || $is_ie) {
                echo '</li>';
            }
            echo str_repeat('</ul></div></div></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else {
		    if($parentPaysId != $item->parent_id || $is_ie) {
                echo '</li>';
            }

            if($countLevel2%$separatorColumn == 0)
                echo '</ul><ul>';
		}
		
        if($item->level == 2)
            $countLevel2++;
        
	endforeach; ?>

</ul>

