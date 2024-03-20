<?php
require('../carbon/autoload.php');
use Carbon\Carbon;
use Carbon\CarbonInterval;
?>
<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<div class="grid_10">
  <div class="box round first grid">
    <h2> Thong ke don hang :<?php echo Carbon::now('Asia/Ho_Chi_Minh')?></h2>
    <div class="block">
      <div class="col-md-3">
        Tu ngay: <input type="form-control" type="text" id="datepicker_from"></p>
      </div>
      <div class="col-md-3">
        Toi ngay: <input type="form-control" type="text" id="datepicker_from"></p>
      </div>
      <div class="col-md-3">
        Loc theo: 
      <select class="form-control">
        <option>Loc theo</option>
        <option value="7ngay">Loc theo 7 ngay</option>
        <option value="30ngay">Loc theo 30 ngay</option>
        <option value="90ngay">Loc theo 90 ngay</option>
        <option value="365ngay">Loc theo 1 nam</option>
      </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="myfirstchart" style="height: 250px;"></div>
      </div>
    </div>
  </div>
</div>

<?php include 'inc/footer.php'; ?>