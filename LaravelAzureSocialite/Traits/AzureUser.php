<?php

namespace Shawinigan\Sso\LaravelAzureSocialite\Traits;

use App\Models\SystemLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait AzureUser
{
    protected $default_avatar = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';

    function getAdAvatar(){
        if($this->avatar !== null)
        {
            return stream_get_contents($this->avatar);
        }

        if(strtotime($this->azure_expires_timestamp) <= strtotime(date('Y-m-d H:i:s')))
        {
            return $this->default_avatar;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.microsoft.com/v1.0/me/photos/48x48/\$value",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $this->azure_access_token",
                "cache-control: no-cache",
            ),
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return $this->default_avatar;
        } else {
            $result = json_decode($response);

            if (!$response || json_last_error() === JSON_ERROR_NONE) {
                return $this->default_avatar;
            }

            $this->avatar = 'data:image/jpeg;base64,'.base64_encode($response);
            $this->save();
            return $this->avatar;
        }
    }
}