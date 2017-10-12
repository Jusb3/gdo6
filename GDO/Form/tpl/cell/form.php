<?php /** @var $form \GDO\Form\GDT_Form **/ ?>
<!-- Begin Form -->
<div class="gdo-form">
  <div class="md-whiteframe-8dp">
    <div class="gdo-form-head">
      <h2 class="gdo-form-title"><?= $form->title; ?></h2>
      <p><?= $form->info; ?></p>
    </div>
    <div class="gdo-form-inner">
      <form
       id="form_<?=$form->name;?>"
       action="<?= $form->action; ?>"
       method="<?= $form->method; ?>"
       enctype="<?= $form->encoding; ?>">
      <?php foreach ($form->getFields() as $field) : ?>
        <?php if ($field->writable) : ?>
          <?= $field->renderForm(); ?>
        <?php endif; ?>
      <?php endforeach; ?>
        <input type="hidden" name="nojs" value="1" />
      </form>
    </div>
  </div>
</div>
<!-- End of Form -->