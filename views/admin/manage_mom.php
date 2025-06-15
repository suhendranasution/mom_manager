<?php
defined('BASEPATH') or exit('No direct script access allowed');
$moms_list = get_moms_for_project($project->id);
?>

<h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-flex tw-items-center">
    </h4>

<div class="table-responsive">
    <table class="table dt-table" data-order-col="2" data-order-type="desc">
        <thead>
            </thead>
        <tbody>
            <?php foreach($moms_list as $mom) { ?>
            <tr>
                <td><?php echo $mom['title']; ?></td>
                <td>
                    <a href="<?php echo admin_url('staff/profile/' . $mom['created_by']); ?>">
                        <?php echo staff_profile_image($mom['created_by'], ['staff-profile-image-small']); ?>
                        <?php echo get_staff_full_name($mom['created_by']); ?>
                    </a>
                </td>
                <td data-order="<?php echo $mom['created_at']; ?>"><?php echo _dt($mom['created_at']); ?></td>
                <td>
                    <?php if (has_permission('projects', '', 'edit')) { ?>
                    <button class="btn btn-default btn-icon" onclick="edit_mom(<?php echo $mom['id']; ?>);"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php } ?>

                    <?php if (has_permission('projects', '', 'delete')) { ?>
                    <a href="<?php echo admin_url('mom_manager/delete_mom/'.$project->id.'/'.$mom['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                    
                    <button class="btn btn-success btn-icon" onclick="copy_public_link('<?php echo get_mom_public_url($mom); ?>')"><i class="fa-regular fa-share-from-square"></i></button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    // Membungkus semua script dalam satu blok agar lebih rapi
    $(function(){
        appValidateForm($('#mom-form'), {
            title: 'required',
            content: 'required'
        });
    });

    function new_mom() {
        $('#mom-form').attr('action', "<?php echo admin_url('mom_manager/mom/' . $project->id); ?>");
        $('#mom_modal #mom_id').val('');
        $('#mom_modal #title').val('');
        
        // Pastikan editor siap sebelum mengubah kontennya
        if (typeof(tinymce) !== 'undefined') {
            tinymce.get('content').setContent('');
        }
        
        $('#mom_modal_title').text("<?php echo _l('mom_manager_new'); ?>");
        $('#mom_modal').modal('show');
    }

    // FUNGSI EDIT YANG DIPERBAIKI DAN LEBIH AMAN
    function edit_mom(id) {
        // Tampilkan loading spinner di modal
        var modal = $('#mom_modal');
        modal.modal('show');
        modal.find('.modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

        $.get(admin_url + 'mom_manager/get_mom_data_ajax/' + id, function(response) {
            // Restore modal body
            modal.find('.modal-body').html($('.modal-body-content-wrapper').html());
            
            // Atur action form
            $('#mom-form').attr('action', "<?php echo admin_url('mom_manager/mom/' . $project->id . '/'); ?>" + id);
            
            // Isi data ke form
            $('#mom_modal #mom_id').val(response.id);
            $('#mom_modal #title').val(response.title);

            // Cara paling aman untuk set konten TinyMCE
            if (typeof(tinymce) !== 'undefined') {
                tinymce.get('content').setContent(response.content);
            }

            $('#mom_modal_title').text("<?php echo _l('mom_manager_edit'); ?>");

        }, 'json').fail(function(error){
             alert('An error occurred while fetching data.');
             modal.modal('hide');
        });
    }

    function copy_public_link(link) {
        // ... (Fungsi ini sudah benar)
    }
</script>

<div class="hidden modal-body-content-wrapper">
    <?php echo form_hidden('mom_id'); ?>
    <?php echo render_input('title', 'mom_manager_title'); ?>
    <p class="bold"><?php echo _l('mom_manager_content'); ?></p>
    <?php echo render_textarea('content', '', '', [], [], '', 'tinymce'); ?>
</div>