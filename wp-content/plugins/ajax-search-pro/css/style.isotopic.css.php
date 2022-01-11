<?php
/**
 * WARNING! DO NOT EDIT THIS FILE DIRECTLY!
 *
 * FOR CUSTOM CSS USE THE PLUGIN THEME OPTIONS->CUSTOM CSS PANEL.
 */

/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");
?>

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic .results .item .asp_content,
    <?php echo $asp_res_ids2; ?>.isotopic .results .item .asp_content,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic .results .item .asp_content {
    width: 100%;
    height: auto;
    z-index: 3;
    padding: 4px 6px;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic,
    <?php echo $asp_res_ids2; ?>.isotopic,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic {
    background: <?php echo $style['i_res_container_bg']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic .results .item,
    <?php echo $asp_res_ids2; ?>.isotopic .results .item,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic .results .item {
    width: <?php echo is_numeric($style['i_item_width']) ? $style['i_item_width'].'px' : $style['i_item_width']; ?>;
    height: <?php echo is_numeric($style['i_item_height']) ? $style['i_item_height'].'px' : $style['i_item_height']; ?>;
    box-sizing: border-box;
    background: <?php echo $style['i_res_item_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    .rtl <?php echo $asp_res_ids1; ?>.isotopic .results .asp_isotopic_item,
    .rtl <?php echo $asp_res_ids2; ?>.isotopic .results .asp_isotopic_item,
<?php endif; ?>
.rtl <?php echo $asp_res_ids; ?>.isotopic .results .asp_isotopic_item {
    -webkit-transition-property: right, top, -webkit-transform, opacity;
    -moz-transition-property: right, top, -moz-transform, opacity;
    -ms-transition-property: right, top, -ms-transform, opacity;
    -o-transition-property: right, top, -o-transform, opacity;
    transition-property: right, top, transform, opacity;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic .results .item.asp_gutter_bottom,
    <?php echo $asp_res_ids2; ?>.isotopic .results .item.asp_gutter_bottom,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic .results .item {
    margin-bottom: <?php echo w_isset_def($style['i_item_margin'], 10); ?>px;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic .results .item .asp_content,
    <?php echo $asp_res_ids2; ?>.isotopic .results .item .asp_content,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic .results .item .asp_content {
    background: <?php echo $style['i_res_item_content_background']; ?>;
}

/* Isotopic navigation */
<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic>nav,
    <?php echo $asp_res_ids2; ?>.isotopic>nav,
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic>nav,
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation {
    background: <?php echo $style['i_pagination_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation a.asp_prev,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation a.asp_prev,
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation a.asp_next,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation a.asp_next,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_prev,
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_next {
    background: <?php echo $style['i_pagination_arrow_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation a.asp_prev svg,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation a.asp_prev svg,
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation a.asp_next svg,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation a.asp_next svg,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_prev svg,
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_next svg {
    fill: <?php echo $style['i_pagination_arrow_color']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation ul li.asp_active,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation ul li.asp_active,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li.asp_active {
    background: <?php echo $style['i_pagination_arrow_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation ul li:hover,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation ul li:hover,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li:hover {
    background: <?php echo $style['i_pagination_arrow_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation ul li.asp_active,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation ul li.asp_active,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li.asp_active {
    background: <?php echo $style['i_pagination_page_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation ul li:hover,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation ul li:hover,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li:hover {
    background: <?php echo $style['i_pagination_page_background']; ?>;
}

<?php if ($use_compatibility == true): ?>
    <?php echo $asp_res_ids1; ?>.isotopic nav.asp_navigation ul li span,
    <?php echo $asp_res_ids2; ?>.isotopic nav.asp_navigation ul li span,
<?php endif; ?>
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li span {
    color:  <?php echo $style['i_pagination_font_color']; ?>;
}