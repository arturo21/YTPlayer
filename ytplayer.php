<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://solucionesweb.net.ve
 * @since             1.0.0
 * @package           ytplayer
 *
 * @wordpress-plugin
 * Plugin Name:       ytplayer
 * Plugin URI:        http://solucionesweb.net.ve
 * Description:       Creates an iframe of a youtube video using the youtube iframe API with a shortcode
 * Version:           1.0.0
 * Author:            Arturo Vásquez
 * Author URI:        http://arturovasquez.com.ve/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ytplayer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'YTPlayer', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_ytplayer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ytplayer-activator.php';
	ytplayer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_ytplayer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ytplayer-deactivator.php';
	ytplayer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ytplayer' );
register_deactivation_hook( __FILE__, 'ytplayer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ytplayer.php';
/*
******MIS FILTROS Y ACCIONES********
*/
		function show_video_youtube( $atts ) {
			//leer attrib que se llame idvideo
			$idvideo=$atts['idvideo'];
			$autoplay=$atts['autoplay'];
			$loop=$atts['loop'];
			$controls=$atts['controls'];
			$mute=$atts['mute'];
			echo("AUTOPLAY: ".$autoplay);
			if(is_numeric($autoplay)){
				if($autoplay>1){
					$autoplay=1;
				}
			}
			else{
				$autoplay=1;
			}
			if(is_numeric($loop)){
				if($loop>1){
					$loop=1;
				}
			}
			else{
				$loop=1;
			}
			if(is_numeric($controls)){
				if($controls>1){
					$controls=0;
				}
			}
			else{
				$controls=0;
			}
			if(is_numeric($mute)){
				if($mute>1){
					$mute=1;
				}
			}
			else{
				$mute=1;
			}
			// $atts = shortcode_atts( array(
			// 	'foo' => 'no foo',
			// 	'baz' => 'default baz'
			// ), $atts, 'bartag' );
			if(!empty($idvideo) && !is_admin()){
				?>
				<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
				<div id="contentplayer">
					<div id="player"></div>
				</div>

				<script>
					// 2. This code loads the IFrame Player API code asynchronously.
					var tag = document.createElement('script');

					tag.src = "https://www.youtube.com/iframe_api";
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

					// 3. This function creates an <iframe> (and YouTube player)
					//    after the API code downloads.
					var player;
					function onYouTubeIframeAPIReady() {
						player = new YT.Player('player', {
							height: '360',
							width: '640',
							videoId: '<?php echo($idvideo); ?>',
							playerVars:{
								'autoplay':<?php echo($autoplay); ?>,
								'loop':<?php echo($loop); ?>,
								'controls':<?php echo($controls); ?>,
								'mute':<?php echo($mute); ?>
							},
							events: {
								'onReady': onPlayerReady,
								'onStateChange': onPlayerStateChange
							}
						});
					}
					// 4. The API will call this function when the video player is ready.
					function onPlayerReady(event) {
						event.target.playVideo();
					}

					// 5. The API calls this function when the player's state changes.
					//    The function indicates that when playing a video (state=1),
					//    the player should play for six seconds and then stop.
					var done = false;
					function onPlayerStateChange(event) {
						var autoplayVar;
						autoplayVar=player.b.b.playerVars.autoplay;
						if(autoplayVar==1){
							if (event.data ==YT.PlayerState.ENDED) {
								event.target.playVideo();
							}
						}
						else{
							event.target.stopVideo();
						}
					}
					function playVideo(event) {
						event.target.playVideo();
					}
					function stopVideo(event) {
						event.target.stopVideo();
					}
				</script>
				<?php
			}
			return 0;
		}
		add_shortcode( 'videoyoutube', 'show_video_youtube' );
/*
****************************
*/
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ytplayer() {

	$plugin = new ytplayer();
	$plugin->run();

}
run_ytplayer();
