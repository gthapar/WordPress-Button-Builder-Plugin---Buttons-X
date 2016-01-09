<?php

// Make sure we don't expose any info if called directly
if ( !defined( 'ABSPATH' ) )
	exit;

	include_once 'page-header.php';
	global $btnsx_settings;
	$tab = ( isset( $btnsx_settings['tab'] ) && $btnsx_settings['tab'] != '' ? $btnsx_settings['tab'] : '0' );
?>
	<div class="" style="margin-right: 20px;background-color:#fcfcfc;">
		<!-- Page Content goes here -->
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$( '#btnsx-tabs-0' ).find('nav ul li:eq(<?php echo $tab; ?>)').trigger('click');
			// console.log(window.location.hash);
			var ig_token = document.URL.substr(document.URL.indexOf('#')+1);
			if( window.location.hash != '' ){
				ig_token = ig_token.replace( 'access_token=', '' );
				$('#social_counters_ig_access_token').val(ig_token);
			}
		});
		</script>
		<div class="row">
			<form id="btnsx-settings-form" name="btnsx-settings-form" method="post" action="">
				<?php settings_fields( 'btnsx_settings_group' ); ?>
		    	<div class="col m12 l9" style="padding:0;">
		        	<!-- page content  -->
					<?php
					$post_types = get_post_types( array( 'public' => true ) );
					$post_types_filter = array( 'attachment', 'buttons-x' );
					foreach( $post_types_filter as $key ) {
					   unset( $post_types[ $key ] );
					}
		        	$btnsx_default_options = array(
		        		array(
		        			'icon_class'	=>	'fa fa-pencil',
		        			'text'			=>	__( 'General', 'btnsx' ),
		        			'elements'		=> array(
								array(
									'type'			=>	'radio',
									'name'			=>	'css',
									'label'			=>	__( 'CSS', 'btnsx' ),
									'tooltip'		=>	__( 'Select CSS to be displayed inline or through external file.', 'btnsx' ),
									'options'		=>	array(
										'css_external'	=>	'external <span style="color:#fff;background-color:#ee6e73;padding:2px 3px;font-size:9px;font-weight:bold;border-radius:4px;margin-left:5px;">Pro Feature</span>',
										'css_inline'	=>	'inline'
									),
									'value'			=>	isset( $btnsx_settings['css'] ) && $btnsx_settings['css'] != '' ? $btnsx_settings['css'] : 'inline'
								)
							),
						),
						array(
		        			'icon_class'	=>	'fa fa-exchange',
		        			'text'			=>	__( 'Free Vs Pro', 'btnsx' ),
		        			'elements'		=> array(
								array(
									'type'			=>	'html',
									'value'			=>	$btnsx->free_vs_pro()
								)
							),
						)
			        );
					// filter to add custom options
		        	$btnsx_filtered_options = apply_filters( 'btnsx_settings_filter', array() );
		        	$btnsx_options = wp_parse_args( $btnsx_filtered_options, $btnsx_default_options );
		        	$btnsx_form_design->tabs(
		        		array(
		        			'id'			=>	'btnsx-tabs-0',
		        			'outer_group'	=>	$btnsx_options
		        		)
		        	);
		        	?>
		      	</div>
		      	<style type="text/css">
		      		.col-pad-css {
						padding: 20px 10px 0!important;
			      	}
			      	.col-pad-settings {
						padding: 20px 10px!important;
			      	}
			      	.btn-save-css {
			      		position: relative;
			      	}
			      	.btnsx .btn-save-css:focus {
			      		background-color: #AFAFAF;
			      	}
			      	#btnsx-settings-css-bg {
			      		position: absolute;
			      		height: 100%;
			      		width: 0%;
			      		left: 0;
			      		top: 0;
			      		background-color: rgba(42, 183, 149, 0.7);
			      	}
			      	#btnsx-settings-css-text {
			      		position: absolute;
			      		height: 100%;
			      		width: 100%;
			      		top: 0;
			      		left: 0;
			      		z-index: 999;
			      	}
			      	.btn-save {
						background-color: <?php echo $_wp_admin_css_colors[$current_color]->colors[3]; ?> !important;
						background-image: none !important;
			      	}
			      	.btn-reset {
						background-color: <?php echo $_wp_admin_css_colors[$current_color]->colors[2]; ?> !important;
						background-image: none !important;
			      	}
			      	.btn-settings {
			      		width: 100% !important;
						border: 0 !important;
						color: #fff !important;
			      	}
			      	.btn-settings:disabled {
			      		opacity: 0.4;
			      	}
			      	.btnsx-sc-authenticate { border: 1px solid #ee6e73 !important; color: #ee6e73 !important; }
			      	.btnsx-sc-authenticated { border: 1px solid #26a69a !important; color: #26a69a !important; }
		      	</style>
		      	<div class="col m12 l3">
		      		<div class="col s12 col-pad-css" style="display:none;">
		      			<button id="btnsx-settings-css-submit" name="btnsx-settings-css-submit" class="btn btn-save-css btn-settings" type="submit"><span id="btnsx-settings-css-text"><?php _e( 'Save & Regenerate CSS', 'btnsx' ); ?></span></button>
		      		</div>
			        <div class="col s6 col-pad-settings">
				    	<button id="btnsx-settings-submit" class="btn btn-save btn-settings" type="submit"><?php _e( 'Save', 'btnsx' ); ?></button>
				    </div>
				    <div class="col s6 col-pad-settings">
				    	<button id="btnsx-settings-reset" class="btn btn-reset btn-settings" type="submit"><?php _e( 'Reset', 'btnsx' ); ?></button>
				    </div>
		      	</div>
		      	<div class="col m12 l3">
		      		<div class="help-links" style="padding: 10px;">
			      		<p><?php _e( 'Helpful Links:', 'btnsx' ); ?></p>
				        <ul>
				        	<li><a href="https://www.button.sx/product-category/add-ons/"><?php _e( 'Button Add-ons', 'btnsx' ); ?></a></li>
				        	<li><a target="_blank" href="https://www.button.sx/product-category/packs/"><?php _e( 'Button Packs', 'btnsx' ); ?></a></li>
				        	<li><a target="_blank" href="https://gautamthapar.atlassian.net/wiki/display/BX/"><?php _e( 'Documentation', 'btnsx' ); ?></a></li>
				        	<li><a target="_blank" href="http://gautamthapar.ticksy.com"><?php _e( 'Pro Support', 'btnsx' ); ?></a></li>
				        	<li><a target="_blank" href="https://www.button.sx/"><?php _e('Official Website','btnsx'); ?></a></li>
				        	<li><a target="_blank" href="https://twitter.com/Gautam_Thapar"><?php _e('Twitter','btnsx'); ?></a></li>
				        </ul>
				        <br>
				        <a href="http://btn.sx/1IUqaqK" style="font-weight:700;">GET PRO VERSION</a>
				    </div>
		      	</div>
	      	</form>
	    </div>
	</div>

</div>