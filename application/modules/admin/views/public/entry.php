<?php
/**
 * file: entry.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-6
 * desc: 
 */
foreach($tab as $value){
?>
<li data-url="<?php echo $value[1]; ?>"><?php echo $value[0]; ?></li>
<?php } ?>