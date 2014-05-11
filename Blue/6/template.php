<?php
function stdhead($title = "", $msgalert = true, $stdhead = false)
{
    global $CURUSER, $INSTALLER09, $lang, $free, $_NO_COMPRESS, $query_stat, $querytime, $mc1, $BLOCKS, $CURBLOCK, $mood;
    if (!$INSTALLER09['site_online']) die("Site is down for maintenance, please check back again later... thanks<br />");
    if ($title == "") $title = $INSTALLER09['site_name'] . (isset($_GET['tbv']) ? " (" . TBVERSION . ")" : '');
    else $title = $INSTALLER09['site_name'] . (isset($_GET['tbv']) ? " (" . TBVERSION . ")" : '') . " :: " . htmlsafechars($title);
    if ($CURUSER) {
        $INSTALLER09['stylesheet'] = isset($CURUSER['stylesheet']) ? "{$CURUSER['stylesheet']}.css" : $INSTALLER09['stylesheet'];
        $INSTALLER09['categorie_icon'] = isset($CURUSER['categorie_icon']) ? "{$CURUSER['categorie_icon']}" : $INSTALLER09['categorie_icon'];
        $INSTALLER09['language'] = isset($CURUSER['language']) ? "{$CURUSER['language']}" : $INSTALLER09['language'];
    }
    /** ZZZZZZZZZZZZZZZZZZZZZZZZZZip it! */
     if (!isset($_NO_COMPRESS))
     if (!ob_start('ob_gzhandler'))
     ob_start();
    //== Include js files needed only for the page being used by pdq
    $js_incl = '';
    $js_incl.= '<!-- javascript goes here or in footer -->';
    if (!empty($stdhead['js'])) {
        foreach ($stdhead['js'] as $JS) $js_incl.= "<script type='text/javascript' src='{$INSTALLER09['baseurl']}/scripts/" . $JS . ".js'></script>";
    }
    //== Include css files needed only for the page being used by pdq
    $css_incl = '';
    $css_incl.= '<!-- css goes here -->';
    $salty = md5("Th15T3xtis5add3dto66uddy6he@water..." . $CURUSER['username'] . "");
    if (!empty($stdhead['css'])) {
        foreach ($stdhead['css'] as $CSS) $css_incl.= "<link type='text/css' rel='stylesheet' href='{$INSTALLER09['baseurl']}/templates/{$CURUSER['stylesheet']}/css/" . $CSS . ".css' />";
    }
    if (isset($INSTALLER09['xhtml_strict'])) { //== Use strict mime type/doctype
        //== Only if browser/user agent supports xhtml
        if (isset($_SERVER['HTTP_ACCEPT']) && stristr($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') && ($INSTALLER09['xhtml_strict'] === 1 || $INSTALLER09['xhtml_strict'] == $CURUSER['username'])) {
            header('Content-type:application/xhtml+xml; charset=' . charset());
            $doctype = '<?xml version="1.0" encoding="' . charset() . '"?>' . '<!DOCTYPE html PUBLIC  "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
        }
    }
    if (!isset($doctype)) {
        header('Content-type:text/html; charset=' . charset());
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"' . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . '<html xmlns="http://www.w3.org/1999/xhtml">';
    }

    $htmlout = $doctype . "<head>
        <meta http-equiv='Content-Language' content='en-us' />
    <title>{$title}</title>
	  <link rel='shortcut icon' href='favicon.ico' />
	  <link rel='stylesheet' href='templates/6/6.css' type='text/css' />
	 <link rel='stylesheet' type='text/css' href='bbcode/markitup/skins/markitup/style.css' />
        <link rel='stylesheet' type='text/css' href='bbcode/markitup/sets/bbcode/style.css' />
        <script type='text/javascript' src='./scripts/jquery.status.js'></script>
        <script type='text/javascript' src='./scripts/jquery.js'></script>
    <script type='text/javascript' src='./scripts/jquery.status.js'></script>
    <script type='text/javascript'>
    /*<![CDATA[*/
    function themes() {
    window.open('take_theme.php','My themes','height=150,width=200,resizable=no,scrollbars=no,toolbar=no,menubar=no');
    }
    /*]]>*/
    </script>
    <script type='text/javascript'>
    /*<![CDATA[*/
    function radio() {
    window.open('radio_popup.php','My Radio','height=700,width=800,resizable=no,scrollbars=no,toolbar=no,menubar=no');
    }
    /*]]>*/
    </script>
	  <link rel='alternate' type='application/rss+xml' title='Latest Torrents' href='./rss.php?passkey={$CURUSER['passkey']}' />
    <link rel='stylesheet' type='text/css' href='bbcode/markitup/skins/markitup/style.css' />
	  <link rel='stylesheet' type='text/css' href='bbcode/markitup/sets/bbcode/style.css' />
    {$js_incl}{$css_incl}
	  </head> 
    <body>
    <div id='arounder'>
    <div id='top_head'>
    <div id='logo'></div></div>
    <div id='top_heada'>";
    $htmlout .= StatusBar();
    $htmlout .="</div><div id='menu'>";
    if ($CURUSER) {
    $htmlout .= "<ul>";
    if( $CURUSER['class'] > UC_STAFF ){
    $htmlout .= "<li><a href='staffpanel.php'>ADMIN</a></li>";
    }
    $htmlout .= "<li><a href='staff.php'>SUPPORT</a></li>
    <li><a href='faq.php'>FAQ</a></li>
    <li><a href='rules.php'>RULES</a></li>";
    if( $CURUSER['class'] <= UC_VIP ){
    $htmlout .= "<li><a href='uploadapp.php'>UPLOAD APP</a></li>";
    }
    if( $CURUSER['class'] >= UC_UPLOADER )
 	  {
    $htmlout .= "<li><a href='upload.php'>UPLOAD</a></li>";
    }   
    $htmlout .= "
    <li><a href='browse.php'>BROWSE</a></li>
    <li><a href='usercp.php?action=default'>PROFILE</a></li>
    <li><a href='index.php'>FORUMS</a></li>
    <li><a href='news.php'>NEWS</a></li></ul>";
    }
    $htmlout .= "</div>
    <div class='shadow'></div>
    <div id='site-txt'>
    <table class='mainouter' width='100%' border='0' cellspacing='0' cellpadding='38'>
    <tr><td align='center'>
    <div id='base_globelmessage'>
    <div id='gm_taps'>
    <ul class='gm_taps'>
    <li><b>Current Site Alerts:</b></li>";
    //== Stdhead alerts
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_REPORTS && $BLOCKS['global_staff_report_on']){
	  require(BLOCK_DIR.'global/report.php');
	  }

	  if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_UPLOADAPP && $BLOCKS['global_staff_uploadapp_on']){
	  require(BLOCK_DIR.'global/uploadapp.php');
	  }

    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_HAPPYHOUR && $BLOCKS['global_happyhour_on']){
    require(BLOCK_DIR.'global/happyhour.php');
    }

	  if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_STAFF_MESSAGE && $BLOCKS['global_staff_warn_on']){
	  require(BLOCK_DIR.'global/staffmessages.php');
	  }
	   
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_NEWPM && $BLOCKS['global_message_on']){
    require(BLOCK_DIR.'global/message.php');
    }

	  if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_DEMOTION && $BLOCKS['global_demotion_on']){
	  require(BLOCK_DIR.'global/demotion.php');
	  } 

    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_FREELEECH && $BLOCKS['global_freeleech_on']){
    require(BLOCK_DIR.'global/freeleech.php');
    }

    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_CRAZYHOUR && $BLOCKS['global_crazyhour_on']){
    require(BLOCK_DIR.'global/crazyhour.php');
    }
      
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_BUG_MESSAGE && $BLOCKS['global_bug_message_on']){
	  require(BLOCK_DIR.'global/bugmessages.php');
	  }
    
    $htmlout .="</ul></div></div>";
    return $htmlout;
    } // stdhead

function stdfoot($stdfoot = false) {
global $CURUSER, $INSTALLER09, $start, $query_stat, $mc1, $querytime;
        $debug   = (SQL_DEBUG && in_array($CURUSER['id'], $INSTALLER09['allowed_staff']['id']) ? 1 : 0);
        $cachetime   = ($mc1->Time/1000);
        $seconds     = microtime(true) - $start;
        $r_seconds   = round($seconds, 5); 
        $phptime     = $seconds - $querytime - $cachetime;
        $queries = count($query_stat); // sql query count by pdq
        $percentphp  = number_format(($phptime / $seconds) * 100, 2);
        $percentsql  = number_format(($querytime / $seconds) * 100, 2);
        $percentmc   = number_format(($cachetime / $seconds) * 100, 2);

    if (($MemStats = $mc1->get_value('mc_hits')) === false) {
    $MemStats = $mc1->getStats();
    $MemStats['Hits'] = (($MemStats['get_hits']/$MemStats['cmd_get'] < 0.7) ? '' : number_format(($MemStats['get_hits']/$MemStats['cmd_get'])*100, 3));
    $mc1->cache_value('mc_hits', $MemStats, 10);
    }
  
// load averages - pdq
    if ($debug) {
     $uptime = $mc1->get_value('uptime');
        if ($uptime === false) {
     $uptime = `uptime`;
     $mc1->cache_value('uptime', $uptime, 25);
        }
        preg_match('/load average: (.*)$/i', $uptime, $load);
    }

    $header = ''; 
    $header .= number_format($cachetime, 5).'s';
    $header = round($percentmc, 2).'&#37; Memcached: '.number_format($cachetime, 5).'s Hits: '.$MemStats['Hits'].'% Misses: '.(100 - $MemStats['Hits']).'% Items: '.number_format($MemStats['curr_items']);
 $htmlfoot = ''; 
    //== query stats 
    //== include js files needed only for the page being used by pdq 
    $htmlfoot .= '<!-- javascript goes here -->';
    if (!empty($stdfoot['js'])) {
    foreach ($stdfoot['js'] as $JS)
    $htmlfoot .= '<script type="text/javascript" src="'.$INSTALLER09['baseurl'].'/scripts/'.$JS.'.js"></script>';
    }
    $querytime = 0;
    if ($CURUSER && $query_stat && $debug) {
    $htmlfoot .= "<br />
	  <div align='center' class='headline'>Querys</div>
	  <div class='headbody'>
	  <table width='100%' align='center' cellspacing='5' cellpadding='5' border='0'>
		<tr>
		<td class='colhead' width='5%'  align='center'>ID</td>
		<td class='colhead' width='10%' align='center'>Query Time</td>
		<td class='colhead' width='85%' align='left'>Query String</td>
		</tr>";
    foreach ($query_stat as $key => $value) {
    $querytime += $value['seconds']; // query execution time
    $htmlfoot  .= "<tr>
		<td align='center'>".($key + 1)."</td>
		<td align='center'><b>". ($value['seconds'] > 0.01 ?
		"<font color='red' title='You should optimize this query.'>".
    $value['seconds']."</font>" : "<font color='green' title='Query good.'>".
	  $value['seconds']."</font>")."</b></td>
		<td align='left'>".htmlspecialchars($value['query'])."<br /></td>
		</tr>";	   		   
     }
    $htmlfoot .="</table></div>";
    }

    $htmlfoot .="</td></tr></table>";

 if ($CURUSER) 
    {
    
	$htmlfoot .= "
       </div> <!-- Ends Content holder -->
       <div id='main-footer'><div id='footer-a'>
       " . $INSTALLER09['site_name'] . " page was generated in " . $r_seconds . " seconds.&nbsp;" . "
       Server was hit  " . $queries . " time" . ($queries != 1 ? "'s" : "") . " " . ($queries > 4 ? "&nbsp;&amp;&nbsp;&nbsp;" . round($queries / 2) . " hits were handled. " : ".") . "
       " . ($debug ? "<br /><b>" . $header . "</b><br /><b>Uptime:</b> " . $uptime . "</div>" : "</div>") . "
      <div id='footer-b'>
 " . ($debug ? "<a title='System View' rel='external' href='/staffpanel.php?tool=system_view'>System View</a> | " . "<a rel='external' title='APC' href='/staffpanel.php?tool=apc'>APC Stats</a>  " . "<a rel='external' title='Memcache' href='/staffpanel.php?tool=memcache'>Memcache</a>&nbsp;|&nbsp;<a title='Flush My Cache' href='" . $is_id . "flush#flush'>Flush Cache</a>" : "") . "";
    }
    $htmlfoot .="</table></div>
    </div> <!-- Ends Footer -->
    </body></html>\n";
    return $htmlfoot;
    }
function stdmsg($heading, $text)
{
    $htmlout = "<table class='main' width='750' border='0' cellpadding='0' cellspacing='0'>
    <tr><td class='embedded'>\n";
    if ($heading)
    $htmlout .= "<h2>$heading</h2>\n";
    $htmlout .= "<table width='100%' border='1' cellspacing='0' cellpadding='10'><tr><td class='text'>\n";
    $htmlout .= "{$text}</td></tr></table></td></tr></table>\n";
    return $htmlout;
}


function hey()
    {
        global $CURUSER, $lang;
        $now = date("H", TIME_NOW);
        switch ($now) {
            case ($now >= 7 && $now < 11):
                return "{$lang['gl_stdhey']}";
            case ($now >= 11 && $now < 13):
                return "{$lang['gl_stdhey1']}";
            case ($now >= 13 && $now < 17):
                return "{$lang['gl_stdhey2']}";
            case ($now >= 17 && $now < 19):
                return "{$lang['gl_stdhey3']}";
            case ($now >= 19 && $now < 21):
                return "{$lang['gl_stdhey4']}";
            case ($now >= 23 && $now < 0):
                return "{$lang['gl_stdhey5']}";
            case ($now >= 0 && $now < 7):
                return "{$lang['gl_stdhey6']}";

            default: return "{$lang['gl_stdhey7']}";
        }
    }

function StatusBar() {
	global $CURUSER, $INSTALLER09, $lang, $rep_is_on, $mc1;
	if (!$CURUSER)
		return "<p align='center'>Yeah Yeah!</p>";
	$upped = mksize($CURUSER['uploaded']);
	$downed = mksize($CURUSER['downloaded']);
  //==Memcache unread pms
	$PMCount=0;
	$unread1 = $mc1->get_value('inbox_new_sb_'.$CURUSER['id']);
  if ($unread1 === false) {
	$res1 = sql_query("SELECT COUNT(id) FROM messages WHERE receiver='".$CURUSER['id']."' AND unread = 'yes' AND location = '1'") or sqlerr(__LINE__,__FILE__);
	list($PMCount) = mysqli_fetch_row($res1); 
  $PMCount= (int)$PMCount;
  $unread1 = $mc1->cache_value('inbox_new_sb_'.$CURUSER['id'], $PMCount, $INSTALLER09['expires']['unread']);
  }
	$inbox = ($unread1 == 1 ? "$unread1&nbsp;{$lang['gl_msg_singular']}" : "$unread1&nbsp;{$lang['gl_msg_plural']}");
  //==Memcache peers
  $MyPeersCache = $mc1->get_value('MyPeers_'.$CURUSER['id']);
if ($MyPeersCache == false) {
    $seed['yes'] = $seed['no'] = 0;
    $seed['conn'] = 3;
    
      $r = sql_query("select count(id) as count, seeder, connectable FROM peers WHERE userid=".$CURUSER['id']." group by seeder") ; 
       while($a = mysqli_fetch_assoc($r)) {
        $key = $a['seeder'] == 'yes' ? 'yes' : 'no'; 
        $seed[$key] = number_format(0+$a['count']);    
        $seed['conn'] = $a['connectable'] == 'no' ? 1 : 2;
    }  
   $mc1->cache_value('MyPeers_'.$CURUSER['id'], $seed, $INSTALLER09['expires']['MyPeers_']);
   unset($r, $a);        
} else {
    $seed = $MyPeersCache;
}
// for display connectable  1 / 2 / 3 
 if (!empty($seed['conn'])) {
       switch ($seed['conn']){ 
       case 1:
         $connectable = "<img src='{$INSTALLER09['pic_base_url']}notcon.png' alt='Not Connectable' title='Not Connectable' />";
       break;
       case 2:
         $connectable = "<img src='{$INSTALLER09['pic_base_url']}yescon.png' alt='Connectable' title='Connectable' />";
       break;
       default :
         $connectable = "N/A";
       }
    }
    else
    $connectable = 'N/A';
  //////////// REP SYSTEM /////////////
     $member_reputation = get_reputation($CURUSER);
 ////////////// REP SYSTEM END //////////
           $usrclass="";
    if ($CURUSER['override_class'] != 255) $usrclass = "&nbsp;<b>(".get_user_class_name($CURUSER['class']).")</b>&nbsp;";
    else
    if ($CURUSER['class'] >= UC_STAFF)
    $usrclass = "&nbsp;<a href='./setclass.php'><b>(".get_user_class_name($CURUSER['class']).")</b></a>&nbsp;";
   $StatusBar = '';
		$StatusBar = "       
       <!-- U-232 Source - Print Statusbar/User Menu -->
       <script type='text/javascript'>
       //<![CDATA[
       function showSlidingDiv(){
       $('#slidingDiv').animate({'height': 'toggle'}, { duration: 1000 });
       }
       //]]>
       </script>  
       <div id='stat-b'>
        <span style='color:#B9BBBD'>
        <img src='templates/12/gfx/icons/email.png' width='14' height='14' alt='' title='Personal Messages' />&nbsp;<a href='./pm_system.php'>$inbox</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;<img src='templates/12/gfx/icons/invite.png' width='14' height='14' alt='' title='Invite a friend' />&nbsp;<a href='./invite.php'>{$CURUSER['invites']}</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;<img src='templates/12/gfx/icons/bonus.png' width='14' height='14' alt='' title='My Bonus' />&nbsp;<a href='./mybonus.php'>{$CURUSER['seedbonus']}</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;<img src='templates/12/gfx/icons/ratio.png' width='14' height='14' alt='' title='Share Ratio' />&nbsp;".member_ratio($CURUSER['uploaded'], $CURUSER['downloaded'])."".
        "&nbsp;&nbsp;|&nbsp;&nbsp;<img src='templates/12/gfx/icons/upload.png' width='14' height='14' alt='' title='Uploaded' />&nbsp;$upped
        &nbsp;&nbsp;|&nbsp;&nbsp;<img src='templates/12/gfx/icons/active.png' width='14' height='14' alt='' title='Active Torrents' />&nbsp;<img alt='{$lang['gl_seed_torrents']}' title='{$lang['gl_seed_torrents']}' src='./templates/12/gfx/up.png' />&nbsp;{$seed['yes']}".
	 "&nbsp;&nbsp;<img alt='{$lang['gl_leech_torrents']}' title='{$lang['gl_leech_torrents']}' src='{$INSTALLER09['pic_base_url']}dl.png' />&nbsp;{$seed['no']}"."
        </span></div>
       <div id='statbar' class='toggle'>
       <div id='stat-a'>
       <div>".hey().",&nbsp;".format_username($CURUSER)."<span class='base_usermenu_arrow'><a href='#' onclick='showSlidingDiv(); return false;'><img src='templates/1/images/usermenu_arrow.png' alt='' /></a></span></div>
       <div id='slidingDiv'>
         <div class='slide_head' ><a href='#' onclick='showsubSlidDiv1(); return false;'>:: Personal Stats</a></div><div id='subslidDiv1'>
         <div class='slide_a'>User Class</div><div class='slide_b'>{$usrclass}</div>
         <div class='slide_c'>Reputation</div><div class='slide_d'>$member_reputation</div>
         <div class='slide_a'>Invites</div><div class='slide_b'><a href='./invite.php'>{$CURUSER['invites']}</a></div>
         <div class='slide_c'>Bonus Points</div><div class='slide_d'><a href='./mybonus.php'>{$CURUSER['seedbonus']}</a></div></div>
         <div class='slide_head' > <a href='#' onclick='showsubSlidDiv2(); return false;'>:: Torrent Stats</a></div><div id='subslidDiv2'>
         <div class='slide_a'>Share Ratio</div><div class='slide_b'>".member_ratio($CURUSER['uploaded'], $CURUSER['downloaded'])."</div>
         <div class='slide_c'>Uploaded</div><div class='slide_d'>$upped</div>
         <div class='slide_a'>Downloaded</div><div class='slide_b'>$downed</div>
         <div class='slide_c'>Uploading Files</div><div class='slide_d'>{$seed['yes']}</div>
         <div class='slide_a'>Downloading Files</div><div class='slide_b'>{$seed['no']}</div>
         <div class='slide_c'>Connectable</div><div class='slide_d'>{$connectable}</div></div>
         <div class='slide_head' > <a href='#' onclick='showsubSlidDiv4(); return false;'>:: Information</a></div><div id='subslidDiv4' >
         <div class='slide_a'>Contact Staff</div><div class='slide_b'><a href='./contactstaff.php'>Send Message</a></div>
         <div class='slide_c'>Change Theme</div><div class='slide_d'><a href='#' onclick='themes();'>Click here</a></div>


         ".(isset($CURUSER) && $CURUSER['class'] < UC_STAFF ? "<div class='slide_c'>Bugs</div><div class='slide_d'><a href='./bugs.php?action=add'>Click here to report it</a></div>":"")."
         ".(isset($CURUSER) && $CURUSER['class'] >= UC_STAFF ? "<div class='slide_c'>Bug Tracker</div><div class='slide_d'><a href='./bugs.php?action=bugs'>Respond</a></div>":"")."
         ".(isset($CURUSER) && $CURUSER['class'] <= UC_VIP ? "<div class='slide_a'>Uploader App</div><div class='slide_b'><a href='./uploadapp.php'>Send Application</a></div>":"")."

         ".(isset($CURUSER) && $CURUSER['got_blocks'] == 'yes' ? "<div class='slide_head'>:: Site Config</div><div class='slide_a'>My Blocks</div><div class='slide_b'><a href='./user_blocks.php'>Click here</a></div>":"")."
         ".(isset($CURUSER) && $CURUSER['got_moods'] == 'yes' ? "<div class='slide_c'>My Unlocks</div><div class='slide_d'><a href='./user_unlocks.php'>Click here</a></div>":"")."
         <div class='slide_a'>Need seeds</div><div class='slide_b'><a href='./needseed.php?needed=seeders'>Click here</a></div></div>
         </div>
       </div>
     </div>";
     return $StatusBar;
}
?>