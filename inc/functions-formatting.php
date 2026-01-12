<?php
defined( 'ABSPATH' ) || exit;


if(!function_exists('control_listings_round')):
/**
 * Round a number using the built-in `round` function, but unless the value to round is numeric
 * (a number or a string that can be parsed as a number), apply 'floatval' first to it
 * (so it will convert it to 0 in most cases).
 *
 * This is needed because in PHP 7 applying `round` to a non-numeric value returns 0,
 * but in PHP 8 it throws an error. Specifically, in WooCommerce we have a few places where
 * round('') is often executed.
 *
 * @param 	mixed 	$val 		The value to round.
 * @param 	int   	$precision 	The optional number of decimal digits to round to.
 * @param 	int   	$mode 		A constant to specify the mode in which rounding occurs.
 *
 * @return 	float 	The value rounded to the given precision as a float, or the supplied default value.
 */
function control_listings_round( $val, int $precision = 0, int $mode = PHP_ROUND_HALF_UP ) : float {
    if ( ! is_numeric( $val ) ) {
        $val = floatval( $val );
    }
    return round( $val, $precision, $mode );
}
endif;


if(!function_exists('control_listings_string_to_bool')):
/**
 * Converts a string (e.g. 'yes' or 'no') to a bool.
 *
 * @param 	string|bool 	$string 	String to convert. If a bool is passed it will be returned as-is.
 * 
 * @return 	bool
 */
function control_listings_string_to_bool( $string ) {
	return is_bool( $string ) ? $string : ( 'yes' === strtolower( $string ) || 1 === $string || 'true' === strtolower( $string ) || '1' === $string );
}
endif;


if(!function_exists('control_listings_bool_to_string')):
/**
 * Converts a bool to a 'yes' or 'no'.
 *
 * @param 	bool|string 	$bool 	Bool to convert. If a string is passed it will first be converted to a bool.
 * @return 	string
 */
function control_listings_bool_to_string( $bool ) {
	if ( ! is_bool( $bool ) ) {
		$bool = control_listings_string_to_bool( $bool );
	}
	return true === $bool ? 'yes' : 'no';
}
endif;


if(!function_exists('control_listings_string_to_array')):
/**
 * Explode a string into an array by $delimiter and remove empty values.
 *
 * @param 	string 	$string    	String to convert.
 * @param 	string 	$delimiter 	Delimiter, defaults to ','.
 * @return 	array
 */
function control_listings_string_to_array( $string, $delimiter = ',' ) {
	return is_array( $string ) ? $string : array_filter( explode( $delimiter, $string ) );
}
endif;


if(!function_exists('control_listings_sanitize_taxonomy_name')):
/**
 * Sanitize taxonomy names. Slug format (no spaces, lowercase).
 * Urldecode is used to reverse munging of UTF8 characters.
 *
 * @param 	string 	$taxonomy Taxonomy name.
 * @return 	string
 */
function control_listings_sanitize_taxonomy_name( $taxonomy ) {
	return apply_filters( 'control_listings_sanitize_taxonomy_name', urldecode( sanitize_title( urldecode( $taxonomy ?? '' ) ) ), $taxonomy );
}
endif;


if(!function_exists('control_listings_sanitize_permalink')):
/**
 * Sanitize permalink values before insertion into DB.
 *
 * Cannot use control_listings_clean because it sometimes strips % chars and breaks the user's setting.
 *
 * @param  string 	$value 	Permalink.
 * @return string
 */
function control_listings_sanitize_permalink( $value ) {
	global $wpdb;

	$value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );

	if ( is_wp_error( $value ) ) {
		$value = '';
	}

	$value = esc_url_raw( trim( $value ) );
	$value = str_replace( 'http://', '', $value );
	return untrailingslashit( $value );
}
endif;


if(!function_exists('control_listings_get_filename_from_url')):
/**
 * Gets the filename part of a download URL.
 *
 * @param 	string 	$file_url 	File URL.
 * @return 	string
 */
function control_listings_get_filename_from_url( $file_url ) {
	$parts = wp_parse_url( $file_url );
	if ( isset( $parts['path'] ) ) {
		return basename( $parts['path'] );
	}
}
endif;


if(!function_exists('control_listings_get_dimension')):
/**
 * Normalise dimensions, unify to cm then convert to wanted unit value.
 *
 * Usage:
 * control_listings_get_dimension( 55, 'in' );
 * control_listings_get_dimension( 55, 'in', 'm' );
 *
 * @param 	int|float $dimension    Dimension.
 * @param 	string    $to_unit      Unit to convert to.
 *                                	Options: 'in', 'm', 'cm', 'm'.
 * @param 	string    $from_unit    Unit to convert from.
 *                                	Defaults to ''.
 *                                	Options: 'in', 'm', 'cm', 'm'.
 * @return 	float
 */
function control_listings_get_dimension( $dimension, $to_unit, $from_unit = '' ) {
	$to_unit = strtolower( $to_unit );

	if ( empty( $from_unit ) ) {
		$from_unit = strtolower( get_option( 'control_listings_dimension_unit' ) );
	}

	// Unify all units to cm first.
	if ( $from_unit !== $to_unit ) {
		switch ( $from_unit ) {
			case 'in':
				$dimension *= 2.54;
				break;
			case 'm':
				$dimension *= 100;
				break;
			case 'mm':
				$dimension *= 0.1;
				break;
			case 'yd':
				$dimension *= 91.44;
				break;
		}

		// Output desired unit.
		switch ( $to_unit ) {
			case 'in':
				$dimension *= 0.3937;
				break;
			case 'm':
				$dimension *= 0.01;
				break;
			case 'mm':
				$dimension *= 10;
				break;
			case 'yd':
				$dimension *= 0.010936133;
				break;
		}
	}

	return ( $dimension < 0 ) ? 0 : $dimension;
}
endif;


if(!function_exists('control_listings_get_weight')):
/**
 * Normalise weights, unify to kg then convert to wanted unit value.
 *
 * Usage:
 * control_listings_get_weight(55, 'kg');
 * control_listings_get_weight(55, 'kg', 'lbs');
 *
 * @param 	int|float $weight    	Weight.
 * @param 	string    $to_unit   	Unit to convert to.
 *                             		Options: 'g', 'kg', 'lbs', 'oz'.
 * @param 	string    $from_unit 	Unit to convert from.
 *                             		Defaults to ''.
 *                             		Options: 'g', 'kg', 'lbs', 'oz'.
 * @return 	float
 */
function control_listings_get_weight( $weight, $to_unit, $from_unit = '' ) {
	$weight  = (float) $weight;
	$to_unit = strtolower( $to_unit );

	if ( empty( $from_unit ) ) {
		$from_unit = strtolower( get_option( 'control_listings_weight_unit' ) );
	}

	// Unify all units to kg first.
	if ( $from_unit !== $to_unit ) {
		switch ( $from_unit ) {
			case 'g':
				$weight *= 0.001;
				break;
			case 'lbs':
				$weight *= 0.453592;
				break;
			case 'oz':
				$weight *= 0.0283495;
				break;
		}

		// Output desired unit.
		switch ( $to_unit ) {
			case 'g':
				$weight *= 1000;
				break;
			case 'lbs':
				$weight *= 2.20462;
				break;
			case 'oz':
				$weight *= 35.274;
				break;
		}
	}
	return ( $weight < 0 ) ? 0 : $weight;
}
endif;


if(!function_exists('control_listings_trim_zeros')):
/**
 * Trim trailing zeros off prices.
 *
 * @param 	string|float|int 	$price Price.
 * @return 	string
 */
function control_listings_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( control_listings_get_price_decimal_separator(), '/' ) . '0++$/', '', $price );
}
endif;


if(!function_exists('control_listings_round_tax_total')):
/**
 * Round a tax amount.
 *
 * @param  double 	$value 		Amount to round.
 * @param  int    	$precision 	DP to round. Defaults to control_listings_get_price_decimals.
 * @return float
 */
function control_listings_round_tax_total( $value, $precision = null ) {
	$precision = is_null( $precision ) ? control_listings_get_price_decimals() : intval( $precision );

	if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
		$rounded_tax = control_listings_round( $value, $precision ); // phpcs:ignore PHPCompatibility.FunctionUse.NewFunctionParameters.round_modeFound
	}else {
		$rounded_tax = control_listings_round( $value, $precision );
	}
	return apply_filters( 'control_listings_round_tax_total', $rounded_tax, $value, $precision );
}
endif;


if(!function_exists('control_listings_legacy_round_half_down')):
/**
 * Round half down in PHP 5.2.
 *
 * @param 	float 	$value 		Value to round.
 * @param 	int   	$precision 	Precision to round down to.
 * @return 	float
 */
function control_listings_legacy_round_half_down( $value, $precision ) {
	$value = control_listings_float_to_string( $value );

	if ( false !== strstr( $value, '.' ) ) {
		$value = explode( '.', $value );

		if ( strlen( $value[1] ) > $precision && substr( $value[1], -1 ) === '5' ) {
			$value[1] = substr( $value[1], 0, -1 ) . '4';
		}

		$value = implode( '.', $value );
	}

	return control_listings_round( floatval( $value ), $precision );
}
endif;


if(!function_exists('control_listings_format_refund_total')):
/**
 * Make a refund total negative.
 *
 * @param 	float 	$amount 	Refunded amount.
 *
 * @return 	float
 */
function control_listings_format_refund_total( $amount ) {
	return $amount * -1;
}
endif;


if(!function_exists('control_listings_get_rounding_precision')):
/**
 * Get rounding precision for internal WC calculations.
 * Will increase the precision of wc_get_price_decimals by 2 decimals, unless WC_ROUNDING_PRECISION is set to a higher number.
 * @return int
 */
function control_listings_get_rounding_precision() {
	$precision = control_listings_get_price_decimals() + 2;
	if ( absint(CTRL_LISTINGS_ROUNDING_PRECISION ) > $precision ) {
		$precision = absint( CTRL_LISTINGS_ROUNDING_PRECISION );
	}
	return $precision;
}
endif;


if(!function_exists('control_listings_format_decimal')):
/**
 * Format decimal numbers ready for DB storage.
 *
 * Sanitize, optionally remove decimals, and optionally round + trim off zeros.
 *
 * This function does not remove thousands - this should be done before passing a value to the function.
 *
 * @param  float|string $number     	Expects either a float or a string with a decimal separator only (no thousands).
 * @param  mixed        $dp number  	Number of decimal points to use, blank to use control_listings_price_num_decimals, or false to avoid all rounding.
 * @param  bool         $trim_zeros 	From end of string.
 * @return string
 */
function control_listings_format_decimal( $number, $dp = false, $trim_zeros = false ) {
	$locale   = localeconv();
	$decimals = array( control_listings_get_price_decimal_separator(), $locale['decimal_point'], $locale['mon_decimal_point'] );

	// Remove locale from string.
	if ( ! is_float( $number ) ) {
		$number = str_replace( $decimals, '.', $number );

		// Convert multiple dots to just one.
		$number = preg_replace( '/\.(?![^.]+$)|[^0-9.-]/', '', control_listings_clean( $number ) );
	}

	if ( false !== $dp ) {
		$dp     = intval( '' === $dp ? control_listings_get_price_decimals() : $dp );
		$number = number_format( floatval( $number ), $dp, '.', '' );
	} elseif ( is_float( $number ) ) {
		// DP is false - don't use number format, just return a string using whatever is given. Remove scientific notation using sprintf.
		$number = str_replace( $decimals, '.', sprintf( '%.' . control_listings_get_rounding_precision() . 'f', $number ) );
		// We already had a float, so trailing zeros are not needed.
		$trim_zeros = true;
	}

	if ( $trim_zeros && strstr( $number, '.' ) ) {
		$number = rtrim( rtrim( $number, '0' ), '.' );
	}
	return $number;
}
endif;


if(!function_exists('control_listings_float_to_string')):
/**
 * Convert a float to a string without locale formatting which PHP adds when changing floats to strings.
 *
 * @param  float 	$float 	Float value to format.
 * @return string
 */
function control_listings_float_to_string( $float ) {
	if ( ! is_float( $float ) ) {
		return $float;
	}

	$locale = localeconv();
	$string = strval( $float );
	$string = str_replace( $locale['decimal_point'], '.', $string );

	return $string;
}
endif;


if(!function_exists('control_listings_format_localized_price')):
/**
 * Format a price with WC Currency Locale settings.
 *
 * @param  string $value 	Price to localize.
 * @return string
 */
function control_listings_format_localized_price( $value ) {
	return apply_filters( 'control_listings_format_localized_price', str_replace( '.', control_listings_get_price_decimal_separator(), strval( $value ) ), $value );
}
endif;


if(!function_exists('control_listings_format_localized_decimal')):
/**
 * Format a decimal with the decimal separator for prices or PHP Locale settings.
 *
 * @param  string 	$value 	Decimal to localize.
 * @return string
 */
function control_listings_format_localized_decimal( $value ) {
	$locale = localeconv();
	$decimal_point = isset( $locale['decimal_point'] ) ? $locale['decimal_point'] : '.';
	$decimal = ( ! empty( control_listings_get_price_decimal_separator() ) ) ? control_listings_get_price_decimal_separator() : $decimal_point;
	return apply_filters( 'control_listings_format_localized_decimal', str_replace( '.', $decimal, strval( $value ) ), $value );
}
endif;


if(!function_exists('control_listings_format_coupon_code')):
/**
 * Format a coupon code.
 *
 * @param  string  $value 	Coupon code to format.
 * @return string
 */
function control_listings_format_coupon_code( $value ) {
	return apply_filters( 'control_listings_coupon_code', $value );
}
endif;


if(!function_exists('control_listings_sanitize_coupon_code')):
/**
 * Sanitize a coupon code.
 *
 * Uses sanitize_post_field since coupon codes are stored as
 * post_titles - the sanitization and escaping must match.
 * @param  string  $value 	Coupon code to format.
 * @return string
 */
function control_listings_sanitize_coupon_code( $value ) {
	return wp_filter_kses( sanitize_post_field( 'post_title', $value, 0, 'db' ) );
}
endif;


if(!function_exists('control_listings_clean')):
/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param 	string|array 	$var 	Data to sanitize.
 * @return 	string|array
 */
function control_listings_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'control_listings_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}
endif;


if(!function_exists('control_listings_check_invalid_utf8')):
/**
 * Function wp_check_invalid_utf8 with recursive array support.
 *
 * @param 	string|array 	$var 	Data to sanitize.
 * @return 	string|array
 */
function control_listings_check_invalid_utf8( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'control_listings_check_invalid_utf8', $var );
	} else {
		return wp_check_invalid_utf8( $var );
	}
}
endif;


if(!function_exists('control_listings_sanitize_textarea')):
/**
 * Run control_listings_clean over posted textarea but maintain line breaks.
 *
 * @param  string 	$var 	Data to sanitize.
 * @return string
 */
function control_listings_sanitize_textarea( $var ) {
	return implode( "\n", array_map( 'control_listings_clean', explode( "\n", $var ) ) );
}
endif;


if(!function_exists('control_listings_sanitize_tooltip')):
/**
 * Sanitize a string destined to be a tooltip.
 *
 * @param  string 	$var 	Data to sanitize.
 * @return string
 */
function control_listings_sanitize_tooltip( $var ) {
	return htmlspecialchars(
		wp_kses(
			html_entity_decode( $var ),
			array(
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
				'small'  => array(),
				'span'   => array(),
				'ul'     => array(),
				'li'     => array(),
				'ol'     => array(),
				'p'      => array(),
			)
		)
	);
}
endif;


if(!function_exists('control_listings_array_overlay')):
/**
 * Merge two arrays.
 *
 * @param 	array 	$a1 	First array to merge.
 * @param 	array 	$a2 	Second array to merge.
 * @return 	array
 */
function control_listings_array_overlay( $a1, $a2 ) {
	foreach ( $a1 as $k => $v ) {
		if ( ! array_key_exists( $k, $a2 ) ) {
			continue;
		}
		if ( is_array( $v ) && is_array( $a2[ $k ] ) ) {
			$a1[ $k ] = control_listings_array_overlay( $v, $a2[ $k ] );
		} else {
			$a1[ $k ] = $a2[ $k ];
		}
	}
	return $a1;
}
endif;


if(!function_exists('control_listings_stock_amount')):
/**
 * Formats a stock amount by running it through a filter.
 *
 * @param  int|float  $amount 	Stock amount.
 * @return int|float
 */
function control_listings_stock_amount( $amount ) {
	return apply_filters( 'control_listings_stock_amount', $amount );
}
endif;


if(!function_exists('control_listings_get_price_format')):
/**
 * Get the price format depending on the currency position.
 *
 * @return string
 */
function control_listings_get_price_format() {
	$currency_pos = control_listings_setting( 'currency_pos' );
	$format       = '%1$s%2$s';

	switch ( $currency_pos ) {
		case 'left':
			$format = '%1$s%2$s';
			break;
		case 'right':
			$format = '%2$s%1$s';
			break;
		case 'left_space':
			$format = '%1$s&nbsp;%2$s';
			break;
		case 'right_space':
			$format = '%2$s&nbsp;%1$s';
			break;
	}

	return apply_filters( 'control_listings_price_format', $format, $currency_pos );
}
endif;


if(!function_exists('control_listings_get_price_thousand_separator')):
/**
 * Return the thousand separator for prices.
 *
 * @return string
 */
function control_listings_get_price_thousand_separator() {
	return stripslashes( apply_filters( 'control_listings_get_price_thousand_separator', control_listings_setting( 'price_thousand_sep',',' ) ) );
}
endif;


if(!function_exists('control_listings_get_price_decimal_separator')):
/**
 * Return the decimal separator for prices.
 *
 * @return string
 */
function control_listings_get_price_decimal_separator() {
	$separator = apply_filters( 'control_listings_get_price_decimal_separator', control_listings_setting( 'price_decimal_sep','.' ) );
	return $separator ? stripslashes( $separator ) : '.';
}
endif;


if(!function_exists('control_listings_get_price_decimals')):
/**
 * Return the number of decimals after the decimal point.
 *
 * @return int
 */
function control_listings_get_price_decimals() {
	return absint( apply_filters( 'control_listings_get_price_decimals', control_listings_setting( 'price_num_decimals', 2 ) ) );
}
endif;


if(!function_exists('control_listings_price')):
/**
 * Format the price with a currency symbol.
 *
 * @param  float $price Raw price.
 * @param  array $args  Arguments to format a price {
 *     Array of arguments.
 *     Defaults to empty array.
 *
 *     @type bool   $ex_tax_label       Adds exclude tax label.
 *                                      Defaults to false.
 *     @type string $currency           Currency code.
 *                                      Defaults to empty string (Use the result from control_listings_get_currency()).
 *     @type string $decimal_separator  Decimal separator.
 *                                      Defaults the result of control_listings_get_price_decimal_separator().
 *     @type string $thousand_separator Thousand separator.
 *                                      Defaults the result of control_listings_get_price_thousand_separator().
 *     @type string $decimals           Number of decimals.
 *                                      Defaults the result of control_listings_get_price_decimals().
 *     @type string $price_format       Price format depending on the currency position.
 *                                      Defaults the result of control_listings_get_price_format().
 * }
 * @return string
 */
function control_listings_price( $price, $args = array() ) {
	$args = apply_filters(
		'control_listings_price_args',
		wp_parse_args(
			$args,
			array(
				'ex_tax_label'       => false,
				'currency'           => '',
				'decimal_separator'  => control_listings_get_price_decimal_separator(),
				'thousand_separator' => control_listings_get_price_thousand_separator(),
				'decimals'           => control_listings_get_price_decimals(),
				'price_format'       => control_listings_get_price_format(),
			)
		)
	);

	$original_price = $price;

	// Convert to float to avoid issues on PHP 8.
	$price = (float) $price;

	$unformatted_price = $price;
	$negative          = $price < 0;

	/**
	 * Filter raw price.
	 *
	 * @param 	float        	$raw_price      	Raw price.
	 * @param 	float|string 	$original_price 	Original price as float, or empty string. Since 5.0.0.
	 */
	$price = apply_filters( 'control_listings_raw_price', $negative ? $price * -1 : $price, $original_price );

	/**
	 * Filter formatted price.
	 *
	 * @param 	float        	$formatted_price    	Formatted price.
	 * @param 	float        	$price              	Unformatted price.
	 * @param 	int          	$decimals           	Number of decimals.
	 * @param 	string       	$decimal_separator  	Decimal separator.
	 * @param 	string       	$thousand_separator 	Thousand separator.
	 * @param 	float|string 	$original_price     	Original price as float, or empty string. Since 5.0.0.
	 */
	$price = apply_filters( 'control_listings_formatted_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'], $original_price );

	if ( apply_filters( 'control_listings_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
		$price = control_listings_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], '<span class="listing-price-currencySymbol">' . control_listings_get_currency_symbol( $args['currency'] ) . '</span>', $price );
	$return          = '<span class="listing-price-amount amount"><bdi>' . $formatted_price . '</bdi></span>';


	/**
	 * Filters the string of price markup.
	 *
	 * @param 	string       		$return            		Price HTML markup.
	 * @param 	string       		$price             		Formatted price.
	 * @param 	array        		$args              		Pass on the args.
	 * @param 	float        		$unformatted_price 		Price as float to allow plugins custom formatting. Since 3.2.0.
	 * @param 	float|string 		$original_price    		Original price as float, or empty string. Since 5.0.0.
	 */
	return apply_filters( 'control_listings_price', $return, $price, $args, $unformatted_price, $original_price );
}
endif;

if(!function_exists('control_listings_let_to_num')):
/**
 * Notation to numbers.
 *
 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
 *
 * @param  string 	$size 	Size value.
 * @return int
 */
function control_listings_let_to_num( $size ) {
	$l   = substr( $size, -1 );
	$ret = (int) substr( $size, 0, -1 );
	switch ( strtoupper( $l ) ) {
		case 'P':
			$ret *= 1024;
			// No break.
		case 'T':
			$ret *= 1024;
			// No break.
		case 'G':
			$ret *= 1024;
			// No break.
		case 'M':
			$ret *= 1024;
			// No break.
		case 'K':
			$ret *= 1024;
			// No break.
	}
	return $ret;
}
endif;

if(!function_exists('control_listings_get_currency')):
/**
 * Get Base Currency Code.
 *
 * @return string
 */
function control_listings_get_currency() {
	return apply_filters( 'control_listings_currency', control_listings_setting( 'currency','USD' ) );
}
endif;


if(!function_exists('control_listings_get_currencies')):
/**
 * Get full list of currency codes.
 *
 * Currency symbols and names should follow the Unicode CLDR recommendation (https://cldr.unicode.org/translation/currency-names-and-symbols)
 *
 * @return array
 */
function control_listings_get_currencies() {
	static $currencies;

	if ( ! isset( $currencies ) ) {
		$currencies = array_unique(
			apply_filters(
				'control_listings_currencies',
				array(
					'AED' => __( 'United Arab Emirates dirham', 'control-listings' ),
					'AFN' => __( 'Afghan afghani', 'control-listings' ),
					'ALL' => __( 'Albanian lek', 'control-listings' ),
					'AMD' => __( 'Armenian dram', 'control-listings' ),
					'ANG' => __( 'Netherlands Antillean guilder', 'control-listings' ),
					'AOA' => __( 'Angolan kwanza', 'control-listings' ),
					'ARS' => __( 'Argentine peso', 'control-listings' ),
					'AUD' => __( 'Australian dollar', 'control-listings' ),
					'AWG' => __( 'Aruban florin', 'control-listings' ),
					'AZN' => __( 'Azerbaijani manat', 'control-listings' ),
					'BAM' => __( 'Bosnia and Herzegovina convertible mark', 'control-listings' ),
					'BBD' => __( 'Barbadian dollar', 'control-listings' ),
					'BDT' => __( 'Bangladeshi taka', 'control-listings' ),
					'BGN' => __( 'Bulgarian lev', 'control-listings' ),
					'BHD' => __( 'Bahraini dinar', 'control-listings' ),
					'BIF' => __( 'Burundian franc', 'control-listings' ),
					'BMD' => __( 'Bermudian dollar', 'control-listings' ),
					'BND' => __( 'Brunei dollar', 'control-listings' ),
					'BOB' => __( 'Bolivian boliviano', 'control-listings' ),
					'BRL' => __( 'Brazilian real', 'control-listings' ),
					'BSD' => __( 'Bahamian dollar', 'control-listings' ),
					'BTC' => __( 'Bitcoin', 'control-listings' ),
					'BTN' => __( 'Bhutanese ngultrum', 'control-listings' ),
					'BWP' => __( 'Botswana pula', 'control-listings' ),
					'BYR' => __( 'Belarusian ruble (old)', 'control-listings' ),
					'BYN' => __( 'Belarusian ruble', 'control-listings' ),
					'BZD' => __( 'Belize dollar', 'control-listings' ),
					'CAD' => __( 'Canadian dollar', 'control-listings' ),
					'CDF' => __( 'Congolese franc', 'control-listings' ),
					'CHF' => __( 'Swiss franc', 'control-listings' ),
					'CLP' => __( 'Chilean peso', 'control-listings' ),
					'CNY' => __( 'Chinese yuan', 'control-listings' ),
					'COP' => __( 'Colombian peso', 'control-listings' ),
					'CRC' => __( 'Costa Rican col&oacute;n', 'control-listings' ),
					'CUC' => __( 'Cuban convertible peso', 'control-listings' ),
					'CUP' => __( 'Cuban peso', 'control-listings' ),
					'CVE' => __( 'Cape Verdean escudo', 'control-listings' ),
					'CZK' => __( 'Czech koruna', 'control-listings' ),
					'DJF' => __( 'Djiboutian franc', 'control-listings' ),
					'DKK' => __( 'Danish krone', 'control-listings' ),
					'DOP' => __( 'Dominican peso', 'control-listings' ),
					'DZD' => __( 'Algerian dinar', 'control-listings' ),
					'EGP' => __( 'Egyptian pound', 'control-listings' ),
					'ERN' => __( 'Eritrean nakfa', 'control-listings' ),
					'ETB' => __( 'Ethiopian birr', 'control-listings' ),
					'EUR' => __( 'Euro', 'control-listings' ),
					'FJD' => __( 'Fijian dollar', 'control-listings' ),
					'FKP' => __( 'Falkland Islands pound', 'control-listings' ),
					'GBP' => __( 'Pound sterling', 'control-listings' ),
					'GEL' => __( 'Georgian lari', 'control-listings' ),
					'GGP' => __( 'Guernsey pound', 'control-listings' ),
					'GHS' => __( 'Ghana cedi', 'control-listings' ),
					'GIP' => __( 'Gibraltar pound', 'control-listings' ),
					'GMD' => __( 'Gambian dalasi', 'control-listings' ),
					'GNF' => __( 'Guinean franc', 'control-listings' ),
					'GTQ' => __( 'Guatemalan quetzal', 'control-listings' ),
					'GYD' => __( 'Guyanese dollar', 'control-listings' ),
					'HKD' => __( 'Hong Kong dollar', 'control-listings' ),
					'HNL' => __( 'Honduran lempira', 'control-listings' ),
					'HRK' => __( 'Croatian kuna', 'control-listings' ),
					'HTG' => __( 'Haitian gourde', 'control-listings' ),
					'HUF' => __( 'Hungarian forint', 'control-listings' ),
					'IDR' => __( 'Indonesian rupiah', 'control-listings' ),
					'ILS' => __( 'Israeli new shekel', 'control-listings' ),
					'IMP' => __( 'Manx pound', 'control-listings' ),
					'INR' => __( 'Indian rupee', 'control-listings' ),
					'IQD' => __( 'Iraqi dinar', 'control-listings' ),
					'IRR' => __( 'Iranian rial', 'control-listings' ),
					'IRT' => __( 'Iranian toman', 'control-listings' ),
					'ISK' => __( 'Icelandic kr&oacute;na', 'control-listings' ),
					'JEP' => __( 'Jersey pound', 'control-listings' ),
					'JMD' => __( 'Jamaican dollar', 'control-listings' ),
					'JOD' => __( 'Jordanian dinar', 'control-listings' ),
					'JPY' => __( 'Japanese yen', 'control-listings' ),
					'KES' => __( 'Kenyan shilling', 'control-listings' ),
					'KGS' => __( 'Kyrgyzstani som', 'control-listings' ),
					'KHR' => __( 'Cambodian riel', 'control-listings' ),
					'KMF' => __( 'Comorian franc', 'control-listings' ),
					'KPW' => __( 'North Korean won', 'control-listings' ),
					'KRW' => __( 'South Korean won', 'control-listings' ),
					'KWD' => __( 'Kuwaiti dinar', 'control-listings' ),
					'KYD' => __( 'Cayman Islands dollar', 'control-listings' ),
					'KZT' => __( 'Kazakhstani tenge', 'control-listings' ),
					'LAK' => __( 'Lao kip', 'control-listings' ),
					'LBP' => __( 'Lebanese pound', 'control-listings' ),
					'LKR' => __( 'Sri Lankan rupee', 'control-listings' ),
					'LRD' => __( 'Liberian dollar', 'control-listings' ),
					'LSL' => __( 'Lesotho loti', 'control-listings' ),
					'LYD' => __( 'Libyan dinar', 'control-listings' ),
					'MAD' => __( 'Moroccan dirham', 'control-listings' ),
					'MDL' => __( 'Moldovan leu', 'control-listings' ),
					'MGA' => __( 'Malagasy ariary', 'control-listings' ),
					'MKD' => __( 'Macedonian denar', 'control-listings' ),
					'MMK' => __( 'Burmese kyat', 'control-listings' ),
					'MNT' => __( 'Mongolian t&ouml;gr&ouml;g', 'control-listings' ),
					'MOP' => __( 'Macanese pataca', 'control-listings' ),
					'MRU' => __( 'Mauritanian ouguiya', 'control-listings' ),
					'MUR' => __( 'Mauritian rupee', 'control-listings' ),
					'MVR' => __( 'Maldivian rufiyaa', 'control-listings' ),
					'MWK' => __( 'Malawian kwacha', 'control-listings' ),
					'MXN' => __( 'Mexican peso', 'control-listings' ),
					'MYR' => __( 'Malaysian ringgit', 'control-listings' ),
					'MZN' => __( 'Mozambican metical', 'control-listings' ),
					'NAD' => __( 'Namibian dollar', 'control-listings' ),
					'NGN' => __( 'Nigerian naira', 'control-listings' ),
					'NIO' => __( 'Nicaraguan c&oacute;rdoba', 'control-listings' ),
					'NOK' => __( 'Norwegian krone', 'control-listings' ),
					'NPR' => __( 'Nepalese rupee', 'control-listings' ),
					'NZD' => __( 'New Zealand dollar', 'control-listings' ),
					'OMR' => __( 'Omani rial', 'control-listings' ),
					'PAB' => __( 'Panamanian balboa', 'control-listings' ),
					'PEN' => __( 'Sol', 'control-listings' ),
					'PGK' => __( 'Papua New Guinean kina', 'control-listings' ),
					'PHP' => __( 'Philippine peso', 'control-listings' ),
					'PKR' => __( 'Pakistani rupee', 'control-listings' ),
					'PLN' => __( 'Polish z&#x142;oty', 'control-listings' ),
					'PRB' => __( 'Transnistrian ruble', 'control-listings' ),
					'PYG' => __( 'Paraguayan guaran&iacute;', 'control-listings' ),
					'QAR' => __( 'Qatari riyal', 'control-listings' ),
					'RON' => __( 'Romanian leu', 'control-listings' ),
					'RSD' => __( 'Serbian dinar', 'control-listings' ),
					'RUB' => __( 'Russian ruble', 'control-listings' ),
					'RWF' => __( 'Rwandan franc', 'control-listings' ),
					'SAR' => __( 'Saudi riyal', 'control-listings' ),
					'SBD' => __( 'Solomon Islands dollar', 'control-listings' ),
					'SCR' => __( 'Seychellois rupee', 'control-listings' ),
					'SDG' => __( 'Sudanese pound', 'control-listings' ),
					'SEK' => __( 'Swedish krona', 'control-listings' ),
					'SGD' => __( 'Singapore dollar', 'control-listings' ),
					'SHP' => __( 'Saint Helena pound', 'control-listings' ),
					'SLL' => __( 'Sierra Leonean leone', 'control-listings' ),
					'SOS' => __( 'Somali shilling', 'control-listings' ),
					'SRD' => __( 'Surinamese dollar', 'control-listings' ),
					'SSP' => __( 'South Sudanese pound', 'control-listings' ),
					'STN' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'control-listings' ),
					'SYP' => __( 'Syrian pound', 'control-listings' ),
					'SZL' => __( 'Swazi lilangeni', 'control-listings' ),
					'THB' => __( 'Thai baht', 'control-listings' ),
					'TJS' => __( 'Tajikistani somoni', 'control-listings' ),
					'TMT' => __( 'Turkmenistan manat', 'control-listings' ),
					'TND' => __( 'Tunisian dinar', 'control-listings' ),
					'TOP' => __( 'Tongan pa&#x2bb;anga', 'control-listings' ),
					'TRY' => __( 'Turkish lira', 'control-listings' ),
					'TTD' => __( 'Trinidad and Tobago dollar', 'control-listings' ),
					'TWD' => __( 'New Taiwan dollar', 'control-listings' ),
					'TZS' => __( 'Tanzanian shilling', 'control-listings' ),
					'UAH' => __( 'Ukrainian hryvnia', 'control-listings' ),
					'UGX' => __( 'Ugandan shilling', 'control-listings' ),
					'USD' => __( 'United States (US) dollar', 'control-listings' ),
					'UYU' => __( 'Uruguayan peso', 'control-listings' ),
					'UZS' => __( 'Uzbekistani som', 'control-listings' ),
					'VEF' => __( 'Venezuelan bol&iacute;var', 'control-listings' ),
					'VES' => __( 'Bol&iacute;var soberano', 'control-listings' ),
					'VND' => __( 'Vietnamese &#x111;&#x1ed3;ng', 'control-listings' ),
					'VUV' => __( 'Vanuatu vatu', 'control-listings' ),
					'WST' => __( 'Samoan t&#x101;l&#x101;', 'control-listings' ),
					'XAF' => __( 'Central African CFA franc', 'control-listings' ),
					'XCD' => __( 'East Caribbean dollar', 'control-listings' ),
					'XOF' => __( 'West African CFA franc', 'control-listings' ),
					'XPF' => __( 'CFP franc', 'control-listings' ),
					'YER' => __( 'Yemeni rial', 'control-listings' ),
					'ZAR' => __( 'South African rand', 'control-listings' ),
					'ZMW' => __( 'Zambian kwacha', 'control-listings' ),
				)
			)
		);
	}

	return $currencies;
}
endif;

if(!function_exists('control_listings_get_currency_symbols')):
/**
 * Get all available Currency symbols.
 *
 * Currency symbols and names should follow the Unicode CLDR recommendation (https://cldr.unicode.org/translation/currency-names-and-symbols)
 *
 * @return array
 */
function control_listings_get_currency_symbols() {

	$symbols = apply_filters(
		'control_listings_currency_symbols',
		array(
			'AED' => '&#x62f;.&#x625;',
			'AFN' => '&#x60b;',
			'ALL' => 'L',
			'AMD' => 'AMD',
			'ANG' => '&fnof;',
			'AOA' => 'Kz',
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => 'Afl.',
			'AZN' => '&#8380;',
			'BAM' => 'KM',
			'BBD' => '&#36;',
			'BDT' => '&#2547;&nbsp;',
			'BGN' => '&#1083;&#1074;.',
			'BHD' => '.&#x62f;.&#x628;',
			'BIF' => 'Fr',
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => 'Bs.',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTC' => '&#3647;',
			'BTN' => 'Nu.',
			'BWP' => 'P',
			'BYR' => 'Br',
			'BYN' => 'Br',
			'BZD' => '&#36;',
			'CAD' => '&#36;',
			'CDF' => 'Fr',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&yen;',
			'COP' => '&#36;',
			'CRC' => '&#x20a1;',
			'CUC' => '&#36;',
			'CUP' => '&#36;',
			'CVE' => '&#36;',
			'CZK' => '&#75;&#269;',
			'DJF' => 'Fr',
			'DKK' => 'kr.',
			'DOP' => 'RD&#36;',
			'DZD' => '&#x62f;.&#x62c;',
			'EGP' => 'EGP',
			'ERN' => 'Nfk',
			'ETB' => 'Br',
			'EUR' => '&euro;',
			'FJD' => '&#36;',
			'FKP' => '&pound;',
			'GBP' => '&pound;',
			'GEL' => '&#x20be;',
			'GGP' => '&pound;',
			'GHS' => '&#x20b5;',
			'GIP' => '&pound;',
			'GMD' => 'D',
			'GNF' => 'Fr',
			'GTQ' => 'Q',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => 'L',
			'HRK' => 'kn',
			'HTG' => 'G',
			'HUF' => '&#70;&#116;',
			'IDR' => 'Rp',
			'ILS' => '&#8362;',
			'IMP' => '&pound;',
			'INR' => '&#8377;',
			'IQD' => '&#x62f;.&#x639;',
			'IRR' => '&#xfdfc;',
			'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
			'ISK' => 'kr.',
			'JEP' => '&pound;',
			'JMD' => '&#36;',
			'JOD' => '&#x62f;.&#x627;',
			'JPY' => '&yen;',
			'KES' => 'KSh',
			'KGS' => '&#x441;&#x43e;&#x43c;',
			'KHR' => '&#x17db;',
			'KMF' => 'Fr',
			'KPW' => '&#x20a9;',
			'KRW' => '&#8361;',
			'KWD' => '&#x62f;.&#x643;',
			'KYD' => '&#36;',
			'KZT' => '&#8376;',
			'LAK' => '&#8365;',
			'LBP' => '&#x644;.&#x644;',
			'LKR' => '&#xdbb;&#xdd4;',
			'LRD' => '&#36;',
			'LSL' => 'L',
			'LYD' => '&#x62f;.&#x644;',
			'MAD' => '&#x62f;.&#x645;.',
			'MDL' => 'MDL',
			'MGA' => 'Ar',
			'MKD' => '&#x434;&#x435;&#x43d;',
			'MMK' => 'Ks',
			'MNT' => '&#x20ae;',
			'MOP' => 'P',
			'MRU' => 'UM',
			'MUR' => '&#x20a8;',
			'MVR' => '.&#x783;',
			'MWK' => 'MK',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => 'MT',
			'NAD' => 'N&#36;',
			'NGN' => '&#8358;',
			'NIO' => 'C&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#x631;.&#x639;.',
			'PAB' => 'B/.',
			'PEN' => 'S/',
			'PGK' => 'K',
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PRB' => '&#x440;.',
			'PYG' => '&#8370;',
			'QAR' => '&#x631;.&#x642;',
			'RMB' => '&yen;',
			'RON' => 'lei',
			'RSD' => '&#1088;&#1089;&#1076;',
			'RUB' => '&#8381;',
			'RWF' => 'Fr',
			'SAR' => '&#x631;.&#x633;',
			'SBD' => '&#36;',
			'SCR' => '&#x20a8;',
			'SDG' => '&#x62c;.&#x633;.',
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&pound;',
			'SLL' => 'Le',
			'SOS' => 'Sh',
			'SRD' => '&#36;',
			'SSP' => '&pound;',
			'STN' => 'Db',
			'SYP' => '&#x644;.&#x633;',
			'SZL' => 'E',
			'THB' => '&#3647;',
			'TJS' => '&#x405;&#x41c;',
			'TMT' => 'm',
			'TND' => '&#x62f;.&#x62a;',
			'TOP' => 'T&#36;',
			'TRY' => '&#8378;',
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => 'Sh',
			'UAH' => '&#8372;',
			'UGX' => 'UGX',
			'USD' => '&#36;',
			'UYU' => '&#36;',
			'UZS' => 'UZS',
			'VEF' => 'Bs F',
			'VES' => 'Bs.S',
			'VND' => '&#8363;',
			'VUV' => 'Vt',
			'WST' => 'T',
			'XAF' => 'CFA',
			'XCD' => '&#36;',
			'XOF' => 'CFA',
			'XPF' => 'Fr',
			'YER' => '&#xfdfc;',
			'ZAR' => '&#82;',
			'ZMW' => 'ZK',
		)
	);

	return $symbols;
}
endif;

if(!function_exists('control_listings_get_currency_symbol')):
/**
 * Get Currency symbol.
 *
 * Currency symbols and names should follow the Unicode CLDR recommendation (https://cldr.unicode.org/translation/currency-names-and-symbols)
 *
 * @param 	string 	$currency 	Currency. (default: '').
 * @return 	string
 */
function control_listings_get_currency_symbol( $currency = '$' ) {
	if ( ! $currency ) {
		$currency = control_listings_get_currency();
	}

	$symbols = control_listings_get_currency_symbols();

	$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

	return apply_filters( 'control_listings_currency_symbol', $currency_symbol, $currency );
}
endif;