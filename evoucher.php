<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

function getLogin(){
    $url = "https://www.epsonconnect.com/user/Auth/authenticate";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Host: www.epsonconnect.com",
       "Cookie: _ga=GA1.2.34629800.1672023010; epsonconnect_lang=en; __atssc=google%3B3; epsonconnect_email=bagus.iqbal%40makanantradisi.com; __atuvc=9%7C52; _gid=GA1.2.822307752.1672634400; _gat=1",
       'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
       "accept: application/json, text/plain, */*",
       "content-type: application/json;charset=UTF-8",
       "sec-ch-ua-mobile: ?0",
       "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36",
       'sec-ch-ua-platform: "Windows"',
       "origin: https://www.epsonconnect.com",
       "sec-fetch-site: same-origin",
       "sec-fetch-mode: cors",
       "sec-fetch-dest: empty",
       "referer: https://www.epsonconnect.com/user",
       "accept-language: en-US,en;q=0.9",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = "mailaddress=bagus.iqbal%40makanantradisi.com&password=089666262920";
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    // Aktifkan opsi CURLOPT_HEADER untuk mengambil header dari respons
    curl_setopt($curl, CURLOPT_HEADER, true);
    
    // Tampung header yang diterima dalam variabel $headers
    $headers = [];
    curl_setopt($curl, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers)
        {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // abaikan header yang tidak valid
                return $len;
    
            $name = strtolower(trim($header[0]));
            if (!array_key_exists($name, $headers))
                $headers[$name] = [trim($header[1])];
            else
                $headers[$name][] = trim($header[1]);
    
            return $len;
        }
    );
    
    $response = curl_exec($curl);
    
    if (array_key_exists('set-cookie', $headers)) {
        foreach ($headers['set-cookie'] as $cookie) {
            $name = strtok($cookie, '=');
            if ($name == 'epsonconnect_sid') {
                $value = strtok(';');
                return $value;
            }
        }
    }
    }
$url = "https://www.epsonconnect.com/user/Print/log_list";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Host: www.epsonconnect.com",
   "Cookie: _ga=GA1.2.34629800.1672023010; epsonconnect_lang=en; __atssc=google%3B3; epsonconnect_email=bagus.iqbal%40makanantradisi.com; __atuvc=9%7C52; _gid=GA1.2.822307752.1672634400; epsonconnect_sid=" . getLogin(),
   'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
   "accept: application/json, text/plain, */*",
   "content-type: application/json;charset=UTF-8",
   "sec-ch-ua-mobile: ?0",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36",
   'sec-ch-ua-platform: "Windows"',
   "origin: https://www.epsonconnect.com",
   "sec-fetch-site: same-origin",
   "sec-fetch-mode: cors",
   "sec-fetch-dest: empty",
   "referer: https://www.epsonconnect.com/user/Device/index?serial_number=X5EM147618",
   "accept-language: en-US,en;q=0.9",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "serial_number=X5EM147618&start=0&limit=60";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);


// Decode the JSON object
$result = json_decode($resp, true);



?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Bagus Tampan</title>
  </head>
  <body>
    <h2 class="text-center mt-3 mb-3">eVoucher - BagusIT Tampan</h2>
    <div class="table-responsive">
<?php // Check if the "rows" field exists and is not empty
if (isset($result['rows']) && !empty($result['rows'])) {
  // Print the table header
  echo '<table class="table table-striped table-sm">';
  echo '<thead>';
  echo '<tr>';
  echo '<th scope="col">#</th>';
  echo '<th scope="col">User</th>';
  echo '<th scope="col">Kode Voucher</th>';
  echo '<th scope="col">Tanggal</th>';
  echo '<th scope="col">Jumlah</th>';
  echo '<th scope="col">???</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  // Loop over the rows
  $i = 1;
  foreach ($result['rows'] as $row) {
    //echo explode(" ", $row['mail_arrival_datetime'])[0] . "|".date("d/m/Y")."_";
    // Check if the date of the current row is today's date
    $three_days_ago = date("d/m/Y", strtotime("-1 days"));
    if(explode(" ", $row['mail_arrival_datetime'])[0] >= $three_days_ago) {
        // Print the data for the current row
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        
      	$voucher = explode("_", explode(" - ", $row['subject'])[0])[0];
        $voucher_count = explode("_", explode(" - ", $row['subject'])[0])[1] - 1;

        $link = "https://www.appsheet.com/template/gettablefileurl?appName=eVoucherV3-BO-5238380&tableName=Voucher&fileName=%2Fappsheet%2FeVoucher_V3%2FeVoucher_".$voucher."_".$voucher_count.".pdf&n=%2Fappsheet%2FeVoucher_V3%2FeVoucher_".$voucher."_".$voucher_count.".pdf";

        
        echo '<td>'.explode(" - ", $row['subject'])[1].'</td>';
        //echo '<td><a target="_blank" href="' . $link . '"><span class="badge badge-pill badge-dark"><i class="bi bi-file-earmark-pdf-fill"></i>PDF</span></a> '.explode(" - ", $row['subject'])[0].'</td>';
        echo '<td><a target="_blank" href="' . $link . '"><span class="badge badge-pill badge-dark"><i class="bi bi-file-earmark-pdf-fill"></i>PDF</span></a> '.explode(" - ", $row['subject'])[0].'</td>';
        echo '<td>' . $row['mail_arrival_datetime'] . '</td>';
        echo '<td>'.explode(" - ", $row['subject'])[2].'</td>';
        if($row['job_status']=="Completed"){
            echo '<td><i class="bi bi-check-circle-fill" style="color:green"></i></td>';
        }elseif($row['job_status']=="Canceled"){
            echo '<td><i class="bi bi-exclamation-circle-fill" style="color:grey"></i></td>';
        }else{
            echo '<td><i class="bi bi-x-circle-fill" style="color:red"></i></td>';
        }

        echo '</tr>';
    }
}


  // Close the table
  echo '</tbody>';
  echo '</table>';
}?>
      
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>