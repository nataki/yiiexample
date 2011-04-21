<?php
//$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
    'FAQ',
);
?>

<h1>F.A.Q.</h1>

<?php foreach($faqCategories as $faqCategory): ?>
<div class="view">
    <h2><?php echo $faqCategory->name; ?></h2>
    <?php 
    $panels = array();
    foreach($faqCategory->faqs as $faq) {
        $panels[$faq->question] = $faq->answer;
    }
    
    $this->widget('zii.widgets.jui.CJuiAccordion', array(
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




