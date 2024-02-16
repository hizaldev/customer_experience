<?php

namespace App\Http\Controllers\Constant;

use App\Http\Controllers\Controller;
use App\Models\BmkgWeathers;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use SimpleXMLElement;

class ConstantController extends Controller
{
   var $url = "http://203.176.179.118:8027/newsrintami/web/api/mv";

   public static function successAlert()
   {
      return  Alert::success('Sukses', 'Data berhasil disimpan !!');
   }

   public static function successAlertWithMessage($message)
   {
      return  Alert::success('Sukses', $message);
   }

   public static function successUpdateAlert()
   {
      return  Alert::success('Sukses', 'Data berhasil diperbarui !!');
   }

   public static function successUpdateAlertWithMessage($message)
   {
      return  Alert::success('Sukses', $message);
   }

   public static function successDeleteAlert()
   {
      return  Alert::success('Sukses', 'Data berhasil dihapus !!');
   }

   public static function errorAlert($e)
   {
      return  Alert::error('Error', $e);
   }

   public static function failedSaveAlert()
   {
      return  Alert::error('Gagal', 'Data Gagal disimpan !!');
   }

   public static function failedUpdateAlert()
   {
      return  Alert::error('Gagal', 'Data Gagal diperbarui !!');
   }

   public static function getDataHealtyIndex($ahi, $id_functloc)
   {
      $http = new Client([
         'verify' => false
      ]);
      $url_get_user = "http://203.176.179.118:8027/newsrintami/web/api/mv/getdata?id=$ahi&filter=IDGARDU:$id_functloc";
      $response = $http->get($url_get_user);
      $data = json_decode((string)$response->getBody(), true);

      return $data;
   }

   public static function GetValueDataBmkg($dataBmkg, $areaId, $stringDate, $description, $unit)
   {

      foreach ($dataBmkg as $bm) {
         if ($bm->attributes()->id == $areaId) {
            foreach ($bm->parameter as $paramsWeather) {
               if ($paramsWeather->attributes()->description == $description) {
                  foreach ($paramsWeather->timerange as $time) {
                     if ($time->attributes()->datetime == $stringDate) {
                        foreach ($time->value as $value) {
                           if ($value->attributes()->unit == $unit) {
                              $data = $value;
                              // dd($data);
                              return $data;
                           }
                        }
                     }
                  }
               }
            }
         }
      }
   }

   public static function GetValueMapingDataBmkg($dataBmkg, $areaId, $stringDate, $description, $unit)
   {
      foreach ($dataBmkg as $bm) {
         if ($bm->attributes()->id == $areaId) {
            foreach ($bm->parameter as $paramsWeather) {
               if ($paramsWeather->attributes()->description == $description) {
                  foreach ($paramsWeather->timerange as $time) {
                     if ($time->attributes()->datetime == $stringDate) {
                        foreach ($time->value as $value) {
                           if ($value->attributes()->unit == $unit) {
                              $dataCuaca = BmkgWeathers::find($value)->first();
                              // dd($dataCuaca);
                              return $dataCuaca;
                           }
                        }
                     }
                  }
               }
            }
         }
      }
   }

   //  public static function logger($dataLog, $module, $action)
   //  {
   //       if(is_array($dataLog)){
   //          $str_json = implode(', ',$dataLog);   
   //          $data['data_log'] = $str_json;
   //       }else{
   //          $data['data_log'] = $dataLog;

   //       }   
   //       $data['module'] = $module;
   //       $data['user_id'] = Auth::user()->user_id;
   //       $data['user_by'] = Auth::user()->name;
   //       $data['name'] = Auth::user()->name;
   //       $data['action'] = $action; 
   //       $data['ip_address'] =Request::ip();
   //       $data['created_at'] = Carbon::now();
   //       // dd($data);
   //       $logger = Logger::create($data);
   //  }

   //  public static function loggerNonAuth($dataLog, $module, $action, $receiver)
   //  {
   //       if(is_array($dataLog)){
   //          $str_json = implode(', ',$dataLog);   
   //          $data['data_log'] = $str_json;
   //       }else{
   //          $data['data_log'] = $dataLog;

   //       }   
   //       $data['module'] = $module;
   //       $data['user_id'] = $receiver;
   //       $data['user_by'] = $receiver;
   //       $data['name'] = $receiver;
   //       $data['action'] = $action; 
   //       $data['ip_address'] =Request::ip();
   //       $data['created_at'] = Carbon::now();
   //       // dd($data);
   //       $logger = Logger::create($data);
   //  }

   public static function sendMessageWhatssap($message, $receiver)
   {
      $url = env('WHATSAPP_GATEWAY_URL') . "/messages";
      $key = env('WHATSAPP_GATEWAY_API_KEY');
      $device = env('WHATSAPP_GATEWAY_DEVICE');

      $client = new Client();
      $noCheck = str::substr($receiver, 0, 2);
      if ($noCheck == '08') {
         $split = Str::substr($receiver, 2, 14);
         $number = '628' . $split;
      }
      if ($noCheck == '+6') {
         $split = Str::substr($receiver, 1, 14);
         $number = '62' . $split;
         // dd($number);
      }
      if ($noCheck == '62') {
         $number = $receiver;
      }

      $data = array(
         'device' => "$device",
         'receiver' => "$number",
         'type' => 'chat',
         'message' => "$message",
         'simulate_typing' => 1
      );
      $client = new Client();
      // dd(json_encode($data)   );
      try {
         $response = $client->post($url, [
            'headers' => [
               'Content-Type' => 'application/json',
               'Accept' => 'application/json',
               'Authorization' => 'Bearer ' . $key
            ],
            'body'    => json_encode($data)
         ]);
         $hasil = (array)json_decode((string)$response->getBody(), true);
         if ($hasil['status'] == 200) {
            // dd($hasil);
            // dd($hasil['data']['status']);
            $status = $hasil['data']['status'];
            $message = $hasil['data']['body'];
            // ConstantController::loggerNonAuth("$message", 'Module', "whatsapp notification $status", $receiver);
         } else {
            // ConstantController::loggerNonAuth("whatsapp gagal terkirim", 'Module', "whatsapp notification gagal", $receiver);
         }
      } catch (Exception $e) {
         $skuList = preg_split('/\r\n|\r|\n/', $e->getMessage());
         // ConstantController::loggerNonAuth("whatsapp gagal terkirim with message : $skuList[1]", 'Module', "whatsapp notification gagal", $receiver);
         ConstantController::errorAlert("Whatsap gagal mengirim dengan error: $skuList[1]");
      }
   }

   public static function sendMessageWhatssapGroup($message, $group_id, $type = 'chat', $file = null, $title = "file.pdf")
   {
      $url = env('WHATSAPP_GATEWAY_URL') . "/groups/$group_id/send";
      $key = env('WHATSAPP_GATEWAY_API_KEY');

      $client = new Client();
      if ($type == 'chat') {
         $data = array(
            'type' => 'chat',
            'message' => "$message",
            'simulate_typing' => 1
         );
      }
      if ($type == 'image') {
         $data = array(
            'type' => 'chat',
            'params' => [
               'image' => [
                  'url' => $file
               ],
               "caption" => "$message",
            ],
            'simulate_typing' => 1
         );
      }

      if ($type == 'file') {
         $now = Carbon::now();
         $data = array(
            "type" => "chat",
            "params" => [
               "document" => [
                  "url" => $file
               ],
               "fileName" => $title,
               "mimeType" => "application/pdf"
            ]
         );
      }

      $client = new Client();
      // dd(json_encode($data));
      try {
         $response = $client->post($url, [
            'headers' => [
               'Content-Type' => 'application/json',
               'Accept' => 'application/json',
               'Authorization' => 'Bearer ' . $key
            ],
            'body'    => json_encode($data)
         ]);
         $hasil = (array)json_decode((string)$response->getBody(), true);
         if ($hasil['status'] == 200) {
            // dd($hasil);
            // dd($hasil['data']['status']);
            $status = $hasil['data']['status'];
            $message = $hasil['data']['body'];
            // ConstantController::loggerNonAuth("$message", 'Module', "whatsapp notification $status", $group_id);
         } else {
            // ConstantController::loggerNonAuth("whatsapp gagal terkirim", 'Module', "whatsapp notification gagal", $group_id);
         }
      } catch (Exception $e) {
         $skuList = preg_split('/\r\n|\r|\n/', $e->getMessage());
         // ConstantController::loggerNonAuth("whatsapp gagal terkirim with message : $skuList[1]", 'Module', "whatsapp notification gagal", $group_id);
         ConstantController::errorAlert("Whatsap gagal mengirim dengan error: $skuList[1]");
      }
   }


   // public static function getGroupList(){

   //    $key = env('WHATSAPP_GATEWAY_API_KEY');
   //    $device = env('WHATSAPP_GATEWAY_DEVICE');
   //    $url = env('WHATSAPP_GATEWAY_URL')."/groups?device=$device";

   //    $client = new Client();
   //    // dd(json_encode($data)   );
   //    try{
   //       $response = $client->get($url, [
   //             'headers' => [
   //                'Content-Type' => 'application/json', 
   //                'Accept' => 'application/json', 
   //                'Authorization' => 'Bearer '.$key
   //             ],
   //       ]); 
   //       $hasil = (array)json_decode((string)$response->getBody(), true);

   //       if($hasil['status'] == 200){
   //          WhatsappGroup::truncate();
   //          $data = $hasil['data'];
   //          for($i = 0; $i < count($data); $i++){
   //             $data['id'] = $data[$i]['id'];
   //             $data['group_name'] = $data[$i]['title'];
   //             $data['muted'] = $data[$i]['muted'] == true ? 'Yes' : 'No';
   //             $data['spam'] = $data[$i]['spam'] == true ? 'Yes' : 'No';
   //             WhatsappGroup::create($data);
   //          }
   //       }else{
   //       }
   //    }catch(Exception $e){
   //       ConstantController::errorAlert($e->getMessage());
   //    } 
   // }  
}
