<?php $types = SportQuery::create()->find(); ?>

<select name="event-type" class="selects">
<?php foreach($types as $type) { ?>
<!--        <option value="0">Category</option>-->
	    <option value="<?= $type->getId(); ?>"><?= $type->getSport(); ?></option>
<?php } ?>
</select>














