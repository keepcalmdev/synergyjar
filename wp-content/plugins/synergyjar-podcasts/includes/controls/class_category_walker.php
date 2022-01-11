<?php

class Category_Walker_Custom extends Walker_Category
{
	public function start_lvl( &$output, $depth = 0, $args = array() )
	{
		$output .= "\n<ul>\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() )
	{
		$output .= "</ul>\n";
	}

	public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
	{
		$output .= '<li id="' . $object->cat_ID . '" class="cat-item cat-item-' . $object->cat_ID . ' podcast-filters-list podcast-cat-' . $object->cat_ID. '">' . $object->name;
	}

	public function end_el( &$output, $item, $depth = 0, $args = array())
	{
		$output .= "</li>\n";
	}
}
