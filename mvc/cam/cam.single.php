<?
$panelSize = first($_REQUEST['zoom'], 640);
?>
<div id="camsPanel"><?

$camTitle = '';
foreach(cfg('cameras/cams') as $cam) if($cam['id'] == $_REQUEST['id'])
{
  $camTitle = htmlspecialchars(first($cam['title'], $cam['id']));
  ?><div>
    <div style="text-align:center;padding:4px;"><?= $camTitle ?></div>
    <a href="<?= actionUrl('index', 'cam', array('id' => $cam['id'])) ?>">
      <img src="data/cam/<?= $cam['id'] ?>_mid.jpg" width="100%"/>
    </a>
  </div><?
}

?></div>

<script>
  
  messageHandlers.camtick = function() {
    window.location.reload(true);
  };
  
  $('#lefthdr').text('<?= $camTitle ?>');
  
</script>

<style>
#camsPanel {
  margin-top: -52px;
  margin-left: -15px;
}

#camsPanel > div {
  display: inline-block;
  width: <?= $panelSize ?>px;
  height: <?= round(3*$panelSize/4)+30 ?>px;
  margin-right: 16px;
  margin-bottom: 16px;
  border: 1px solid rgba(0,0,0,0.3);
  box-shadow: 0px 0px 12px rgba(0,0,0,0.25);
  overflow: hidden;
}
</style>