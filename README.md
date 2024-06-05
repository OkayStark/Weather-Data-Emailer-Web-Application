# Weather Data Dashboard

This is a PHP CodeIgniter project that fetches weather data based on user input of location. It uses the WeatherAPI to get the current weather and astronomical data. The project also has a feature to send an AI-generated weather report to a specified email.

## Installation

1. Clone the project to your preferred server's htdocs folder. If you're using XAMPP, this would typically be in `C:\xampp\htdocs\`.

```bash
https://github.com/OkayStark/Weather-Dashboard-with-AI-emails.git
```

2. Navigate to the project directory.

```bash
cd weather-data-fetcher
```

3. Open the .env file and assign the following values:

```bash
WEATHER_API_KEY: Your WeatherAPI key. You can get this key by signing up on the WeatherAPI website.
GEMINI_API_KEY: Your Gemini AI api key, You can get this key by signing into gemini api developers page.
EMAIL_USERNAME: The username for the email account from which the weather reports will be sent.
EMAIL_APP_KEY: The app key for the email account from which the weather reports will be sent.
```

4.Start the apache server and go to localhost/{project name}/public using any browser

## Usage

https://github.com/OkayStark/Weather-Data-Emailer-Web-Application/assets/66514398/9c1df9a0-04f0-4b6e-a538-ad03092a8da1

