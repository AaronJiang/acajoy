<?php defined('IN_TS') or die('Access Denied.'); ?><link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
<div class="rateit average_socre" data-rateit-value="0" data-rateit-ispreset="true" data-rateit-readonly="true"></div><span class="rateit_score"></span> (34944人评分)
<script>
  // set tooltip value       
  $(document).ready(function(){
	  $.ajax({
          url: siteUrl+'index.php?app=article&ac=rate&ts=get',
          data: { id: <?php echo $_GET['id'];?> }, //our data
          type: 'POST',
          success: function (data) {
        	  $('.average_socre').rateit('value', data); 
        	  $('.rateit_score').html(' ' + data + ' ');
          }
      });
  });
 </script>