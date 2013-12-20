<form method="post" action="creditUpdate/id/<?php echo $Creditmodel->id;?>" name = "credit">
<?php
	echo $this->renderPartial('_form', array('Creditmodel'=>$Creditmodel,'Rolemodel'=>$Rolemodel)); 
?>
</form>