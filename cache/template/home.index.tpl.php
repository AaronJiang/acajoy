<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('home_index_js')?>
<?php doAction('home_index_css')?>
<div class="midder">
<?php doAction('home_index_header')?>
<div class="clear"></div>

<div class="mc">

<?php doAction('wordad')?>

<div class="cleft">
<?php doAction('home_index_left')?>
</div>

<div class="cright">
<?php doAction('home_index_right')?>
<div class="clear"></div>
<!--广告位-->
<?php doAction('gobad','300')?>
</div>


<div class="clear"></div>
<?php doAction('home_index_footer')?>

</div>

</div>
<?php include template('footer'); ?>