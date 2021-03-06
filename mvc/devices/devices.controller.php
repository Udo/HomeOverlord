<?php

class DevicesController extends H2Controller
{
  function __init()
  {
    $this->access('local,internal,auth');
    $GLOBALS['submenu'] = array();
    foreach(array('index', 'admin') as $a)
      $GLOBALS['submenu'][] = array('controller' => 'devices', 'action' => $a, 'text' => 'devices.'.$a);
  }

  function index()
  {
    $GLOBALS['pagetitle'] = ':: Devices';
    $this->setupDeviceList();
  }
  
  function ajax_savefield()
  {
    o(db)->query('UPDATE devices SET '.$_REQUEST['f'].'=? WHERE d_key=?', array($_REQUEST['v'], $_REQUEST['key']));
    WriteToFile('log/debug.log', json_encode($_REQUEST).chr(10));
  }
  
  function ajax_pairHmStart()
  { 
    HMRPC('setInstallMode', array(true));
    print(HMRPC('getInstallMode', array()));    
  }
  
  function bigicons()
  {
    $this->index();
  }
  
  function setupDeviceList($by = 'd_room')
  {
    $this->devices = array();
    foreach(o(db)->get('SELECT * FROM devices
      ORDER BY d_room, d_type, d_name, d_key') as $d)
    {
      if($d['d_room'] != 'unknown')
        $this->devices[$d[$by]][] = $d;
    }  
    if($by == 'd_room') foreach($GLOBALS['config']['cameras']['cams'] as $camKey => $camDevice)
    {
      if($camDevice['room'] != '')
      {
        $this->devices[$camDevice['room']][] = array(
          'd_key' => 'cam'.$camKey,
          'd_type' => 'camera',
          'd_room' => $camDevice['room'],
          'd_visible' => 'Y',
          'd_name' => $camDevice['title'],
          'd_id' => $camDevice['id'],
          );
      }
    }
  }
  
  function pairhe()
  {
    
  }
  
  function create()
  {
    $dds = array();
    $dkey = o(db)->commit('devices', $dds);
    header('location: ?/devices/edit&key='.$dkey);
    die();
  }
  
  function ajax_cli()
  {
    $cmd = explode(' ', trim($_REQUEST['q']));
    $method = array_shift($cmd);
    if(substr($method, 0, 3) == 'hm.')
    {
      print_r(HMRPC(substr($method, 3), $cmd));
      if($method == 'hm.setInstallMode')
      {
        print('You have 60 seconds to pair your device. After completing the pairing, click here to create an entry for it: <a href="'.
          actionUrl('pair', 'devices').
          '">Pairing Complete</a>.');
      }
    }
    else
    {
      profile_point('starting command');
      eval(trim($_REQUEST['q']));
      profile_point('command executed');
      print(chr(10));
      print_r($GLOBALS['profiler_log']);
    }
  }
  
  function client_settings()
  {
    $this->setupDeviceList();
  }
  
  function ajax_client_update()
  {
    $nv = new H2NVStore();
    $clientIdentifier = $_POST['id'];
    $clientSettings = $nv->get($clientIdentifier);
    $clientSettings[$_POST['key']] = $_POST['value'];
    $nv->set($clientIdentifier, $clientSettings);
  }
  
  function group_new()
  {
    $gds = array('g_name' => $_REQUEST['name']);
    o(db)->commit('groups', $gds);
    $this->viewName = 'groups';
  }
  
  function group_delete()
  {
    o(db)->remove('groups', $_REQUEST['id']);
    $this->viewName = 'groups';
  }
  
  function ajax_switch()
  {
    $this->skipView = true;
    deviceCommand($_REQUEST['key'], first($_REQUEST['p'], 'STATE'), $_REQUEST['v'], first($_REQUEST['by'], 'EXT'), true);
  }
  
  function ajax_halcommand()
  {
    $this->skipView = true;
    WriteToFile('log/hal.command.log', json_encode($_POST).chr(10));
    $device = new H2HALDevice($_POST['key']);
    $call = first($_POST['call'], 'state');
    $device->{$call}($_POST['command'], first($_POST['by'], 'EXT'));
  }
  
  function _getSubmenu2($opt = false)
  {
    return(H2Configuration::getAdminMenu());
  }

}

