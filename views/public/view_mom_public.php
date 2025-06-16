<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $mom->title; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.min.css'); ?>">
    <style> body { padding: 20px; } </style>
</head>
<body>
    <div class="panel_s">
        <div class="panel-body">
            <h1><?php echo $mom->title; ?></h1>
            <p class="text-muted"><?php echo _l('mom_manager_meeting_date'); ?>: <?php echo _d($mom->meeting_date); ?></p>
            <p class="text-muted">Created on: <?php echo _dt($mom->created_at); ?></p>
            <hr />
            <div><?php echo $mom->content; ?></div>
        </div>
    </div>
</body>
</html>