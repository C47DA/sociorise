<?php include 'header.php'; ?>
<style>
html,body
{
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: hidden; 
}
.pt-4 {
    padding-top: 1.5rem !important;
}
.px-4 {
    padding-right: 1.5rem !important;
    padding-left: 1.5rem !important;
}
.g-4, .gy-4 {
    --bs-gutter-y: 1.5rem;
}
.g-4, .gx-4 {
    --bs-gutter-x: 1.5rem;
}
.rounded {
    border-radius: 5px !important;
}

.p-4 {
    padding: 1.5rem !important;
}
.align-items-center {
    align-items: center !important;
}
.justify-content-between {
    justify-content: space-between !important;
}
.d-flex {
    display: flex !important;
}
.text-primary {
    color: #EB1616 !important;
}
.ms-3 {
    margin-left: 1rem !important;
}
.mb-2 {
    margin-bottom: .5rem !important;
}
.mb-0 {
    margin-bottom: 0 !important;
}
.satistics {
    margin-bottom:10px;
  

}
.satistics  {
    margin:5px;
    border-radius:10px;
    box-shadow: 0 .46875rem 2.1875rem rgba(4,9,20,.03),0 .9375rem 1.40625rem rgba(4,9,20,.03),0 .25rem .53125rem rgba(4,9,20,.05),0 .125rem .1875rem rgba(4,9,20,.03);
    transition: all .2s;
}

.button-1 {
  background-color: #EA4C89;
  border-radius: 5px;
  border-style: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  margin: 8px;
  outline: none;
  padding: 10px 16px;
  position: relative;
  text-align: center;
  text-decoration: none;
}
body.dark-mode .button-1 {
    color:#fff;
}

.stretch-card {
    display: -webkit-flex;
    display: flex;
    -webkit-align-items: stretch;
    align-items: stretch;
    -webkit-justify-content: stretch;
    justify-content: stretch;
}
.grid-margin {
    margin-bottom: 1.875rem;
}
.stretch-card > .card {
    width: 100%;
    min-width: 100%;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e7eaed;
    border-radius: 0.625rem;
}
.card {
    box-shadow: 5px 11px 23px -13px #e5e5e5;
    -webkit-box-shadow: 5px 11px 23px -13px #e5e5e5;
    -moz-box-shadow: 5px 11px 23px -13px #e5e5e5;
    -ms-box-shadow: 5px 11px 23px -13px #e5e5e5;
    border: 1px solid rgba(230, 230, 230, 0.41);
}
body.dark-mode .card {
   box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
}
.icon-card-primary {
    background: #FF9933 !important;
    color: #ffffff;
}
.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
}
.card .card-body {
    padding: 1.25rem 1.25rem;
}
.icon-card-primary .icon , .icon-card-success .icon ,.icon-card-dark .icon ,.icon-card-info .icon{
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.3);
    text-align:center;
}
.icon i {
    font-size: 17px;
    line-height: 30px;
    text-align: center;
    display: block;
    color: white;
}
.font-weight-medium {
    font-weight: 500;
}
p {
    font-size: 1.4rem;
    margin-bottom: .5rem;
    line-height: 1.3rem;
}

.mt-3, .template-demo > .btn, .fc .template-demo > button, .ajax-upload-dragdrop .template-demo > .ajax-file-upload, .swal2-modal .swal2-buttonswrapper .template-demo > .swal2-styled, .wizard > .actions .template-demo > a, .template-demo > .btn-toolbar, .my-3 {
    margin-top: 1rem !important;
}
.flex-wrap, .jsgrid .jsgrid-pager {
    flex-wrap: wrap !important;
}
.font-weight-normal {
    font-weight: 400 !important;
}
.mr-2, .template-demo > .btn, .fc .template-demo > button, .ajax-upload-dragdrop .template-demo > .ajax-file-upload, .swal2-modal .swal2-buttonswrapper .template-demo > .swal2-styled, .wizard > .actions .template-demo > a, .template-demo > .btn-group, .fc .template-demo > .fc-button-group, .template-demo > .btn-group-vertical, .template-demo > .dropdown, .mx-2 {
    margin-right: 0.5rem !important;
}
.mb-0, .my-0 {
    margin-bottom: 0 !important;
}

.badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    margin-top:18px;
    background-color:transparent;
}
body.dark-mode .badge {
    background-color: transparent;
    color: #fff;
}
.badge-pill {
    padding-right: 0.6em;
    padding-left: 0.6em;
    border-radius: 10rem;
}
.badge {
    border-radius: 4px;
    font-size: 11px;
    line-height: 1;
    padding: .475rem .5625rem;
    font-weight: normal;
}
.badge-outline-light {
    color: #f8f9fa;
    border: 1px solid #f8f9fa;
}
.badge.badge-pill {
    border-radius: 10rem;
}
.icon-card-primary .badge {
    padding: 0.4rem .725rem;
    border-width: .5px;
}
.align-items-baseline {
    align-items: baseline !important;
}
.mr-2, .template-demo > .btn, .fc .template-demo > button, .ajax-upload-dragdrop .template-demo > .ajax-file-upload, .swal2-modal .swal2-buttonswrapper .template-demo > .swal2-styled, .wizard > .actions .template-demo > a, .template-demo > .btn-group, .fc .template-demo > .fc-button-group, .template-demo > .btn-group-vertical, .template-demo > .dropdown, .mx-2 {
    margin-right: 0.5rem !important;
}
.icon-card-info {
    background: #138808 !important;
    color: #ffffff;
}
.icon-card-success {
    background: #000080 !important;
    color: #ffffff;
}
.icon-card-dark {
    background: #222437 !important;
    color: #ffffff;
}
</style>
<div class="container-fluid">
<div class="row">
     <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
 <div class="card icon-card-primary">
 <a style="text-decoration:none;color:#fff;"  href="admin/clients");?>
   <div class="card-body">
<div class="d-flex align-items-center">
  <div class="icon mb-0 mb-md-2 mb-xl-0 mr-2">
    <i class="fa fa-users"></i>
  </div>
  <p class="font-weight-medium mb-0">Users</p>
</div>

<div class="d-flex align-items-center mt-3 flex-wrap">
  <h3 class="font-weight-normal mb-0 mr-2"><?php echo countRow(["table"=>"clients"]);?></h3>
  <div class="badge badge-outline-light badge-pill mt-md-2 mt-xl-0">
    <div class="d-flex align-items-baseline">
<?php 

$clients = $conn->prepare("SELECT * FROM clients");
$clients->execute();
$clients = $clients->fetchAll(PDO::FETCH_ASSOC);
$month = date('m');
$previous_month = date("m",strtotime ( '-1 month',strtotime(date('Y-m-d'))));

$count_this_month = 0;
$count_previous_month = 0;
for($i = 0;$i < count($clients);$i++){
   $register_month = $clients[$i]["register_date"];
   $register_month = explode(" ",$register_month)[0];
   $register_month = explode("-",$register_month)[1];
if($register_month == $month){
   $count_this_month += 1;
}
if($register_month == $previous_month){
    $count_previous_month += 1;
}


}
$show = $count_this_month - $previous_month;
if($show > 0 || $show == 0){
  $growth = '<span class="mb-0 mr-2">'.$show.'</span>
<i class="fas fa-arrow-up"></i>';
}  elseif($show < 0){
$growth = '<span class="mb-0 mr-2">'.str_replace("-","",strval($show)).'</span>
<i class="fas fa-arrow-down"></i>';
}
?>
<span class="mr-2"></span>
<?=$growth?>
    </div>
  </div>
</div>
<small class="font-weight-medium d-block mt-2">Total</small>
   </div></a>
 </div>
     </div>
     <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
 <div class="card icon-card-success">
 <a style="text-decoration:none;color:#ffffff;" href="admin/orders");?>
   <div class="card-body">
<div class="d-flex align-items-center">
  <div class="icon mb-0 mb-md-2 mb-xl-0 mr-2">
  
    <i class="fas fa-shopping-bag"></i>
  </div>
  <p class="font-weight-medium mb-0">Orders</p>
</div>
<div class="d-flex align-items-center mt-3 flex-wrap">
  <h3 class="font-weight-normal mb-0 mr-2"><?php echo $settings["panel_orders"]; ?></h3>
  <div class="badge badge-outline-light badge-pill mt-md-2 mt-xl-0">
    <div class="d-flex align-items-baseline">
<?php 

$orders = $conn->prepare("SELECT * FROM orders");
$orders->execute();
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);
$month = date('m');
$previous_month = date("m",strtotime ( '-1 month',strtotime(date('Y-m-d'))));

$count_this_month = 0;
$count_previous_month = 0;
for($i = 0;$i < count($orders);$i++){
   $order_month = $orders[$i]["order_create"];
   $order_month = explode(" ",$order_month)[0];
   $order_month = explode("-",$order_month)[1];
if($order_month == $month){
   $count_this_month += 1;
}
if($register_month == $previous_month){
    $count_previous_month += 1;
}


}
$show = $count_this_month - $previous_month;
if($show > 0 || $show == 0){
  $growth = '<span class="mb-0 mr-2">'.$show.'</span>
<i class="fas fa-arrow-up"></i>';
}  elseif($show < 0){
$growth = '<span class="mb-0 mr-2">'.str_replace("-","",strval($show)).'</span>
<i class="fas fa-arrow-down"></i>';
}


$today = new DateTime('today');

$today_str = $today->format('Y-m-d');

$a = $conn->prepare("SELECT * FROM payments WHERE payment_status=:status AND payment_delivery=:delivery");
$a->execute(array(
    "status" => 3,
    "delivery" => 2
));
$a = $a->fetchAll(PDO::FETCH_ASSOC);
$funds = 0.00;
for($i = 0;$i< count($funds);$i++){
   $b = explode(" ",$a[$i]["payment_create_date"]);
 if($today_str == $b[0]){
 $funds +=$a[$i]["payment_amount"];
 }
}

?>

<?=$growth?>


    </div>
  </div>
</div>
<small class="font-weight-medium d-block mt-2">Total</small>

   </div></a>
 </div>
     </div>
     <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
 <div class="card icon-card-info">
   <div class="card-body">
<div class="d-flex align-items-center">
  <div class="icon mb-0 mb-md-2 mb-xl-0 mr-2">
    <i class="glyphicon glyphicon-remove"></i>
 </div>
   <p class="font-weight-medium mb-0">Failed orders</p>
</div>
<div class="d-flex align-items-center mt-3 flex-wrap">
  <h3 class="font-weight-normal mb-0 mr-2"><?=$failCount?></h3>
</div>
<small class="font-weight-medium d-block mt-2">Total</small>
   </div>
 </div>
     </div>
 
  
  <div style="border:2px solid #2B2D42;border-radius:10px;box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;margin:5px;">
<h4 style="padding:8px;border-bottom:2px solid #2B2D42;padding-bottom:15px;" class="text-left">
Page Shortcuts
</h4>
<div>
<a style="background-color:#07BEB8" class="button-1" href="/admin/clients">Manage Users</a>
<a style="background-color:#FF6D00" class="button-1" href="/admin/orders">Manage Orders</a>
<a style="background-color:#FF5D8F" class="button-1" href="/admin/tasks">Refill and Cancel Tasks</a>
<a style="background-color:#0C0A3E" class="button-1" href="/admin/broadcasts">Manage Broadcasts</a>
<a style="background-color:#FFC300" class="button-1" href="/admin/settings/site_count">Manage Fake Orders</a>
<a style="background-color:#F9564F" class="button-1" href="/admin/settings/currency-manager">Manage Currencies</a>
<a style="background-color:#44AF69" class="button-1" href="/admin/settings/providers">Manage Sellers</a>
<a style="background-color:#00B4D8" class="button-1" href="/admin/appearance">Manage Themes</a>
<a style="background-color:#003566" class="button-1" href="/admin/settings/payment-methods">Payment Methods</a>

</div>
</div>


</div>
</div>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
 <div class="modal-body text-center">
    <h4>Are you sure you want to proceed ?</h4>
    <div align="center">
       <a class="btn btn-primary" href="" id="confirmYes">Yes</a>
       <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
    </div>
 </div>
      </div>
   </div>
</div>
<?php include 'footer.php'; ?>
