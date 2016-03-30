<html>
<head>
     <meta name="viewport" content="width=device-width" />
     <title>LED Control</title>
     <link rel="stylesheet" href="styles.css">
     </head>
<body>
      LED Control:
	<table>
	   <tr>
		<td>
       <form method="get" action="gpioControl.php">
                     <input type="submit" value="ON" name="on">
                     <input type="submit" value="OFF" name="off">
             </form>
	 </td>
	<td>
	<form method="get" action="gpioControl2.php">
                 <input type="submit" value"ON" name="on">
                 <input type="submit" value="OFF" name="off">
        </form>
	</td>
	</tr>
	</table>
       <?php

        $setmode17 = shell_exec("/usr/local/bin/gpio -g mode 25 out");
         if(isset($_GET['on'])){
                $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 1");
                 echo "LED is on";
       }
       else if(isset($_GET['off'])){
              $gpio_off = shell_exec("/usr/local/bin/gpio -g write 25 0");
                echo "LED is off";
         }
       ?>
         </body>
 </html>
