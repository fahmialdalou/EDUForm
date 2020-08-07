<?php
   /*
   Plugin Name: EDUForm
   Plugin URI: https://www.upwork.com/fl/fahmialdalou
   description: Just copy this shortcode [EDUForm] into any Page/post and watch the magic happens.
   Version: 1.0
   Author: Fahmi Aldalou
   Author URI: https://www.linkedin.com/in/fahmiz/
   License: GPL2
   */


function formtest_plugin_name_scripts() {
    wp_enqueue_style( 'teststyles', plugins_url( 'css/style.css', __FILE__ ) );    
    wp_enqueue_script( 'testscripts', plugins_url( '/js/script.js', __FILE__ ) , array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'formtest_plugin_name_scripts' );

/* FormTest Shortcode */
add_shortcode( 'EDUForm', 'EDUForm_shortcode' );
function EDUForm_shortcode() {
    ob_start();
    $user_name = $_POST['user_name'] ?? '';
    $user_email     = $_POST['user_email'] ?? '';
    $notes     = $_POST['notes'] ?? '';

    if( isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['submit'])):
    	$user_name = $_POST['user_name'];
	    $user_email     = $_POST['user_email'];
	    $notes     = $_POST['notes'];
    	if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    		echo '<h2 class="api-response">Please use valid email!</h2>';
    	}else{
    		echo '<h2 class="api-response">APi response: '.send_api($user_name,$user_email,$notes).'</h2>';
    	}
        
    endif;
    ?>
    <div class="form-wrap" >
        <form method="post" action="<?php echo get_the_permalink(); ?>" class="edu_form">
            <div class="input-wrap">
                <label for="name">User Name*</label>
                <input type="text" placeholder="User Name" class="required"   name="user_name" id="user_name" value="<?=$user_name?>">
            </div>
            <div class="input-wrap">
                <label for="email">Email*</label>
                <input type="email" placeholder="Best Email" class="required"   name="user_email" id="user_email" value="<?=$user_email?>">
            </div>  
            <div class="input-wrap">
                <label for="notes">Notes</label>
                <textarea name="notes" id="" cols="30" rows="10" placeholder="Additional Notes" name="notes"><?=$notes?></textarea>
            </div> 
            <input type="submit" value="Submit" name="submit" class="form_submit" >                       
        </form>
    </div>
    <?php
    return ob_get_clean();
}

function send_api($user_name,$user_email,$notes){          
        $post_fields = array( "username" => $user_name, "email" => $user_email, "notes"=>$notes );                                                                    
        $post_fields_data = json_encode($post_fields);     
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, 'https://petstore.swagger.io/v2/user');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields );        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return (json_decode($result)->message);          
}