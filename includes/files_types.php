<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: files_types.php,v 1.2 2004/11/07 18:32:47 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

/**
 * Search for an icone based on the extention passed
 *
 * @param string $ext
 * @return string $icon
 */
function file_info_type($ext)
{
    // check for file type icone (gif, png, jpg)
    if (file_exists('../interface/icones/' . $ext . '.gif')) {
        $icon = $ext . '.gif';
    } else if (file_exists('../interface/icones/' . $ext . '.png')) {
        $icon = $ext . '.png';
    } else if (file_exists('../interface/icones/' . $ext . '.jpg')) {
        $icon = $ext . '.jpg';
    } else {
        $icon = 'fic.gif';
    }

    return($icon);
}

?>
