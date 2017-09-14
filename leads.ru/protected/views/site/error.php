<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
?>

<?php /* $this->widget('application.widgets.TopMenuWidget', ['model' => new Lot('search'), 'markAction' => false]) */ ?>

<div class="wrapper">
    <div id='content_list' style="padding: 0 100px;  margin-top: 80px;">
        <h2>Error <?php echo $code; ?></h2>

        <div class="error">
            <?php echo CHtml::encode($message); ?>
        </div>
    </div>
    <div class='cl'></div>
</div>

