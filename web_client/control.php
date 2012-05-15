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

function directv_control_ssh($command)
{
   if (!function_exists('ssh2_auth_pubkey_file'))
   {
      return FALSE;
   }

   if ($con = ssh2_connect("philgomez.com", 2154, array('hostkey'=>'ssh-rsa'))) 
   {
      if (ssh2_auth_pubkey_file($con, 'mediacenter', '/home/phillip/Documents/id_rsa.pub', '/home/phillip/Documents/id_rsa'))
      {
            // execute a command
            if ($stream = ssh2_exec($con, '/home/mediacenter/src/Directv_Control/directv.pl '.$command))
            {
               // collect returning data from command
               stream_set_blocking($stream, true);
               $data = "";
               while ($buf = fread($stream,4096)) {
                  $data .= $buf;
               }
               fclose($stream);
               return $data;
         }
      }
   }

   return FALSE;
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
