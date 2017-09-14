<h1>Подтверждение регистрации</h1>
<p>Спасибо за регистрацию на нашем сайте!</p>
<p>Перейдите по <a href="http://<?=Yii::app()->getRequest()->serverName;?>/registration/confirm/<?=$model->code;?>" target="_blank">ссылке</a> для подтверждения регистрации и получите приветственный бонус в размере <?=Yii::app()->params->welcomeBonus;?>руб. </p>