<?php

if (isset($_GET['noTelp']) && isset($_GET['kodeOTP'])) {
  $noTelp = $_GET['noTelp'];
  $kodeOTP = $_GET['kodeOTP'];

  if (!is_null($noTelp) && !is_null($kodeOTP)) {
    $endpoint = "https://api.thebigbox.id/SMSOTP/1.0.2/otp/lupabapak-".$noTelp."/verifications";
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array(
        "X-API-KEY: <API_KEY_FROM_THEBIGBOX>",
        "Content-Type: application/json",
        "Cache-Control: no-cache"
      ),
      CURLOPT_POSTFIELDS => json_encode(array(
        "maxAttempt" => 3,
        "otpstr" => $kodeOTP,
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
  $response = array('status' => false, 'message' => 'Telah terjadi kesalahan', 'error' => 'Error nomor telepon atau kode OTP tidak terdefinisi');

  header('Content-Type: application/json');
  echo json_encode($response);
}

?>