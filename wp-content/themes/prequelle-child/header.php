<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until the main cotent
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<head>
	
<script src="<?=get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!--<script src="https://cdn.rawgit.com/leafo/sticky-kit/v1.1.2/jquery.sticky-kit.min.js"></script>-->
  <script src="<?=get_template_directory_uri(); ?>/assets/js/jquery-1.12.4.min.js"></script>
      

	<?php wp_head(); ?>
	

	<!-- search toggle script-->
<script>
	//$(".entry-summary").stick_in_parent();
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function js_function_seaxch() {
    document.getElementById("myDropdown").classList.toggle("show");
	dropdown.fadeIn('slow');
	
}
$(document).ready(function() {
	var element = document.getElementsByClassName('flexslider');
for(var i = 0; i < element.length; i++)
{
	element[i].classList.add('sticky');
}


});

</script>
<script>
$(document).ready(function(){
	function resizeForm(){
        var width = (window.innerWidth > 0) ? window.innerWidth : document.documentElement.clientWidth;
        if(width > 800){
		 $('.sticky').stickyBox({
						  stopper: '.related-products'
		   });
        } else {

        }    
    }
    window.onresize = resizeForm;
    resizeForm();
  
  
	// $('.ok').append('<option value="5"><a class="ok" href="http://138.197.64.28/popular-products/">test</a></option>');
    // $('ok').removeClass('orderby');

//	$('.input').on('click', function(){
//
//    $('body').addClass('loginform-popup-toggle');
//});

});

$('button').on('click', function(){
    $('button').removeClass('selected');
    $(this).addClass('selected');
});
$(".mob-filter").on("click", function () {
    $("form.woocommerce-ordering.cus-trend").addClass("show");
});
$('.mob-filter').click(function() {
    $('form.woocommerce-ordering.cus-trend').addClass('show');
});


</script>

</head>
<body <?php body_class(); ?>>
<?php
	/**
	 * prequelle_body_start
	 *
	 * Used to add a top anchor or other usefull stuff
	 *
	 * @see in/frontend/hooks.php prequelle_output_top_anchor functions
	 */
	do_action( 'prequelle_body_start' );

	/**
	 * wolf_body_start
	 *
	 * Hook dedicated to plugins
	 * Allow plugins to add content right after the body tag
	 */
	do_action( 'wolf_body_start' );
?>
<div class="site-container">
	<div id="page" class="hfeed site">
		<div id="page-content">

		<header id="masthead" class="site-header clearfix" itemscope itemtype="http://schema.org/WPHeader">

			<p class="site-name" itemprop="headline"><?php echo get_bloginfo( 'name' ); ?></p><!-- .site-name -->
			<p class="site-description" itemprop="description"><?php echo get_bloginfo( 'description' ); ?></p><!-- .site-description -->

			<div id="header-content">
				<?php
					/**
					 * Main Navigation hook
					 *
					 * @see inc/frontend/hooks/navigation.php
					 */
					do_action( 'prequelle_main_navigation' );
				?>
			</div><!-- #header-content -->

		</header><!-- #masthead -->

		<div id="main" class="site-main clearfix">
			<?php
				/**
				 * prequelle_main_content_start
				 *
				 * Used to add stuff that will be included in the main content area
				 *
				 * @see in/frontend/hooks.php
				 */
				do_action( 'prequelle_main_content_start' );
			?>
			<div class="site-content">
				<?php
					/**
					 * Hero
					 *
					 * prequelle_hero hook
					 *
					 * @see inc/frontend/hooks.php prequelle_output_hero function
					 */
					do_action( 'prequelle_hero' );
				?>
				<?php
					/**
					 * prequelle_after_header_block hook
					 */
					do_action( 'prequelle_after_header_block' );
				?>
				<div class="content-inner section wvc-row">
					<div class="content-wrapper">