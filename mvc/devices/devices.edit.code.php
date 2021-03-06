<?
  
$editable = array(
  'd_bus' => 'Bus System',
  'd_id' => 'Identifier',
  'd_type' => 'Type',
  'd_name' => 'Name',
  'd_icon' => 'Icon',
  'd_room' => 'Room',
  'd_alias' => 'Alias'
);

$doSave = isset($_POST['controller']);

$ds = getDeviceDS($_REQUEST['key']);
$dev = HMRPC('getDeviceDescription', array($ds['d_id']));
$paramSet = H2EventManager::getEmittableEventsByDevice($ds);

$_REQUEST['actionEvents'] = array();

$related = array();
$idnr = $ds['d_id'];
$idroot = CutSegment(':', $idnr);
  
if($dds['d_id'] != '')
foreach (o(db)->get('SELECT d_key,d_id,d_alias,d_type FROM devices WHERE d_id LIKE "' . $idroot . '%" ORDER BY d_id') as $dds)
{
  $related[] = '<a href="' . actionUrl('edit', 'devices', array('key' => $dds['d_key'])) . 
    '" style="' . ($dds['d_key'] == $ds['d_key'] ? 'font-weight:bold;' : '') . '">' . 
    htmlspecialchars(first($dds['d_alias'], $dds['d_type'])) . ' ' . $dds['d_id'] . '</a>'; 
}

if ($_POST['key'])
{
  foreach($editable as $fn => $fncap)
    $ds[$fn] = $_POST[$fn];
  o(db)->commit('devices', $ds);
  header('location: '.actionUrl('show'));
  die();
}

$eventList = H2EventManager::getEventsByDevice($ds);
$eventTargetList = H2EventManager::getEventsByTarget($ds);
$groupList = H2GroupManager::getGroupsByDevice($ds);