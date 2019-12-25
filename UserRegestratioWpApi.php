<?php
/*
* Basic User Creation Through WP REST API
* https//:www.example.com/wp-json/my-route/createuser?email_id=<Your Email>
*/ 
add_action('rest_api_init', 'your_prefix_create_user');
function your_prefix_create_user(){
	register_rest_route( 'my-route', '/createuser/', 
	   array(
	   	'methods' => GET,
	   'callback' => 'your_prefix_create_user_callback'
	) );
}

function your_prefix_create_user_callback($request){

	$data['message']="User has been created using the email " .$request['email_id'].'at'. site_url();
	if (!empty($request['email_id'])){
		 $email_address=$request['email_id'];
		 if ( null == username_exists( $email_address ) ) {
		 	 // generate password
             $password = wp_generate_password( 12, true );
             // create user
             $user_id = wp_create_user ( $email_address, $password, $email_address );
             $user = new WP_User( $userid ); 
             $user->set_role( 'subscriber' ); 
			//Mall Part
			$headers[]='MIME-Version: 1.0';
			$headers[]='Content-type: text/html; charset.iso-8859-1';
			$headers[]='From: WoprdPress <welcome@example.com>';
			$subject='Your Example Access Inside';
			$data['message']='Welcome to Example: https://example.com/
			<br><br> Your login details:
			<br>Username: ' .$email_address.'
			<br>Password: '.$password.'<br><br>To your success,';
			wp_mail( $email_address,$subject,$data['message'],$headers);
		 }
		 else{
		 		 $data['message']="User already exists for the email ..".$request['email_id'].'at' site_url();
		 }
	}
	 return($data['message']);
}

?>