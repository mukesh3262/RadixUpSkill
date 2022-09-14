<?php

namespace App\Utility;

use Image;
use File;
use App\AppSetting;

class CommonHelper {

    const WEB_REDIRECT = 515;

    /**
     * Generate Json Response
     *
     * @param  boolean  $status
     * @param  string  $message
     * @param  integer  $statusCode
     * @param  array  $data
     * @param  array  $error
     * @param  string  $url
     *
     * @return \Illuminate\Http\Response
     */
    public function generateResponse($status = false, $message = NULL, $statusCode = 200, $data = array(), $error = array(), $url = '') {
        $response["status"] = $status;
        $response["message"] = $message;
        $response["data"] = empty($data) ? (object) $data : $data;
        $response["error"] = empty($error) ? (object) $error : $error;

        if (self::WEB_REDIRECT === $statusCode) {
            return redirect($url);
        }

        return response()->json($response, $statusCode);
    }

    public function uplodeImageWithThumbnails($image, $type = null) {
        $categoryImage = time() . rand(1, 99999) . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/thumbnails');
        if ($type == "profile") {
            $destinationPath = public_path('/profile/thumbnails');
        }

        if ($type == "chats") {
            $destinationPath = public_path('/chats');
        }

        $img = Image::make($image->getRealPath());
        $img->orientate();
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $categoryImage);

        $destinationPath = public_path('/upload');
        if ($type == "profile") {
            $destinationPath = public_path('/profile');
        }

        $img = Image::make($image->getRealPath());
        $img->orientate();
        $img->save("" . $destinationPath . "/" . $categoryImage, 60);

        //$image->move($destinationPath, $categoryImage);

        return $categoryImage;
    }

    public function unlinkImage($image_name) {
        $image_path = public_path("upload/" . $image_name);

        if (file_exists($image_path)) {
            File::delete($image_path);
        }

        $image_path = public_path("thumbnails/" . $image_name);

        if (file_exists($image_path)) {
            File::delete($image_path);
        }

        return true;
    }

    public function getAppSetting($userId) {
        $appSettings = AppSetting::select('meta_key', 'meta_value')->where('user_id', $userId)->get();

        $appSettingData = [];
        if (!empty($appSettings)) {
            $data = $this->keyValueArray($appSettings);

            if ($data) {
                $appSettingData = call_user_func_array('array_merge', $data);

                //$appSettingData = collect($dataArray)->only(AppSetting::Except_ARRAY)->toArray();
            }
        }

        return $appSettingData;
    }

    public function keyValueArray($appSettings) {
        return $appSettings->map(function($item) {
                    $data = array($item['meta_key'] => is_null($item['meta_value']) ? "" : $item['meta_value']);

                    if (in_array($item['meta_key'], AppSetting::BOOLEAN_ARRAY)) {
                        $data = array(
                            $item['meta_key'] => ($item['meta_value'] == "false") ? false : true
                        );
                    }

                    return $data;
                })->toArray();
    }

}