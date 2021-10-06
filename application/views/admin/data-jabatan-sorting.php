<?php
// Prefix halaman ini
$prefix_page = 'admin/kelola/jabatan/';

?>

<?php view('_layouts/header'); ?>


<?php  view('_layouts/topbar'); ?>
<?php view('_layouts/wrapper-img'); ?>
<div class="page-wrapper">
  <div class="page-wrapper-inner">

    <?php view('_layouts/sidenav'); ?>
    <!-- Page Content-->
    <div class="page-content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <div class="card">
              <div class="card-body table-responsive">
                <div class="text-right">
                  <a href="javascript:void(0)" class="btn btn-primary waves-effect text-right mb-4" id="get-order"><i class="fa fa-save"></i></a>
                </div>
                <div class="">
                  <table class="table dt-responsive table-hover nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                        <th width="10%"><center><i class="fas fa-bars"></i></center></th>
                        <th>Nama Jabatan</th>
                      </tr>
                    </thead>
                    <tbody id="list-jabatan">
                      <?php $no = 1; foreach ($jabatan as $val): ?>
                      <tr id="<?=$val->id ?>" data-id="<?=$val->id ?>">
                        <td><center><i class="fas fa-bars"></i></center></td>
                        <td><?=$val->nama_jabatan ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end row-->
      </div>
      <!-- container -->

      <?php view('_layouts/footer'); ?>

    </div>
    <!-- end page content -->
  </div>
  <!--end page-wrapper-inner -->
</div>
<!-- end page-wrapper -->
<?php view('_layouts/js'); ?>
<script src="https://unpkg.com/sortablejs-make/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script>
  $(document).ready(function() {
    $('#items-1').sortable({
      animation: 200
    });

    $('#list-jabatan').sortable({
      animation: 200
    });
  })
  // Arrays of "data-id"
  $('#get-order').click(function() {
    var sort = $('#list-jabatan').sortable('toArray');
    let csrfHash = "<?=$this->security->get_csrf_hash(); ?>";
    let csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
    let url = "<?=site_url($prefix_page.'updateSort') ?>";
    let dataJson = {
      [csrfName]: csrfHash,
      ids: sort
    };

    $.ajax({
      url: url,
      type: "POST",
      data: dataJson,
      dataType: "JSON",
      cache: false,
      success: function(data) {
        console.log(data)
        window.location.href = "<?=site_url('admin/kelola/jabatan') ?>";
      },
      error: function(jqxhr, textStatus, errorThrown) {
        console.log(jqxhr);
        console.log(textStatus);
        console.log(errorThrown);

        for (key in jqxhr)
          alert(key + ":" + jqxhr[key])
        for (key2 in textStatus)
          alert(key + ":" + textStatus[key])
        for (key3 in errorThrown)
          alert(key + ":" + errorThrown[key])

      }
    });
  });

</script>

<?php view('_layouts/end'); ?>