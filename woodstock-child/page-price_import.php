<?php
/*
Template Name: Price import
*/
get_header();
if(!current_user_can('administrator') ) {
    exit;
}
?>
    <div id="content" class="site-content" role="main" style="padding: 50px 0;">
        <div class="row woocommerce">
            <h1>עדכון מחירון</h1>
            <form class="fileUpload" enctype="multipart/form-data">
                <div class="form-group">
                    <label>טען קובץ:</label>
                    <input type="file" id="file" accept=".csv" />
                </div>
            </form>
            <div class="table"></div>
        </div>
    </div>
    <style>
        td, th {
            border: 1px solid #000;
            text-align: center;
        }
    </style>
<?php
get_footer();
?>