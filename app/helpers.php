<?php

use App\Models\SettingWeb;
use Illuminate\Support\Str;

if (!function_exists('generateBookingCode')) {
    function generateBookingCode( $length = 6) {
        // Generate a short random string
        $randomString = Str::random($length);

        // Get a timestamp (last 4 digits for brevity)
        $timestamp = substr(now()->timestamp, -4) ;


        $code = Str::upper($randomString . $timestamp);

        // Concatenate the random string with the timestamp
        return $code;
    }
}

if (!function_exists('generateUUID')) {
    /**
     * Generates a unique identifier (UUID) based on the current timestamp and a random string.
     *
     * @param int $length The length of the random string part of the UUID.
     * @return string The generated UUID.
     */
    function generateUUID($length = 30)
    {
        // Generate a short random string
        $randomString = Str::upper(Str::random($length));

        // Get the current timestamp in milliseconds
        $timestamp = (string) round(microtime(true) * 1000);

        // Concatenate the random string with the timestamp
        $uuid = $timestamp . '-' . $randomString;

        return $uuid;
    }


}

if (!function_exists('getSettingWeb')) {

    function getSettingWeb($name)
    {
        $value = SettingWeb::where('name','=',$name)->first()->value;

        return $value;
    }


}
