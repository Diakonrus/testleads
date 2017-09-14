<?php
/**
 * @var $this UserController
 * @var $model UsersBonus
 * @var $form CActiveForm
 */
$this->pageTitle = Yii::app()->name . ' - Личный кабинет';
?>

<h2>Личный кабинет пользователя <?=$model->user->email;?></h2>
<b>Сменить имя пользователя</b>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'prof-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));?>

    <div class="row">
        <?php echo $form->labelEx($modelUser,'name'); ?>
        <?php echo $form->textField($modelUser,'name'); ?>
        <?php echo $form->error($modelUser,'name'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>


    <?php $this->endWidget(); ?>
</div>
<HR>
<b>Списание средств через API</b>
<p>Ваш баланс: <?=$model->bonus;?></p>
<p>Ваш код: <?=$model->user->code;?></p>

<p>Вы можете осуществить вывод средств через консоль. Укажите нужную для вывода сумму, если она не будет больше вашего текущего баланся - будет осуществлено списание. Списание происходит через JSON API</p>

<b>HEADERS:</b><BR>
<input id="code" type="text" class="form-control" placeholder="code - укажите код пользователя,">
<HR><b>BODY:</b><BR>
<form>
    <select class="form-control" id="request_verb" name="RequestURL[request_verb]">
        <option value="post">POST</option>
    </select>

    <input id="request_bar_1" class="form-control" type="text" value="/api/balance" size="30" name="RequestURL[request_bar]" autocomplete="off"><BR>


    <div id="param_block">
        <input class="form-control" name="bonus" placeholder="bonus - укажите сумму списания" type="text">
    </div>
    <BR>

    <button id="send_button_api" class="btn btn-info">Отправить</button>
</form>

<HR>
<div class="response_serv_title">Ответ сервера</div>
<div id="response">
</div>