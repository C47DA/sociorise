  <div class="modal fade" id="modalDiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         <h4 class="modal-title" id="modalTitle"></h4>
       </div>
       <div id="modalContent">
       </div>
     </div>
   </div>
  </div>
  




  <div class="modal fade" id="subsDiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         <h4 class="modal-title" id="subsTitle"></h4>
       </div>
       <div id="subsContent">
       </div>
     </div>
   </div>
  </div>
  <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
  <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

  <script src="public/admin/toastDemo.js"></script>
  <script src="public/admin/script.js"></script>
  <script src="public/admin/script-2.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="public/admin/jquery.tinytoggle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src="public/admin/sortable-animation.js"></script>
<script src="https://itsjavi.com/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js"></script>
<script src="public/admin/image-picker.min.js"></script>
 <script type="text/javascript">
$(window).on('load', function() {
    $('#loading').hide();
  });
$(document).ready(function(){



var site_url  = $('head base').attr('href');
<?php if( route(2) == "new-service" || route(2) == "new-subscription" ): echo '$(document).ready(function(){
getProviderServices($("#provider").val(),site_url);
});'; endif; ?>




$(".buy-button").click(function(){
var pr = $(this).parent();
var addon = pr.attr("data-addon");

window.location.href = "admin/settings/modules?action=buy_addon&addon="+addon;

});


$(".addon").change(function(){
 var addon = $(this).attr("data-addon");
 $.ajax({
  url:"admin/settings/modules?action=toggle_addon&addon="+addon,
  type:'GET',
  success:function(response){
      
  }
 });
});




$(document).on("change","#image-input", function (){

var upload_btn = $("#upload_an_image");

upload_btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');
upload_btn.attr("disabled","true");
var file_data = $("#image-input").prop("files")[0];
var form_data = new FormData();
form_data.append("logo", file_data);

$.ajax({
url:"admin/appearance/files",
contentType: false,
processData: false,
cache:false,
data: form_data,
type:"POST",
success: function (response) {
upload_btn.html("Upload an Image");
upload_btn.removeAttr("disabled");
iziToast.show({

    icon:'fa fa-check',

    title: "Image uploaded successfully.",
    message: '',
    color:'green',
    position:'topCenter'
});


var imgpicker = $(".imagepicker-div");

imgpicker.html('<center><svg class="spinner_2 medium" viewBox="0 0 48 48"><circle class="path_2" cx="24" cy="24" r="20" fill="none" stroke-width="3"></circle></svg></center><br><br>');
$.ajax({
url:"admin/ajax_data",
data:"action=download_category_icon_images",
type:"POST",
success:function(resp){
var resp = JSON.parse(resp);
imgpicker.html(resp.content);
imgpicker.removeClass("load-images");
}
});

}
});


});







$('#summernote').summernote({

height: 300
});

$('#summernote1').summernote({

height: 300
});





$("#update_inr_rate").click(function(){
$.ajax({
url:site_url+'admin/ajax_data',
data:'action=update_inr_rate',
type:'POST',
success:function(json){
json = JSON.parse(json);
$.toast({ heading: "Success", text: 'Rates Updated', icon:'success', loader: true, loaderBg: "#9EC600" });
$("#inr_rate").val(json.rate);
}
});
});

$(".check_seller_last_response").click(function(){
$.ajax({
url:'/admin/ajax_data',
data:'action=seller_last_response&'+$(this).attr("data-action"),
type:'POST',
success:function(json){
json = JSON.parse(json);
$(".modal-title").html('Seller Last Response<br/><div class="label label-api">'+json.api_url+'</div>');
$(".modal-body").html(json.body);
}
});
});


$("#set_total_orders_pattern").click(function(){
var prefix = $("#total_orders_prefix").val();
var suffix = $("#total_orders_suffix").val();
$.ajax({
url:site_url+'admin/settings/site_count/total_orders_pattern',
data:'total_orders_prefix='+prefix+'&total_orders_suffix='+suffix,
type:'POST',
success:function(response){
    iziToast.show({
    icon:'fa fa-check',
    title: 'Changes saved.',
    message: '',
    color:'green',
    position:'topCenter'
});
}
});
});



$("#choose_currency").change(function(){
$code = $(this).val();
$ht = $("#choose_currency > option:selected").html();
$("#site_currency_btn").attr("data-href","<?php echo site_url("admin/settings/currency-manager");?>/"+$code+"");
$("#site_currency_btn").html("Set Currency to "+$ht.replace("(Recommended for International Users)","").replace("(Recommended for Indian Users)","")+" ("+$code+")");
});



$("#enable-light-mode").click(function(){
$.ajax({
url:site_url+'admin/ajax_data',
data:'action=enable-light-mode',
type:'POST',
success:function(resp){
window.location.reload();
}
});
});

$("#enable-dark-mode").click(function(){
$.ajax({
url:site_url+'admin/ajax_data',
data:'action=enable-dark-mode',
type:'POST',
success:function(resp){
window.location.reload();
}
});
});


$(".currency-values-save-changes").click(function(e){
e.preventDefault();
$form = $(this).parent().parent().parent().parent().find("form");
$data = $form.serialize();


$.ajax({
url:site_url+'admin/settings/currency-manager',
data:'action=currency-values-save-changes&'+$data,
type:'POST',
success:function(json){
iziToast.show({
    icon:'fa fa-check',
    title: 'Changes saved.',
    message: '',
    color:'green',
    position:'topCenter'
});
}
});
});

$("#activate_deactivate_curr_conv").click(function(){
$.ajax({
url:site_url+'admin/settings/currency-manager',
data:'action=activate_deactivate_curr_conv',
type:'POST',
success:function(json){
iziToast.show({
    icon:'fa fa-check',
    title: 'Success',
    message: '',
    color:'green',
    position:'topCenter'
});
}
});
});




$("#rate_update_switch").click(function(){
$.ajax({
url:site_url+'admin/settings/currency-manager',
data:'action=rate_update_switch',
type:'POST',
success:function(json){
iziToast.show({
    icon:'fa fa-check',
    title: 'Success',
    message: '',
    color:'green',
    position:'topCenter'
});
}
});
});
$("#update-rates").click(function(){
$.ajax({
url:site_url+'admin/settings/currency-manager',
data:'action=update_rates',
type:'POST',
success:function(json){
iziToast.show({
    icon:'fa fa-check',
    title: 'Currency Rates Updated.',
    message: '',
    color:'green',
    position:'topCenter'
});
}
});
});


$("#next_order_id_value_btn").click(function(){
var oid = $("#next_order_id_value").val();
$.ajax({
url:site_url+'admin/ajax_data',
data:'action=next_order_id&order_id='+oid,
type:'POST',
success:function(resp){
var resp = JSON.parse(resp);
if(resp.success == 1){
iziToast.show({
    icon:'fa fa-check',
    title: resp.message,
    message: '',
    color:'green',
    position:'topCenter'
});
} else {
iziToast.show({
    icon:'fa fa-times',
    title: resp.message,
    message: '',
    color:'red',
    position:'topCenter'
});
}
}
});
});

$(".delete-currency").click(function(){
var cur_id = $(this).attr("data-currency-id");
$.ajax({
url:site_url+'admin/settings/currency-manager',
data:'action=delete-currency&currency_id='+cur_id,
type:'POST',
success:function(resp){
iziToast.show({
    icon:'fa fa-check',
    title: 'Currency Deleted Successfully.',
    message: '',
    color:'green',
    position:'topCenter'
});
window.location.reload();
}
});
});


$(document).on("click",".category-visible",function(){
;
var element = $(this);
$.ajax({
url:'admin/ajax_data',
data:'action=category_disable&'+$(this).data("post"),
type:'POST',
success:function(resp){
var resp = JSON.parse(resp);
element.replaceWith(resp.content);
}
});
});



$(document).on("click",".category-invisible",function(){
var element = $(this);
$.ajax({
url:'admin/ajax_data',
data:'action=category_enable&'+$(this).data("post"),
type:'POST',
success:function(resp){
var resp = JSON.parse(resp);
element.replaceWith(resp.content);

}
});
});



$("#modalDiv").on('shown.bs.modal', function() {
  $('#custom-payment-content').summernote({
height: 300,
tabsize: 2
});
});

$(".service-sortable").sortable({
handle: '.handle',
items : '> .ui-state-default',
animation:200,
opacity: 0.75,
revert: 50,
update: function(event, ui) {
var array = [];
$(this).find('tr').each(function(i) {
$(this).attr('data-line',i+1);
var params = {};
params['id']   = $(this).attr('data-id');
params['line'] = $(this).attr('data-line');
array.push(params);
});
$.post(site_url+'admin/ajax_data',{action:'service-sortable',services:array});
}
});

$(".methods-sortable").sortable({
handle: '.handle',
update: function(event, ui) {
var array = [];
$(this).find('tr').each(function(i) {
$(this).attr('data-line',i+1);
var params = {};
params['id']   = $(this).attr('data-id');
params['line'] = $(this).attr('data-line');
array.push(params);
});
$.post(site_url+'admin/ajax_data',{action:'paymentmethod-sortable',methods:array});
}
});

$(".category-sortable").sortable({
handle: '.handle',
items : '> .categories',
animation:200,
opacity: 0.75,
revert: 100,
update: function(event, ui) {
var array = [];
$(this).find('.categories').each(function(i) {
$(this).attr('data-line',i+1);
var params = {};
params['id']   = $(this).attr('data-id');
params['line'] = $(this).attr('data-line');
array.push(params);
});
$.post(site_url+'admin/ajax_data',{action:'category-sortable',categories:array});
}
});

});
$(function () {
$('[data-toggle="tooltip"]').tooltip()
});
<?php if( route(2) == "themes" && route(3) ): ?>
(function () {
var codeMirroSetting = {},
codeType = '<?=$codeType;?>';

switch (codeType){
case 'twig':
codeMirroSetting = {
mode : "text/html",
lineNumbers : true,
profile: 'xhtml',
lineWrapping: true,
extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
foldGutter: true,
gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
onKeyEvent: function(i, e) {
// Hook into F11
if ((e.keyCode == 122 || e.keyCode == 27) && e.type == 'keydown') {
e.stop();
return toggleFullscreenEditing();
}
},
};
break;
case 'css':
codeMirroSetting = {
mode : "text/css",
lineNumbers : true,
lineWrapping: true,
extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
foldGutter: true,
gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
onKeyEvent: function(i, e) {
// Hook into F11
if ((e.keyCode == 122 || e.keyCode == 27) && e.type == 'keydown') {
e.stop();
return toggleFullscreenEditing();
}
},
};
break;
case 'js':
codeMirroSetting = {
mode : "text/javascript",
lineNumbers : true,
lineWrapping: true,
extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
foldGutter: true,
gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
onKeyEvent: function(i, e) {
// Hook into F11
if ((e.keyCode == 122 || e.keyCode == 27) && e.type == 'keydown') {
e.stop();
return toggleFullscreenEditing();
}
},
};
break;
default:
codeMirroSetting = {
lineNumbers : true,
lineWrapping: true,
foldGutter: true,
gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
onKeyEvent: function(i, e) {
// Hook into F11
if ((e.keyCode == 122 || e.keyCode == 27) && e.type == 'keydown') {
e.stop();
return toggleFullscreenEditing();
}
},
};
break;
}

CodeMirror.fromTextArea(document.getElementById("code"), codeMirroSetting);

function toggleFullscreenEditing()
{
var editorDiv = $('.CodeMirror-scroll');
if (!editorDiv.hasClass('fullscreen')) {
toggleFullscreenEditing.beforeFullscreen = { height: editorDiv.height(), width: editorDiv.width() }
editorDiv.addClass('fullscreen');
editorDiv.height('100%');
editorDiv.width('100%');
editor.refresh();
editorDiv.append('<div class="fullscreen-blockFull"><a href="#" class="btn btn-sm btn-default fullScreenButtonOff"><span class="fa fa-compress" style="font-size: 18px; position: absolute; left: 6px; top: 4px;"></span></a> </div>')
}
else {
editorDiv.removeClass('fullscreen');
editorDiv.height(toggleFullscreenEditing.beforeFullscreen.height);
editorDiv.width(toggleFullscreenEditing.beforeFullscreen.width);
editor.refresh();
$('.fullscreen-blockFull').remove();
}
}

$(document).on('click', '.fullScreenButton', function (e) {
toggleFullscreenEditing();
});
$(document).on('click', '.fullScreenButtonOff', function (e) {
toggleFullscreenEditing();
});
$(document).keyup(function(e) {
if (e.keyCode == 27 && $('.fullscreen').length >= 1) {
toggleFullscreenEditing();
}
});
})();
<?php endif; ?>


</script>
  

</body>
</html>
