<div class="profile">
 <?php print render($user_profile); ?>
</div>

<?php

//Show owned content div only if a user is logged in
global $user;
global $base_url;
if ($user->uid != null && arg(0) == 'user') {
?>
  <h1><a href="<?php $base_url; ?>/research/admin-guides">
    Search content within Research Guides</a></h1>
<?php } ?>
