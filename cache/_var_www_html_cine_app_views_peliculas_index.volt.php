
<?= $this->getContent() ?>

<div align="right">
    <?= $this->tag->linkTo(['peliculas/new', 'Crear Peliculas', 'class' => 'btn btn-primary']) ?>
</div>

<?= $this->tag->form(['peliculas/search']) ?>

<h2>Buscar peliculas</h2>

<fieldset>

<?php foreach ($form as $element) { ?>
    <?php if ($this->callMacro('is_a', [$element, 'Phalcon\Forms\Element\Hidden'])) { ?>
<?= $element ?>
    <?php } else { ?>
<div class="control-group">
    <?= $element->label(['class' => 'control-label']) ?>
    <div class="controls">
        <?= $element ?>
    </div>
</div>
    <?php } ?>
<?php } ?>

<div class="control-group">
    <?= $this->tag->submitButton(['Search', 'class' => 'btn btn-primary']) ?>
</div>

</fieldset>

</form>
