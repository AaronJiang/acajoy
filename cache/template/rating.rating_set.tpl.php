<?php defined('IN_TS') or die('Access Denied.'); ?> <b>你的评分</b> : <div class="rateit" data-rateit-value="0" data-rateit-resetable="false" data-articleid="<?php echo $_GET['id'];?>"> </div> 
 <span id="rate_response"></span>
 <script>
  // set tooltip value       
  $(".tar .rateit").bind('over', function (event,value) { $(this).attr('title', value); });       
  $('.tar .rateit').bind('rated reset', function (e) {
      var ri = $(this);

      //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
      var value = ri.rateit('value');
      var articleid = ri.attr('data-articleid'); // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()

      ri.rateit('readonly', true);
      $.ajax({
          url: siteUrl+'index.php?app=article&ac=rate&ts=set',
          data: { id: articleid, value: value }, //our data
          dataType: 'json',
          type: 'POST',
          success: function (data) {
        	  if (data.error == 0) {
        		  $('#rate_response').html(data.score);
        	  }
        	  alert(data.msg);  
          }
      });
  });
 </script>