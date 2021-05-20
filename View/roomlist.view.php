<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div class="row" style="min-height: 1000px; margin-top: 100px; margin-bottom: 60px;">
        <?php 
        foreach($viewParams['postList'] as $post){ ?>
            <div class="col-xl-6 col-lg-6 col-md-6 row">

            </div>
        <?php
        } ?>
        </div>
<?php getTemplate("footer", $viewParams) ?>