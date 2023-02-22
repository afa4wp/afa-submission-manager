<?php
namespace Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {
	
	public function render() {
		?>
			<div class="wrap">
				<h2><?php echo get_admin_page_title(); ?></h2>
				<h3 class="nav-tab-wrapper">
					<a href="#" class="nav-tab">Add User as Stauff</a>
					<a href="#" class="nav-tab">Generate QR CODE</a>
					<a href="#" class="nav-tab">About</a>
				</h3>
				<div class="metabox-holder has-right-sidebar">ola</div>
			</div>
		<?php
	}

}

