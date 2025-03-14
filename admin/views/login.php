<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>WT Official Rental</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
  <link rel="stylesheet" type="text/css" href="style.css"> 
  <style>
@charset "utf-8";* {box-sizing: border-box;margin: 0;padding: 0;}
html {font-size: 16px;}
body {font-family: Arial, sans-serif;}
#container {display: flex;justify-content: center;align-items: center;position: relative;width: 100%;height: 100vh;padding: 10px;background: linear-gradient(135deg, #f4d951, #f85858);overflow: hidden scroll;}
@media (min-width:991px){.box{min-width: 335px;padding-bottom:20px;}}
.box {display: flex;justify-content: center;align-items: center;position: relative;width: 100%;max-width: 310px;height: auto;margin: auto;}
.form-box {display: flex;flex-direction: column;justify-content: center;align-items: center;position: relative;z-index: 999;width: 100%;padding: 20px 20px;border: solid 1px rgba(255, 255, 255, .5);border-radius: 26px;box-shadow: 4px 4px 10px rgba(0, 0, 0, .1),-4px -4px 10px rgba(0, 0, 0, .1);background-color: rgba(255, 255, 255, .4);-webkit-backdrop-filter: blur(15px);backdrop-filter: blur(15px);}
.ic-account {width: 95px;height: 95px;border-radius: 50%;background-color: rgba(255, 255, 255, .99);background-image: url(../img/admin/Nitesh.png);background-position: center;background-size: 90px;background-repeat: no-repeat;position:relative;margin-bottom:-45px;top:-60px;border: solid 1px rgba(255, 255, 255, .5);box-shadow: -4px -4px 10px rgba(0, 0, 0, .1);}
.login-form-input {padding-left:8px;border: none;background-color: rgb(255 255 255 / 0%);display:flex;align-items:center;width: 100%;height: 50px;color: #fff;font-size: 1rem;outline: none;}
.login-form-input::placeholder {color: rgba(255, 255, 255, .8);}
.two_factor_input::placeholder {font-size: 10px;}
.login-form-btn {width: 100%;height: 50px;margin: 20px auto 10px;border: none;border-radius: 14px;background-color: rgba(255, 255, 255, .35);color: #fff;font-size: 1.25rem;outline: none;cursor: pointer;box-shadow: 4px 4px 10px rgba(0, 0, 0, .1);border: solid 1px rgba(255, 255, 255, .25);}
.text {margin: 0;padding: 0;color: #fff;font-size: 14px;text-align: center;}
.text a {color: #fff;}
.input-field:hover,.login-form-btn:hover,.text a:hover {opacity: .8;}
.input-field{display:flex;align-items:center;width: 100%;height: 50px;margin: 18px auto;border: solid 1px rgba(255, 255, 255, .25);border-radius: 15px;background-color: rgba(255, 255, 255, .12);color: #fff;font-size: 1rem;outline: none;box-shadow: 4px 4px 10px rgba(0, 0, 0, .1);overflow:hidden;}
.input-field i{background-color: rgba(255, 255, 255, .2);border-top-left-radius: 15px;border-bottom-left-radius: 15px;padding:17px;box-shadow: 2px 0px 15px rgba(0, 0, 0, .05);}
.form-check-input{border: solid 1px rgba(255, 255, 255, .25);background-color: rgba(255, 255, 255, .25);}
.form-check{margin-left:24%;}
.form-check-input:focus{box-shadow:0px 0px 5px rgba(255, 255, 255, .85);border: solid 1px rgba(255, 255, 255, .8);}
.form-check-input:checked {background-color: rgba(255, 255, 255, .5);border: solid 1px rgba(255, 255, 255, .8);}
.alert{border-radius: 18px;margin-top:5px;margin-bottom:-3px;border: 1px solid #ff707f;color:#fff;background-color: #ff001787;}
</style> 
  </head>
  <body>
    



<div id="container"> 
   <div class="box"> 
    <div class="form-box"> 
     <?php 
     // Initialize variables if not set
     $success = $success ?? false;
     $error = $error ?? false;
     $successText = $successText ?? '';
     $errorText = $errorText ?? '';
     ?>
     
     <?php if($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($successText); ?></div>
     <?php endif; ?>

     <?php if($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errorText); ?></div>
     <?php endif; ?>

     <form name="login-form" action="" method="post"> 
      <div class"input-group"=""> 
       <div class="input-field"> 
        <i class="fa-solid fa-user"></i> 
        <input class="login-form-input" type="username" name="username" placeholder="Enter Username..." required> 
       </div>
      </div> 
      <div class"input-group"=""> 
       <div class="input-field"> 
        <i style="padding:17px 16px;" class="fa-solid fa-key"></i> 
        <input class="login-form-input" type="password" name="password" placeholder="Password" required> 
       </div>
      </div> 
      <div class"input-group"=""> 
       <div class="input-field"> 
        <i class="fa-solid fa-unlock"></i> 
        <input class="login-form-input two_factor_input" type="number" name="two_factor_code" placeholder="Enter Code from Authenticator App (If Setup)"> 
       </div>
      </div> 
      <div class="form-check"> 
       <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1"> 
       <label class="form-check-label" for="exampleCheck1" style="color:#ffffffe4;">Remember me</label> 
      </div> 
      <button class="login-form-btn" type="submit"><i style="margin-right:5px;font-size:17px;" class="fa-sharp fa-solid fa-shield"></i>Login</button> 
     </form> 
    </div> 
   </div> 
  </div> 