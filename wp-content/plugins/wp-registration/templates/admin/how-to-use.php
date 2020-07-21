<?php
/*
** help
*/
    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $registration_form = "<li> <a target ='_blank' href='" .admin_url("edit.php")."?post_type=wpr'> Registration Page: </a> Generated by WPR Forms</li>";

    $dashboard_link = "<a  class ='dashboard_link' target ='_blank' href='" .admin_url("edit.php")."?post_type=wpr&page=wpr_dashboard_id'>migration</a>";


?>
<div class="wpr-how-use">  
    <h2>How to use this plugin</h2>
    <p>This plugin create following pages and also create a demo registration form</p>
    <ul>
            <li><h4>Pages</h4></li>
            <li>1. WPR Login</li>
            <li>2. WPR Registration</li>
            <li>3. WPR Account</li>
            <li>4. WPR Profile</li>
            <li>5. WPR Logout</li>
            <li>6. WPR Password Reset</li>
            <li><h4>Form</h4></li>
            <li>Default Registration</li>

    </ul>

    <h2>Important Shorcodes</h2>
    <ol>
        <?php echo $registration_form; ?>
        <li>Login Page: <pre>[wpr-login]</pre></li>
        <li>Registration Page: <pre>[wpr-form id]</pre></li>
        <li>Profile Page: <pre>[wpr-profile]</pre></li>
        <li>Account Page: <pre>[wpr-account]</pre></li>
        <li>Password Reset Page: <pre>[wpr-password-reset]</pre></li>
        <li>Member Directory: <pre>[wpr-member-dir]</pre></li>

        <li><strong>I need more features, how to get it?</strong>
        <p>Yes, we do customization for all our plugins please contact us at <a href="mailto:sales@najeebmedia.com">sales@najeebmedia.com</a></p></li>
    </ol>

    <h2>Quick Videos</h2>
    <a target ="_blank" href="https://najeebmedia.com/videos-tutorial-for-wordpress-simple-registrations/">Video Tutorial for WordPress Simple Registration</a>

    <h2>Migrate from Old Vesion</h2>
    <p>We have <?php echo $dashboard_link; ?> utility added in plugin Dashboard.</p>
</div>