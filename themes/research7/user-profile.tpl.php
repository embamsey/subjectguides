<div class="profile">
 <?php print render($user_profile); ?>
</div>

<?php

//Show owned content div only if a user is logged in
global $user;
global $base_url;
global $language;

$link = '';
if ($user->uid != null && arg(0) == 'user') {
  if ($language->language == 'fr') {?>
    <h1><a href="<?php $base_url; ?>/research/admin-guides">
      Chercher dans les Guides de recherches</a></h1>
  <?php } 
  else {?>
    <h1><a href="<?php $base_url; ?>/research/admin-guides">
      Search content within Research Guides</a></h1>
  <?php }
}?>
