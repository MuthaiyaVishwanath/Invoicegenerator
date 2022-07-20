<?php 

require ("fpdf184/fpdf.php");
require ("letter.php");
require "config.php"; 
// require ("vascominvoice.php");

$reciver_details = [
    "recivername"=>"",
    "address"=>"",
    "city"=>"",
    "invoice_no"=>"",
    "invoicedate"=>"",
    "gstno"=>"",
    "words"=>"",
];
$con=mysqli_connect("localhost","root","","vascominvoice");

$sql="select * from invoice where id='{$_GET["id"]}'";
$res=$con->query($sql);
  if($res->num_rows>0){
	  $row=$res->fetch_assoc();
    $obj=new IndianCurrency($row["Maintotal"]);
      $reciver_details = [
         "recivername"=>$row["username"],
         "address"=>$row["address"],
         "city"=>$row["city"],
         "invoice_no"=>$row["invoiceno"],
         "invoicedate"=>$row["invoice_date"],
         //"gstno"=>$row["GST"],
         "words"=> $obj->get_words(),
];
      
  }
  
      
         
$product_details= [];

$sql = "select * from invoice_products where SID={$_GET['id']}";
 $res=$con->query($sql);
  if($res->num_rows>0){
    $obj=new IndianCurrency($row["Maintotal"]);
	  while($row=$res->fetch_assoc()){
		   $product_details[]=[
			"name"=>$row["PNAME"],
			"price"=>$row["PRICE"],
			"quantity"=>$row["QTY"],
			"total"=>$row["TOTAL"],
		   ];
	  }
  }

class PDF extends FPDF {
      
    function header(){
        $this->image('logo.png',3,0,75);
        $this->SetY(20);
        $this->SetFont('Arial','B',16);
        $this->cell(50,10,"Vascom",0,1);
        $this->SetFont('Arial','',16);
        $this->cell(50,8,"pitchu street,mylapore,",0,1);       
        $this->cell(50,7,"chennai-600004,",0,1);
        $this->cell(50,8,"PH:8838459548.",0,1);
        $this->SetY(15);
        $this->SetX(-40);
        $this->SetFont('Arial','B',18);
        $this->cell(50,8,"INVOICE",0,1);
        $this->Line(0,55,210,55);
    }
    function body($reciver_details,$product_details){
        $gTotal = 0;
        $this->SetY(55);
        $this->SetX(10);
        $this->SetFont('Arial','',15);
        $this->cell(50,10,"Bil To:",0,1);
        $this->SetFont('Arial','',13);
        $this->cell(50,7,$reciver_details["recivername"],0,1);
        $this->cell(50,7,$reciver_details["address"],0,1);
        $this->cell(50,7,$reciver_details["city"],0,1);
        //$this->cell(50,7,$reciver_details["gstno"],0,1);
        $this->SetY(55);
        $this->SetX(-55);
        $this->cell(50,10,"Invoice No : ".$reciver_details["invoice_no"],0,1);
        $this->SetY(62);
        $this->SetX(-55);
        $this->cell(50,10,"Invoice No : ".$reciver_details["invoicedate"],0,1);
        $this->SetY(95);
        $this->SetX(10);
        $this->SetFont('Arial','b',13);
        $this->cell(75,9,"  PRODUCT NAME",1,0);
        $this->cell(40,9,"PRICE",1,0,"C");
        $this->cell(40,9,"QUANTITY",1,0,"C");
        $this->cell(40,9,"TOTAL",1,1,"C");
        $this->SetFont('Arial','',13);
         foreach($product_details as $row){
        $this->Cell(75,9,$row["name"],"LR",0);
        $this->Cell(40,9,$row["price"],"R",0,"R");
        $this->Cell(40,9,$row["quantity"],"R",0,"C");
        $this->Cell(40,9,$row["total"],"R",1,"R");
             $gTotal += $row["total"];
      }
        for($i=0;$i<12-count($product_details);$i++){
             $this->cell(75,9,"","LR",0);//R-right border  for BORDER lR-LEFTRIGHTBORDER
            $this->cell(40,9,"","R",0,"R");
            $this->cell(40,9,"","R",0,"C");
            $this->cell(40,9,"","R",1,"R");    
        }
         $this->SetFont('Arial','b',13);
         $this->cell(155,10,"TOTAL",1,0,"R");
         $this->cell(40,10,$gTotal,1,0,"R");

      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,$reciver_details["words"],0,1);
    }
    function Footer(){
        $this->SetY(-50);
        $this->SetFont('Arial','b',13);
        $this->cell(0,10,"FOR VASCOM",0,1,"R");
        $this->Ln(20);
        $this->SetFont('Arial','',13);
        $this->cell(0,10,"Authorized Signature",0,1,"R");
        $this->SetFont('Arial','',8);
        $this->cell(0,10,"This is Vascom invoice generator",0,1,"C");
    }
}
$pdf = new PDF("p","mm","A4");
$pdf->ADDPage();
$pdf->body($reciver_details,$product_details);
$pdf->Output();

?>