<?php // $Revision: 1.19 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: block.class.php,v 1.19 2005/05/27 19:42:52 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

class block {
    function block() {
        $this->iconWidth = "23";
        $this->iconHeight = "23";
        $this->bgColor = "#5B7F93";
        $this->fgColor = "#C4D3DB";
        $this->oddColor = "#F5F5F5";
        $this->evenColor = "#EFEFEF";
        $this->highlightOn = "#FFFEE7";

        $this->class = "odd";
        $this->highlightOff = $this->oddColor;
        $this->theme = THEME;
        $this->pathImg = "../themes";
    }

    /**
     * Print tooltips
     *
     * @param string $item Text printed in tooltip
     * @access public
     */
    function printHelp($item) {
        global $help, $strings;
        return " [<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help[$item]) . "',SNAPX,550,BGCOLOR,'" . $this->bgColor . "',FGCOLOR,'" . $this->fgColor . "');\" onmouseout=\"return nd();\">" . $strings["help"] . "</a>]";
    }

    function note($content) {
        echo "<p class=\"note\">" . $content . "</p>\n\n";
    }


    //=== heading with embedded icon-palette ============
    // NOTE: Must by closed by either heading_close() or closePaletteIcon()!!!
    // if no icons exists, use headingForm
    function heading($title) {

/*        if ($_COOKIE[$this->form] == "c") {
            $style = "none";
            $arrow = "closed";
        }
        else {
            $style = "block";
            $arrow = "open";
        }*/

        echo '<div class=blockHeader>';
        echo '<table class="title">';
        echo "<tr>";
        echo "<td width=\"99%\">";
		echo "&nbsp;".$title;
		echo '</td><td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo "<td>";
		//... here starts paletteIcon
    }

    function heading_close(){
    	echo "</td></tr></table><div>";
	}


	function block_close() {
    	echo "</div>";
	}


    //=== heading with embedded icon-palette ============
    // NOTE: must by closed by "headingForm_close()"
    function headingForm($title) {

     	echo "<div class=blockHeader>";
        echo "<table class=title>";
        echo "<tr>";
	    echo "<td>";
		echo "&nbsp;".$title."</td>";
		echo "<td width=\"1%\">&nbsp;&nbsp;&nbsp;";
    	echo "</td>";
		echo "</tr>";
		echo "<tr><td class=blockForm colspan=2>";

	}

    function headingForm_close() {
		echo "</td></tr></table></div>";
	}

    function closeToggle() {
        echo "</div>\n\n";
    }

	//=== open headingToggle with embedded icon-palette ================================
	// NOTE: this must be closed either by headingToggle_close or by closePaletteIcon
    function headingToggle($title) {

        if ($_COOKIE[$this->form] == "c") {
            $style = "none";
            $arrow = "closed";
            $blockStyle="Closed";
        }
        else {
            $style = "block";
            $arrow = "open";
            $blockStyle="";
        }
        $this->toggle=true;

        echo "<!-- blockHeaer -->\n";
        echo '<div id="'.$this->form .'Head" class="blockHeader'.$blockStyle.'">';
        echo "<table class=title>";
        echo "<tr>";
        echo "<td class=toggle width=\"99%\">";
        echo "<a href=\"javascript:showHideModule('" . $this->form . "','$this->theme')\" onMouseOver=\"javascript:showHideModuleMouseOver('" . $this->form . "'); return true; \" onMouseOut=\"javascript:window.status=''; return true;\">";
        echo "<img name=\"" . $this->form . "Toggle\" border=\"0\" src=\"$this->pathImg/$this->theme/module_toggle_" . $arrow . ".gif\" alt=\"\">";
		echo  '&nbsp;'.$title;
		echo "</a>";
		echo '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo '<td class=heading_line_icons><nobr>';
		// ... starting paletteIcon
    }

    //================================================================
    // headingToggle_close() {
	//================================================================
	/*
		NOTE:
		- this function is called when an icon-palette is closed
		- it is ALSO CALLED for headingForm (no toggles but icons)
		- to distinguish between toggleBlocks and normal blocks $this->toggle is set in headingToggle();
		- this is a hack and bad style
	*/
    function headingToggle_close() {

     	//--- toggle the content-block? ---
		if ($this->toggle && $_COOKIE[$this->form] == 'c') {
            $style = 'none';
            $arrow = 'closed';
        } else {
            $style = 'block';
            $arrow = 'open';
        }

        echo "</nobr></td>";
	    echo "</tr>";
		echo "</table>";
		echo "</div>\n";
		echo "<!-- formBody -->";
	    echo '<div name="'.$this->form.'" id="'. $this->form . '" style="display:'. $style.'" class=formBody>';
    }

    /**
     * Print error heading
     *
     * @param string $title Text printed in heading
     * @access public
     */
    function headingError($title) {
        echo "<h1 class=\"headingError\">" . $title . "</h1>\n";
    }

    /**
     * Print error message in table
     *
     * @param string $content Text printed in content error table
     * @access public
     */
    function contentError($content) {
        echo "<table class=\"error\"><tr><td>" . $content . "</td></tr></table>\n";
    }


    function returnBorne($current) {
        global ${'borne'.$current};
        if (${'borne'.$current} == "") {
            $borneValue = "0";
        } else {
            $borneValue = ${'borne'.$current};
        }
        return $borneValue;
    }

    /**
     * Print page-per-page in bottom of list block
     *
     * @param string $current Borne number for concerned block
     * @param string $total Total bornes number
     * @param string $showall Link to page which display all records, with parameters
     * @param string $parameters Optional parameters to transmit between pages
     * @access public
     */
    function bornesFooter($current, $total, $showall, $parameters) {
        global $strings;
        if ($this->rowsLimit < $this->recordsTotal) {
            echo "<table cellspacing=\"0\" width=\"100%\" border=\"0\" cellpadding=\"0\"><tr><td nowrap class=\"footerCell\">&#160;&#160;&#160;&#160;";

            $nbpages = ceil($this->recordsTotal / $this->rowsLimit);
            $j = "0";
            for($i = 1;$i <= $nbpages;$i ++) {
                if ($this->borne == $j) {
                    echo "<b>$i</b>&#160;";
                } else {
                    echo "<a href=\"$PHP_SELF?";
                    for ($k = 1;$k <= $total;$k++) {
                        global ${'borne'.$k};
                        if ($k != $current) {
                            echo "&amp;borne$k=" . ${'borne'.$k};
                        } else if ($k == $current) {
                            echo "&amp;borne$k=$j";
                        }
                    }
                    echo "&amp;$parameters#" . $this->form . "Anchor\">$i</a>&#160;";
                }
                $j = $j + $this->rowsLimit;
            }
            echo "</td><td nowrap align=\"right\" class=\"footerCell\">";
            if ($showall != "") {
                echo "<a href=\"$showall\">" . $strings["show_all"] . "</a>";
            }
            echo "&#160;&#160;&#160;&#160;&#160;</td></tr><tr><td height=\"5\" colspan=\"2\"><img width=\"1\" height=\"5\" border=\"0\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\"></td></tr></table>";
        }
    }

    //==== Print Message table (obsolete!) =====================
    function messageBox($msgLabel) {
        echo "<div class=\"message\">".$msgLabel."</div>";
    }

    /**
     * Open icons table
     *
     * @see block::closePaletteIcon()
     * @see block::paletteIcon()
     * @see block::paletteScript()
     * @access public
     */
    function openPaletteIcon() {
		#echo "<table class=\"icons\"><tr><td align=left width=\"1%\"><img height=\"26\" width=\"5\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\"></td><td class=\"commandDesc\" align=\"left\" width=\"99%\"><div class=commandDesc id=\"" . $this->form . "tt\" class=\"rel\"><div id=\"" . $this->form . "tti\" class=\"abs\"><img height=\"1\" width=\"350\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\"></div></div></td>\n";
        echo '<table class="icons" align=right>';
        echo '<tr>';
		#echo "<td align=left width=\"1%\">";
		#echo '<img height="26" width="5" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\">';
		#echo '</td>';
        #echo "<td class=\"commandDesc\" align=\"left\" width=\"99%\">";
        echo "<td class=\"commandDesc\" align=\"left\">";
        echo "<div style=\"white-space:nowrap;\" id=\"" . $this->form . "tt\" >&nbsp;&nbsp;";
        echo "<div id=\"" . $this->form . "tti\">";
        echo "<img height=\"1\" width=\"100%\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\">";
        echo "</div>";
        echo "</div>";
        echo "</td><td><nobr>";
        //... starting

	}

    //==== Close icons table ====================================
    // NOTE: calling headingToggle_close is a hack
    function closePaletteIcon()  {
     	echo "</nobr></td>";
	    echo "</tr></table>";

		$this->headingToggle_close();
    }


    /**
     * Open icons script
     *
     * @see block::openPaletteScript()
     * @access public
     */
    function openPaletteScript() {
        echo "<script type=\"text/JavaScript\">
<!--
document." . $this->form . "Form.buttons = new Array();\n";
    }

    /**
     * Close icons script
     *
     * @param integer $compt Total records
     * @param array $values First row
     * @see block::closePaletteScript()
     * @access public
     */
    function closePaletteScript($compt, $values) {
        echo "MM_updateButtons(document." . $this->form . "Form, 0);document." . $this->form . "Form.checkboxes = new Array();";
        for ($i = 0;$i < $compt;$i++) {
            echo "document." . $this->form . "Form.checkboxes[document." . $this->form . "Form.checkboxes.length] = new MMCheckbox('$values[$i]',document." . $this->form . "Form,'" . $this->form . "cb$values[$i]');";
        }
        echo "document." . $this->form . "Form.tt = '" . $this->form . "tt';
// -->
</script>\n\n";
    }

    /**
     * Define sorting to apply on a list block
     *
     * @param string $sortingRef Row reference in sorting table
     * @param string $sortingValue Row value in sorting table
     * @param string $sortingDefault Default sorting value
     * @param array $sortingFields Array with sorted fields on each column
     * @access public
     */
    function sorting($sortingRef, $sortingValue, $sortingDefault, $sortingFields)
    {
        if ($sortingRef != "") {
            $this->sortingRef = $sortingRef;
        }

        if ($sortingValue != "") {
            $this->sortingValue = $sortingValue;
        }

        if ($sortingDefault != "") {
            $this->sortingDefault = $sortingDefault;
        }

        if ($sortingFields != "") {
            $this->sortingFields = $sortingFields;
        }

        global $sortingOrders, $sortingFields, $sortingArrows, $sortingStyles, $explode;

        if (isset($this->sortingValue) != "") {
            $explode = explode(" ", $this->sortingValue);
        } else {
            $this->sortingValue = $this->sortingDefault;
            $explode = explode(" ", $this->sortingValue);
        }

        for ($i = 0;$i < count($sortingFields);$i++) {
            if ($sortingFields[$i] == $explode[0] && $explode[1] == "DESC") {
                $sortingOrders[$i] = "ASC";
                $sortingArrows[$i] = "&#160;<img border=\"0\" src=\"$this->pathImg/$this->theme/icon_sort_za.gif\" alt=\"\" width=\"11\" height=\"11\">";
                $sortingStyles[$i] = "active";
            } else if ($sortingFields[$i] == $explode[0] && $explode[1] == "ASC") {
                $sortingOrders[$i] = "DESC";
                $sortingArrows[$i] = "&#160;<img border=\"0\" src=\"$this->pathImg/$this->theme/icon_sort_az.gif\" alt=\"\" width=\"11\" height=\"11\">";
                $sortingStyles[$i] = "active";
            } else {
                $sortingOrders[$i] = "ASC";
                $sortingArrows[$i] = "";
                $sortingStyles[$i] = "";
            }
        }

        if ($sortingOrders != "") {
            $this->sortingOrders = $sortingOrders;
        }

        if ($sortingArrows != "") {
            $this->sortingArrows = $sortingArrows;
        }

        if ($sortingStyles != "") {
            $this->sortingStyles = $sortingStyles;
        }
    }

    /**
     * Open a standard form
     *
     * @param string $address Action form value
     * @see block::closeFormResults()
     * @see block::closeForm()
     * @access public
     */
    function openForm($address)  {
        echo "<a name=\"" . $this->form . "Anchor\"></a>";
        echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"$address\" name=\"" . $this->form . "Form\" enctype=\"application/x-www-form-urlencoded\">\n\n";
    }

    /**
     * Close a form used with a list block
     *
     * @access public
     */
    function closeFormResults(){
        echo "<input name=\"sor_cible\" type=\"HIDDEN\" value=\"$this->sortingRef\"><input name=\"sor_champs\" type=\"HIDDEN\" value=\"\"><input name=\"sor_ordre\" type=\"HIDDEN\" value=\"\">";
        echo "</form>";
    }

    /**
     * Define column labels in a list block
     *
     * @param array $labels Array with labels strings
     * @param boolean $published Show/hide a published column
     * @param boolean $sorting Disable sorting
     * @param array $sortingOff Array with label number (from $labels) and order (ASC/DESC)
     * @access public
     */
    function labels($labels, $published, $sorting = "true", $sortingOff = "")
    {
        global $labels, $sortingOrders, $sortingFields, $sortingArrows, $sortingStyles, $strings, $sitePublish;

        $sortingFields = $this->sortingFields;
        $sortingOrders = $this->sortingOrders;
        $sortingArrows = $this->sortingArrows;
        $sortingStyles = $this->sortingStyles;

        if ($sitePublish == "false" && $published == "true") {
            $comptLabels = count($labels) - 1;
        } else {
            $comptLabels = count($labels);
        }

        for ($i = 0;$i < $comptLabels;$i++) {
            if ($sorting == "true") {
                echo "<th nowrap class=\"$sortingStyles[$i]\">";
                echo "<a href=\"javascript:document." . $this->form . "Form.sor_cible.value='$this->sortingRef';document." . $this->form . "Form.sor_champs.value='$sortingFields[$i]';document." . $this->form . "Form.sor_ordre.value='$sortingOrders[$i]';document." . $this->form . "Form.submit();\" onMouseOver=\"javascript:window.status='" . $strings["sort_by"] . " " . addslashes($labels[$i]) . "'; return true;\" onMouseOut=\"javascript:window.status=''; return true\">";
                echo trim($labels[$i]);
                echo $sortingArrows[$i];
                echo "</a></th>";
            }
            else {
                if ($sortingOff[1] == "ASC") {
                    $sortingArrow = "&#160;<img border=\"0\" src=\"$this->pathImg/$this->theme/icon_sort_az.gif\" alt=\"\" width=\"11\" height=\"11\">";
                } else if ($sortingOff[1] == "DESC") {
                    $sortingArrow = "&#160;<img border=\"0\" src=\"$this->pathImg/$this->theme/icon_sort_za.gif\" alt=\"\" width=\"11\" height=\"11\">";
                }
                if ($i == $sortingOff[0]) {
                    echo "<th nowrap class=\"active\">" . $labels[$i] . "$sortingArrow";
                } else {
                    echo "<th nowrap>" . $labels[$i];
                }
            }
        }

        echo "</tr>\n";
    }

    /**
     * Open results list
     *
     * @param boolean $checkbox Disable checkbox display
     * @access public
     */
    function openResults($checkbox = "true") {
 		echo "<table class=\"listing\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
        echo "<tr>\n";
        if ($checkbox == "true") {
            echo "<th width=\"1%\" align=\"center\">";
            echo "<a href=\"javascript:MM_toggleSelectedItems(document." . $this->form . "Form,'$this->theme')\">";
            echo "<img height=\"16\" width=\"16\" border=\"0\" src=\"$this->pathImg/$this->theme/checkbox_off_16.gif\" alt=\"\" >";
            echo "</a></th>\n";
        } else {
            echo "<th width=\"1%\" align=\"center\">";
            echo "<img height=\"13\" width=\"13\" border=\"0\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\" vspace=\"3\">";
            echo "</th>\n";
        }
    }

    function closeResults()  {
        echo "</table>\n";
    }

    function noresults() {
        global $strings;
		#echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\"><tr><td colspan=\"4\">" . $strings["no_items"] . "</td></tr></table><hr />";
		echo "<div class=blockContent><div class=blockForm>";
		echo $strings["no_items"];
		echo "</div></div>";

    }

    /**
     * Display an icon (html)
     *
     * @param integer $num Icon number
     * @param string $type Icon name (used in graphic file name)
     * @param string $text Text used in info-tip
     * @see block::openPaletteIcon()
     * @access public
     */
    function paletteIcon($num, $type, $text)  {
        echo "<a href=\"javascript:var b = MM_getButtonWithName(document." . $this->form . "Form, '" . $this->form . "$num'); if (b) b.click();\" onMouseOver=\"var over = MM_getButtonWithName(document." . $this->form . "Form, '" . $this->form . "$num'); if (over) over.over(); return true; \" onMouseOut=\"var out = MM_getButtonWithName(document." . $this->form . "Form, '" . $this->form . "$num'); if (out) out.out(); return true; \">";
        echo "<img width=\"$this->iconWidth\" height=\"$this->iconHeight\" border=\"0\" name=\"" . $this->form . "$num\" src=\"$this->pathImg/$this->theme/btn_" . $type . "_norm.gif\" alt=\"$text\">";
        echo "</a>";

        #echo "<td class=\"commandBtn\">";
        #echo "<a href=\"javascript:var b = MM_getButtonWithName(document." . $this->form . "Form, '" . $this->form . "$num'); if (b) b.click();\" onMouseOver=\"var over = MM_getButtonWithName(document." . $this->form . "Form, '" . $this->form . "$num'); if (over) over.over(); return true; \" onMouseOut=\"var out = MM_getButtonWithName(document." . $this->form . "Form, '" . $this->form . "$num'); if (out) out.out(); return true; \">";
        #echo "<img width=\"$this->iconWidth\" height=\"$this->iconHeight\" border=\"0\" name=\"" . $this->form . "$num\" src=\"$this->pathImg/$this->theme/btn_" . $type . "_norm.gif\" alt=\"$text\">";
        #echo "</a>";
        #echo "</td>";
    }

    /**
     * Display an icon (JavaScript)
     *
     * @param integer $num Icon number
     * @param string $type Icon name (used in graphic file name)
     * @param string $options JavaScript options enableOnNoSelection, enableOnSingleSelection, enableOnMultipleSelection
     * @param string $text Text used in roll-over layer
     * @see block::openPaletteIcon()
     * @access public
     */
	 function paletteScript($num, $type, $link, $options, $text) {
	 	echo "document." . $this->form . "Form.buttons[document." . $this->form . "Form.buttons.length] = new MMCommandButton('" . $this->form . "$num',document." . $this->form . "Form,'" . $link . "','$this->pathImg/$this->theme/btn_" . $type . "_norm.gif','$this->pathImg/$this->theme/btn_" . $type . "_over.gif','$this->pathImg/$this->theme/btn_" . $type . "_down.gif','$this->pathImg/$this->theme/btn_" . $type . "_dim.gif',$options,'','" . "".$text."" . "',false,'');\n";

       	#echo "document." . $this->form . "Form.buttons[document." . $this->form . "Form.buttons.length] = ";
        #echo "new MMCommandButton('";
        #echo $this->form . "$num', ";
        #echo "document." . $this->form . "Form,'";
        #echo $link ."','$this->pathImg/$this->theme/btn_" . $type . "_norm.gif',";
        #echo "'$this->pathImg/$this->theme/btn_" . $type . "_over.gif',";
        #echo "'$this->pathImg/$this->theme/btn_" . $type . "_down.gif',";
        #echo "'$this->pathImg/$this->theme/btn_" . $type . "_dim.gif',";
        #echo "$options,'','" . "<nobr>".$text."</nobr>" . "',false,'');\n";

    }

    /**
     * Start a table to display sheet/form
     *
     * @see block::contentRow()
     * @access public
     */
    function openContent()   {
        //echo "<table class=\"content\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<div class=content><table cellspacing=\"0\" cellpadding=\"0\">";

    }

    /**
     * Display a table line in sheet/form
     *
     * @param string $left Text in left cell
     * @param string $right Text in right cell
     * @param boolean $altern Option to altern background color
     * @access public
     */
    function contentRow($left, $right, $altern = "false")
    {
        if ($this->class == "") {
            $this->class = "odd";
        }
        if ($left != "") {
            echo "<tr class=\"$this->class\"><td valign=\"top\" class=\"leftvalue\">" . $left . " :</td><td>" . $right . "&nbsp;</td></tr>\n";
        }
        else {
            echo "<tr class=\"$this->class\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $right . "&nbsp;</td></tr>\n";
        }
        if ($this->class == "odd" && $altern == "true") {
            $this->class = "even";
        }
        else if ($this->class == "even" && $altern == "true") {
            $this->class = "odd";
        }
    }

    function openRow($ref=-1) {

     	if($ref == -1) {
	        echo '<tr class="'.$this->class.'"';
	        echo " onmouseover=\"this.style.backgroundColor='". $this->highlightOn  ."'\"";
	        echo " onmouseout=\"this.style.backgroundColor='" . $this->highlightOff ."'\"";
	        echo ">";
	        if ($this->class == "odd") {
	            $this->class = "even";
	            $this->highlightOff = $this->evenColor;
	            $change = "false";
	        }
	        else if ($this->class == "even" && $change != "false") {
	            $this->class = "odd";
	            $this->highlightOff = $this->oddColor;
	        }
		}
		else {
		 	$change = "true";
	        echo '<tr class="'.$this->class.'"';
	        echo " onmouseover=\"this.style.backgroundColor='". $this->highlightOn  ."'\" ";
	        echo " onmouseout=\"this.style.backgroundColor='" . $this->highlightOff ."'\" ";
	        echo " onclick=\"";
			echo "MM_toggleItem(document.";
	        echo $this->form;
	        echo "Form, '" . $ref . "', '";
	        echo $this->form."cb" . $ref;
	        echo "','$this->theme')";
	        echo "\"";

	        echo ">\n";
	        if ($this->class == "odd") {
	            $this->class = "even";
	            $this->highlightOff = $this->evenColor;
	            $change = "false";
	        }
	        else if ($this->class == "even" && $change != "false") {
	            $this->class = "odd";
	            $this->highlightOff = $this->oddColor;
	        }
		}
	}

    function checkboxRow($ref, $checkbox = "true") {
        if ($checkbox == "true") {
            echo "<td align=\"center\">";
            echo "<a href=\"javascript:MM_toggleItem(document." . $this->form . "Form, '" . $ref . "', '" . $this->form . "cb" . $ref . "','$this->theme')\">";
            #echo "<img name=\"" . $this->form . "cb" . $ref . "\" border=\"0\" src=\"$this->pathImg/$this->theme/checkbox_off_16.gif\" alt=\"\" vspace=\"3\">";
			echo "<img ";
	        echo " onclick=\"";
			echo "MM_toggleItem(document.";
	        echo $this->form;
	        echo "Form, '" . $ref . "', '";
	        echo $this->form."cb" . $ref;
	        echo "','$this->theme')";
	        echo "\"";
			echo " name=\"" . $this->form . "cb" . $ref . "\" border=\"0\" src=\"$this->pathImg/$this->theme/checkbox_off_16.gif\" alt=\"\" vspace=\"3\">";
            echo "</a>";
            echo "</td>";
        }
        else {
            echo "<td><img height=\"13\" width=\"13\" border=\"0\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\" vspace=\"3\"></td>";
        }


	 /*    if ($checkbox == "true") {
            echo "<td align=\"center\">";
            echo "<a href=\"javascript:MM_toggleItem(document.";
            echo $this->form;
            echo "Form, '" . $ref . "', '";
            echo $this->form."cb" . $ref;
            echo "','$this->theme')\">";
            echo "<img name=\"";
            echo $this->form . "cb" . $ref;
            echo "\" border=\"0\" src=\"$this->pathImg/$this->theme/checkbox_off_16.gif\" alt=\"\" vspace=\"3\">";
            echo "</a></td>";
        }
        else {
            echo "<td><img height=\"13\" width=\"13\" border=\"0\" src=\"$this->pathImg/$this->theme/spacer.gif\" alt=\"\" vspace=\"3\"></td>";
        }*/
    }

    function cellRow($content = null, $width = null, $nowrap = null) {
        if ($nowrap == true) {
            $nowrap = ' nowrap';
        }

        if ($width) {
            echo '<td width="' . $width . '%"' . $nowrap . '>' . $content . '</td>';
        }
        else
        {
            echo '<td' . $nowrap . '>' . $content . '</td>';
        }
    }

    function closeRow() {
        echo "\n</tr>\n";
    }

    function contentTitle($title) {
        echo "<tr><th colspan=\"2\">" . $title . "</th></tr>";
    }

    function closeContent() {
        echo "</table></div>";
    }

    function closeForm() {
        echo "</form>\n";
    }



	//======================================================================
	// sections (top navigation)
	//======================================================================
    function openNavigation()  {
        echo "<div id=\"navigation\">";
    }

    function itemNavigation($url, $label) {
        echo('<a href="'.$url.'">&nbsp;&nbsp;'.$label .'&nbsp;&nbsp;</a>');
    }

    function itemNavigationCurrent($url, $label) {
        echo('<a class=current href="'.$url.'">&nbsp;&nbsp;'.$label .'&nbsp;&nbsp;</a>');
    }


    function closeNavigation() {
        echo "</div>\n\n";
    }

    	//======================================================================
	// breadcrumbs
	//======================================================================
    function openBreadcrumbs()  {
        echo "<div id=\"breadcrumbs\">";
    }

    function itemBreadcrumbs($content) {
        echo '<img src="../themes/'. THEME. '/brdcmb_carrat.gif" alt="" align="absmiddle"> '.$content;
    }

    function closeBreadcrumbs()     {
        echo "</div>\n\n";
    }




	//======================================================================
	// account
	//======================================================================
    function openAccount()   {
        echo "<p id=\"account\">";
    }

    function itemAccount($content) {
        if ($this->accountTotal == "") {
            $this->accountTotal = "0";
        }
        $this->account[$this->accountTotal] = $content;
        $this->accountTotal = $this->accountTotal + 1;
    }

    function closeaccount() {
        $items = $this->accountTotal;
        for ($i = 0;$i < $items;$i++) {
            echo $this->account[$i];
            if ($items-1 != $i) {
                echo " ";
            }
        }
        echo "</p>\n\n";
    }
}

//--- define standard instance to simulate static class in php4 ---
$template=new block();

//======================================================================
// links
//======================================================================
// todo (added by pixtur 2004-11-11):
// - throw exception if unknown link-type
// - in the long term:
//	- add different icon-types
//	- LINK_INSIDE as default
//  - replace all string-usage with properly defined constances in library.php
//  - this function makes no sense. Splitting into different functions would make the code more readable
function buildLink($url, $label, $type=LINK_INSIDE) {

	//---link inside as default ---
	switch($type) {
	case LINK_INSIDE:	//formerly 'in'
		return('<a href="' . $url . '">' . $label . '</a>');

    case LINK_STRIKE:	//formerly 'in_strike'
        return('<a href="' . $url . '" class="instrike">' . $label . '</a>');

    case LINK_BLANK:	//'in_blank'
		return('<a href="' . $url . '" target="_blank">' . $label . '</a>');

    case LINK_OUT:			//'out'
        return('<a href="' . $url . '" target="_blank">' . $label . '</a>');

    case LINK_ICON:		//'icone'
        return('<a href="' . $url . '"><img src="../interface/icones/' . $label . '" border="0" alt=""></a>');

    case LINK_POWERED:		//'powered'
        return('Powered by <a href="' . $url . '" target="_blank">' . $label . '</a>');

    case LINK_MAIL:		//'mail'
		$buf='<img src="../themes/deepblue/gfx_icons/link_mail.gif">';
		$buf.='<a href="mailto:' . $url . '">' . $label . '</a>';

        return($buf);

	//??? is there a way to throw an exception
    default:
		return ('UNDEFINED LINK-TYPE: <a href="'. $url .'">'. $label .'</a>');
    }
}



?>