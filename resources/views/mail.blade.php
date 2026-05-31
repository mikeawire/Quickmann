
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
      @laravelPWA
  </head>
  <body>
         <div><h1>QuickMann Customer Registration</h1> </div>
    <div><img src="https://quickmann.app/images/bg-3.jpeg" width="50px;" height="50px"> </div>
    
  
     
     <div style="width:100%;">
         
    <h1>Dear {{ ucwords($surname) }} {{ ucwords($first_name) }}  {{ ucwords($othername) }} </h1>
    <p>This is to notify you that your QuickMann customer registration was successful.</p>
    
    <p>Follow the link <a href="https://quickmann.app/register_customer/create">https://quickmann.app/register_customer/create</a>  generate your login details in QuickMann customer portal </p>
    
    </div >
    <div style="background:#000; color:#fff; padding:10px;text-align:center;"><p>Please ignore  this information if you do not subscribe for it</p></div>
    
  </body>
</html>
