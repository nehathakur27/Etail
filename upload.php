<?php
require 'dbconfig/config.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
require_once  $_SERVER['DOCUMENT_ROOT'] . '/excel/src/Bootstrap.php';
if(isset($_POST['upload'])){
    if (!empty($_FILES['files']['name']))
   {
       $pathinfo = pathinfo($_FILES["files"]["name"]);
       $inputFileType = $pathinfo['extension'] ;
       if (($inputFileType == 'xlsx' || $inputFileType == 'xls')&& $_FILES['files']['size'] > 0 )
       {
            $inputFileType = 'Xlsx';
            $inputFileName = $_FILES['files']['tmp_name'];
            $reader = IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);
            $sheetCount = $spreadsheet->getSheetCount();
            for ($i = 0; $i < $sheetCount; $i++) {
                $sheet = $spreadsheet->getSheet($i);
                $sheetData = $sheet->toArray(null, true, true, true);
                if($i == 0){
                    for($row = 2; $row <= count($sheetData); $row++)
                    {
                        $data = "'" . implode("','" , $sheetData[$row]) . "'";
                        $sql ="insert INTO master (sku,ain,qty,price) values(".$data.") ";
                        $query_run = mysqli_query($con,$sql);
                    }
                }
                else if($i==1){
                    for($row = 2; $row <= count($sheetData); $row++)
                    {
                        $data = "'" . implode("','" , $sheetData[$row]) . "'";
                        $sql ="insert INTO second (pid,price,qty) values(".$data.") ";
                        $query_run = mysqli_query($con,$sql);
                    }

                }

            }
            $query = "create table result as
             SELECT second.pid,master.sku,master.ain, second.price , second.qty
             FROM master
             INNER JOIN second ON master.sku LIKE concat('%',second.pid,'%')";
             $output='';
            $q_run = mysqli_query($con,$query);
            if($q_run){
                $sql = "select * from result";
                $res = mysqli_query($con,$sql);
                if(mysqli_num_rows($res) > 0){
                    $output .='
                    <table class="table">
                    <tr>
                       <th>ProductId</th>
                       <th>SKU</th>
                       <th>ASIN</th>
                       <th>Price</th>
                       <th>Quantity</th>
                    </tr> ';
                    while($r = mysqli_fetch_array($res)){
                        $output .='
                        <tr>
                           <td>'.$r["pid"].'</td>
                            <td>'.$r["sku"].'</td>
                             <td>'.$r["ain"].'</td>
                              <td>'.$r["price"].'</td>
                               <td>'.$r["qty"].'</td>
                            </tr>
                           ';
                    }
                    $output .='</table>';
                    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename="file.xls"');
                    echo $output;
                }
            }
            }else {
                echo(mysqli_error($con));
            }

            }

       else{
           echo "Please Select Valid Excel File";
       }
  }
?>
