<?php
$this->sectionTitle = 'Maintenance';
?>

<?php if(Yii::app()->user->hasFlash('maintenanceResult')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('maintenanceResult'); ?>
</div>
<?php endif; ?>

<p>This section allows you to perform some maintenance of your system.</p>

<p>The following actions are available:</p>
<ul>
    <li><?php echo CHtml::link('Clear Cache', $this->createUrl('clearcache')) ?></li>
</ul>
<p>Note: some actions may take long time to be performed.</p>