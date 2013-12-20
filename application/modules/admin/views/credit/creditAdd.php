<form method="post" action="creditAdd" name = "credit">
<?php
	echo $this->renderPartial('_form',array('Creditmodel'=>$Creditmodel,'Rolemodel'=>$Rolemodel)); 
?>
</form>