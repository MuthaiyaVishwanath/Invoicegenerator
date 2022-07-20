<DOCTYPE HTML>
<html>
    <head>
    
    <title>VascomInvoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        

        
<style>
  *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    /* background-image: linear-gradient(to right,lightblue,red); */
  }
  body {
  width: 100%;
  align-items: center;
  background-image: linear-gradient(to right,lightblue,red);
  display: grid;
  grid-column-gap: 3rem;
  grid-template-columns: 200px;
  height: 100vh;
  justify-content: center;
  padding: 1rem;
}
   

.element {
  align-items: center;
  /* background: linear-gradient(-45deg, rgba(0,0,0,0.22), rgba(255,255,255,0.25)); */
  background-image: linear-gradient(to right,lightblue,red);
  border-radius: 50px;
  display: flex;
  height: 100%;
  justify-content: center;
  width: 100%;
     background: linear-gradient(var(--bg-angle), var(--bg-start), var(--bg-end));
}

.element-1 {
  border-radius: 10px;
background: linear-gradient(145deg, #921d1d, #ad2222);
/* background-image: linear-gradient(to right,lightblue,red); */
box-shadow:  8px 5px 30px #9f1f1f,
             -8px -5px 30px #a52121;
}

.element-2:hover {
  cursor: pointer;
  box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;
  box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #fff;
}

.element-3 {
    width: 100%;
    height: 80%;
   background: linear-gradient(145deg, #cacaca, #f0f0f0); 
  /* background-image: linear-gradient(to right,lightblue,red); */
box-shadow:  5px 5px 14px #b1b1b1,
             -5px -5px 14px #ffffff;
}

.element-4 {
border-radius: 30px;
 background: #4320a2; 
/* background-image: linear-gradient(to right,lightblue,red); */
box-shadow: inset 17px 17px 34px #33187b,
            inset -17px -17px 34px #5328c9;
}
@media (min-width: 1200px) {
  body {
    grid-template-columns: 230vh 50px;
  }
}
@media (min-width: 600px) {
  body {
    grid-template-columns: 230vh 0px;
  }
}
    .el{
        position: absolute;
        text-align: center;
   
        justify-content: center;
        width: 85%;
   text-transform: uppercase;
  background-image: linear-gradient(
    -225deg,
    #231557 0%,
    #44107a 29%,
    #ff1361 67%,
    #fff800 100%
  );
         background-size: auto auto;
  background-clip: border-box;
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  text-fill-color: transparent;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 2s linear infinite;
  display: inline-block;
      font-size: 35px;
        margin-top: 10px;
        
    }
 @keyframes textclip {
  to {
    background-position: 200% center;
  }
}
 
</style>
    
    </head>
    
    <body class="p-3 element">
          <div class="element-3" > 
     <h4 class="el">VASCOM INVOICE</h4>
     <?php
        $con=mysqli_connect("localhost","root","","vascominvoice");
        if(!$con){
          echo "not connected";
        }
        if(isset($_POST["submit"])){
          $invoice_no=$_POST["invoice_no"];
          $invoice_date=date("Y-m-d",strtotime($_POST["invoice_date"]));
          $cname=mysqli_real_escape_string($con,$_POST["cname"]);
          $caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
          $ccity=mysqli_real_escape_string($con,$_POST["ccity"]);
          $grand_total=mysqli_real_escape_string($con,$_POST["grand_total"]);
          if($invoice_no==0||$invoice_date==""||$cname==""||$caddress==""||$caddress==""||$ccity==""){
            $errinvo= "Enter Valid Number";
          }else{ 
          $sql="insert into invoice (invoiceno,invoice_date,username,address,city,Maintotal	) values ('{$invoice_no}','{$invoice_date}','{$cname}','{$caddress}','{$ccity}','{$grand_total}') ";
          if($con->query($sql)){
            $id=$con->insert_id;
            
            $sql2="insert into invoice_products (SID,PNAME,PRICE,QTY,TOTAL) values ";
            $rows=[];
            for($i=0;$i<count($_POST["name"]);$i++)
            {
              $name=mysqli_real_escape_string($con,$_POST["name"][$i]);
              $price=mysqli_real_escape_string($con,$_POST["price"][$i]);
              $qty=mysqli_real_escape_string($con,$_POST["qty"][$i]);
              $total=mysqli_real_escape_string($con,$_POST["total"][$i]);
              $rows[]="('{$id}','{$name}','{$price}','{$qty}','{$grand_total}')";
            }
            $sql2.=implode(",",$rows);
            if($con->query($sql2)){
              echo "<div class='alert alert-success'>Invoice Added Successfully. <a href='pdfinvoice.php?id={$id}' target='_BLANK'>Click </a> here to Print Invoice </div> ";
            }else{
              echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
            }
          }else{
            echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
          }
        }
        }
        
      ?>
    <div id="container" class="container pt-5 text-white">
        <form action="vascominvoice.php" method="post" autocomplete="off" class="pt-4">
        <div class="row text-dark">
        <div class="col-md-4 element-2 element-3">
            <div class="form-group">
               <h4 class="text-primary">INVOICE DETAILS:</h4> 
               <label>Invoice No</label>
               <input type="number" name="invoice_no" class="form-control" required>
               <span class="text-danger"><?php if(isset($_POST['submit'])){if($invoice_no==0){
                 echo "*Enter Valid Number";
          } }?></span>
                </div>
                <!-- muthaiyavishwanath -->
            <div class="form-group">
              <label>Invoice Date:</label>
              <input type="date" name="invoice_date" required class="form-control">
              <span class="text-danger"><?php if(isset($_POST['submit'])){if($invoice_no==0){echo "*Enter Invoice Date";} }?></span>
            </div>
            <div class="form-group">
              
            </div>
            
            </div>
        <div class="col-md-8 element-2 element-3">
            <h4 class="text-primary">CUTOMER DETAILS:</h4>
            <div class="form-group">
               <label>Customer Name</label>
               <input type="text" pattern="(?=.*[a-z]).{5,}" name="cname" required class="form-control">
                </div>
            <div class="form-group">
               <label>Address</label>
               <input type="address" name="caddress" required class="form-control">
                </div>
            <div class="form-group">
               <label>City</label>
               <input type="text" name="ccity" required class="form-control">
                </div>
            </div>
         </div> <br>
            <div class="row ">
            <div class="col-md-12">
                <h4 class="display-5 text-dark">PRODUCT DETAILS:</h4>
                <table class="table table-bordered element-3 element-2">
                    <thead>
                    <th>Description:</th>
                    <th>Price</th>
                    <th>QTY</th>
                    <th>Total</th>
                    <th>Action</th>    
                    </thead>
                    <tbody id='addbinbody'>
                        <tr>
                        <td><input type='text' required name="name[]" class='form-control'></td>
                        <td><input type='text'  name="price[]" class='form-control price'></td>
                        <td><input type='number' required name="qty[]" class='form-control qty'></td>
                        <td><input type='text' required name="total[]" class='form-control total'></td>
                        <td><input type='button' value='x' class='btn btn-danger btn-sm buttonremove'> </td>
                        </tr>
                     </tbody>
                    <tfoot>
                     <tr>
                        <td><button class="btn btn-primary" type="button" id='addrow'>Add Row</button>
                         </td>
                        <!-- <td colspan="2" class="text-right font-weight-bold">GST</td>   
                        <td><input name="gst" id="gst" required class="form-control gst" type="text"></td></tr> -->
                        <td colspan="3" class="text-right"><b>Total:</b></td> 
                        <td><input name="grand_total" id="grand_total" required class="form-control grand_total" type="text"></td>
                        <!-- <tr>
                         <td colspan="3" class="text-right"><b>Total:</b></td>
                         <td><input name="grand_total" id="grand_total" required class="form-control grand_total" type="text"></td>
                             </tr> -->
                        
                    </tfoot>
                </table>
                 <button type="reset" class="btn btn-danger element-1">Reset</button>
                <button class="btn  float-right element-2" type="submit" name="submit">save</button>

                </div>
            </div>
            </form>
        </div></div>
    <script>
        $(document).ready(function(){
        $("#addrow").click(function(){
            var row = "<tr> <td><input type='text' required name='name[]' class='form-control'></td> <td><input type='text' required name='price[]' class='form-control price'></td> <td><input type='number' required name='quantity[]' class='form-control qty'></td> <td><input type='text' required name='total[]' class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm buttonremove'> </td> </tr>";
                $("#addbinbody").append(row);
        });
        $("body").on("click",".buttonremove",function(){
            if(confirm("You wnat to remove the row")){
            $(this).closest("tr").remove();
            maintotal();}
        });
        $("body").on("keyup",".price",function(){
        var price = ($(this).val()); 
        var quantity = ($(this).closest("tr").find(".qty").val());   
       // var gst = ($(this).closest("tfoot").find(".gst").val());    
            $(this).closest("tr").find(".total").val(price*quantity);
            maintotal();
        });    
        $("body").on("keyup",".qty",function(){
        var quantity = ($(this).val()); 
        var price = ($(this).closest("tr").find(".price").val());
       // var gst = ($(this).closest("tfoot").find(".gst").val());    
            $(this).closest("tr").find(".total").val(price*quantity);
            maintotal();
        });
            // $("body").on("keyup",".gst",function(){
           
        //  var tot=document.getElementsByClassName(".total").val();
        //  var gst =document.getElementsByClassName(".gst").val(tot);
        //         gst=tot;
        //    $(this).find("#grand_total").val(gst);
            
        // });
        function maintotal(){
            var total=0;
            $(".total").each(function(){
            total += $(this).val();    
            });
            $("#grand_total").val(total*118/100);
        }})
        //$(".buttonremove").click(function(){
          //  $(this).closest("tr").remove();
        //});
        const reload = document.getElementById("reload");
           reload.addEventListener('click', ()=>{
            reload.reload();
        })
        </script>
    </body>
    
    
    
    
    
    
    
    
    
    
    
    
    </html>