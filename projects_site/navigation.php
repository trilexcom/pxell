<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: navigation.php,v 1.3 2004/12/22 22:16:31 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
?>

<!-- Navigation Start -->
<form method="post" name="login" action="<?php echo $pathMantis ?>login.php?url=<?php echo "http://{$HTTP_HOST}{$REQUEST_URI}" ?>&id=<?php echo $_SESSION['projectSession'] ?>&PHPSESSID=<?php echo $PHPSESSID;
?>">
<input type="hidden" name="f_username" value="<?php echo $_SESSION['loginSession'];
?>">
<input type="hidden" name="f_password" value="<?php echo $_SESSION['passwordSession'];
?>">
<!-- Navigation End -->
