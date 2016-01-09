<?php
/**
 * Buttons X Form Elements
 *
 * This file is used to output form elements.
 *
 * @package Buttons X
 * @since 0.1
 */

// Make sure we don't expose any info if called directly
if ( !defined( 'ABSPATH' ) )
	exit;

if( !class_exists( 'BtnsxFormElements' ) ) {
	
	class BtnsxFormElements {

		private static $instance;

		/**
		 * Initiator
		 * @since 0.1
		 */

		public static function init(){
			return self::$instance;
		}

		/**
		 * CPT as select options
		 * @since  0.1
		 * @param  string    $selected
		 * @return string
		 */
		public function cpt( $type, $selected ) {
			$options = array();

			$args = array(
				'post_type' => $type,
				'post_status' => 'publish',
				'posts_per_page' => -1
			);
			$query = new WP_Query( $args );
			// The Loop
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$options[ get_the_ID() ] = get_the_title();
				}
			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();

			$output = '';
			foreach ( $options as $k => $l ) {
				if( is_array( $selected ) ) {
					if( in_array( $k, $selected ) ) {
						$output .= '<option value="' . $k . '" selected>' . $l . '</option>';
					} else {
						$output .= '<option value="' . $k . '">' . $l . '</option>';
					}
				} else {
					if( $k == $selected ){
						$output .= '<option value="' . $k . '" selected>' . $l . '</option>';
					} else {
						$output .= '<option value="' . $k . '">' . $l . '</option>';
					}
				}
			}

			return $output;
		}

		/**
		 * Post/Page/CPT's as select options
		 * @since  0.1
		 * @param  string    $selected
		 * @return string
		 */
		public function posts( $selected ) {
			$post_types = get_post_types( array( 'public' => true ) );
			$options = array();
			foreach ( $post_types as $key => $type ) {
				if( !in_array( $type, array( 'buttons-x', 'buttons-x-social' ) ) ) {
					$args = array(
						'post_type' => $type,
						'post_status' => 'publish'
					);
					$query = new WP_Query( $args );
					// The Loop
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							$options[ ucfirst( $type ) ][ get_the_ID() ] = get_the_title();
						}
					} else {
						// no posts found
					}
					/* Restore original Post Data */
					wp_reset_postdata();
				}
			}

			$output = '';
	
			foreach ( $options as $option => $label ) {
				$output .= '<optgroup label="' . $option . '">';
				foreach ( $label as $k => $l ) {
					if( is_array( $selected ) ) {
						if( in_array( $k, $selected ) ) {
							$output .= '<option value="' . $k . '" selected>' . $l . '</option>';
						} else {
							$output .= '<option value="' . $k . '">' . $l . '</option>';
						}
					} else {
						if( $k == $selected ){
							$output .= '<option value="' . $k . '" selected>' . $l . '</option>';
						} else {
							$output .= '<option value="' . $k . '">' . $l . '</option>';
						}
					}
				}
			}

			return $output;
		}

		/**
		 * Post/Page/CPT links as select options
		 * @since  0.1
		 * @param  string    $selected
		 * @return string
		 */
		public function post_links( $selected ) {
			$post_types = get_post_types( array( 'public' => true ) );
			$options = array();
			foreach ( $post_types as $key => $type ) {
				if( !in_array( $type, array( 'buttons-x', 'buttons-x-social' ) ) ) {
					$args = array(
						'post_type' => $type,
						'post_status' => 'publish',
						'posts_per_page' => -1
					);
					$query = new WP_Query( $args );
					// The Loop
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							$options[ ucfirst( $type ) ][ get_permalink() ] = get_the_title();
						}
					} else {
						// no posts found
					}
					/* Restore original Post Data */
					wp_reset_postdata();
				}
			}

			$output = '';
	
			foreach ( $options as $option => $label ) {
				$output .= '<optgroup label="' . $option . '">';
				foreach ( $label as $k => $l ) {
					if( $k == $selected ){
						$output .= '<option value="' . $k . '" selected>' . $l . '</option>';
					}else{
						$output .= '<option value="' . $k . '">' . $l . '</option>';
					}
				}
			}

			return $output;
		}

		/**
		 * Google WebFonts as select options
		 * @since  0.1
		 * @param  string    $selected
		 * @return string
		 */
		public function google_webfonts( $selected ){
			$fonts = json_decode( 
        		file_get_contents( BTNSX__PLUGIN_DIR . 'assets/webfonts.json' ) 
			); // 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . BTNSX__WEBFONTS_API_KEY
			$output = array();
			foreach ($fonts->items as $key => $value) {
				$output[$value->family] = $value->family;
			}
			return $output;
		}

		/**
		 * Function to output tooltip
		 * @since  0.1
		 * @param  array     $args
		 * @return string
		 */
		public function tooltip( $args = array() ) {

			$defaults = array(
				'class' => 'btnsx-tooltip', 
				'position' => 'right', 
				'delay' => '50', 
				'text' => 'I am tooltip'
			);

			$args = wp_parse_args( $args, $defaults );

			return '<span class="fa-stack fa-lg ' . sanitize_html_class( $args['class'] ) . '" data-position="' . esc_attr( $args['position'] ) . '" data-delay="' . esc_attr( $args['delay'] ) . '" data-tooltip="' . esc_attr( $args['text'] ) . '"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-question fa-stack-1x"></i></span>';
		}

		/**
		 * Function to output pro label
		 * @since  0.1
		 * @param  array     $args
		 * @return string
		 */
		public function pro_label( $args = array() ) {

			$defaults = array(
				'class' => 'btnsx-pro-only',
				'text' => 'Pro Feature'
			);

			$args = wp_parse_args( $args, $defaults );

			return '<span class="'.$args['class'].'" style="color:#fff;background-color:#ee6e73;padding:2px 3px;font-size:9px;font-weight:bold;border-radius:4px;margin-left:5px;">'.$args['text'].'</span>';
		}

		/**
		 * Generate input HTML
		 * @since  0.1
		 * @param  array     $args 	existing options array
		 * @return array 	all standard DOM input options
		 */
		public function input( $args = array() ) {

			$defaults = array(
				'type'				=>	'text',
				'cpt'				=>	'post',
				'size'				=>	'12',
				'id'				=>	NULL,
				'name'				=>	NULL,
				'class'				=>	NULL,
				'multiselect'		=>	NULL,
				'title'				=>	NULL,
				'placeholder'		=>	NULL,
				'label'				=>	NULL,
				'tooltip'			=>	NULL,
				'min'				=>	0,
				'max'				=>	100,
				'on_text'			=>	__( 'On', 'btnsx' ),
				'off_text'			=>	__( 'Off', 'btnsx' ),
				'step'				=>	1,
				'value'				=>	NULL,
				'options'			=>	array(),
				'copy'				=>	NULL,
				'copy_text'			=>	NULL,
				'copy_ids'			=>	array(),
				'pro'				=>	false
			);

			// Merge arguments together 
			$input = wp_parse_args( $args, $defaults );
			$no_esc_key = array( 'options', 'tooltip', 'value', 'multiselect', 'copy_ids', 'copy_text', 'copy_ids' );

			// Validate the data - All input values are validated here with few exceptions, exceptions are validated on occurence
			foreach ( $input as $k => $v ) {
				if( !in_array( $k, $no_esc_key ) ) {
					$input[$k] = esc_attr( $v );
				}
			}

			// Create input attributes
			$input_props = array();
			$input_props['id'] = ( $input['id'] != NULL ) ? 'id="' . $input['id'] . '"' : NULL;
			$input_props['name'] = ( $input['name'] != NULL ) ? 'name="' . $input['name'] . '"' : NULL;
			$input_props['placeholder'] = ( $input['placeholder'] != NULL ) ? 'placeholder="' . $input['placeholder'] . '"' : NULL;
			$input_props['class'] = ( $input['class'] != NULL ) ? 'class="' . $input['class'] . '"' : NULL;
			$input_props['value'] = ( $input['value'] != NULL && !is_array( $input['value'] ) ) ? 'value="' . esc_attr( $input['value'] ) . '"' : NULL;

			// declare allowed html tags for tooltip
			$tooltip_allowed_html = array(
				'span' => array(
					'class' => array(),
					'data-position' => array(),
					'data-delay' => array(),
					'data-tooltip' => array()
				),
				'i'	=>	array(
					'class' => array()
				)
			);
			// declare allowed html tags for select options
			$select_allowed_html = array(
				'optgroup' => array(
					'label' => array()
				),
				'option' =>	array(
					'value' => array(),
					'selected' => array()
				)
			);

			switch ( $input['type'] ) {

				case 'text': ?>
					<div class="col m<?php echo $input['size']; ?>">
						<div class="input-field col s12">
							<input type="text" <?php echo implode( ' ', $input_props ); ?>>
							<?php if( $input['label'] != NULL ){ ?>
								<label for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
									<?php } if( $input['tooltip'] != NULL ) {
										echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
									}
									?>
								</label>
						</div>
					</div>
					<?php break;

				case 'number': ?>
					<div class="col m<?php echo $input['size']; ?>">
						<div class="input-field col s12">
							<input type="number" <?php echo implode( ' ', $input_props ); ?>>
							<label for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
								<?php if( $input['tooltip'] != NULL ) {
									echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
								}
								?>
							</label>
						</div>
					</div>
					<?php break;

				case 'range': 

					$input_props['range_id'] = ( $input['id'] != NULL ) ? 'id="' . $input['id'] . '_range"' : NULL;
					$input_props['range_name'] = ( $input['name'] != NULL ) ? 'name="range_' . $input['name'] . '"' : NULL;
					$input_props['min'] = ( $input['min'] != NULL ) ? 'min="' . $input['min'] . '"' : 0;
					$input_props['max'] = ( $input['max'] != NULL ) ? 'max="' . $input['max'] . '"' : 100;
					$input_props['step'] = ( $input['step'] != NULL ) ? 'step="' . $input['step'] . '"' : 1;

					?>
					<div class="col m12">
						<div class="row">
							<div class="col m4 btnsx-no-padding">
								<div class="input-field col s12">
									<input type="text" <?php echo implode( ' ', $input_props ); ?>>
									<label for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
										<?php if( $input['tooltip'] != NULL ) {
											echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
										}
										?>
									</label>
								</div>
							</div>
							<div class="col m8 btnsx-no-padding">
								<p class="range-field">
									<input type="range" <?php echo $input_props['class'] . $input_props['range_id'] . ' ' . $input_props['range_name'] . ' ' . $input_props['min'] . ' ' . $input_props['max'] . ' ' . $input_props['step']; ?>/>
								</p>
							</div>
						</div>
					</div>
					<?php break;

				case 'select': 

					$input_props['select_placeholder'] = ( $input['placeholder'] != NULL ) ? $input['placeholder'] : __('Choose your option','btnsx');
					$input_props['placeholder'] = NULL;
					$input_props['class'] = ( $input['class'] != NULL ) ? 'class="' . $input['class'] . '"' : 'class="btnsx-select"';

					$input['value'] = maybe_unserialize( $input['value'] );
					$multi_select = ( isset( $input['multiselect'] ) && $input['multiselect'] === true ) ? ' multiple="multiple"' : '';

					?>
					<div class="col m12">
						<div class="col s12">
							<label for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
								<?php if( $input['tooltip'] != NULL ) {
									echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
								}
								?>
							</label>
							<?php 
								if( $input['copy'] == true ){
									$highlight = isset( $input['copy_ids']['highlight'] ) ? $input['copy_ids']['highlight'] : '';
									$old_select = isset( $input['copy_ids']['old_select'] ) ? $input['copy_ids']['old_select'] : '';
									$new_select = isset( $input['copy_ids']['new_select'] ) ? $input['copy_ids']['new_select'] : '';
									$normal_text = isset( $input['copy_text'] ) && $input['copy_text'] === 'normal' ? __( 'Copy to normal', 'btnsx' ) : '';
									$hover_text = isset( $input['copy_text'] ) && $input['copy_text'] === 'hover' ? __( 'Copy to hover', 'btnsx' ) : '';
									echo '<button id="' . $input['id'] . '_copy_btn" class="btnsx-copy-field" data-highlight="' . $highlight . '" data-old-select="' . $old_select . '" data-new-select="' . $new_select . '">' . $normal_text . $hover_text . '</button>';
								}	
							?>
						</div>
						<div class="input-field col s12" style="margin-top: 0.5rem;">
							<select <?php echo implode( ' ', $input_props ) . $multi_select; ?> style="width: 100%">
								<?php if( $input['placeholder'] != NULL ) { ?>
									<option value="-1" disabled selected><?php echo $input_props['select_placeholder']; ?></option>
								<?php } 
									// var_dump($input['value']);
									foreach ( $input['options'] as $key => $label ) {
										if( is_array( $input['value'] ) ) {
											if( in_array( $key, $input['value'] ) ) {
												echo '<option id="' . $input['id'] . '-option-' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '" selected>' . sanitize_text_field( $label ) . '</option>';
											} else {
												echo '<option id="' . $input['id'] . '-option-' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '">' . sanitize_text_field( $label ) . '</option>';
											}
										} else {
											if( $input['value'] == $key ){
												echo '<option id="' . $input['id'] . '-option-' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '" selected>' . (string) $label . '</option>';
											} else {
												echo '<option id="' . $input['id'] . '-option-' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '">' . (string) $label . '</option>';
											}
										}
									}
								?>
							</select>
						</div>
					</div>
					<?php break;

				case 'radio': ?>
					<div class="col m<?php echo $input['size']; ?>" style="margin-bottom:20px;">
						<div class="col s12">
							<label for=""><?php echo $input['label']; ?>
								<?php if( $input['tooltip'] != NULL ) {
									echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
								}
								?>
							</label>
							<?php
								unset( $input_props['id'] );
								$checkbox_value = isset( $input['value'] ) ? 'value="' . esc_attr( $input['value'] ) . '"' : '';
								foreach ( $input['options'] as $id => $value ) {
									$checkbox_checked = isset( $input['value'] ) && $input['value'] == $value ? 'checked="checked"' : '';
									echo '<p>';
									echo '<input type="radio" id="' .  esc_attr( $id ) . '" value="' .  esc_attr( $value ) . '" ' . implode( ' ', $input_props ) . $checkbox_checked .'/>';
									echo '<label for="' .  esc_attr( $id ) . '">' . ucfirst( $value ) . '</label>';
									echo '</p>';
								}
							?>
						</div>
					</div>
					<?php break;

				case 'checkbox': 
					$checkbox_value = isset( $input['value'] ) ? 'value="' . esc_attr( $input['value'] ) . '"' : '';
					$checkbox_checked = isset( $input['value'] ) && $input['value'] == '1' ? 'checked="checked"' : '';
					?>
					<div id="<?php echo $input['id'].'_container'; ?>" class="col m<?php echo $input['size']; ?>">
						<div class="col s12">
							<p class="btnsx-checkbox-container">
								<input type="checkbox" <?php echo implode( ' ', $input_props ) . $checkbox_value . $checkbox_checked; ?>/>
								<label for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
									<?php if( $input['tooltip'] != NULL ) {
										echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
									}
									?>
								</label>
							</p>
						</div>
					</div>
					<?php break;

				case 'switch': 
					$checkbox_value = isset( $input['value'] ) ? 'value="' . esc_attr( $input['value'] ) . '"' : '';
					$checkbox_checked = isset( $input['value'] ) && $input['value'] == '1' ? 'checked="checked"' : '';
					?>
					<div class="col m<?php echo $input['size']; ?>">
						<div class="col s12" style="margin-bottom:20px;">
							<label for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
								<?php 
									if( $input['tooltip'] != NULL ) {
										echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
									}
									if( $input['pro'] === true || $input['pro'] === '1' ) {
										echo $this->pro_label();
									}
								?>
							</label>
							<p>
								<!-- Switch -->
								<div class="switch">
								    <label>
								    	<?php echo $input['off_text']; ?>
										<input type="checkbox" <?php echo implode( ' ', $input_props ) . $checkbox_value . $checkbox_checked; ?>/>
										<span class="lever"></span>
										<?php echo $input['on_text']; ?>
									</label>
								</div>
							</p>
						</div>
					</div>
					<?php break;
				
				case 'trbl': 

					$trbl_fields = array(
						'all'		=>	__( 'All Sides', 'btnsx' ),
						'top'		=>	__( 'Top', 'btnsx' ),
						'bottom'	=>	__( 'Bottom', 'btnsx' ),
						'left'		=>	__( 'Left', 'btnsx' ),
						'right'		=>	__( 'Right', 'btnsx' )
					);

					foreach ( $trbl_fields as $key => $label ) { ?>
						<div class="col3">
							<?php
							echo $this->input( 
								array(
									'type'			=>	'range',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['id'] . '_' . $key,
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : ''
								)
							);
							?>
						</div>
					<?php } break;

				case 'color': ?>
					<div class="col m12">
						<label class="btnsx-color-label" name="" for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
							<?php if( $input['tooltip'] != NULL ) {
								echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
							}
							?>
						</label>
						<?php 
							if( $input['copy'] == true ){
								$highlight = isset( $input['copy_ids']['highlight'] ) ? $input['copy_ids']['highlight'] : '';
								$old_input = isset( $input['copy_ids']['old_input'] ) ? $input['copy_ids']['old_input'] : '';
								$new_input = isset( $input['copy_ids']['new_input'] ) ? $input['copy_ids']['new_input'] : '';
								$old_color = isset( $input['copy_ids']['old_color'] ) ? $input['copy_ids']['old_color'] : '';
								$new_color = isset( $input['copy_ids']['new_color'] ) ? $input['copy_ids']['new_color'] : '';
								$normal_text = isset( $input['copy_text'] ) && $input['copy_text'] === 'normal' ? __( 'Copy to normal', 'btnsx' ) : '';
								$hover_text = isset( $input['copy_text'] ) && $input['copy_text'] === 'hover' ? __( 'Copy to hover', 'btnsx' ) : '';
								echo '<button id="' . $input['id'] . '_copy_btn" class="btnsx-copy-field" data-highlight="' . $highlight . '" data-old-input="' . $old_input . '" data-new-input="' . $new_input . '" data-old-color="' . $old_color . '" data-new-color="' . $new_color . '" data-old-select data-new-select>' . $normal_text . $hover_text . '</button>';
							}	
						?>
					</div>
					<?php
						echo $this->input( 
							array(
    							'type'			=>	'text',
    							'id'			=>	$input['id'],
    							'name'			=>	$input['name'],
    							'placeholder'	=>	' ',
    							'class'			=>	'btnsx-text btnsx-color',
    							'value'			=>	( isset( $input['value'] ) ? $input['value'] : NULL )
    						)
						);

					break;

				case 'font': 
					$font_fields = array(
						'size'		=>	__( 'Font Size', 'btnsx' ),
						'family'	=>	__( 'Font Family', 'btnsx' ),
						'weight'	=>	__( 'Font Weight', 'btnsx' ),
						'style'		=>	__( 'Font Style', 'btnsx' )
					);

					foreach ( $font_fields as $key => $label ) {
						if( $key == 'size' ){

							echo $this->input( 
								array(
	    							'type'			=>	'range',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);

						} elseif( $key == 'style' ) {

							echo $this->input(
								array(
	    							'type'			=>	'select',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'placeholder'	=>	__( 'Choose font style', 'btnsx' ),
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'options'		=>	array(
	    								'normal'		=> __( 'Normal', 'btnsx' ),
	    								'italic'		=> __( 'Italic', 'btnsx' ),
	    								'oblique'		=> __( 'Oblique', 'btnsx' ),
	    								'inherit'		=> __( 'Inherit', 'btnsx' )
	    							),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);

						} elseif( $key == 'weight' ) {

							echo $this->input(
								array(
	    							'type'			=>	'select',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'placeholder'	=>	__( 'Choose font weight', 'btnsx' ),
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'options'		=>	array(
	    								'normal'		=> __( 'Normal', 'btnsx' ),
	    								'bold'			=> __( 'Bold', 'btnsx' ),
	    								'bolder'		=> __( 'Bolder', 'btnsx' ),
	    								'lighter'		=> __( 'Lighter', 'btnsx' ),
	    								'100'			=> __( '100', 'btnsx' ),
	    								'100italic'		=> __( '100 Italic', 'btnsx' ),
	    								'200'			=> __( '200', 'btnsx' ),
	    								'200italic'		=> __( '200 Italic', 'btnsx' ),
	    								'300'			=> __( '300', 'btnsx' ),
	    								'300italic'		=> __( '300 Italic', 'btnsx' ),
	    								'400'			=> __( '400', 'btnsx' ),
	    								'400italic'		=> __( '400 Italic', 'btnsx' ),
	    								'500'			=> __( '500', 'btnsx' ),
	    								'500italic'		=> __( '500 Italic', 'btnsx' ),
	    								'600'			=> __( '600', 'btnsx' ),
	    								'600italic'		=> __( '600 Italic', 'btnsx' ),
	    								'700'			=> __( '700', 'btnsx' ),
	    								'700italic'		=> __( '700 Italic', 'btnsx' ),
	    								'800'			=> __( '800', 'btnsx' ),
	    								'800italic'		=> __( '800 Italic', 'btnsx' ),
	    								'900'			=> __( '900', 'btnsx' ),
	    								'900italic'		=> __( '900 Italic', 'btnsx' ),
	    								'inherit'		=> __( 'Inherit', 'btnsx' )
	    							),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);

						} elseif( $key == 'family' ) {

							echo $this->input(
								array(
	    							'type'			=>	'select',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'placeholder'	=>	__( 'Choose font family', 'btnsx' ),
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'options'		=>	$this->google_webfonts( $input['value'][$key] ),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);

						}
					}

					break;

				case 'color-states': 

					$color_fields = array(
						'normal' =>	__( 'Normal', 'btnsx' ),
						'hover'	=>	__( 'Hover', 'btnsx' )
					);

					$i = 0;
					foreach ( $color_fields as $key => $label ) { 
						if( !is_array($input['value']) ){
							$input['value'] = NULL;
						}
						if( !is_array($input['copy_ids']) ){
							$input['copy_ids'] = NULL;
						}
						if( !is_array($input['copy_text']) ){
							$input['copy_ids'] = NULL;
						}
						echo $this->input( 
							array(
    							'type'			=>	'color',
    							'id'			=>	$input['id'] . '_' . $key,
    							'name'			=>	$input['name'] . '_' . $key,
    							'placeholder'	=>	' ',
    							'label'			=>	$label,
    							'tooltip'		=>	$input['tooltip'][$key],
    							'class'			=>	'btnsx-color',
    							'value'			=>	$input['value'][$key],
    							'copy'			=>	$input['copy'],
    							'copy_text'		=>	$input['copy_text'][$key],
    							'copy_ids'		=>	$input['copy_ids'][$key]
    						)
						);
						$i++;
					}

					break;

				case 'gradient': 

					$gradient_fields = array(
						'location'	=>	__( 'Location', 'btnsx' ),
						'color'		=>	__( 'Color', 'btnsx' )
					);

					$i = 0;
					foreach ( $gradient_fields as $key => $label ) { 
						if( !is_array( $input['value'] ) ){
							$input['value'] = NULL;
						}
						if( $key === 'color' ) {
							echo $this->input( 
								array(
	    							'type'			=>	'color',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key . '[]',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'placeholder'	=>	' ',
	    							'value'			=>	$input['value'][$key]
	    						)
							);
						}
						if( $key === 'location' ) {
							echo $this->input( 
								array(
	    							'type'			=>	'range',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key . '[]',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'placeholder'	=>	' ',
	    							'class'			=>	'btnsx-text',
	    							'value'			=>	$input['value'][$key]
	    						)
							);
						}
						$i++;
					}

					break;

				case 'box-shadow': 

					$shadow_fields = array(
						'horizontal'	=>	__( 'Horizontal', 'btnsx' ),
						'vertical'		=>	__( 'Vertical', 'btnsx' ),
						'blur'			=>	__( 'Blur', 'btnsx' ),
						'spread'		=>	__( 'Spread', 'btnsx' ),
						'position'		=>	__( 'Position', 'btnsx' ),
						'color'			=>	__( 'Color', 'btnsx' )
					);

					foreach ( $shadow_fields as $key => $label ) { 
						if( $key == 'color' ) { 
							echo $this->input( 
								array(
	    							'type'			=>	'color',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key . '[]',
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'class'			=>	'btnsx-text btnsx-color',
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						} elseif( $key == 'horizontal' || $key == 'vertical' || $key == 'blur' || $key == 'spread' ) {
							echo $this->input( 
								array(
	    							'type'			=>	'range',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key . '[]',
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'class'			=>	'btnsx-text',
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						} elseif( $key == 'position' ) {
							echo $this->input( 
								array(
	    							'type'			=>	'select',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key . '[]',
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'class'			=>	'btnsx-select',
	    							'options'		=>	array(
	    								' '		=> __( 'Outset', 'btnsx' ),
	    								'inset'			=> __( 'Inset', 'btnsx' )
    								),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						}
					}

					break;

				case 'radius': 

					$radius_fields = array(
						'all'			=>	__( 'All Sides', 'btnsx' ),
						'top_left'		=>	__( 'Top Left', 'btnsx' ),
						'top_right'		=>	__( 'Top Right', 'btnsx' ),
						'bottom_left'	=>	__( 'Bottom Left', 'btnsx' ),
						'bottom_right'	=>	__( 'Bottom Right', 'btnsx' )
					);

					foreach ( $radius_fields as $key => $label ) {
						echo $this->input( 
							array(
    							'type'			=>	'range',
    							'id'			=>	$input['id'] . '_' . $key,
    							'name'			=>	$input['name'] . '_' . $key,
    							'placeholder'	=>	' ',
    							'label'			=>	$label,
    							'tooltip'		=>	isset( $input['tooltip'][$key] ) ? $input['tooltip'][$key] : NULL,
    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
    						)
						);
					}

					break;

				case 'file': 

					$file_props['id'] = ( $input['id'] != NULL ) ? 'id="' . $input['id'] . '_upload"' : NULL;
					
					?>
					<div class="col m12">
						<div class="col s12">
							<label class="btnsx-upload-label" for="<?php echo $input['id']; ?>"><?php echo $input['label']; ?>
								<?php if( $input['tooltip'] != NULL ) {
									echo wp_kses( $this->tooltip( array( 'text' => $input['tooltip'] ) ), $tooltip_allowed_html );
								}
								?>
							</label>
							<?php 
								if( $input['copy'] == true ){
									$highlight = isset( $input['copy_ids']['highlight'] ) ? $input['copy_ids']['highlight'] : '';
									$old_input = isset( $input['copy_ids']['old_input'] ) ? $input['copy_ids']['old_input'] : '';
									$new_input = isset( $input['copy_ids']['new_input'] ) ? $input['copy_ids']['new_input'] : '';
									$normal_text = isset( $input['copy_text'] ) && $input['copy_text'] === 'normal' ? __( 'Copy to normal', 'btnsx' ) : '';
									$hover_text = isset( $input['copy_text'] ) && $input['copy_text'] === 'hover' ? __( 'Copy to hover', 'btnsx' ) : '';
									echo '<button id="' . $input['id'] . '_copy_btn" class="btnsx-copy-field" data-highlight="' . $highlight . '" data-old-input="' . $old_input . '" data-new-input="' . $new_input . '" data-old-color="" data-new-color="" data-old-select data-new-select>' . $normal_text . $hover_text . '</button>';
								}	
							?>
						</div>
					</div>
					<div class="col m12">
						<div class="col s12">
							<div class="file-field input-field">
						    	<input class="file-path btnsx-input-upload validate" type="text" <?php echo implode( ' ', $input_props ); ?>/>
						    	<div class="btn">
						    		<span><?php _e( 'UPLOAD', 'btnsx' ); ?></span>
						    		<input <?php echo $file_props['id']; ?> class="btnsx-btn-upload" type="file"/>
						    	</div>
						    </div>
						</div>
					</div>

					<?php

					break;

				case 'html': ?>

					<div class="col m<?php echo $input['size']; ?>">
						<?php echo wp_kses_post( $input['value'] ); ?>
					</div>

					<?php break;

				case 'button': ?>

					<div class="col m<?php echo $input['size']; ?>">
						<div class="col m<?php echo $input['size']; ?>">
							<?php echo wp_kses_post( $input['value'] ); ?>
							<button <?php echo implode( ' ', $input_props ); ?>><?php echo $input['label']; ?></button>
						</div>
					</div>

					<?php break;

				case 'border': 

					$border_fields = array(
						'size'		=>	__( 'Size', 'btnsx' ),
						'style'		=>	__( 'Style', 'btnsx' ),
						'color'		=>	__( 'Color', 'btnsx' )
					);

					foreach ( $border_fields as $key => $label ) { 
						if( $key == 'color' ) { 
							echo $this->input( 
								array(
	    							'type'			=>	'color',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'placeholder'	=>	' ',
	    							'class'			=>	'btnsx-color',
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						} elseif( $key == 'size' ) {
							echo $this->input( 
								array(
	    							'type'			=>	'range',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	$input['tooltip'][$key],
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						} elseif( $key == 'style' ) {
							echo $this->input( 
								array(
									'type'			=>	'select',
								    'id'			=>	$input['id'] . '_' . $key,
								    'name'			=>	$input['name'] . '_' . $key,
								    'placeholder'	=>	' ',
								    'label'			=>	$label,
								    'tooltip'		=>	$input['tooltip'][$key],
								    'options'		=>	array(
								    	'none'		=> __( 'None', 'btnsx' ),
								    	'hidden'	=> __( 'Hidden', 'btnsx' ),
								    	'dotted'	=> __( 'Dotted', 'btnsx' ),
								    	'dashed'	=> __( 'Dashed', 'btnsx' ),
								    	'solid'		=> __( 'Solid', 'btnsx' ),
								    	'double'	=> __( 'Double', 'btnsx' ),
								    	'groove'	=> __( 'Groove', 'btnsx' ),
								    	'ridge'		=> __( 'Ridge', 'btnsx' ),
								    	'inset'		=> __( 'Inset', 'btnsx' ),
								    	'outset'	=> __( 'Outset', 'btnsx' ),
								    	'inherit'	=> __( 'Inherit', 'btnsx' ),
								    ),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						}
					}

					$border_sides = array(
						'top'		=>	__( 'Top', 'btnsx' ),
						'bottom'	=>	__( 'Bottom', 'btnsx' ),
						'left'		=>	__( 'Left', 'btnsx' ),
						'right'		=>	__( 'Right', 'btnsx' )
					);

					?>
					
					<div class="row">
						<div class="col m12">
							<label style="float:left;padding-left:0.75rem;margin-top:1.2rem;"><?php _e('Sides','btnsx'); ?></label>
						</div>
					<?php 
						foreach ( $border_sides as $key => $label ) {
							echo $this->input( 
								array(
									'type'			=>	'checkbox',
									'size'			=>	3,
									'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'label'			=>	$label,
	    							'tooltip'		=>	isset( $input['tooltip'][$key] ) ? $input['tooltip'][$key] : NULL,
									'class'			=>	'btnsx-checkbox',
									'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : 1
								)
							);
						}
					?>

					</div>

					<?php break;

				case 'background-image': 

					$bg_image_fields = array(
						'image'		=>	__( 'Background Image', 'btnsx' ),
						// 'repeat'	=>	__( 'Background Repeat', 'btnsx' ),
						'position'	=>	__( 'Background Position', 'btnsx' )
					);

					foreach ( $bg_image_fields as $key => $label ) { 
						if( $key == 'image' ) { 
							echo $this->input( 
								array(
	    							'type'			=>	'file',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'label'			=>	$label,
	    							'tooltip'		=>	isset( $input['tooltip'][$key] ) ? $input['tooltip'][$key] : NULL,
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						} elseif( $key == 'repeat' ) {
							echo $this->input( 
								array(
	    							'type'			=>	'select',
	    							'id'			=>	$input['id'] . '_' . $key,
	    							'name'			=>	$input['name'] . '_' . $key,
	    							'placeholder'	=>	' ',
	    							'label'			=>	$label,
	    							'tooltip'		=>	isset( $input['tooltip'][$key] ) ? $input['tooltip'][$key] : NULL,
	    							'options'		=>	array(
	    								'repeat'	=>	__( 'Repeat', 'btnsx' ),
	    								'repeat-x'	=>	__( 'Repeat X', 'btnsx' ),
	    								'repeat-y'	=>	__( 'Repeat Y', 'btnsx' ),
	    								'no-repeat'	=>	__( 'No Repeat', 'btnsx' ),
	    								'initial'	=>	__( 'Initial', 'btnsx' )
	    							),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						} elseif( $key == 'position' ) {
							echo $this->input( 
								array(
									'type'			=>	'select',
								    'id'			=>	$input['id'] . '_' . $key,
								    'name'			=>	$input['name'] . '_' . $key,
								    'placeholder'	=>	' ',
								    'label'			=>	$label,
								    'tooltip'		=>	isset( $input['tooltip'][$key] ) ? $input['tooltip'][$key] : NULL,
								    'options'		=>	array(
								    	'left top'		=> __( 'Left Top', 'btnsx' ),
								    	'left center'	=> __( 'Left Center', 'btnsx' ),
								    	'left bottom'	=> __( 'Left Bottom', 'btnsx' ),
								    	'right top'		=> __( 'Right Top', 'btnsx' ),
								    	'right center'	=> __( 'Right Center', 'btnsx' ),
								    	'right bottom'	=> __( 'Right Bottom', 'btnsx' ),
								    	'center top'	=> __( 'Center Top', 'btnsx' ),
								    	'center center'	=> __( 'Center Center', 'btnsx' ),
								    	'center bottom'	=> __( 'Center Bottom', 'btnsx' ),
								    	'initial'		=> __( 'Initial', 'btnsx' ),
								    ),
	    							'value'			=>	isset( $input['value'][$key] ) ? $input['value'][$key] : NULL
	    						)
							);
						}
					}

					break;

				case 'pro-banner': ?>

					<div class="col m<?php echo $input['size']; ?>">
						<?php echo '<div class="btnsx-tabs-pro-banner">This is a <u>Pro Only</u> feature. Get <a href="http://btn.sx/1IUqaqK">Pro version</a>!</div>'; ?>
					</div>

					<?php break;

				case 'gradient-limit': ?>

					<div class="col m<?php echo $input['size']; ?>">
						<?php echo '<div class="btnsx-tabs-free-limit">This being a lite version supports only vertical gradient and 2 stops. Pro version supports unlimited stops. Get <a href="http://btn.sx/1IUqaqK">Pro version</a>!</div>'; ?>
					</div>

					<?php break;

				case 'shadow-limit': ?>

					<div class="col m<?php echo $input['size']; ?>">
						<?php echo '<div class="btnsx-tabs-free-limit">This being a lite version supports only 2 layers of shadow. Pro version supports unlimited layers. Get <a href="http://btn.sx/1IUqaqK">Pro version</a>!</div>'; ?>
					</div>

					<?php break;

				case 'preview-bg-img-banner': ?>

					<div class="col m<?php echo $input['size']; ?>">
						<?php echo '<div class="preview-bg-img-banner">Preview background image is supported in Pro version. Get <a href="http://btn.sx/1IUqaqK">Pro version</a>!</div>'; ?>
					</div>

					<?php break;

				default: ?>
					<input type="hidden" <?php echo implode( ' ', $input_props ); ?>>
					<?php break;
			
			}
		}

	} // Form Elements Class

}