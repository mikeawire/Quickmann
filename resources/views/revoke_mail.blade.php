
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
      @laravelPWA
  </head>
  <body>
         <div><h1>Quickmann Product Revoke Notification</h1> </div>
    <div><img src="https://quickmann.app/images/bg-3.jpeg" width="50px;" height="50px"> </div>
    
  
     
     <div style="width:100%;">
         
    <h5>Dear {{ ucwords($full_name) }}  </h5>
    <p>This is to notify you that the Plot with Plot ID: {{$plot_id}} ,Location Name: {{$location_name}} has been withdraw from you due to your inability to meet up with the monthly installment.</p>
    
    <p><b>Contact Your Direct Relationship Manager For More Information</b></p>
   
    </div >
    <div style="background:#000; color:#fff; padding:10px;"><p>Please neglet  this information if you do not subscribe to it</p></div>
    
  </body>
</html>
