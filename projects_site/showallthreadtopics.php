<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: showallthreadtopics.php,v 1.4 2004/12/22 22:16:31 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once("../includes/library.php");

$bouton[5] = "over";
$titlePage = $strings["bulletin_board"];
require_once ("include_header.php");

$tmpquery = "WHERE topic.project = '" . $_SESSION['projectSession'] . "' AND topic.published = '0' ORDER BY topic.last_post DESC";
$listTopics = new request();
$listTopics->openTopics($tmpquery);
$comptListTopics = count($listTopics->top_id);

$block1 = new block();

$block1->headingForm($strings["bulletin_board"]);

if ($comptListTopics != "0") {
    echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\" cols=\"4\" class=\"listing\">
<tr><th>" . $strings["topic"] . "</th><th>" . $strings["posts"] . "</th><th>" . $strings["owner"] . "</th><th class=\"active\">" . $strings["last_post"] . "</th></tr>";

    for ($i = 0;$i < $comptListTopics;$i++) {
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        } else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        }
        echo "<tr class=\"$class\" onmouseover=\"this.style.backgroundColor='" . $block1->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><td><a href=\"showallthreads.php?id=" . $listTopics->top_id[$i] . "\">" . $listTopics->top_subject[$i] . "</a></td><td>" . $listTopics->top_posts[$i] . "</td><td>" . $listTopics->top_mem_name[$i] . "</td><td>" . createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\"><tr><td colspan=\"4\">" . $strings["no_items"] . "</td></tr></table>";
}

echo "<br><br>
<a href=\"createthread.php\" class=\"FooterCell\">" . $strings["create_topic"] . "</a>";

$block1->headingForm_close();
require_once ("include_footer.php");

?>