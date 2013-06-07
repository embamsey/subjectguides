<!--
/* 
 * The header displays the Laurentian Logo, site name, Language selection, and the Navigation bar,
 * in that order starting from the top of the page.
 */
-->
<div id="header">
  <div id="logo">
    <?php
      global $base_url;
      $logo = '/images/LU.png';
      $lu_home = 'http://laurentian.ca';
        if ($language->language == 'fr') {
          $logo = '/images/UL.png';
          $lu_home = 'http://laurentian.ca/fr';
        }
      if ($logo) {
          $logo = "$base_url/" . drupal_get_path('theme', 'research7') . $logo;
    ?>
          <a href=" <?php print $lu_home ?> " title=" <?php print t('Home') ?> "><img src=" <?php print $logo ?> " alt=" <?php print t('Home') ?> " /></a>
    <?php
      }
      if ($site_name) {
    ?>
        <h1 class='site-name'><a href=" <?php print render($front_page) ?> " title=" <?php print t('Home') ?> "> <?php print render($site_name) ?> </a></h1>
    <?php
      }
      if ($site_slogan) {
    ?> 

      <div class='site-slogan'>
      <?php print render($site_slogan); ?> 
      </div>
    <?php } ?>
  </div>
  <div><br><br></div>
  <div>
    <?php print render($page['header']); ?>
  </div>
</div>

<!--
/*
 * The content section displays the guides, databases, database lists, etc.
 */
-->
<div id="content">
  <?php print render($breadcrumb); ?>
  <div class="tabs"> 
    <?php print render($tabs); ?>
  </div>
  
  <?php
    if ($messages) { print $messages; }
    print render($page['help']);
    if ($action_links):
  ?>
    <ul class="action-links">
  <?php
    print render($action_links);
  ?>
    </ul>
  <?php
    endif;
    print render($page['content']);
    print $feed_icons;
  ?>
</div>

<!--
/*
 * The footer displays the admin naviagtion and the user menu
 * in the that order at the bottom of the screen when a user 
 * is logged in, otherwise nothing is displayed in the footer
 */
-->
<div id="footer">
  <?php print render($page['footer']); ?>
</div>

