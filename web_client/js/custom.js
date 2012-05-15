function pressKey(key) 
{
   jQuery.ajax("control.php?command=key " + key);
}

function restartStream()
{
   jQuery.ajax("control.php?reset=true");
}

$(document).ready(function(){
   $('#controller .restart').click(function(){
      $.confirm({
         'title'     : 'Restart Live Stream Confirmation',
         'message'   : 'You are about to restart the live stream. <br />Are you sure you want to continue?',
         'buttons'   : {
             'Yes'   : {
                 'class'   : 'blue',
                 'action'  : function() { restartStream(); }
             },
             'No'    : {
                 'class'   : 'grey',
                 'action'  : function(){}
             }
         }
      });
   });
});
