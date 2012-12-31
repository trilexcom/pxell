<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listholidays.php,v 1.6 2004/12/22 17:13:43 madbear Exp $
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

if ($_SESSION['profilSession'] != 0) {
    header('Location: ../general/permissiondenied.php');
    exit;
}

/*
function reschedule($date1) {
    global $tableCollab;
    
    $date1b = hours_before($date1, 8);
    $date1a = hours_after($date1, 8);
    
    $tmpquery = " WHERE tas.start_date >= '$dateb' AND tas.start_date <= '$date1a' OR tas.due_date >= '$dateb' AND tas.due_date <= '$date1a' AND tas.start_date <> '--' AND tas.due_date <> '--' ORDER BY tas.due_date";
    $taskList = new request();
    $taskList->openTasks($tmpquery);
    
    $comptTaskList = count($taskList->tas_id);
    $adjArray = array();
    
    for ($i = 0;$i < $comptTaskList;$i++) {
        $old_sd = $taskList->tas_start_date[$i];
        $old_dd = $taskList->tas_due_date[$i];
        $old_etm = $taskList->tas_estimated_time[$i];
        $sd = hours_after($old_sd, 1);
        $etm = $taskList->tas_estimated_time[$i];
        $fixd = $taskList->tas_fixed_duration[$i];
        $miles = $taskList->tas_milestone[$i];
        
        if ($miles == "0") {
            $dd = $sd;
        } elseif ($fixd == "0") {
            $dd = hours_after($sd, $etm);
        } else {
            $dd = hours_before($old_dd, 1);

            if ($dd < $sd) {
                $dd = $sd;
            }
            $etm = diff_hour($sd, $dd);
        }
        
        // Adjust task start & due date with predecessor tasks
        $tmpquery8 = " WHERE pre.task = '" . $taskList->tas_id[$i] . "'";
        $predecessorList = new request();
        $predecessorList->openTaskPredecessor($tmpquery8);
        $comptPredecessorList = count($predecessorList->pre_id);
        
        if (($dd != $old_dd || $sd != $old_sd) && $comptPredecessorList > 0) {
            $sdLowerLimit = -1;
            $sdUpperLimit = -1;
            $ddLowerLimit = -1;
            $ddUpperLimit = -1;
            $timestampSD = date2timestamp($sd);
            $timestampDD = date2timestamp($dd);
            
            for ($j = 0; $j < $comptPredecessorList; $j++) {
                $timestampSD2 = date2timestamp($predecessorList->pre_tas2_start_date[$j]);
                $timestampDD2 = date2timestamp($predecessorList->pre_tas2_due_date[$j]);
                $timestampSD3 = date2timestamp(hours_after(date('Y-m-d', $timestampSD2), $predecessorList->pre_lag[$j]+1));
                $timestampDD3 = date2timestamp(hours_after(date('Y-m-d', $timestampDD2), $predecessorList->pre_lag[$j]+1));
                
                switch ($predecessorList->pre_type[$j]) {
                    case 'FF':
                        if ($ddLowerLimit < $timestampDD2) {
                            $ddLowerLimit = $timestampDD2;
                        }
                        if ($ddUpperLimit == -1 || $ddUpperLimit > $timestampDD3) {
                            $ddUpperLimit = $timestampDD3;
                        }
                        break;
                    case 'FS':
                        if ($sdLowerLimit < $timestampDD2) {
                            $sdLowerLimit = $timestampDD2;
                        }
                        if ($sdUpperLimit == -1 || $sdUpperLimit > $timestampDD3) {
                            $sdUpperLimit = $timestampDD3;
                        }
                        break;
                    case 'SF':
                        if ($ddLowerLimit < $timestampSD2) {
                            $ddLowerLimit = $timestampSD2;
                        }
                        if ($ddUpperLimit == -1 || $ddUpperLimit > $timestampSD3) {
                            $ddUpperLimit = $timestampSD3;
                        }
                        break;
                    case 'SS':
                        if ($sdLowerLimit < $timestampSD2) {
                            $sdLowerLimit = $timestampSD2;
                        }
                        if ($sdUpperLimit == -1 || $sdUpperLimit > $timestampSD3) {
                            $sdUpperLimit = $timestampSD3;
                        }
                        break;
                }
                
                if (($sdLowerLimit != -1 && $sdUpperLimit != -1 && $sdLowerLimit > $sdUpperLimit)
                 || ($ddLowerLimit != -1 && $ddUpperLimit != -1 && $ddLowerLimit > $ddUpperLimit)
                 || ($fixd == "0" && $sdUpperLimit != -1 && $ddLowerLimit != -1 && date2timestamp(hours_after(date('Y-m-d', $sdUpperLimit), $etm)) < $ddLowerLimit)
                 || ($fixd == "0" && $sdLowerLimit != -1 && $ddUpperLimit != -1 && date2timestamp(hours_after(date('Y-m-d', $sdLowerLimit), $etm)) > $ddUpperLimit)
                 || ($miles == "0" && $sdUpperLimit != -1 && $ddLowerLimit != -1 && $sdUpperLimit < $ddLowerLimit)) {
                    header("Location: ../tasks/viewtask.php?id=" . $taskList->tas_id[$i] . "&msg=taskDependency");
                    exit;
                }
                
                if ($miles == "0") {
                    if ($ddLowerLimit != -1 && $sdLowerLimit < $ddLowerLimit) {
                        $sdLowerLimit = $ddLowerLimit;
                    }
                    
                    if ($sdUpperLimit != -1 && $sdUpperLimit < $ddUpperLimit) {
                        $ddUpperLimit = $sdUpperLimit;
                    }
                    
                    switch ($predecessorList->pre_type[$j]) {
                        case 'FF':
                        case 'SF':
                            if ($timestampDD < $ddLowerLimit || $timestampDD > $ddUpperLimit) {
                                $timestampDD = $ddUpperLimit;
                                $timestampSD = $timestampDD;
                            }
                            break;
                        case 'FS':
                        case 'SS':
                            if ($timestampSD < $sdLowerLimit || $timestampSD > $sdUpperLimit) {
                                $timestampDD = $sdUpperLimit;
                                $timestampSD = $timestampDD;
                            }
                            break;
                    }
                } else if ($fixd == "0") {
                    if ($sdLowerLimit != -1 && $ddLowerLimit != -1 && date2timestamp(hours_after(date('Y-m-d', $sdLowerLimit), $etm)) < $ddLowerLimit) {
                        $sdLowerLimit = date2timestamp(hours_before(date('Y-m-d', $ddLowerLimit), $etm));
                    }
                    
                    if ($sdUpperLimit != -1 && $ddUpperLimit != -1 && date2timestamp(hours_after(date('Y-m-d', $sdUpperLimit), $etm)) < $ddUpperLimit) {
                        $ddUpperLimit = date2timestamp(hours_after(date('Y-m-d', $sdUpperLimit), $etm));
                    }
                    
                    switch ($predecessorList->pre_type[$j]) {
                        case 'FF':
                        case 'SF':
                            if ($timestampDD <= $ddLowerLimit) {
                                if ($predecessorList->pre_lag[$j] < "8") {
                                    $timestampDD = $ddLowerLimit;
                                } else {
                                    $timestampDD = date2timestamp(hours_after(date('Y-m-d', $ddLowerLimit), 9));
                                }
                            } else if ($timestampDD > $ddUpperLimit) {
                                $timestampDD = $ddUpperLimit;
                            }
                            $timestampSD = date2timestamp(hours_before(date('Y-m-d', $timestampDD), $etm));
                            break;
                        case 'FS':
                        case 'SS':
                            if ($timestampSD <= $sdLowerLimit) {
                                if ($predecessorList->pre_lag[$j] < "8") {
                                    $timestampSD = $sdLowerLimit;
                                } else {
                                    $timestampSD = date2timestamp(hours_after(date('Y-m-d', $sdLowerLimit), 9));
                                }
                            } else if ($timestampSD > $sdUpperLimit) {
                                $timestampSD = $sdUpperLimit;
                            }
                            $timestampDD = date2timestamp(hours_after(date('Y-m-d', $timestampSD), $etm));
                            break;
                    }
                } else {
                    switch ($predecessorList->pre_type[$j]) {
                        case 'FF':
                        case 'SF':
                            if ($timestampDD <= $ddLowerLimit) {
                                if ($predecessorList->pre_lag[$j] < "8") {
                                    $timestampDD = $ddLowerLimit;
                                } else {
                                    $timestampDD = date2timestamp(hours_after(date('Y-m-d', $ddLowerLimit), 9));
                                }
                            } else if ($timestampDD > $ddUpperLimit) {
                                $timestampDD = $ddUpperLimit;
                            }
                            if ($timestampSD > $timestampDD) {
                                $timestampSD = $timestampDD;
                            }
                            break;
                        case 'FS':
                        case 'SS':
                            if ($timestampSD <= $sdLowerLimit) {
                                if ($predecessorList->pre_lag[$j] < "8") {
                                    $timestampSD = $sdLowerLimit;
                                } else {
                                    $timestampSD = date2timestamp(hours_after(date('Y-m-d', $sdLowerLimit), 9));
                                }
                            } else if ($timestampSD > $sdUpperLimit) {
                                $timestampSD = $sdUpperLimit;
                            }
                            if ($timestampDD < $timestampSD) {
                                $timestampDD = $timestampSD;
                            }
                            break;
                    }
                }
            }
            
            $sd = date('Y-m-d', $timestampSD);
            $dd = date('Y-m-d', $timestampDD);
            $etm = diff_hour($sd, $dd);
            $tmpquery6 = "";
            
            if ($old_sd != $sd) {
                $tmpquery6 .= "start_date='$sd',";
            }
            
            if ($old_dd != $dd) {
                $tmpquery6 .= "due_date='$dd',";
            }
            
            if ($miles == "1" && $fixd == "1" && $old_etm != $etm) {
                $tmpquery6 .= "estimated_time='$etm',";
            }
            
            if ($tmpquery6 != "") {
                $tmpquery6 = "UPDATE " . $tableCollab["tasks"] . " SET " . $tmpquery6 . "modified='$dateheure' WHERE id = '" . $taskList->tas_id[$i] . "'";
                connectSql("$tmpquery6");
                                                                                                                                   
                $cUp = "\n[datedue:$new_dd]";
                $cUp = convertData($cUp);
                $tmpquery6 = "INSERT INTO " . $tableCollab["updates"] . "(type,item,member,comments,created) VALUES ('1','" . $taskList->tas_id[$i] . "','" . $_SESSION['idSession'] . "','$cUp','$dateheure')";
                connectSql("$tmpquery6");
            }
        }
        
        array_push($adjArray, $taskList->tas_id[$i]);
    }
    
    while (count($adjArray) > 0) {
        $adjTaskID = array_shift($adjArray);
        $tmpquery8 = " WHERE pre.predecessor='$adjTaskID'";
        $successorList = new request();
        $successorList->openTaskPredecessor($tmpquery8);
        $comptSuccessorList = count($successorList->pre_id);
        
        for ($i = 0; $i < $comptSuccessorList; $i++) {
            $timestampSD = date2timestamp(hours_after($successorList->pre_tas_start_date[$i], 1));
            
            if ($successorList->pre_tas_milestone[$i] == "0") {
                $timestampDD = $timestampSD;
            } else if ($successorList->pre_tas_fixed_duration[$i] == "0") {
                $timestampDD = date2timestamp(hours_after(date('Y-m-d', $timestampSD), $successorList->pre_tas_estimated_time[$i]));
            } else {
                $timestampDD = date2timestamp(hours_before($successorList->pre_tas_due_date[$i], 1));
                if ($timestampDD < $timestampSD) {
                    $timestampDD = $timestampSD;
                }
            }
            
            $timestampSD2 = date2timestamp($successorList->pre_tas2_start_date[$i]);
            $timestampDD2 = date2timestamp($successorList->pre_tas2_due_date[$i]);
            $timestampSD3 = date2timestamp(hours_after(date('Y-m-d', $timestampSD2), $successorList->pre_lag[$i]+1));
            $timestampDD3 = date2timestamp(hours_after(date('Y-m-d', $timestampDD2), $successorList->pre_lag[$i]+1));
            
            switch ($successorList->pre_type[$i]) {
                case 'FF':
                    if ($timestampDD>$timestampDD3) {
                        $timestampDD = $timestampDD3;
                    } else if ($timestampDD<=$timestampDD2) {
                        if ($successorList->pre_lag[$i]<"8") {
                            $timestampDD = $timestampDD2;
                        } else {
                            $timestampDD = date2timestamp(hours_after(date('Y-m-d', $timestampDD2), 9));
                        }
                    }
                    if ($successorList->pre_tas_milestone[$i]=="0") {
                        $timestampSD = $timestampDD;
                    } else if ($successorList->pre_tas_fixed_duration[$i] == "0") {
                        $timestampSD = date2timestamp(hours_before(date('Y-m-d', $timestampDD), $successorList->pre_tas_estimated_time[$i]));
                    }
                    break;
                case 'FS':
                    if ($timestampSD>$timestampDD3) {
                        $timestampSD = $timestampDD3;
                    } else if ($timestampSD<=$timestampDD2) {
                        if ($successorList->pre_lag[$i]<"8") {
                            $timestampSD = $timestampDD2;
                        } else {
                            $timestampSD = date2timestamp(hours_after(date('Y-m-d', $timestampDD2), 9));
                        }
                    }
                    if ($successorList->pre_tas_milestone[$i]=="0") {
                        $timestampDD = $timestampSD;
                    } else if ($successorList->pre_tas_fixed_duration[$i] == "0") {
                        $timestampDD = date2timestamp(hours_after(date('Y-m-d', $timestampSD), $successorList->pre_tas_estimated_time[$i]));
                    }
                    break;
                case 'SF':
                    if ($timestampDD>$timestampSD3) {
                        $timestampDD = $timestampSD3;
                    } else if ($timestampDD<=$timestampSD2) {
                        if ($successorList->pre_lag[$i]<"8") {
                            $timestampDD = $timestampSD2;
                        } else {
                            $timestampDD = date2timestamp(hours_after(date('Y-m-d', $timestampSD2), 9));
                        }
                    }
                    if ($successorList->pre_tas_milestone[$i]=="0") {
                        $timestampSD = $timestampDD;
                    } else if ($successorList->pre_tas_fixed_duration[$i] == "0") {
                        $timestampSD = date2timestamp(hours_before(date('Y-m-d', $timestampDD), $successorList->pre_tas_estimated_time[$i]));
                    }
                    break;
                case 'SS':
                    if ($timestampSD>$timestampSD3) {
                        $timestampSD = $timestampSD3;
                    } else if ($timestampSD<=$timestampSD2) {
                        if ($successorList->pre_lag[$i]<"8") {
                            $timestampSD = $timestampSD2;
                        } else {
                            $timestampSD = date2timestamp(hours_after(date('Y-m-d', $timestampSD2), 9));
                        }
                    }
                    if ($successorList->pre_tas_milestone[$i]=="0") {
                        $timestampDD = $timestampSD;
                    } else if ($successorList->pre_tas_fixed_duration[$i] == "0") {
                        $timestampDD = date2timestamp(hours_after(date('Y-m-d', $timestampSD), $successorList->pre_tas_estimated_time[$i]));
                    }
                    break;
            }
            
            $new_sd = date("Y-m-d", $timestampSD);
            $new_dd = date("Y-m-d", $timestampDD);
            $new_etm = diff_hour($timestampSD, $timestampDD);
            $tmpquery6 = "";
            
            if ($new_sd != $successorList->pre_tas_start_date[$i]) {
                $tmpquery6 .= "start_date='$new_sd',";
            }
            
            if ($new_dd != $successorList->pre_tas_due_date[$i]) {
                $tmpquery6 .= "due_date='$new_dd',";
            }
            
            if ($successorList->pre_tas_milestone[$i] == "1" && $successorList->pre_tas_fixed_duration[$i] == "1" && $new_etm != $successorList->pre_tas_estimated_time[$i]) {
                $tmpquery6 .= "estimated_time='$new_etm',";
            }
            
            if ($tmpquery6 != "") {
                array_push($adjArray, $successorList->pre_task[$i]);
                $tmpquery6 = "UPDATE " . $tableCollab["tasks"] . " SET " . $tmpquery6 . "modified='$dateheure' WHERE id = '" . $successorList->pre_task[$i] . "'";
                connectSql("$tmpquery6");
                                                                                                                                   
                $cUp = "\n[datedue:$new_dd]";
                $cUp = convertData($cUp);
                $tmpquery6 = "INSERT INTO " . $tableCollab["updates"] . "(type,item,member,comments,created) VALUES ('1','" . $successorList->pre_task[$i] . "','" . $_SESSION['idSession'] . "','$cUp','$dateheure')";
                connectSql("$tmpquery6");
            }
        }
    }
}
*/

if ($action == "add") {
    $tmpquery = "INSERT INTO " . $tableCollab["holiday"] . " (date,comments) VALUES ('$d','$c')";
    connectSql("$tmpquery");
    #reschedule($d);
    $msg = 'add';
} else if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $tmpquery = " WHERE id IN($id) ORDER BY hol.date";
    $holidayList = new request();
    $holidayList->openHoliday($tmpquery, 0, 1);
    $comptHolidayList = count($holidayList->hol_id);
    $tmpquery = "DELETE FROM " . $tableCollab["holiday"] . " WHERE id IN($id)";
    connectSql("$tmpquery");
    if ($comptHolidayList != "0") {
        #reschedule($holidayList->hol_date[0]);
    }
    $msg = 'delete';
}

$breadcrumbs[]=buildLink('../administration/admin.php', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['holidays'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

//--- content -----
$block1 = new block();
$block1->headingForm($strings['new_holiday']);

$block1->openContent();

$block1->form = 'hoT';
$block1->openForm("../administration/listholidays.php?action=add&amp;d=" . $d. "&amp;c=" . $c . "#" . $block1->form . "Anchor");

$block1->contentRow($strings["date"], "<input type=\"text\" style=\"width: 150px;\" name=\"d\" id=\"sel1\" size=\"20\" value=\"$sd\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");
$block1->contentRow($strings["comments"], "<textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"c\" cols=\"47\">$c</textarea>");

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"></td></tr>";

$block1->closeContent();

$block1->heading($strings["holidays"]);

$block1->openPaletteIcon();
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->closePaletteIcon();

$tmpquery = " ORDER BY hol.date DESC";
$holidayList = new request();
$holidayList->openHoliday($tmpquery);
$comptHolidayList = count($holidayList->hol_id);

$block1->recordsTotal = $comptHolidayList;

if ($comptHolidayList > 0) {
    $block1->openResults();
    $block1->labels($labels = array(0 => $strings['date'], 1 => $strings['comments']), 'true', $sorting = false, $sortingOff = array(0 => '0', 1 => 'DESC'));

    for ($i = 0; $i < $comptHolidayList; $i++) {
        $block1->openRow($holidayList->hol_id[$i]);
        $block1->checkboxRow($holidayList->hol_id[$i]);
        $block1->cellRow($holidayList->hol_date[$i]);
        $block1->cellRow($holidayList->hol_comments[$i]);
        $block1->closeRow();
    }

    $block1->closeResults();
} else {
    $block1->noresults();
} 

$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(1, "remove", "../administration/deleteholidays.php?", "false,true,true", $strings["delete"]);
$block1->closePaletteScript($comptHolidayList, $holidayList->hol_id);

$block1->headingForm_close();

require_once("../themes/" . THEME . "/footer.php");

?>
