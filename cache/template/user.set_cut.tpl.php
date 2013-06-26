<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<script src="<?php echo SITE_URL;?>public/js/jcrop/jquery.Jcrop.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo SITE_URL;?>public/js/jcrop/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript">

    jQuery(function($){

      // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;
      
      $('#target').Jcrop({
		minSize: [48,48],
		setSelect: [0,0,190,190],
        onChange: updatePreview,
        onSelect: updatePreview,
		onSelect: updateCoords,
        aspectRatio: 1
      },
	function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the API in the jcrop_api variable
        jcrop_api = this;
    });
	function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press submit.');
		return false;
	};
      function updatePreview(c){
        if (parseInt(c.w) > 0)
        {
          var rx = 48 / c.w;		//小头像预览Div的大小
          var ry = 48 / c.h;

          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
	    {
          var rx = 199 / c.w;		//大头像预览Div的大小
          var ry = 199 / c.h;
          $('#preview2').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
      };
    });

  </script>
<!--main-->
<div class="midder">
<div class="mc">
<?php include template('set_menu'); ?>


<div class="cleft bbox pd20">

<h1>裁切头像</h1>

<div style="float:left;"><img width="300" id="target" src="<?php echo SITE_URL;?>uploadfile/user/<?php echo $strUser['face'];?>"  ></div>

<div style="width:190px;height:195px;margin:0 10px;overflow:hidden; float:left;"><img  style="float:left;" id="preview2" src="<?php echo SITE_URL;?>uploadfile/user/<?php echo $strUser['face'];?>" ></div>

	<form action="<?php echo SITE_URL;?>index.php?app=user&ac=set&ts=cutdo" method="post" onsubmit="return checkCoords();">
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input class="btn" type="submit" value="裁剪" />
	</form>
	
	<a href="<?php echo tsurl('user','set',array('ts'=>'face'))?>">返回头像设置</a>

</div>

<div class="cright"></div>

</div>
</div>

<?php include template('footer'); ?>