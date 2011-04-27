<?php
$this->breadcrumbs=array(
    'FAQ',
);
?>
<?php 
$cacheOptions = array(
    'duration' => 3600*24,
    'dependency' => array(
        'class'=>'CFileCacheDependency',
        'fileName'=>__FILE__
    )
);
if ($this->beginCache('faqListHtml', $cacheOptions)) { 
?>
<h1>F.A.Q.</h1>
<?php 
    $faqCategories = FaqCategory::model()->findAll();
    foreach($faqCategories as $faqCategory): 
?>
<div class="view">
    <h2><?php echo $faqCategory->name; ?></h2>
    <?php 
    $panels = array();
    foreach($faqCategory->faqs as $faq) {
        $panels[$faq->question] = $faq->answer;        
    }
    
    $this->widget('zii.widgets.jui.CJuiAccordion', array(
         'htmlOptions'=>array(
            'id'=>'faq_list_'.$faqCategory['id']
         ),
         'panels'=>$panels,
         // additional javascript options for the accordion plugin
         'options'=>array(
             'animated'=>'bounceslide',
             'collapsible'=>'false',
             'active'=>'false',
         ),
     ));
    ?>    
</div>
<?php endforeach; ?>
<?php $this->endCache(); } ?>
