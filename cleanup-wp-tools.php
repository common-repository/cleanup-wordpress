<?php
	$wpdb =& $GLOBALS['wpdb'];
	
	if (isset($_POST['opti_db'])){
		$sql_o = 'OPTIMIZE TABLE `'.$wpdb->prefix.'posts`, `'.$wpdb->prefix.'comments`, `'.$wpdb->prefix.'links`, `'.$wpdb->prefix.'options`';
		$wpdb->query($sql_o);		
	}
	if (isset($_POST['repair_db'])){
		$sql_o = 'REPAIR TABLE `'.$wpdb->prefix.'posts`, `'.$wpdb->prefix.'comments`, `'.$wpdb->prefix.'links`, `'.$wpdb->prefix.'options`';
		$wpdb->query($sql_o);		
	}
	if (isset($_POST['del_rev_posts'])){
		$sql1 = 'delete t1.* from '.$wpdb->prefix.'posts t1 JOIN '.$wpdb->prefix.'posts t2
				on (t1.post_parent = t2.id and t2.post_type like "post")
				where (t1.post_type like "revision")';
		$wpdb->query($sql1);
		
		$sql_o = 'OPTIMIZE TABLE `'.$wpdb->prefix.'posts`';
		$wpdb->query($sql_o);		
	}
	if (isset($_POST['del_rev_pages'])){
		$sql2 = 'delete t1.* from '.$wpdb->prefix.'posts t1 JOIN '.$wpdb->prefix.'posts t2
				on (t1.post_parent = t2.id and t2.post_type like "page")
				where (t1.post_type like "revision")';
		$wpdb->query($sql2);	
		
		$sql_o = 'OPTIMIZE TABLE `'.$wpdb->prefix.'posts`';
		$wpdb->query($sql_o);		
	}
	
	if (isset($_POST['del_spam'])){
		$SQL3 = 'DELETE FROM '.$wpdb->prefix.'comments WHERE `comment_approved` like "spam"';
		$wpdb->query($SQL3);
		
		$sql_o = 'OPTIMIZE TABLE `'.$wpdb->prefix.'comments`';
		$wpdb->query($sql_o);		
	}
		
	function getSpamNr($wpdb){
		$SQL = 'SELECT count(comment_ID) as nr_spam FROM '.$wpdb->prefix.'comments WHERE `comment_approved` like "spam"';
		$nr_spam = $wpdb->get_var($SQL);	
		if ($nr_spam=='') $nr_spam =0;
		return $nr_spam;
	}
	function getPostRevNr($wpdb){
		$SQL = 'select COUNT(t1.id) as nr_postRev from '.$wpdb->prefix.'posts as t1 JOIN '.$wpdb->prefix.'posts as t2
				on (t1.post_parent = t2.id and t2.post_type like "post")
				where (t1.post_type like "revision")
				group by t1.post_type';
		$nr_postRev = $wpdb->get_var($SQL);	
		if ($nr_postRev=='') $nr_postRev =0;
		return $nr_postRev; 
	}
	
	function getPageRevNr($wpdb){
		$SQL = 'select COUNT(t1.id) as nr_pageRev from '.$wpdb->prefix.'posts as t1 JOIN '.$wpdb->prefix.'posts as t2
				on (t1.post_parent = t2.id and t2.post_type like "page")
				where (t1.post_type like "revision")
				group by t1.post_type';
		$nr_pageRev = $wpdb->get_var($SQL);	
		if ($nr_pageRev=='') $nr_pageRev =0;
		return $nr_pageRev; 
	}
?>
<form method="post" action="">
<table width="500" border="0" cellspacing="0" cellpadding="0" class="widefat fixed" style="margin-top: 5px;">
  <thead>
  <tr>
  	<th colspan="5">
    	<div id="#nisi_header1"><strong style="text-decoration:underline">Cleanup Wordpress</strong> <?PHP echo(PG_VERSION); ?></div>    </th>
  </tr>
  </thead>
  <tr class="alternate">
    <td colspan="5"><strong>Delete revisions for</strong></td>
    </tr>
  <tr>
    <td><ul>
      <li> posts (<?PHP echo(getPostRevNr($wpdb)); ?>)</li>
    </ul></td>
    <td width="150"><label>
      <input type="submit" name="del_rev_posts" id="del_rev_posts" value="Delete" class="button">
    </label></td>
    <td width="150">&nbsp;</td>
    <td width="150">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><ul>
      <li> pages (<?PHP echo(getPageRevNr($wpdb)); ?>)</li>
    </ul></td>
    <td><label>
      <input type="submit" name="del_rev_pages" id="del_rev_pages" value="Delete" class="button">
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>

  <tr class="alternate">
    <td colspan="5"><strong>Delete comments</strong></td>
    </tr>
  <tr>
    <td><ul>
      <li> spam (<?PHP echo(getSpamNr($wpdb)); ?>)</li>
    </ul></td>
    <td><label>
      <input type="submit" name="del_spam" id="button" value="Delete" class="button">
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>

  <tr class="alternate">
    <td colspan="5"><strong>Optimize/repair tables</strong> (just default wordpress tables)</td>
    </tr>
  <tr>
    <td><ul>
      <li> Optimise</li>
    </ul></td>
    <td colspan="4"><label>
      <div align="left">
        <input type="submit" name="opti_db" id="opti_db" value="_comments/_links/_options/_posts" class="button">
        </div>
    </label></td>
    </tr>
  <tr>
    <td><ul>
      <li> Repair</li>
    </ul></td>
    <td colspan="4"><label>
      <div align="left">
        <input type="submit" name="repair_db" id="repair_db" value="_comments/_links/_options/_posts" class="button">
        </div>
    </label></td>
    </tr>
</table>
</form>


<div class="postbox" style="margin-top: 5px">
  <table width="100%" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td width="18%">
	        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7124263">
                <img src="<?php echo(ASSETS_URL); ?>paypal.gif" border="0" alt="help me to continue support and development of this free software!"/></a> 
            <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7124263">Donate with PayPal</a>
      </td>
      <td width="14%"><a href="http://en.nisi.ro/wordpress" target="_blank">Plugin Home Page</a></td>
      <td width="68%"><a href="http://en.nisi.ro/wordpress" target="_blank">My Other Plugins for Wordpress</a></td>
    </tr>
  </table>
</div>
