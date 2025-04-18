function category_detail(){

  var category_now = $("#neworder_category").val();


$.ajax({
url:'/ajax_data',
data:'action=services_list&category='+category_now,
type:'POST',
success:function(json){
json = JSON.parse(json);
$("#neworder_services").html(data.services);
service_detail();
$("#neworder_services").trigger("change");
}
});
}

function service_detail(){
  var service_now = $("#neworder_services").val();
  $.post('ajax_data',{action:'service_detail',service:service_now}, function(data){
      if( data.empty == 1 ){
        $("#charge_div").hide();
      }else{
        $("#charge_div").show();
        $("#neworder_fields").html(data.details);
        $("#charge").val(data.price);
      }
      
       var dripfeed = $("#dripfeedcheckbox").prop('checked');
       if( dripfeed ){
         $("#dripfeed-options").removeClass();
       }
       comment_charge();
        if( $("#dripfeedcheckbox").prop('checked') ){
          dripfeed_charge();
        }
          if( data.sub ){
            $("#charge_div").hide();
          }else{
            $("#charge_div").show();
          }
  }, 'json');
}

function comment_charge(){
  var service   = $("#neworder_services").val();
  var comments  = $("#neworder_comment").val();
    if( comments ){
      $.post('ajax_data',{action:'service_price',service:service,comments:comments}, function(data){
          $("#neworder_quantity").val(data.commentsCount);
          $("#charge").val(data.price);
      }, 'json');
    }
}

function dripfeed_charge(){
  var service     = $("#neworder_services").val();
  var quantity    = $("#neworder_quantity").val();
  var runs        = $("#dripfeed-runs").val();
    if( $("#dripfeedcheckbox").prop('checked') ){
      var dripfeed  = "var";
    }else{
      var dripfeed  = "bos";
    }
  $.post('ajax_data',{action:'service_detail',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
      $("#charge").val(data.price);
  }, 'json');
}

$(document).ready(function(){
 
category_detail();
  $("#neworder_category").change(function(){
    category_detail();
  });
  /* Katogeriye ait servisleri ÃƒÂ§ek */
  /* Servise ait verileri ÃƒÂ§ek */
  $("#neworder_services").change(function(){
    service_detail();
  });
  /* Servise ait verileri ÃƒÂ§ek */
  /* SipariÃ…Å¸ miktarÃ„Â± deÃ„Å¸iÃ…Å¸ince fiyat hesapla */
  $(document).on('keyup', '#order_quantity', function() {
    var service   = $("#neworder_services").val();
    var quantity  = $("#neworder_quantity").val();
    var runs      = $("#dripfeed-runs").val();
      if( $("#dripfeedcheckbox").prop('checked') ){
        var dripfeed  = "var";
      }else{
        var dripfeed  = "bos";
      }
    $.post('ajax_data',{action:'service_price',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
        $("#charge").val(data.price);
        $("#dripfeed-totalquantity").val(data.totalQuantity);
    }, 'json');
  });
  $(document).on('keyup', '#dripfeed-runs', function() {
    var service   = $("#neworder_services").val();
    var quantity  = $("#neworder_quantity").val();
    var runs      = $("#dripfeed-runs").val();
      if( $("#dripfeedcheckbox").prop('checked') ){
        var dripfeed  = "var";
      }else{
        var dripfeed  = "bos";
      }
    $.post('ajax_data',{action:'service_price',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
        $("#charge").val(data.price);
        $("#dripfeed-totalquantity").val(data.totalQuantity);
    }, 'json');
  });
  $(document).on('keyup', '#neworder_comment', function() {
    comment_charge();
  });
  /* SipariÃ…Å¸ miktarÃ„Â± deÃ„Å¸iÃ…Å¸ince fiyat hesapla */
  /* Dripfeed deÃ„Å¸iÃ…Å¸tir */
  $(document).on('change', '#dripfeedcheckbox', function() {
    var dripfeed = $(this).prop('checked');
    if( dripfeed ){
      $("#dripfeed-options").removeClass();
      dripfeed_charge();
    }else{
      $("#dripfeed-options").addClass('hidden');
      dripfeed_charge();
    }
  });
  /* Dripfeed deÃ„Å¸iÃ…Å¸tir */

$(".currencies-item").click(function(){
var key = $(this).attr("data-rate-key");
var sym = $(this).attr("data-rate-symbol");
$.ajax({
url:'/account/change_currency',
data:'rate_key='+key+'&sym='+sym,
type:'POST',
success:function(resp){
window.location.reload();
}
});
});
});


function funBroadcast() {
    $.ajax({
        url: "/broadcast/",
        type: 'GET',
        success: function(data) {
            data = JSON.parse(data);
            if (data.id != "undefined") {
                var div = document.createElement("div");
                div.innerHTML = data.BROADCAST_DESCRIPTION;
                swal({
                    title: data.BROADCAST_TITLE,
                    content: div,
                    icon: data.BROADCAST_ICON,
                    allowOutsideClick: false,
                    button: 'Ok!',
                    width: '650px'
                }).then((result) => {
                    funBroadcast()
                })
            }
        }
    })
}
$(document).ready(function() {
    funBroadcast();
    $("#randomize_password").click(function(){
var input = $("#childpanel_admin_password");
var  input2 = $("#childpanel_admin_confirm_password");
var pass = password_generator(15);
input.val(pass);
input2.val(pass);
});
});


function category_detail() {
    var category_now = $("#neworder_category").val();
    $.post('ajax_data', {
        action: 'services_list',
        category: category_now
    }, function(data) {
        $("#neworder_services").html(data.services);
        
       /* var x = $("#neworder_services > option:selected").html();
        $("#neworder_services > option").each(function() {
            var text = $(this).html();
            var icon = ikon(text);
            $(this).attr("data-icon", icon)
        });
        $("#neworder_services > option:selected").attr("data-icon", ikon(x));*/
        $("#neworder_services").trigger("change");
        service_detail();
    }, 'json')
}

function service_detail() {
    var service_now = $("#neworder_services").val();
    $.post('ajax_data', {
        action: 'service_detail',
        service: service_now
    }, function(data) {
        if (data.empty == 1) {
            $("#charge_div").hide()
        } else {
            $("#charge_div").show();
            $("#neworder_fields").html(data.details);
            $("#charge").val(data.price)
        }
        $(".datetime").datepicker({
            format: "dd/mm/yyyy",
            language: "tr",
            startDate: new Date(),
        }).on('change', function(ev) {
            $(".datetime").datepicker('hide')
        });
        $("#clearExpiry").click(function() {
            $("#expiryDate").val('')
        });
        var dripfeed = $("#dripfeedcheckbox").prop('checked');
        if (dripfeed) {
            $("#dripfeed-options").removeClass()
        }
        comment_charge();
        if ($("#dripfeedcheckbox").prop('checked')) {
            dripfeed_charge()
        }
        if (data.sub) {
            $("#charge_div").hide()
        } else {
            $("#charge_div").show()
        }
    }, 'json')
}

function comment_charge() {
    var service = $("#neworder_services").val();
    var comments = $("#neworder_comment").val();
    if (comments) {
        $.post('ajax_data', {
            action: 'service_price',
            service: service,
            comments: comments
        }, function(data) {
            $("#neworder_quantity").val(data.commentsCount);
            $("#charge").val(data.price)
        }, 'json')
    }
}

function dripfeed_charge() {
    var service = $("#neworder_services").val();
    var quantity = $("#neworder_quantity").val();
    var runs = $("#dripfeed-runs").val();
    if ($("#dripfeedcheckbox").prop('checked')) {
        var dripfeed = "var"
    } else {
        var dripfeed = "bos"
    }
    $.post('ajax_data', {
        action: 'service_detail',
        service: service,
        quantity: quantity,
        dripfeed: dripfeed,
        runs: runs
    }, function(data) {
        $("#charge").val(data.price)
    }, 'json')
}



function copyToClipboard(text) {

    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}

function password_generator( len ) {
    var length = (len)?(len):(10);
    var string = "abcdefghijklmnopqrstuvwxyz"; //to upper 
    var numeric = '0123456789';
    var punctuation = '!@#$%^&*()_+|}{[]\:;?><,./-=';
    var password = "";
    var character = "";
    var crunch = true;
    while( password.length<length ) {
        entity1 = Math.ceil(string.length * Math.random()*Math.random());
        entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
        entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
        hold = string.charAt( entity1 );
        hold = (password.length%2==0)?(hold.toUpperCase()):(hold);
        character += hold;
        character += numeric.charAt( entity2 );
        character += punctuation.charAt( entity3 );
        password = character;
    }
    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');
    return password.substr(0,len);
}


