<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

class WeatherController extends BaseController
{
    public function fetchData($location)
    {
        $apiKey = $_ENV['WEATHER_API_KEY'];
        $url1 = "http://api.weatherapi.com/v1/astronomy.json?key=$apiKey&q=$location";
        $url2 = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$location";

        $client = \Config\Services::curlrequest();

        $response1 = $client->request('GET', $url1);
        $data1 = json_decode($response1->getBody(), true);

        $response2 = $client->request('GET', $url2);
        $data2 = json_decode($response2->getBody(), true);

        $mergedData = ['astronomy' => $data1, 'current' => $data2];
        $jsonResponse = json_encode($mergedData);
        return $jsonResponse;
    }

    public function sendmail()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $mail_id = $data['email'];
        unset($data['email']); // remove the email from the data array
        $weatherData = $data; // remaining data is the weather data
        $weatherDataString = implode(", ", array_map(function ($v, $k) {
            return sprintf("%s='%s'", $k, $v);
        }, $weatherData, array_keys($weatherData)));
        $body = [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => "Compose the body of around 300 words (no subject) of a professional and informative email with a greeting to the user, weather summary, and closing statement using the following data: " . $weatherDataString
                        ]
                    ]
                ]
            ]
        ];
        $apiKey = $_ENV['GEMINI_API_KEY'];
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=$apiKey";
        $client = \Config\Services::curlrequest();
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($body)
        ]);

        $responseData = json_decode($response->getBody(), true);
        $emailContent = $responseData['candidates'][0]['content']['parts'][0]['text'];
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USERNAME'];
            $mail->Password = $_ENV['EMAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('ttiimmccookk@gmail.com');
            $mail->addAddress($mail_id);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Subject';
            $mail->Body = $emailContent;

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


}