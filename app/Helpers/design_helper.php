<?php

/** display parent chaild menu* */
function getDropDown($type = 'top')
{
    $menu_type = \App\Models\Back\MenuType::where('menu_type', strtolower($type))->first();

    $id = 0;
    $var = '';
    $select = '';

    $orderby = 'ORDER BY menu_sort_order ASC';

    $where = "where parent_id = 0 and status= 'Y' and menu_types = " . $menu_type->id;
    $query = \Illuminate\Support\Facades\DB::select('select id,menu_label, menu_id, menu_url,open_in_new_window,show_no_follow,is_external_link  from menus ' . $where . ' ' . $orderby);

    if (count($query) > 0) {
        foreach ($query as $row) {
            if ($id > 0) {
                $var = ($row->id == $id) ? 'style="color:red" selected="selected"' : '';
            }
            $isdropdown = (is_child($row->id, $menu_type->id)) ? 'dropdown-toggle' : '';
            $isdropdownb = (is_child($row->id, $menu_type->id)) ? '<b class="caret"></b>' : '';
            $prelink = ($row->is_external_link == 'N') ? site_link() : '';
            $isnofollow = ($row->show_no_follow == 1) ? ' rel="nofollow" ' : '';

            $isactive = '';

            $navLICls = 'nav-item';
            $navLinkCls = 'nav-link';
            if ($type == 'footer') {
                $navLinkCls = '';
            }

            $targetBlank = '';
            if ($row->open_in_new_window == 'yes') {
                $targetBlank = 'target="_blank"';
            }

            $select .= ' <li class="' . $navLICls . ' ' . $isactive . '">';
            $select .= '<a class="' . $navLinkCls . ' ' . $isdropdown . '" ' . $targetBlank . ' ' . $isnofollow . ' href="' . $prelink . $row->menu_url . '">' . $row->menu_label . ' ' . $isdropdownb . '</a>';            

            if (is_child($row->id, $menu_type->id) == TRUE) {
                $select .= getSubDropDown($row->id, '--', $id, $menu_type);
            }
            $select .= '</li>';
        }
    }
    return $select . '';
}

function getSubDropDown($childs, $dash = '--', $id = 0, $menu_type)
{
    $select = '';
    $open_in_new_window = 'target="_blank"';
    $orderby = 'ORDER BY menu_sort_order ASC';

    $var = '';
    $where = " where parent_id =  $childs and status = 'Y' and menu_types = " . $menu_type->id;
    $query = \Illuminate\Support\Facades\DB::select('select id,menu_label, menu_id, menu_url,open_in_new_window,show_no_follow,is_external_link from menus' . $where . ' ' . $orderby);

    if (count($query) > 0) {
        $select .= "<ul class='submenu'>";
        foreach ($query as $row) {
            if ($id > 0) {
                $var = ($row->id == $id) ? 'style="color:red" selected="selected"' : '';
            }
            $isdropdown = (is_child($row->id, $menu_type->id)) ? 'dropdown-toggle' : '';
            $isdropdownb = (is_child($row->id, $menu_type->id)) ? '<b class="caret"></b>' : '';
            $prelink = ($row->is_external_link == 'N') ? site_link() : '';
            $isnofollow = ($row->show_no_follow == 1) ? ' rel="nofollow" ' : '';

            $isactive = '';

            $targetBlank = '';
            if ($row->open_in_new_window == 'yes') {
                $targetBlank = 'target="_blank"';
            }

            $select .= ' <li class="' . $isactive . '">';
            $select .= '<a class="' . $isdropdown . '" ' . $targetBlank . ' ' . $isnofollow . ' href="' . $prelink . $row->menu_url . '">' . $row->menu_label . ' ' . $isdropdownb . '</a>';

            if (is_child($row->id, $menu_type->id) == TRUE) {
                $dashs = $dash . '---';
                $select .= getSubDropDown($row->id, $dashs, $id, $menu_type);
            }
            $select .= '</li>';
        }
        $select .= "</ul>";
    }
    return $select;
}

function is_child($parent_id, $menu_type_id)
{
	$where = " where parent_id = $parent_id and menu_types = " . $menu_type_id;
	$query = \Illuminate\Support\Facades\DB::select("select * from menus " . $where);
	if (count($query) > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}
function social_media()
{
	$sm = \App\Models\Back\SocialMedia::where('sts', 'active')->orderBy('item_order', 'ASC')->get();
	$html = '';
	foreach ($sm as $key => $value) {
		$newTab = ($value['open_in_new_tab'] == 'Yes') ? 'target="_blank"' : '';
		if (trim($value['link'] != "")) {
			$html .= '<li><a ' . $newTab . ' title="' . $value['alt_tag'] . '" href="' . $value['link'] . '"><i class="fab ' . $value['i_class'] . '" aria-hidden="true"></i></a></li> ';
		}
	}
	return $html;
}
function cms_page_heading($heading, $pageID = 0)
{
	return '
    <div class="pagetitle_wrap">
        <div class="container">
            <h1>' . $heading . '</h1>
        </div>
    </div>';
}
