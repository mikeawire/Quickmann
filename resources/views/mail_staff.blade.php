
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
      @laravelPWA
  </head>
  <body>
         <div><h1>Quickmann Staff Registration Notification</h1> </div>
    <div><img src="https://quickmann.app/images/bg-3.jpeg" width="50px;" height="50px"> </div>
    
  
     
     <div style="width:100%;">
         
    <h5>Dear {{ ucwords($email) }}  </h5>
    <p>This is to notify you that your quickmann Staff registration was successful.</p>
    
    <p>Follow the link <a href="https://quickmann.app/register">https://quickmann.app/register</a>  generate your login details in quickmann staff portal </p>
    <p>Your Access Code is {{$access_code}}</p>
    <p>Do not disclose this code to any third party</p>
    
    </div >
    <div style="background:#000; color:#fff; padding:10px;"><p>Please neglet  this information if you do not subscribe to it</p></div>
    
  </body>
</html>
