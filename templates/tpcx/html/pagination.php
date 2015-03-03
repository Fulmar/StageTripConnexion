<?php 

function pagination_list_render($list)
{
    // Reverse output rendering for right-to-left display.
    /*$html = '<ul>';
    $html .= '<li>Page</li>';
    foreach($list['pages'] as $index => $page) {
        $html .= '<li>'.$page['data'].'</li>';
        if($index != count($list['pages']))
            $html .= '<li>-</li>';
    }
    $html .= '</ul>';

    return $html;*/
 
    // Reverse output rendering for right-to-left display.
    $html = '<ul>';
    $html .= '<li class="pagination-start">' . $list['start']['data'] . '</li>';
    $html .= '<li class="pagination-prev">' . $list['previous']['data'] . '</li>';
    
    $limitDotted = 4;
    $startPage = 1;
    $count = count($list['pages']);
    
    $dotted = false;
    if($count > $limitDotted) {
        $dotted = true;
    }
    
    $start = JRequest::getVar('start');
    $url = JURI::current() . '?start=';

    foreach($list['pages'] as $key => $page) {
        
        if(!$page['active'])
            $currentPage = $key;
        
    }
    
    $startPage = $currentPage;
    if($currentPage > $count - $limitDotted)
        $startPage = $count - $limitDotted;
    $endPage = $startPage + $limitDotted;
    
    $posStart = strpos($list['next']['data'], 'href="');
    $posEnd = strpos($list['next']['data'], '" class=');
    $dottedNextUrl = substr($list['next']['data'], $posStart + 6, $posEnd - $posStart - 6);
    
    $posStart = strpos($list['previous']['data'], 'href="');
    $posEnd = strpos($list['previous']['data'], '" class=');
    $dottedPrevUrl = substr($list['previous']['data'], $posStart + 6, $posEnd - $posStart - 6);
    
    if($startPage > 1)
        $html .= '<li><a href="' . $dottedPrevUrl . '" class="pagenav">...</a></li>';

    foreach ($list['pages'] as $key => $page)
    {
        
        if($key >= $startPage && $key <= $endPage)
            $html .= '<li>' . $page['data'] . '</li>';
        
    }
    
    if($count > $endPage)
        $html .= '<li><a href="' . $dottedNextUrl . '" class="pagenav">...</a></li>';
    
    $html .= '<li class="pagination-next">' . $list['next']['data'] . '</li>';
    $html .= '<li class="pagination-end">' . $list['end']['data'] . '</li>';
    $html .= '</ul>';

    return $html;
}

?>