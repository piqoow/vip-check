<html>
  <head>
    <title>POST</title>
  <script src="https://code.jquery.com/jquery-latest.js"></script>
  <script>
    //V2 ENPOINTS
    function submit_customsearchv2(){
      var effective_start_date=$("#effective_start_date").val();
      var effective_end_date=$("#effective_end_date").val();
      var location_code=$("#location_code").val();
      $.post("store_customsearchv2.php",{effective_start_date:effective_start_date,effective_end_date:effective_end_date,location_code:location_code},
      function(data){
        $("#json_response").html(data);
      });
    }
    function submit_quantityv2(){
      var effective_start_date=$("#effective_start_date").val();
      var effective_end_date=$("#effective_end_date").val();
      var location_code=$("#location_code").val();
      $.post("store_quantityv2.php",{effective_start_date:effective_start_date,effective_end_date:effective_end_date,location_code:location_code},
      function(data){
        $("#json_response").html(data);
      });
    }
    function submit_incomev2(){
      var effective_start_date=$("#effective_start_date").val();
      var effective_end_date=$("#effective_end_date").val();
      var location_code=$("#location_code").val();
      $.post("store_incomev2.php",{effective_start_date:effective_start_date,effective_end_date:effective_end_date,location_code:location_code},
      function(data){
        $("#json_response").html(data);
      });
    }
    function submit_epaymentv2(){
      var effective_start_date=$("#effective_start_date").val();
      var effective_end_date=$("#effective_end_date").val();
      var location_code=$("#location_code").val();
      $.post("store_epaymentv2.php",{effective_start_date:effective_start_date,effective_end_date:effective_end_date,location_code:location_code},
      function(data){
        $("#json_response").html(data);
      });
    }
    function submit_stickerv2(){
      var effective_start_date=$("#effective_start_date").val();
      var effective_end_date=$("#effective_end_date").val();
      var location_code=$("#location_code").val();
      $.post("store_stickerv2.php",{effective_start_date:effective_start_date,effective_end_date:effective_end_date,location_code:location_code},
      function(data){
        $("#json_response").html(data);
      });
    }
    </script>
    
    </head>
    <body>
      <!-- <center> -->
    <!-- <fieldset style="width: 575px; height: 150px; max-width:100%;">
    <legend>Store Batch V2:</legend>
        Start Date    <input name="effective_start_date" id="effective_start_date" type="date"/> <br />
        End Date      <input name="effective_end_date" id="effective_end_date" type="date"/> <br />
        Location Code <input name="location_code" id="location_code" type="text"/> = BSH-T2 / BHS-T1<br />
        <input style="width: 140px; height: 30px;" type="button" value="CUSTOMSEARCH" onclick="submit_customsearchv2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST EPAYMENT" onclick="submit_epaymentv2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST INCOME" onclick="submit_incomev2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST QUANTITY" onclick="submit_quantityv2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST STICKERV2" onclick="submit_stickerv2()"/>
    </fieldset> -->
    <fieldset style="width: 600px; height: 140px; max-width:100%;">
    <legend>Store Batch V2:</legend>
    <!-- <p>Location Code </p> -->
        Start Date    <input name="effective_start_date" id="effective_start_date" type="date"/> <br />
        End Date      <input name="effective_end_date" id="effective_end_date" type="date"/> <br />
        Location Code <input name="location_code" id="location_code" type="text"/> = Sesuaikan Kode Lokasi<br />
        <input style="width: 140px; height: 30px;" type="button" value="POST EPAYMENT" onclick="submit_epaymentv2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST INCOME" onclick="submit_incomev2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST QUANTITY" onclick="submit_quantityv2()"/>
        <input style="width: 140px; height: 30px;" type="button" value="POST STICKER" onclick="submit_stickerv2()"/>
        <input style="width: 190px; height: 30px;" type="button" value="POST CUSTOMSEARCH" onclick="submit_customsearchv2()"/>
    </fieldset>
        <form action="index.php" method="post">
        <input type="submit" name="tombol_submit" value="Back to Home" style="width: 100px; height: 50px;">
        </form>
        
        <button onClick="window.location.href=window.location.href" style="width: 100px; height: 50px;">Clear Page</button>
    <br>
        
    <div id="json_response"></div>
  <!-- </center> -->

  
    </body>
    </html>

    <html>
    <head>
        <meta http-equiv="<?=$respon?>" content="<?=$waktu?>"/>
    </head>
    <body>
        <p align="center">PARKEE V2 CP ENDPOINT STATUS</p>
    </body>
</html>
<?php

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>KODE LOKASI</th><th>NAMA LOKASI</th><th>IP LOKASI</th><th>STATUS ENDPOINT</th><th>STATUS TERAKHIR</th></tr>";

class TableRowss extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='width:350px;height: 40px;border:1px solid black;text-align:center; font-size: 18px;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}

$servername = "110.0.100.71:3306";
$username = "root";
$password = "P@ssw0rdKu!23";
$dbname = "site-dashboard";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT kode_Lokasi, nama_Lokasi, ip_Lokasi, endpoint_status, update_status FROM ms_lokasi ml WHERE chisel_version = 'V2' order by endpoint_status, update_status desc");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRowss(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";

?>
