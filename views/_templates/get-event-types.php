<?php $types = SportQuery::create()->find(); ?>

<select name="event-type">
<?php foreach($types as $type) { ?>
	    <option value="<?= $type->getId(); ?>"><?= $type->getSport(); ?></option>
<?php } ?>
</select>













