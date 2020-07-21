<?php defined('ABSPATH') or die('No script kiddies please!');?>
<div class="asap-section" id="asap-section-how" <?php if ($active_tab != 'how') { ?>style="display: none;"<?php } ?>>
    <div class="more-title">TAuto Poster</div>
    <p>For TAuto Poster, you will need <strong>API Key</strong>,<strong>API Secret</strong>,<strong>Access Token</strong>,<strong>Access Token Secret</strong>.</p>
    <p>You can get all these details after creating a Twitter Application <a href="https://apps.twitter.com/" target="_blank">here</a>.And please make sure you keep
    <input type="text" readonly="readonly" value="<?php echo site_url(); ?>" onfocus="this.select();" style="width:50%;display:block;margin:10px 0;"/>
    as Website URL while creating the app.</p>
    <p>For the proper plugin setup, please check our below video.</p>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/v9vlzZoX12s" frameborder="0" allowfullscreen></iframe>
</div>
