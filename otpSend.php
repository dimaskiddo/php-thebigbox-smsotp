<?php

if (isset($_GET['noTelp'])) {
  $noTelp = $_GET['noTelp'];

  if (!is_null($noTelp)) {
    $endpoint = "https://api.thebigbox.id/SMSOTP/1.0.2/otp/lupabapak-".$noTelp;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_HTTPHEADER => array(
        "X-API-KEY: <API_KEY_FROM_THEBIGBOX>",
        "Content-Type: application/json",
        "Cache-Control: no-cache"
      ),
      CURLOPT_POSTFIELDS => json_encode(array(
        "maxAttempt" => 3,
        "phoneNum" => $noTelp,
        "content" => "Halo, Kode OTP LupaBapak (LB) Anda Adalah {{otp}}. JANGAN BERITAHUKAN KODE OTP INI KEPADA SIAPAPUN!",
        "expireIn" => 60,
        "digit" => 4
      )),
    ));
    
    $responseOK = curl_exec($curl);
    $responseErr = curl_error($curl);
    
    curl_close($curl);
    
    if ($responseErr) {
      echo $responseErr;
    } else {
      header('Content-Type: application/json');
      echo $responseOK;
    }
  }
} else {
  $response = array('status' => false, 'message' => 'Telah terjadi kesalahan', 'error' => 'Error nomor telepon tidak terdefinisi');

  header('Content-Type: application/json');
  echo json_encode($response);
}

?>