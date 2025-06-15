<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="mom_modal_title">
        </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <?php echo form_hidden('mom_id'); // Hidden input untuk menyimpan ID saat mode edit ?>
            
            <?php echo render_input('title', 'mom_manager_title', '', 'text', ['data-title-validate' => true]); ?>

            <p class="bold"><?php echo _l('mom_manager_content'); ?></p>
            <?php echo render_textarea('content', '', '', [], [], '', 'tinymce'); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
</div>