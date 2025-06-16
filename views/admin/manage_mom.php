<?php defined('BASEPATH') or exit('No direct script access allowed');
$moms_list = get_moms_for_project($project->id);
?>
<h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-flex tw-items-center">
    <?php echo _l('mom_manager_mom'); ?>
    <?php if (has_permission('projects','','create')) { ?>
        <a href="#" class="btn btn-primary ml-2" onclick="new_mom(); return false;">
            <?php echo _l('mom_manager_new'); ?>
        </a>
    <?php } ?>
</h4>
<div class="table-responsive">
    <table class="table dt-table" data-order-col="1" data-order-type="desc">
        <thead>
            <tr>
                <th><?php echo _l('mom_manager_title'); ?></th>
                <th><?php echo _l('mom_manager_meeting_date'); ?></th>
                <th><?php echo _l('staff_member'); ?></th>
                <th><?php echo _l('mom_manager_created_at'); ?></th>
                <th><?php echo _l('options'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($moms_list as $mom) { ?>
            <tr>
                <td><?php echo $mom['title']; ?></td>
                <td data-order="<?php echo $mom['meeting_date']; ?>"><?php echo _d($mom['meeting_date']); ?></td>
                <td>
                    <a href="<?php echo admin_url('staff/profile/' . $mom['created_by']); ?>">
                        <?php echo staff_profile_image($mom['created_by'], ['staff-profile-image-small']); ?>
                        <?php echo get_staff_full_name($mom['created_by']); ?>
                    </a>
                </td>
                <td data-order="<?php echo $mom['created_at']; ?>"><?php echo _dt($mom['created_at']); ?></td>
                <td>
                    <?php if (has_permission('projects','','edit')) { ?>
                        <button class="btn btn-default btn-icon" onclick="edit_mom(<?php echo $mom['id']; ?>);"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php } ?>
                    <?php if (has_permission('projects','','delete')) { ?>
                        <a href="<?php echo admin_url('mom_manager/delete_mom/'.$project->id.'/'.$mom['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                    <button class="btn btn-success btn-icon" onclick="copy_public_link('<?php echo get_mom_public_url($mom); ?>');"><i class="fa-regular fa-share-from-square"></i></button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="mom_modal" tabindex="-1" role="dialog">
    <?php echo form_open('', ['id' => 'mom-form']); ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $this->load->view('mom_manager/admin/mom_entry'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script>
$(function(){
    appValidateForm($('#mom-form'), {
        title: 'required',
        meeting_date: 'required',
        content: 'required'
    });
});

function new_mom(){
    $('#mom-form').attr('action','<?php echo admin_url('mom_manager/mom/'.$project->id); ?>');
    $('#mom_modal input[name="mom_id"]').val('');
    $('#mom_modal input[name="title"]').val('');
    $('#mom_modal input[name="meeting_date"]').val('');
    if(typeof(tinymce)!=='undefined'){tinymce.get('content').setContent('');}
    $('#mom_modal_title').text('<?php echo _l('mom_manager_new'); ?>');
    $('#mom_modal').modal('show');
}

function edit_mom(id){
    var modal=$('#mom_modal');
    modal.modal('show');
    modal.find('.modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

    $.get(admin_url+'mom_manager/get_mom_data_ajax/'+id,function(response){
        modal.find('.modal-body').html($('.modal-body-content-wrapper').html());
        $('#mom-form').attr('action','<?php echo admin_url('mom_manager/mom/'.$project->id.'/'); ?>'+id);
        $('#mom_modal input[name="mom_id"]').val(response.id);
        $('#mom_modal input[name="title"]').val(response.title);
        $('#mom_modal input[name="meeting_date"]').val(response.meeting_date);
        if(typeof(tinymce)!=='undefined'){tinymce.get('content').setContent(response.content);}
        $('#mom_modal_title').text('<?php echo _l('mom_manager_edit'); ?>');
    },'json').fail(function(){
        alert('An error occurred while fetching data.');
        modal.modal('hide');
    });
}

function copy_public_link(link){
    var tmp=document.createElement('input');
    document.body.appendChild(tmp);
    tmp.value=link;
    tmp.select();
    document.execCommand('copy');
    document.body.removeChild(tmp);
    alert('<?php echo _l('mom_manager_link_copied'); ?>');
}
</script>

<div class="hidden modal-body-content-wrapper">
    <?php echo form_hidden('mom_id'); ?>
    <?php echo render_input('title', 'mom_manager_title'); ?>
    <?php echo render_date_input('meeting_date', 'mom_manager_meeting_date'); ?>
    <p class="bold"><?php echo _l('mom_manager_content'); ?></p>
    <?php echo render_textarea('content', '', '', [], [], '', 'tinymce'); ?>
</div>

