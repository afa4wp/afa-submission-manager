<?php
/**
 * The User QRCOde Class Model.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserQRCodeModel
 *
 * Manipulate UserQRCodeModel Table
 *
 * @since 1.0.0
 */
class UserQRCodeModel {

    /**
	 * Data base name
	 *
	 * @var string
	 */
	private $data_base_name;

    
	/**
	 * UserQRCodes constructor.
	 */
	public function __construct() {
		 $this->data_base_name = $_ENV['DATA_BASE_PREFIX'] . 'user_qr_codes';
	}

}
