<?php // $Revision: 1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: footer.php,v 1.1 2004/11/09 17:13:48 pixtur Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

echo "<p id='footer'>Powered by NetOffice v$version";

if ($notLogged != true && $blank != true) {
    echo ' - Connected users: ' . $connectedUsers;
} 

if ($footerDev == true) {
    $parse_end = getmicrotime();
    $parse = $parse_end - $parse_start;
    $parse = round($parse, 3);
    echo " - $parse secondes - databaseType $databaseType - select requests $comptRequest";
    echo ' - <a href="http://validator.w3.org/check/referer" target="w3c">w3c</a> (in progress)';
} 

echo '</p>
</body>
</html>';

?>
