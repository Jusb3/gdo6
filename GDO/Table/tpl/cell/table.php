<?php /** @var $field \GDO\Table\GDT_Table **/
use GDO\Util\Common;
$headers = $field->getHeaderFields();
if ($pagemenu = $field->getPageMenu())
{
	echo $pagemenu->renderCell();
}
$result = $field->getResult();
?>
<form method="post" action="<?= $field->href; ?>" class="b">
<div
 class="gdo-table"
 layout="column" flex layout-fill
 ng-controller="GDOTableCtrl"
 ng-init='init(<?= $field->displayConfigJSON(); ?>)'>
  <?php if ($field->title) : ?>
  <h3><?= $field->title; ?></h3>
  <?php endif; ?>
  <table id="gwfdt-<?= $field->name; ?>" class="gdo-table">
	<thead>
	  <tr>
	  <?php foreach($headers as $gdoType) : ?>
		<th class="<?=$gdoType->htmlClass()?>">
		  <label>
			<?= $gdoType->renderHeader(); ?>
			<?php if ($field->ordered) : ?>
			<?= $gdoType->displayTableOrder($field); ?>
			<?php endif; ?>
		  </label>
		  <?php if ($field->filtered) : ?>
			<?= $gdoType->renderFilter(); ?>
		  <?php endif; ?>
		</th>
	  <?php endforeach; ?>
	  </tr>
	</thead>
	<tbody>
	<?php while ($gdo = $result->fetchAs($field->fetchAs)) : ?>
	<tr gdo-id="<?= $gdo->getID()?>">
	  <?php foreach($headers as $gdoType) :
	  $col = $field->getField($gdoType->name);
	  $gdoType = $col ? $col : $gdoType;
	  $gdoType->gdo($gdo); ?>
		<td class="<?=$gdoType->htmlClass()?>"><?= $gdoType->renderCell(); ?></td>
	  <?php endforeach; ?>
	</tr>
	<?php endwhile; ?>
	</tbody>
	<tfoot></tfoot>
  </table>
  <input type="submit" class="n" />
</div>
<?php if ($actions = $field->getActions()) : ?>
<?php echo $actions->render(); ?>
<?php endif; ?>
</form>
<!-- END of GDT_Table -->
