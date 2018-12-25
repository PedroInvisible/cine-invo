
<?= $this->getContent() ?>

<?= $this->tag->form(['peliculas/create']) ?>

    <ul class="pager">
        <li class="previous pull-left">
            <?= $this->tag->linkTo(['peliculas', '&larr; Go Back']) ?>
        </li>
        <li class="pull-right">
            <?= $this->tag->submitButton(['Save', 'class' => 'btn btn-success']) ?>
        </li>
    </ul>

    <fieldset>

    <?php foreach ($form as $element) { ?>
        <?php if ($this->callMacro('is_a', [$element, 'Phalcon\Forms\Element\Hidden'])) { ?>
            <?= $element ?>
        <?php } else { ?>
            <div class="form-group">
                <?= $element->label() ?>
                <?= $element->render(['class' => 'form-control']) ?>
            </div>
        <?php } ?>
    <?php } ?>

    </fieldset>

</form>
