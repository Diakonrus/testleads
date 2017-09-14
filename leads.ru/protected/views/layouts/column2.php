<?php $this->beginContent('//layouts/administration/main'); ?>
<div class="span-19">
    <div id="content">
        <?php echo $content; ?>
    </div>
</div>
<div class="span-5 last">
    <div id="sidebar">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => $this->menuTitle,
            'htmlOptions' => ['class' => 'grid-view']
        ));
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->menu,
        ));
        $this->endWidget();
        ?>
    </div>
</div>
<?php $this->endContent(); ?>
