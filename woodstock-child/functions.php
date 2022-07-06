<?php
	/* Styles
	=============================================================== */
// 	function woodstock_child_theme_styles() {
// 		 // Enqueue child theme styles
// 		 wp_enqueue_style( 'woodstock-child-theme', get_stylesheet_directory_uri() . '/style.css' );
// 	}
// 	add_action( 'wp_enqueue_scripts', 'woodstock_child_theme_styles', 1000 ); // Note: Use priority "1000" to include the stylesheet after the parent theme stylesheets



function woodstock_child_enqueue_styles() {
    wp_enqueue_style( 'woodstock-style' , get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'woodstock-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'woodstock-style' ),
        wp_get_theme()->get('Version')
    );
if ( is_rtl() ) {

wp_enqueue_style(  'woodstock-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
}
}

add_action(  'wp_enqueue_scripts', 'woodstock_child_enqueue_styles',100 );
	
	
    $actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    if($actual_link == site_url().'/product-category/%d7%9e%d7%93%d7%99%d7%94-%d7%95%d7%92%d7%99%d7%91%d7%95%d7%99/'){
        header("Location: ".site_url()."/%d7%9e%d7%93%d7%99%d7%94-%d7%95%d7%92%d7%99%d7%91%d7%95%d7%99/", true, 301);
        exit();
    }

    // if($actual_link == site_url().'/product-category/%d7%93%d7%99%d7%95-%d7%95%d7%98%d7%95%d7%a0%d7%a8%d7%99%d7%9d/'){
    //     header("Location: ".site_url()."/shop/?swoof=1&product_cat=%D7%93%D7%99%D7%95-%D7%95%D7%98%D7%95%D7%A0%D7%A8%D7%99%D7%9D", true, 301);
    //     exit();
    // }

    // add_filter('the_title', 'new_title', 10, 2);
    function the_title_datapool($title) {
        

        $title=str_replace(array('(',')'),'',$title);
        if(preg_match("/\p{Hebrew}/u", $title) == 1){
            $title = '<span class="title-rtl" >'.$title.'</span>';
        }else{
            $title='<span class="title-ltr">'.$title.'</span>';
        }        
        
        return $title;
    }

    function my_login_logo_one() { 
        ?> 
        <style type="text/css"> 
        body.login div#login h1 a {
            background-image: url(https://www.datapool.co.il/wp-content/uploads/2019/07/logo.png);
            width: 300px;
            height: 150px;
            background-size: 240px;
            margin: auto;
        } 
        </style>
         <?php 
        } add_action( 'login_enqueue_scripts', 'my_login_logo_one' );


add_action("wp_ajax_refund_fun", "refund_fun");
add_action("wp_ajax_nopriv_refund_fun", "refund_fun");



//החזרת מוצר
// כל הגווסקריפט  datapool.co.il/themes/woodstock/js/refund.js 
function refund_fun() {
    global $wpdb;
    $params = array();
  

    // $data = "counter=1&r_item_num_1=11111111&r_item_name_1=שם פריט&r_amont_1=444&r_date_1=22/12/2020&r_invoicing_1=434535&r_return_1=rgdgdfgd+gfdgdg&r_item_num_2=222222&r_item_name_2=שם פריט&r_amont_2=555&r_date_2=2020-03-07&r_invoicing_2=4343&r_return_2=fdgfdgdg";
    // parse_str($data, $params);
    // var_dump($_POST['data']);


    parse_str($_POST['data'], $params);
    // var_dump($params);
    // exit;

    $to_save = array();
    $refundtype = $params['refundtype'];

    for ($i=1; $i < intval($params['counter'])+1; $i++) { 
        $q="SELECT DISTINCT dp_postmeta.meta_value as sku FROM dp_postmeta
        JOIN dp_posts
        ON dp_posts.ID = dp_postmeta.post_id
        WHERE dp_posts.post_title LIKE '".$params['r_item_name_'.$i]."'
        AND dp_postmeta.meta_key = 'datapool_id'";
        $results = $wpdb->get_results($q);
        $to_save[$i][] = $i;
        $to_save[$i][] = $results[0]->sku;   
        $to_save[$i][] = $params['r_item_name_'.$i];   
        $to_save[$i][] = $params['r_amont_'.$i];   
        $to_save[$i][] = $params['r_date_'.$i];   
        $to_save[$i][] = $params['r_invoicing_'.$i];   
        $to_save[$i][] = $params['r_return_'.$i]; 
    }

    // var_dump($to_save);
    // exit;

    // $current_user = wp_get_current_user();
    $name = date('h_i_s');
    $file=get_stylesheet_directory().'/return_files/'.$name.'.csv';
    $fp = fopen($file, 'w');
    fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($fp, array('מספר','מקט','תאור פריט','כמות','תאריך קניה','מס חשבונית','סיבת החזרה'));
    
    foreach($to_save as $item) {
        $item_save=array();
        $save=array();
        foreach($item as $item_save) {
            $save[]=$item_save;
        }
        fputcsv($fp, $save);
    }

    fclose($fp) or die("Can't close php://output");
    // exit;
    $emailText ="<table border='1'>";
    $emailText .= "<tr>
    <td style='padding: 5px'>שורה</td>
    <td style='padding: 5px'>מקט</td>
    <td style='padding: 5px'>תאור פריט</td>
    <td style='padding: 5px'>כמות</td>
    <td style='padding: 5px'>תאריך קניה</td>
    <td style='padding: 5px'>מס חשבונית</td>
    <td style='padding: 5px'>סיבת החזרה</td>
    </tr>";
    foreach($to_save as $item) {
        $emailText .= "<tr>";
        foreach ($item as $value) {
                $emailText .= "<td style='padding: 5px'>$value</td>";
        }
        $emailText .= "</tr>";
    }    
    $emailText .="</table><br />";

    $company_name = get_user_meta(get_current_user_id(),'user_registration_input_box_1584276913');
    $tel = get_user_meta(get_current_user_id(),'user_registration_number_box_1584279850');
    $company_id = get_user_meta(get_current_user_id(),'user_registration_input_box_1584279971');
    $f_name = get_user_meta(get_current_user_id(),'first_name');
    $l_name = get_user_meta(get_current_user_id(),'last_name');
    $email = get_userdata(get_current_user_id());

    $massage = "
    <p style='text-align: right;'><b>שם פרטי: </b>$f_name[0]</p>
    <p style='text-align: right;'><b>שם משפחה: </b>$l_name[0]</p>
    <p style='text-align: right;'><b>שם החברה: </b>$company_name[0]</p>
    <p style='text-align: right;'><b>אימייל: </b>$email->user_email</p>
    <p style='text-align: right;'><b>טלפון: </b>$tel[0]</p>
    <p style='text-align: right;'>ח.פ<b></b>$company_id[0]</p>
    ";
    $massage .= $emailText;   
 
    //save as post 
    $form_post = array(
        'post_title'    => 'החזרה מלקוח '.$f_name[0].' '.$l_name[0].' | '.$company_name[0],
        'post_content'  => $massage,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type' => 'refunds'
    );
    $id = wp_insert_post( $form_post );
  
    //send email
    // $massage=iconv("UTF-8", "cp1255", $massage);
    $headers = array('Content-Type: text/html; charset=UTF-8');
    // 'jetserver@datapool365.onmicrosoft.com',
    $r=wp_mail(array('jetserver@datapool365.onmicrosoft.com','info@link-in.co.il'),'החזרת '.$refundtype,$massage,$headers,array($file));
    if($r == true){
        echo "true";
    }
    die;
}

function ajax_login_init(){

    wp_register_script('ajax-login-script', get_stylesheet_directory_uri() . '/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => 'https://www.datapool.co.il/%D7%94%D7%97%D7%96%D7%A8%D7%AA-%D7%9E%D7%95%D7%A6%D7%A8/',
        'loadingmessage' => __('מתבצעת בדיקת נתונים ...נא להמתין'),
        'security' => wp_create_nonce( 'my-special-string' )
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_ajaxlogin_refund', 'ajax_login_refund' );
    add_action( 'wp_ajax_nopriv_ajaxlogin_refund', 'ajax_login_refund' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}


function ajax_login_refund(){

    // check_ajax_referer( 'ajax-login-nonce', 'security' );
    check_ajax_referer( 'my-special-string', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('שם משתמש או ססמה לא נכונים')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('התחבר בהצלחה ...')));
    }

    die();
}

add_action('user_register','user_massage_after_register');

function user_massage_after_register($user_id){
    $user = get_user_by( 'ID', $user_id );
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $massage = '<p style="text-align: right; direction: rtl;">שלום Admin,</p>
    <p style="text-align: right; direction: rtl;">משתמש חדש '.$user->data->display_name.' - '.$user->data->user_email.' נרשם בהצלחה לאתר.</p>
    <p style="text-align: right; direction: rtl;">יש לאשר את הרשמו של המשתמש</p>
    <p style="text-align: right; direction: rtl;"><a href="https://www.datapool.co.il/wp-admin/users.php?s&amp;action=-1&amp;new_role&amp;ur_user_approval_status=pending&amp;ur_user_filter_action=Filter&amp;paged=1&amp;action2=-1&amp;new_role2&amp;ur_user_approval_status2">עמוד משתמשים </a></p>
    <p style="text-align: right; direction: rtl;">תודה</p>';
    $r=wp_mail(array('jetserver@datapool365.onmicrosoft.com','info@link-in.co.il'),'משתמש חדש נרשם לאתר',$massage,$headers);
}

//hook to use after user is approved by admin
add_action( 'ur_user_status_updated' , 'create_customer_365', 10, 3);
function create_customer_365( $status, $user_id, $alert_user){
    $company = get_field('user_registration_input_box_1584276913', 'user_'.$user_id);
    if(!empty($company)){
        update_field('billing_company',$company,'user_'.$user_id);
    }
    
    $billing_phone = get_field('user_registration_number_box_1584279850', 'user_'.$user_id);
    if(!empty($billing_phone)){
       update_field('billing_phone',$billing_phone,'user_'.$user_id);
    }

    $company_id = get_field('user_registration_number_box_1591078155', 'user_'.$user_id);
    if(!empty($company_id)){
        update_field('billing_company_id',$company_id,'user_'.$user_id);
    }

    $job_position = get_field('user_registration_input_box_1591078080', 'user_'.$user_id);
    if(!empty($job_position)){
        update_field('billing_job_position',$job_position,'user_'.$user_id);
    }

    $first_name = get_user_meta( $user_id, 'first_name', true );
    if(!empty($first_name)){
        update_field('billing_first_name',$first_name,'user_'.$user_id);
    }

    $last_name = get_user_meta( $user_id, 'last_name', true );
    if(!empty($last_name)){
        update_field('billing_last_name',$last_name,'user_'.$user_id);
    }

    update_field('billing_country','IL','user_'.$user_id);


}



// הפניה לעמוד חנות לאחר התחברות לאתר
function filter_woocommerce_login_redirect( $redirect, $user ) { 
    // make filter magic happen here... 
    return site_url().'/shop/';
    // return $redirect; 
}; 
         
// add the filter 
add_filter( 'woocommerce_login_redirect', 'filter_woocommerce_login_redirect', 10, 2 ); 

// מסתיר את אפשרויות התשלום האחרות במידה וזה משלוח חינם
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

add_action( 'woocommerce_order_status_processing', 'so_payment_processing' );
function so_payment_processing( $order_id ){
    $order = wc_get_order( $order_id );
    $user = $order->get_user();

    if( $user ){
        send_order_by_email($order->get_items(),$user->data->ID,$order_id);
    }
    // exit;
}

function send_order_by_email($items,$user_id,$order_id) {
    $integral_id = get_field('integral_id','user_'.$user_id);
    global $wpdb;
    $to_save = array();
    $i=1;
    foreach($items as $item){
        // d($item);
        $name = $item->get_name();
        $q="SELECT DISTINCT dp_postmeta.meta_value as sku FROM dp_postmeta
        JOIN dp_posts
        ON dp_posts.ID = dp_postmeta.post_id
        WHERE dp_posts.post_title LIKE '".$name."'
        AND dp_postmeta.meta_key = 'datapool_id'";
        $results = $wpdb->get_results($q);
        $to_save[$i][] = $i;
        $to_save[$i][] = $results[0]->sku;   
        $to_save[$i][] = $name;   
        $to_save[$i][] = $item->get_total();   
        $to_save[$i][] = $item->get_quantity();  
        $to_save[$i][] = $integral_id; 
        $i++;
    }


    // $current_user = wp_get_current_user();
    $name = date('h_i_s');
    $file=get_stylesheet_directory().'/order_files/order_'.$order_id.'_'.$name.'.csv';
    $fp = fopen($file, 'w');
    fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($fp, array('שורה','מקט','שם מוצר','מחיר','כמות','מזהה אינטגרל'));
    
    foreach($to_save as $item) {
        $item_save=array();
        $save=array();
        foreach($item as $item_save) {
            $save[]=$item_save;
        }
        fputcsv($fp, $save);
    }

    fclose($fp) or die("Can't close php://output");
    // exit;
    $emailText ="<table border='1'>";
    $emailText .= "<tr>
    <td style='padding: 5px'>שורה</td>
    <td style='padding: 5px'>מקט</td>
    <td style='padding: 5px'>שם מוצר</td>
    <td style='padding: 5px'>מחיר</td>
    <td style='padding: 5px'>כמות</td>
    <td style='padding: 5px'>מזהה אינטגרל</td>
    </tr>";
    foreach($to_save as $item) {
        $emailText .= "<tr>";
        foreach ($item as $value) {
                $emailText .= "<td style='padding: 5px'>$value</td>";
        }
        $emailText .= "</tr>";
    }    
    $emailText .="</table><br />";

    $company_name = get_user_meta($user_id,'billing_company');
    $tel = get_user_meta($user_id,'billing_phone');
    $company_id = get_user_meta($user_id,'billing_company_id');
    $f_name = get_user_meta($user_id,'first_name');
    $l_name = get_user_meta($user_id,'last_name');
    $email = get_userdata($user_id);

    $massage = "
    <p style='text-align: right;'><b>שם פרטי: </b>$f_name[0]</p>
    <p style='text-align: right;'><b>שם משפחה: </b>$l_name[0]</p>
    <p style='text-align: right;'><b>שם החברה: </b>$company_name[0]</p>
    <p style='text-align: right;'><b>אימייל: </b>$email->user_email</p>
    <p style='text-align: right;'><b>טלפון: </b>$tel[0]</p>
    <p style='text-align: right;'><b>ח.פ: </b><b></b>$company_id[0]</p>
    ";
    $massage .= $emailText;   

    //send email
    // $massage=iconv("UTF-8", "cp1255", $massage);
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail(array('jetserver@datapool365.onmicrosoft.com','info@link-in.co.il'),'הזמנה חדשה',$massage,$headers,array($file));
    wp_mail(array('info@link-in.co.il'),'הזמנה חדשה',$massage,$headers,array($file));
    return;
}


//מחליף דיפולט פלייסהולדר ללוגו של יצרן
add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
function custom_woocommerce_placeholder_img_src( $src ) {
    global $post;
    $term_list = wp_get_post_terms($post->ID,'menufacher',array('fields'=>'ids'));
    $cat_id = (int)$term_list[0];
    $term =  get_term_by ('id', $cat_id,'menufacher');
    $thumbnail_id = get_field('menufacher_logo', $term->taxonomy . '_' . $term->term_id);
    $img_src=wp_get_attachment_image_src($thumbnail_id,'full');
	return $img_src[0];
}

function blog_scripts() {
    // Register the script
    wp_register_script( 'custom-script', get_stylesheet_directory_uri(). '/js/custom.js', array('jquery'), false, true );

    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'file_upload' ),
    );
    wp_localize_script( 'custom-script', 'blog', $script_data_array );

    // Enqueued script with localized data.
    wp_enqueue_script( 'custom-script' );
}
add_action('wp_enqueue_scripts', 'blog_scripts');

add_action('wp_ajax_file_upload', 'file_upload_callback');
add_action('wp_ajax_nopriv_file_upload', 'file_upload_callback');

function file_upload_callback() {
    check_ajax_referer('file_upload', 'security');
    $arr_img_ext = array('text/csv');
    if (in_array($_FILES['file']['type'], $arr_img_ext)) {
        $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
        get_html($upload['url']);
    }
    wp_die();
}

function get_html($csv_file) {
    global $wpdb;
    $html = '<h2>הקובץ עודכן בהצלחה :-)</h2>';
    $html.='<table border="1">';
    $file = fopen($csv_file,'r');
    $header_arr=fgetcsv($file);
    $html.='<thead>';
    foreach($header_arr as $k=>$v)
    {
        $html.='<th>'.$v.'</th>';
    }
    $html.='<th>מחיר מעודכן</th>';
    $html.='<th>מזהה וורדפרס</th>';
    $html.='</thead>';
    $html.='<tbody>';


    while($line = fgetcsv($file))
    {
        $html.='<tr>';

        foreach($line as $k => $v)
        {
            $style = ($k == 3) ? 'style="background: blue;"' : '';
            $html.='<td '.$style.'>'.$v.'</td>';
            if($k == 0){
                $query = "SELECT `post_id` FROM `dp_postmeta` WHERE `meta_key` = 'datapool_id' AND `meta_value` = '".$v."'";
                $productId = $wpdb->get_results($query)[0]->post_id;
            }
            if($k == 3 || $k == 4){
                $newPrice = $v;
                if(!empty(intval($newPrice)) && $k == 3){
//                    if($productId == 5077) {
                        $_pf = new WC_Product_Factory();
                        if(!empty($_pf)){
                            $product = $_pf->get_product($productId);
                            if(!empty($product)) {
                            $product->set_price($newPrice);
                                $product->set_regular_price($newPrice);
                                $product->save();
//                            exit;
                            }
                        }
//                    }
                }
                if($k == 4){
                    $price = get_post_meta( $productId, '_regular_price', true);
                    $html.='<td style="background: green;">'.$price.'</td>';
                }
            }
        }
        $t = ($productId == 0) ? 'style="background: red;"' : '';
        $html.='<td '.$t.'>'.$productId.'</td>';
        $html.='</tr>';
    }
    $html.='</tbody>';
    $html.='</table>';
    echo $html;

}

//get_html('https://www.datapool.co.il/wp-content/uploads/2022/07/מחירון-ראשי-דיו-יוני2022.xls-1.csv');
//exit;
