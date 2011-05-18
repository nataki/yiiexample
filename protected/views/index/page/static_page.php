<?php
$this->composePageTitle($staticPage->title);
$this->composePageMetaTag('description', $staticPage->meta_description);
$this->breadcrumbs=array(
    $staticPage->title,
);
?>
<h1><?php echo $staticPage->title ?></h1>
<p><?php echo $staticPage->content ?></p>