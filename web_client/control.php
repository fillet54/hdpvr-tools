<?php 

$STREAMING_SCRIPT_DIR = "/home/gomez/src/hdpvr-tools/streaming_scripts"

function reset_stream()
{
	$output = shell_exec("cd $STREAMING_SCRIPT_DIR; ./restart.sh &>/dev/null");
}

function directv_control($command)
{
	$output = shell_exec('/home/gomez/src/DirectTV/directv.pl '.$command);
	return $output;
}

if (isset($_GET['reset']))
{
	reset_stream();
}

if (isset($_GET['command']))
{
  $response = directv_control($_GET['command']);
  $parts = preg_split("/ /", $response);


   $channel = trim($parts[1]);
   if ($channel == null)
   {
      $data = array('response' => 'success');
   }
   else
   {
      $data = array('channel' => trim($parts[1]));
   }

   echo json_encode($data);
}
?>
