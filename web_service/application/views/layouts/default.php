<?php $this->load->view('partials/header'); ?>

  <div class="col-sm-8 col-md-9 content-fixed">
    <div class="row">
      <div id="dynamic-content" class="col-12">
        <?php echo $content_for_layout; ?>
      </div>
    </div>
  </div>

<?php $this->load->view('partials/footer'); ?>
