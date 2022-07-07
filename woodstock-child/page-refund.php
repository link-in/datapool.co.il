<?php
/*
Template Name: Refund Page
*/
?>

<?php get_header('refund'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://jqueryui.com/resources/demos/datepicker/i18n/datepicker-he.js"></script>
    <div class="site_header woo-pages with_featured_img" style="background-image: url('https://www.datapool.co.il/wp-content/uploads/2021/08/banner4-scaled.jpg'); background-position: center -12px; opacity: 1;">

        <div class="site_header_overlay" style="opacity: 1;"></div>

        <div class="row">
            <div class="large-12 title-center large-centered columns">

                <h1 class="page-title on-shop">שירות לקוחות</h1>

            </div>
            <!-- .large-12 -->

        </div>
        <!-- .row -->
    </div>

    <div class="blank-page">

        <div id="primary" class="content-area">

            <div id="content" class="site-content" role="main">

                <div class="row">


                    <div class="large-12 columns">

                        <?php while ( have_posts() ) : the_post(); ?>

                            <div class="entry-content">
                                <div class="refund-all-form">
                                    <div class="vc_row wpb_row vc_row-fluid">
                                        <?php if(!is_user_logged_in()){ ?>
                                            <div class="vc_column-inner">
                                                <h3>
                                                    *על מנת לבצע החזרה יש להתחבר או להירשם לאתר
                                                </h3>
                                                <h2>התחברות</h2>
                                                <div class="account-forms">
                                                    <form id="login" action="login" method="post" class=login-refund>
                                                        <p class="status"></p>
                                                        <label for="username">שם משתמש או כתובת אימייל&nbsp;
                                                            <span class="required">*</span>
                                                        </label>
                                                        <input id="username" type="text" name="username">
                                                        <label for="password">סיסמה&nbsp;
                                                            <span class="required">*</span>
                                                        </label>
                                                        <input id="password" type="password" name="password">

                                                        <input class="submit_button" type="submit" value="התחבר" name="submit">
                                                        <br>
                                                        <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">שחזור סיסמה</a>
                                                        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                                                    </form>
                                                </div>
                                                <h2>הרשמה</h2>
                                                <h4>*יש למלא את כל הפרטים על מנת להירשם , לאחר ההרשמה נציגנו יעבור על הפרטים ויאשר את התחברות לאתר</h4>
                                                <?php echo do_shortcode('[user_registration_form id="6608"]'); ?>
                                            </div>
                                        <?php }else{?>
                                            <div class="vc_column-inner">
                                                <div class="vc_column-inner">

                                                    <div class="row" style=" margin-top: 50px; ">
                                                        <h4 style="margin-bottom: 40px;">בחר את הפעולה הרצויה:</h4>
                                                        <a href="#return_policy" onclick="newItems()" class="refund-link">להחזרת פריטים חדשים</a>
                                                        <a href="#return_policy" onclick="defectiveItems()" class="refund-link">להחזרת פריטים פגומים אשר נמצאים באחריות</a>
                                                        <a href="#files_for_technicians" onclick="filesForTechnicians()" class="refund-link">קבצים לטכנאים</a>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="return_policy" class="return_police">
                                                <h3>מדיניות ההחזרה </h3>
                                            </div>
                                            <div class="files_for_technicians_title" style="display:none;margin-top: 50px;">
                                                <h3>קבצים לטכנאים </h3>
                                            </div>
                                            <div class="vc_column-inner">
                                                <div class="return_policy return_policy_new">
                                                    <?php the_field('return_policy_new') ?>
                                                </div>
                                                <div class="return_policy return_policy_defective">
                                                    <?php the_field('return_policy_defective') ?>
                                                </div>
                                                <div class="return_policy files_for_technicians">
                                                    <?php
                                                    if( have_rows('files',8261) ):
                                                        echo "<ul style='padding: 60px;'>";
                                                        while( have_rows('files',8261) ) : the_row();
                                                            $file = get_sub_field('pdf_file',8261);
                                                            $url = $file['url'];
                                                            echo "<li style='margin-bottom: 15px;'>";
                                                            echo "<span style='font-size: 22px; font-weight: bold;'>".get_sub_field('name',8261)."</span> &nbsp;";
                                                            echo " - לצפייה בקובץ";
                                                            echo "<b><u><a href='".esc_attr($url)."' target='_blank'>
                                                                לחץ כאן
                                                              </a></u></b>";
                                                            echo "</li>";
                                                        endwhile;
                                                        echo "<ul>";
                                                    endif;
                                                    ?>
                                                </div>

                                            </div>
                                            <div class="vc_column-inner search-area-box">
                                                <div class="search-area search-area-refund" style=" background: #8d388ccf; width: 100%; padding: 30px; margin-bottom: 30px;">
                                                    <p style=" font-size: 28px;">חפש מוצר...</p>
                                                    <div class="l-search">

                                                        <?php
                                                        woodstock_search_form( array(
                                                            'ajax' => $tdl_options['tdl_header_ajax_search'],
                                                            'count' => $tdl_options['tdl_header_ajax_search_count'],
                                                            'post_type' => $tdl_options['tdl_header_search_pt'],
                                                            // 'fadeIn("slow")_categories' => $tdl_options['tdl_header_search_categories'],
                                                            'type' => 'form',
                                                        ) );
                                                        ?>

                                                    </div>
                                                </div>


                                                <form action="" id="refund-form">
                                                    <div class="new-line">
                                                        <input type="hidden" id="counter" name="counter" value="" />
                                                    </div>
                                                    <input type="hidden" id="refundtype" name="refundtype" value="" />
                                                    <input type="submit" value="סיים ושלח" class="wpcf7-form-control wpcf7-submit submit-refund" style="display:none;text-align: center!important; width: auto;">
                                                    <div class="l-search">
                                                        <div class="ajax-loading-refund spinner-circle">
                                                            <div class="spinner"></div>
                                                        </div>
                                                    </div>

                                                </form>


                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="refund-message">
                                    <h3>הטופס נשלח בהצלחה , נציגנו יחזרו אליכם בהקדם</h3>
                                </div>
                            </div><!-- .entry-content -->


                        <?php endwhile; // end of the loop. ?>

                    </div>
                </div>

            </div><!-- #content -->

        </div><!-- #primary -->

    </div><!-- .boxed-page -->

    <script>

        function newItems(){
            jQuery('.return_policy_new').fadeIn("slow");
            jQuery('#return_policy').fadeIn("slow");
            jQuery('.search-area-box').fadeIn("slow");
            jQuery('.return_policy_defective').fadeOut("slow");
            jQuery('#refundtype').val('מוצרים חדשים');
            jQuery('.files_for_technicians').hide();
            jQuery('.files_for_technicians_title').hide();
        }
        function defectiveItems(){
            jQuery('.return_policy_defective').fadeIn("slow");
            jQuery('#return_policy').fadeIn("slow");
            jQuery('.search-area-box').fadeIn("slow");
            jQuery('.return_policy_new').fadeOut("slow");
            jQuery('#refundtype').val('מוצרים פגומים');
            jQuery('.files_for_technicians').hide();
            jQuery('.files_for_technicians_title').hide();
        }

        function filesForTechnicians(){
            jQuery('.return_policy').hide();
            jQuery('.search-area-box').hide();
            jQuery('.files_for_technicians').fadeIn("slow");
            jQuery('.files_for_technicians_title').fadeIn("slow");
            jQuery('#return_policy').hide();
        }

        function lineValidation(line){
            var valid = true;

            if(jQuery('#r_amont_'+line+'').val() == ''){
                valid = false;
                jQuery('.r_amont_label-'+line+'').hide();
                jQuery('<label class="user-registration-error r_amont_label-'+line+'" for="#r_amont_'+line+'">שדה חובה</label>').insertAfter( '#r_amont_'+line+'' );
            }else{
                jQuery('.r_amont_label-'+line+'').hide();
            }
            if(jQuery('#r_date_'+line+'').val() == ''){
                valid = false;
                jQuery('.r_date_label-'+line+'').hide();
                jQuery('<label class="user-registration-error r_date_label-'+line+'" for="#r_date_'+line+'">שדה חובה</label>').insertAfter( '#r_date_'+line+'' );
            }else{
                jQuery('.r_date_label-'+line+'').hide();
            }
            if(jQuery('#r_invoicing_'+line+'').val() == ''){
                valid = false;
                jQuery('.r_invoicing_label-'+line+'').hide();
                jQuery('<label class="user-registration-error r_invoicing_label-'+line+'" for="#r_invoicing_'+line+'">שדה חובה</label>').insertAfter( '#r_invoicing_'+line+'' );
            }else{
                jQuery('.r_invoicing_label-'+line+'').hide();
            }
            if(jQuery('#r_invoicing_'+line+'').val().length != 6 && jQuery('#r_invoicing_'+line+'').val().length > 0){
                valid = false;
                jQuery('.r_invoicing_length_label-'+line+'').hide();
                jQuery('<label class="user-registration-error r_invoicing_length_label-'+line+'" for="#r_invoicing_'+line+'">החשבונית צריכה להיות 6 ספרות</label>').insertAfter( '#r_invoicing_'+line+'' );
            }else{
                jQuery('.r_invoicing_length_label-'+line+'').hide();
            }
            if(jQuery('#r_return_'+line+'').val() == 'נא לבחור סיבה'){
                valid = false;
                jQuery('.r_return_label-'+line+'').hide();
                jQuery('<label class="user-registration-error r_return_label-'+line+'" for="#r_return_'+line+'">שדה חובה</label>').insertAfter( '#r_return_'+line+'' );
            }else{
                jQuery('.r_return_label-'+line+'').hide();
            }
            return valid;
        }

        function addItem(line){
            valid = lineValidation(line);
            if(valid == true){
                jQuery('.ajax-search-input').val('');
                jQuery('.ajax-search-input').focus();
                jQuery('html, body').animate({
                    scrollTop: jQuery('.return_policy_defective').offset().top
                }, 2000);
                jQuery('.ajax-search-input').css('border', '1px solid #8d388c');
            }else{
                return false;
            }
        }

        function removeRow(line){
            jQuery('.r_row_'+line+'').remove().fadeOut( "slow" );
            jQuery('.ajax-search-input').val('');
        }

        jQuery( document ).ready(function() {
            jQuery("#refund-form").submit( function(e) {
                valid = lineValidation(jQuery('#counter').val());
                if(valid == true){
                    jQuery(".ajax-loading-refund").css({"opacity":"1","visibility":"visible","width":"110px"});
                    e.preventDefault();
                    jQuery.ajax({
                        type : "post",
                        dataType : "json",
                        url : jckqv_vars.ajaxurl,
                        data : {action: "refund_fun", data : jQuery('#refund-form').serialize(), nonce: jckqv_vars.nonce},
                        success: function(response) {
                            // console.log("response" + response);
                            jQuery(".ajax-loading-refund").css({"opacity":"0","visibility":"hidden","width":"90px"});
                            if(response == true) {
                                jQuery('.refund-all-form').fadeOut("slow");
                                jQuery('.refund-message').fadeIn("slow");
                                jQuery('.submit-refund').fadeIn("slow");
                            }
                            // else {
                            //    alert("Your like could not be added");
                            // }
                        }
                    });
                }else{
                    return false;
                }
            });

            jQuery(".searchform").submit( function(e) {
                e.preventDefault();
                return false;
            });

            jQuery('.count_digits').keydown( function(e){
                if (jQuery(this).val().length == 7) {
                    jQuery('<label id="number_box_1591078155-error" class="user-registration-error" for="number_box_1591078155">מקסימום 7 ספרות</label>').insertAfter( '#number_box_1591078155' );
                }
            });
        });



    </script>

    <style>
        button.searchsubmit {
            display: none;
        }
        .wpcf7-submit {
            /* background: #808080!important; */

        }
        input.wpcf7-form-control.wpcf7-submit.submit-refund {
            background: #8d388ccf!important;
        }
        span.required {
            color: red!important;
        }

        input[type="submit"]{
            padding: 0 10px!important;
        }


    </style>


<?php get_footer(); ?>