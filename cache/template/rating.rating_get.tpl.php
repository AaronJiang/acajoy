<?php defined('IN_TS') or die('Access Denied.'); ?><link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
<div class="rateit average_socre" data-rateit-value="0" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
<span id="rateit_score"></span> (<span id="rateit_count"></span>人评分)
<script>
  // set tooltip value       
  $(document).ready(function(){
	  $.ajax({
          url: siteUrl+'index.php?app=article&ac=rate&ts=get',
          data: { id: <?php echo $_GET['id'];?> }, //our data
          type: 'POST',
          success: function (data) {
        	  data = JSON.parse(data);
        	  if (data.error == 0) {
        		  $('.average_socre').rateit('value', data.score.average); 
            	  $('#rateit_score').html(' ' + data.score.average + ' ');
            	  $('#rateit_count').html(' ' + data.score.count + ' ');
        	  }
        	
          }
      });
  });
 </script>