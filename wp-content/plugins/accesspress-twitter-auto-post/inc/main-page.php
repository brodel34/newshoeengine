<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="wrap">
    <!--Plugin Header-->
    <?php include('header.php'); ?>
    <!--Plugin Header-->

    <div class="asap-main-section">
        <?php if (isset($_SESSION['atap_message'])) { ?><div class="notice notice-success is-dismissible"><p><?php
            echo $_SESSION['atap_message'];
            unset($_SESSION['atap_message']);
            ?></p></div><?php } ?>
        <?php
        global $wpdb;



            ?>
            <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'settings'; ?>
            <div class="asap-main-inner-wrap">
                <ul class="asap-tabs-wrap">
                    <li class="asap-tab asap-active-tab" id="asap-tab-settings"><?php _e('Settings', 'accesspress-twitter-auto-post'); ?></li>
                    <li class="asap-tab" id="asap-tab-logs"><?php _e('Logs', 'accesspress-twitter-auto-post'); ?></li>
                    <li class="asap-tab" id="asap-tab-how"><?php _e('How To Use', 'accesspress-twitter-auto-post'); ?></li>
                    <li class="asap-tab" id="asap-tab-about"><?php _e('About', 'accesspress-twitter-auto-post'); ?></li>
                    <li class="asap-tab"  id="asap-tab-upgrade"><?php _e('Upgrade', 'accesspress-twitter-auto-post'); ?></li>
                    <li class="asap-tab" id="asap-tab-morewp"><?php _e('More WordPress Resources', 'accesspress-twitter-auto-post'); ?></li>
                </ul>
                <?php
                /**
                 * Accounts Section
                 */
                include_once('tabs/settings.php');

                /**
                 * Logs Section
                 * */
                include('tabs/logs.php');

                /**
                 * How To Use Section
                 */
                include_once('tabs/how-to-use.php');

                /**
                 * About Section
                 */
                include_once('tabs/about.php');

                /**
                 * Upgrade Section
                 */
                include_once('tabs/upgrade.php');

                /**
                 * More WordPress Resources Section
                 */
                include_once('tabs/more-wp.php');
                ?>
            </div>
            <div class="right-promobar">
                 <img src="<?php echo ATAP_IMG_DIR . '/upgrade to pro.png'; ?>" width="100%" />
                 <div class="button-wrap-backend">
                    <a href="http://demo.accesspressthemes.com/wordpress-plugins/accesspress-social-auto-post/" target="_blank" class="upgrade-btn">Demo</a>
                    <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-social-auto-post%2F11752265" target="_blank" class="upgrade-btn">Upgrade To Pro</a>
              </div>
                 <img src="<?php echo ATAP_IMG_DIR . '/upgrade to pro-feature.png'; ?>" width="100%" />
            </div>

    </div>
</div>
