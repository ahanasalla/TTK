<?php
/**
 * WooCommerce Local Pickup Plus
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Local Pickup Plus to newer
 * versions in the future. If you wish to customize WooCommerce Local Pickup Plus for your
 * needs please refer to http://docs.woocommerce.com/document/local-pickup-plus/
 *
 * @package     WC-Shipping-Local-Pickup-Plus
 * @author      SkyVerge
 * @copyright   Copyright (c) 2012-2017, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

/**
 * Field component to select a pickup location.
 *
 * @since 2.1.0
 */
abstract class WC_Local_Pickup_Plus_Pickup_Location_Field {


	/**
	 * Gets the pickup location data.
	 *
	 * Extending classes should override this to retrieve data based on their
	 * specific model for storage.
	 *
	 * @since 2.1.0
	 *
	 * @param string $piece specific data to get. Defaults to getting all available data.
	 * @return array|string
	 */
	abstract protected function get_pickup_data( $piece = '' );


	/**
	 * Sets the pickup location data.
	 *
	 * Extending classes should override this to set data based on their
	 * specific model for storage.
	 *
	 * @since 2.1.0
	 * @param array $pickup_data pickup data
	 */
	abstract protected function set_pickup_data( array $pickup_data );


	/**
	 * Deletes the pickup location data.
	 *
	 * Extending classes should override this to delete data based on their
	 * specific model for storage.
	 *
	 * @since 2.1.0
	 */
	abstract protected function delete_pickup_data();


	/**
	 * Get the current user default lookup area.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return array
	 */
	protected function get_user_default_lookup_area() {

		$user   = wp_get_current_user();
		$lookup = array(
			'country' => '',
			'state'   => '',
		);

		if ( $user instanceof WP_User && ( $default_pickup = wc_local_pickup_plus_get_user_default_pickup_location( $user ) ) ) {
			$lookup['country'] = $default_pickup->get_address( 'country' );
			$lookup['state']   = $default_pickup->get_address( 'state' );
		}

		return $lookup;
	}


	/**
	 * Get default lookup country:state area.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return array
	 */
	protected function get_lookup_area() {

		$plugin      = wc_local_pickup_plus();
		$geocoding   = $plugin->geocoding_enabled();
		$codes       = $plugin->get_pickup_locations_instance()->get_available_pickup_location_country_state_codes();
		$chosen      = $this->get_pickup_data( 'lookup_area' );
		$country     = '';
		$state       = '';

		// get selected value
		if ( ! empty( $chosen ) ) {
			if ( is_string( $chosen ) ) {
				$chosen = explode( ':', $chosen );
			}
			if ( is_array( $chosen ) ) {
				$country = isset( $chosen[0] ) ? $chosen[0] : '';
				$state   = isset( $chosen[1] ) ? $chosen[1] : '';
			}
		}

		// get or fallback to default value
		if ( empty( $chosen ) || empty( $country ) ) {

			if ( wc_local_pickup_plus_get_user_default_pickup_location() ) {

				$preferred_lookup = $this->get_user_default_lookup_area();

				if ( ! empty( $preferred_lookup['country'] ) ) {

					$country = $preferred_lookup['country'];
					$state   = ! empty( $preferred_lookup['state'] ) ? $preferred_lookup['state'] : '';

				} else {

					if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) {

						$location = wc_get_customer_default_location();
						$country  = isset( $location['country'] ) ? $location['country'] : '';
						$state    = isset( $location['state'] )   ? $location['state'] : '';

					} else {

						$country = WC()->customer->get_default_country();
						$state   = WC()->customer->get_default_state();
					}
				}

			} elseif ( $geocoding ) {

				$country = 'anywhere';
				$state   = '';
			}
		}

		// sanity check:
		if ( 'anywhere' !== $country && ( '' === $country || ( ! in_array( "{$country}:{$state}", $codes, true ) && ! in_array( $country, $codes, true ) ) ) ) {
			$country = ! $geocoding ? WC()->countries->get_base_country() : 'anywhere';
			$state   = ! $geocoding ? WC()->countries->get_base_state()   : '';
		}

		return array(
			'country' => $country,
			'state'   => $state
		);
	}


	/**
	 * Get the default lookup area label.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return string
	 */
	protected function get_lookup_area_label() {

		$lookup = $this->get_lookup_area();

		if ( ! empty( $lookup['state'] ) ) {
			$states    = WC()->countries->get_states( $lookup['country'] );
			$label     = $states[ $lookup['state'] ];
		} elseif ( 'anywhere' === $lookup['country'] ) {
			$label     = __( 'Anywhere', 'woocommerce-shipping-local-pickup-plus' );
		} else {
			$countries = WC()->countries->get_countries();
			$label     = $countries[ $lookup['country'] ];
		}

		return $label;
	}


	/**
	 * Get dropdown options with countries and states with available pickup locations.
	 *
	 * @see \WC_Countries::country_dropdown_options()
	 *
	 * @since 2.1.0-dev
	 *
	 * @return string HTML
	 */
	protected function get_country_dropdown_options() {

		$chosen         = $this->get_lookup_area();
		$chosen_country = isset( $chosen['country'] ) ? $chosen['country'] : '';
		$chosen_state   = isset( $chosen['state'] )   ? $chosen['state']   : '';
		$countries      = wc_local_pickup_plus()->get_pickup_locations_instance()->get_available_pickup_location_countries();

		ob_start();

		if ( ! empty( $countries ) ) :

			?>
			<option value="anywhere" <?php selected( $chosen_country, 'anywhere' ); ?>><?php esc_html_e( 'Anywhere', 'woocommerce-shipping-local-pickup-plus' ); ?></option>
			<?php

			foreach ( $countries as $country_code => $country_label ) :

				if ( $states = wc_local_pickup_plus()->get_pickup_locations_instance()->get_available_pickup_location_states( $country_code ) ) :

					?>
					<optgroup label="<?php echo esc_attr( $country_label ); ?>">
						<?php foreach ( $states as $state_code => $state_label ) : ?>
							<option
								value="<?php echo esc_attr( "{$country_code}:{$state_code}" ); ?>"
								<?php if ( $chosen_country === $country_code && $chosen_state === $state_code ) { echo 'selected="selected"'; } ?>
							><?php echo esc_html( sprintf( '%1$s &mdash; %2$s', $country_label, $state_label ) ); ?></option>
						<?php endforeach; ?>
					</optgroup>
					<?php

				else :

					?>
					<option
						value="<?php echo esc_attr( $country_code ); ?>"
						<?php if ( $chosen_country === $country_code ) { echo 'selected="selected"'; } ?>
					><?php echo esc_html( $country_label ); ?></option>
					<?php

				endif;

			endforeach;

		endif;

		return ob_get_clean();
	}


	/**
	 * Get a dropdown with available country/state options for available pickup locations.
	 *
	 * @since 2.1.0-dev
	 *
	 * @param string $object_id cart item or package ID
	 * @return string HTML
	 */
	protected function get_country_state_dropdown( $object_id ) {

		ob_start();

		?>
		<select
			id="pickup-location-lookup-area-for-<?php echo sanitize_html_class( $object_id ); ?>"
			class="wc-enhanced-select country_to_state country_select pickup-location-lookup-area"
			style="width:100%; max-width:512px;"
			placeholder="<?php echo esc_html_x( 'Choose an area&hellip;', 'Geographic area to search', 'woocommerce-shipping-local-pickup-plus' ); ?>"
			data-placeholder="<?php echo esc_html_x( 'Choose an area&hellip;', 'Geographic area to search', 'woocommerce-shipping-local-pickup-plus' ); ?>"
			autocomplete="country">
			<?php if ( $this->use_enhanced_search() ) : ?>
				<?php echo $this->get_country_dropdown_options(); ?>
			<?php else : ?>
				<option value="anywhere" selected="selected"><?php esc_html_e( 'Anywhere', 'woocommerce-shipping-local-pickup-plus' ); ?></option>
			<?php endif; ?>
		</select>
		<?php

		return ob_get_clean();
	}


	/**
	 * Whether to enable enhanced search.
	 *
	 * If there are more than 80 published locations, use enhanced search (perhaps with geocoding) in lookup fields.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return bool
	 */
	protected function use_enhanced_search() {

		return wc_local_pickup_plus_shipping_method()->is_enhanced_search_enabled();
	}


	/**
	 * Returns all locations available.
	 *
	 * This should be only used when simple dropdown is active and locations are less than a hundred or will cause performance issues.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return \WC_Local_Pickup_Plus_Pickup_Location[]
	 */
	protected function get_all_pickup_locations() {

		$query_args = array();

		switch ( wc_local_pickup_plus_shipping_method()->pickup_locations_sort_order() ) {

			case 'location_alphabetical' :

				$query_args['order']   = 'ASC';
				$query_args['orderby'] = 'title';
				$pickup_locations      = wc_local_pickup_plus_get_pickup_locations( $query_args );

			break;

			case 'location_date_added' :

				$query_args['order']   = 'ASC';
				$query_args['orderby'] = 'date';
				$pickup_locations      = wc_local_pickup_plus_get_pickup_locations( $query_args );

			break;

			case 'distance_customer' :

				if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) {

					$country           = '';
					$state             = '';
					$customer_location = wc_get_customer_default_location();
					$shop_location     = wc_get_base_location();

					if ( isset( $customer_location['country'], $customer_location['state'] ) ) {
						$country = $customer_location['country'];
						$state   = $customer_location['state'];
					} elseif( isset( $shop_location['country'], $shop_location['state'] ) ) {
						$country = $shop_location['country'];
						$state   = $shop_location['state'];
					}

				} else {

					$country = WC()->customer->get_default_country();
					$country = empty( $country ) ? WC()->countries->get_base_country() : $country;
					$state   = WC()->customer->get_default_state();
					$state   = empty( $state )   ? WC()->countries->get_base_state()   : $state;
				}

				$coordinates = wc_local_pickup_plus()->get_geocoding_api_instance()->get_coordinates( array( 'country' => $country, 'state' => $state ) );
				$coordinates = empty( $coordinates ) ? array( 'lat' => 0.00000, 'lon' => 0.000000 ) : $coordinates;

				$pickup_locations = wc_local_pickup_plus()->get_pickup_locations_instance()->get_pickup_locations_by_distance( $coordinates, array( 'post_status' => 'publish', 'orderby' => 'distance_customer' ), '40000km' );

			break;

			default :
				$pickup_locations = wc_local_pickup_plus_get_pickup_locations();
			break;
		}

		return $pickup_locations;
	}


	/**
	 * Gets the location select field HTML.
	 *
	 * @since 2.1.0
	 *
	 * @param string $object_id object ID, like cart key or package index
	 * @param \WC_Local_Pickup_Plus_Pickup_Location $chosen_location chosen pickup location
	 * @return string field HTML
	 */
	protected function get_location_select_html( $object_id, $chosen_location = null ) {

		$object_type     = $this->get_object_type();
		$enhanced_search = $this->use_enhanced_search();
		$field_name      = wc_local_pickup_plus_shipping_method()->is_per_item_selection_enabled() ? '_pickup_location_id' : 'shipping_method_pickup_location_id';

		if ( ! $chosen_location ) {
			$chosen_location = wc_local_pickup_plus_get_user_default_pickup_location();
		}

		ob_start();

		?>
		<div
			id="pickup-location-lookup-area-field-for-<?php echo esc_attr( $object_id ); ?>"
			class="pickup-location-lookup-area-field"
			data-pickup-object-id="<?php echo esc_attr( $object_id ); ?>"
			<?php if ( ! $enhanced_search ) { echo 'style="display: none;"'; } ?>>
			<small
				class="pickup-location-current-lookup-area"
				<?php if ( ! $enhanced_search ) { echo 'style="display: none;"'; } ?>><?php
				$change = '<a class="pickup-location-change-lookup-area" href="#">' . strtolower( esc_html__( 'Change', 'woocommerce-shipping-local-pickup-plus' ) ) . '</a>';
				/* translators: Placeholder: %s - country or state name (or "Anywhere") */
				printf( __( 'Enter a postcode or city to search for pickup locations from: %s', 'woocommerce-shipping-local-pickup-plus' ) . ' (' . $change . ')', '<em class="pickup-location-current-lookup-area-label">' . $this->get_lookup_area_label() . '</em>' ); ?>
			</small>
			<div style="display: none;">
				<?php echo $this->get_country_state_dropdown( $object_id ); ?>
			</div>
		</div>

		<?php if ( ! $enhanced_search ) : ?>

			<?php $pickup_locations = $this->get_all_pickup_locations(); ?>
			<select
				name="<?php echo sanitize_html_class( $field_name ); ?>[<?php echo esc_attr( $object_id ); ?>]"
				class="pickup-location-lookup"
				style="width:100%; max-width:512px;"
				placeholder="<?php esc_attr_e( 'Search locations&hellip;', 'woocommerce-shipping-local-pickup-plus' ); ?>"
				data-pickup-object-type="<?php echo esc_attr( $object_type ); ?>"
				data-pickup-object-id="<?php echo esc_attr( $object_id ); ?>">
				<?php foreach ( $pickup_locations as $pickup_location ) : ?>
					<?php if ( $this->can_be_picked_up( $pickup_location ) ) : ?>
						<option value="<?php echo esc_attr( $pickup_location->get_id() ); ?>" <?php selected( $pickup_location->get_id(), $chosen_location ? $chosen_location->get_id() : null, true ); ?>><?php echo esc_html( $pickup_location->get_name() ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>

		<?php else : ?>

			<?php if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) : ?>

				<select
					name="<?php echo sanitize_html_class( $field_name ); ?>[<?php echo esc_attr( $object_id ); ?>]"
					class="pickup-location-lookup"
					style="width:100%; max-width:512px;"
					placeholder="<?php esc_attr_e( 'Search locations&hellip;', 'woocommerce-shipping-local-pickup-plus' ); ?>"
					data-pickup-object-type="<?php echo esc_attr( $object_type ); ?>"
					data-pickup-object-id="<?php echo esc_attr( $object_id ); ?>">
					<?php if ( $chosen_location instanceof WC_Local_Pickup_Plus_Pickup_Location ) : ?>
						<option value="<?php echo $chosen_location->get_id(); ?>" selected><?php echo esc_html( $chosen_location->get_name() ); ?></option>
					<?php endif; ?>
				</select>

			<?php else : ?>

				<input
					type="hidden"
					name="<?php echo sanitize_html_class( $field_name ); ?>[<?php echo esc_attr( $object_id ); ?>]"
					class="pickup-location-lookup"
					style="width:100%; max-width:512px;"
					value="<?php echo $chosen_location ? $chosen_location->get_id() : ''; ?>"
					placeholder="<?php esc_attr_e( 'Search locations&hellip;', 'woocommerce-shipping-local-pickup-plus' ); ?>"
					data-pickup-object-type="<?php echo esc_attr( $object_type ); ?>"
					data-pickup-object-id="<?php echo esc_attr( $object_id ); ?>"
				/>

			<?php endif; ?>

		<?php endif;

		return ob_get_clean();
	}


	/**
	 * Determines if the current object can be picked up, or must be shipped.
	 *
	 * @since 2.1.0
	 *
	 * @param \WC_Local_Pickup_Plus_Pickup_Location $pickup_location pickup location to check
	 * @return bool
	 */
	protected function can_be_picked_up( $pickup_location ) {

		return true;
	}


	/**
	 * Gets the object type for this field.
	 *
	 * This lets us differentiate between cart items and packages in the JS.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return string
	 */
	abstract protected function get_object_type();


	/**
	 * Get the field HTML.
	 *
	 * @since 2.1.0-dev
	 *
	 * @return string HTML
	 */
	abstract public function get_html();


	/**
	 * Output the field HTML.
	 *
	 * @since 2.1.0-dev
	 */
	public function output_html() {

		echo $this->get_html();
	}


}
