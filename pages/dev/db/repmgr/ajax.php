<?
if(!$repmgr || !$repmgr->initialized){
   die('no cluster installed');
}

$params = (count($_POST)?$_POST:(count($_GET)?$_GET:die('no parameters')));

switch($params['func']){
   case('kill'):
      $standby_node = $params['a'];
      $pid = $params['b'];

      $output = $repmgr->remote_kill($standby_node, $pid);

      $json = array(
         'exit_status' => $exit_status = array_pop($output),
         'success' => $exit_status == '0',
         'output' => is_array($output)?implode('\n', $output):$output,
         'ps' => $repmgr->remote_ps($standby_node)
      );

      echo json_encode($json);

      break;
   case('start'):
      $standby_node = $params['a'];

      $output = $repmgr->remote_start($standby_node);

      $json = array(
         'exit_status' => $exit_status = array_pop($output),
         'success' => $exit_status == '0',
         'output' => is_array($output)?implode('\n', $output):$output,
         'ps' => $repmgr->remote_ps($standby_node)
      );

      echo json_encode($json);

      break;
   default:
      die('unrecognized function');
}

?>
