<?php

namespace Includes\Plugins;

 use chillerlan\QRCode\QRCode as ChillerlanQRCode;

class QRCode {

	private $chillerlanQRCode;

	public function __construct() {
		 $this->chillerlanQRCode = new ChillerlanQRCode();
	}

	public function generateQRCode() {
		$data = $this->getData();
		return $this->chillerlanQRCode->render( $data );
	}

	private function getData() {

		$url = get_site_url();

		$access_token = '12222222222222';

		$refresh_token = '12222222222222';

		$data = array(
			'url'           => $url,
			'access_token'  => $access_token,
			'refresh_token' => $refresh_token,
		);

		return implode( ';', $data );
	}
}
