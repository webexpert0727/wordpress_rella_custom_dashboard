<?php

if( ! class_exists( 'Envato_Market' ) ) {
	retuen;
}

$notice = 'success';
$email = $email_error = $apikey = $api_error = '';
if( isset( $_POST['rella-register-submit'] ) && isset( $_POST['rella-register'] ) && ! empty( $_POST['rella-register'] ) ) {

	$data = $_POST['rella-register'];
    $email = !empty( $data['email'] ) ? $data['email'] : false;
    $apikey = !empty( $data['apikey'] ) ? $data['apikey'] : false;

	if ( !$email ) {
        $email_error = ' has-error';
    }

    if ( !$apikey ) {
        $api_error = ' has-error';
    }

	if( $email && $apikey ) {

		envato_market()->api()->token = $apikey;
		$response = envato_market()->api()->request( 'https://api.envato.com/v1/market/total-items.json' );
		if ( is_wp_error( $response ) || ! isset( $response['total-items'] ) ) {
			$notice = 'error';
		}
		else {
			update_option( envato_market()->get_option_name(), array( 'token' => $apikey ) );
		}
	}
}
else {
	$envato = envato_market()->get_options();
	if( ! empty( $envato ) && ! empty( $envato['token'] ) ) {
		$response = envato_market()->api()->request( 'https://api.envato.com/v1/market/total-items.json' );
		if ( is_wp_error( $response ) || ! isset( $response['total-items'] ) ) {
			$notice = 'error';
		}
	}
}

if( 'success' === $notice ) {
	return;
}

$theme = rella_helper()->get_current_theme();
?>
<h2 class="h1">
	<i class="fa fa-check text-gradient"></i>
	<?php printf( esc_html__( '%s is successfully installed!', 'boo' ), $theme->name ) ?>

	<div class="rella-label">
		<span><?php printf( esc_html__( 'Latest Update %s', 'boo' ), $theme->version ) ?></span>
	</div>

</h2>

<div class="rella-info rella-align-center bg-gradient mb-0">
    <h4 class="color-white"><?php esc_html_e( 'Let’s register your product to enable updates and access to support forums.', 'boo' ) ?></h4>
</div>

<div class="rella-register">

    <form action="" class="rella-register-form" method="post">

        <div class="title">
            <figure>
                <img src="<?php echo rella()->load_assets( 'img/lock.svg' ); ?>" alt="Lock">
            </figure>
            <h2><?php esc_html_e( 'You’re almost finished.', 'boo' ) ?></h2>
        </div>

        <div class="rella-input-container<?php echo $email_error  ?>">
            <input type="email" name="rella-register[email]" id="rella-register-email" placeholder="Email address" value="<?php echo $email ?>">
        </div>

        <div class="rella-input-container<?php echo $api_error  ?>">
            <input type="text" name="rella-register[apikey]" id="rella-register-apikey" placeholder="API Key" value="<?php echo $apikey ?>">
        </div>

        <div class="rella-input-container">

			<?php wp_nonce_field( 'rella-registration', 'rella-security' ) ?>

            <button type="submit" name="rella-register-submit" id="rella-register-submit" class="bg-gradient"><?php esc_html_e( 'Register Product', 'boo' ) ?> <i class="fa fa-angle-right"></i></button>

		</div>

        <h5><?php esc_html_e( 'Find your API Key', 'boo' ) ?></h5>

        <p><?php echo wp_kses_post( __( 'Lorem ipsum dolor sit amet, consectetur adi nunc<br> maximus egestas lectus eu condi..', 'boo' ) ) ?></p>

        <a href="#" class="generate-apikey"><?php esc_html_e( 'Generate API Key', 'boo' ) ?> <i class="fa fa-angle-right"></i></a>

    </form>

</div>

<div style="height: 100px;"></div>
