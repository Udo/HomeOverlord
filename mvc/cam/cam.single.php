<?
$panelSize = first($_REQUEST['zoom'], 640);
?>
<div id="camsPanel"><?

$camTitle = '';
$thisCam = array();
foreach(cfg('cameras/cams') as $cam) if($cam['id'] == $_REQUEST['id'])
{
  $thisCam = $cam;
  $camTitle = htmlspecialchars(first($cam['title'], $cam['id']));
  ?><a href="<?= actionUrl('index', 'cam') ?>"><img src="data/cam/<?= $cam['id'] ?>_mid.jpg" width="80%"/></a><?
}

?></div>

<div style="text-align: center;">
  <?
  if($thisCam['videoUrl'])
  {
    ?><a href="<?= actionUrl('video', 'cam', array('id' => $thisCam['id'])) ?>">&gt; Live Video</a><?
  }
  ?>
</div>

<script>
  
  messageHandlers.camtick = function() {
    window.location.reload(true);
  };
  
  setTimeout(function() {
    window.location.reload(true);
    }, 1000*20);
  
  $('#lefthdr').text('<?= $camTitle ?>');
  
</script>

<style>
#camsPanel {
  margin-top: -22px;
  margin-left: -10px;
  text-align: center;
}

</style>