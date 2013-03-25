<?php
// $Id: node.tpl.php,v 1.7 2007/08/07 08:39:36 goba Exp $
?>
  <div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">


<?php

  global $language;
  global $base_url;

  $multidis = FALSE;

  // Check to see if we are listing all databases, or only multidisciplinary
  if (strstr($_SERVER['REQUEST_URI'], 'multidisciplinary-databases') == 'multidisciplinary-databases') {
    $multidis = TRUE;
  }

  // Choose the correct title to display based on language / multidisciplinary
  $title_text = 'Databases A-Z';
  if ($multidis)
    $title_text = 'Multidisciplinary Databases';
  if ($language->language == 'fr') {
    if ($multidis)
      $title_text = 'Bases de Données Multidisciplinaire';
    else
      $title_text = 'Bases de Données, A-Z';
  }

  print '<h1>' . $title_text . '</h1>';

  /*  We want all nodes that are:
   *   1. Of the type library_database
   *   2. In the user's current language 
   *   3. Published
   */

  $result = db_query("
    SELECT n.created, n.title, n.nid, n.changed
    FROM {node} n
    WHERE n.type = 'library_database'
      AND (n.language = :language OR n.language = 'und')
      AND n.status = 1
      ORDER BY n.title ASC
    ", array(':language' => $language->language)
  );

  // Inline navigation via the wonder of anchors
  $jump_text = 'Jump to:';
  if ($language->language == 'fr') {
    $jump_text = 'Aller à :';
  }
  $jump_list = <<<"HERE"
    <p class='dblist_nav'>$jump_text
      <a href="#list_A">A-C</a>
      <a href="#list_D">D-G</a>
      <a href="#list_H">H-L</a>
      <a href="#list_M">M-R</a>
      <a href="#list_S">S-Z</a>
    </p>
HERE;

?>
<ul>
<?php

  // Place anchors roughly 1/5 of the way through the page
  $anchors = array('A', 'D', 'H', 'M', 'S', 'Z');
  $init_ltr = array_shift($anchors);

  foreach ($result as $i) {
    $list_id = '';
    $nid = $i->nid;
    // Load the node contents for each database
    $cur_db_node = node_load($i->nid);
    // Grab the URL & description
    $cur_db_title = $i->title;
    $cur_db_url = $cur_db_node->field_database_url['und'][0]['url'];
    $cur_db_desc = $cur_db_node->field_database_description['und'][0]['value'];
    $cur_db_multi = $cur_db_node->field_multidisciplinary['und'][0]['value'];

    // Skip this database if we are listing multidis & this db is not multidis
    if ($multidis && !$cur_db_multi) {
       continue;
    }

    // Proxy 'em if you got 'em
    $cur_db_proxy = $cur_db_node->field_proxied['und'][0]['value'];
    if ($cur_db_proxy) {
      $cur_db_url = "http://librweb.laurentian.ca/login?url=$cur_db_url";
    }
    $db_display = '';
    $db_edit = '';
    $desc = '';

    if ($cur_db_desc) {

      $desc = '<p name="dbdesc_' . $nid . '" style="display:none;">';
      $desc .= '<span width="25%"><b>Description:</b></span>';
      $desc .= '<span>' . $cur_db_desc . '</span>';
      $desc .= '</p>';

      $db_display = "(<span onclick='jQuery(\"[name=\\\"dbdesc_$nid\\\"]\").toggle();' style='font-weight: bold'>?</span>)";

    }

    //Check current user's roles and show an edit button if admin or librarian
    if (in_array(librarian, $GLOBALS['user']->roles) || in_array(administrator, $GLOBALS['user']->roles)) {
       $db_edit = '&nbsp;<a class="db_edit_link" href="' . $base_url . '/node/' . $nid . '/edit">(Edit)</a>';
    }

    // Define an anchor, perhaps
    if (substr($cur_db_title, 0, 1) == $init_ltr) {
      $list_id = " id='list_$init_ltr'";
      $init_ltr = array_shift($anchors);
      print $jump_list;
    }
?>

    <li<?php print $list_id; ?>><a href="<?php print $cur_db_url; ?>"><?php print render($cur_db_title); ?></a> <?php print render($db_display); ?><?php print render($db_edit); ?> </li>
    <?php print render($desc); ?>

<?php
  }
?>
</div>