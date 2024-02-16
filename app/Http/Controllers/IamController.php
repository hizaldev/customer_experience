<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Constant\ConstantController;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class IamController extends Controller
{
    public function getPLNRedirect()
    {

        $client_id = env('PLN_ID');
        $redirect_uri = env('PLN_REDIRECT');
        $url = 'https://iam.pln.co.id/svc-core/oauth2/auth?response_type=code&client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&scope=openid email profile empinfo phone address';

        // dd($url);
        // Alert::success(' Success ', 'ini muncul karena gagal');
        return redirect($url);
    }

    public function getPLNHandle(Request $request)
    {

        if ($request->code == null) {
            Alert::success(' Success ', 'ini muncul karena gagal');
            return redirect()->to('login');
        }

        // get access token
        try {
            $client_id = env('PLN_ID');
            $client_secret = env('PLN_SECRET');
            $redirect_uri = env('PLN_REDIRECT');

            $url = 'https://iam.pln.co.id/svc-core/oauth2/token';

            $http = new Client([
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret)
                ],
                'verify' => false
            ]);

            $response = $http->post($url, [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'redirect_uri' => $redirect_uri,
                    'code' => $request->code,
                ],
            ]);

            $data = (array)json_decode((string)$response->getBody(), true);
            $token = $data['access_token'];
            $id_token = $data['id_token'];

            $http = new Client([
                'headers' =>
                ['Authorization' => 'Bearer ' . $token],
                'verify' => false
            ]);
            $url_get_user = 'https://iam.pln.co.id/svc-core/oauth2/me';
            $response = $http->get($url_get_user);

            $data = json_decode((string)$response->getBody(), true);

            $user_sso = collect($data);
            // ==================================================================================================

            $user = new User();

            // dd($user_sso);

            // $domain = 'pusat';
            $pernr = $user_sso->get('email');
        } catch (Exception $e) {
            //throw $th;
            ConstantController::errorAlert($e->getMessage());
            return redirect('/home');
        }
        // Cek Tabel User, jika tidak ada -> register, jika ada -> update data.
        if (User::where('email', '=', $pernr)->count() > 0) {
            // User lama
            $user = User::where('email', '=', $pernr)->first();
            $action = 'lama';
        } else {
            // User baru
            $user = new User();
            $action = 'baru';
        }

        try {
            $personel_area_id = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['personnelArea']['id'];
            $personel_area_name = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['personnelArea']['name'];
            $personel_sub_area_id = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['personnelSubArea']['id'];
            $personel_sub_area_name = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['personnelSubArea']['name'];
            $organisasi_id = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['organisasi']['id'];
            $organisasi_name = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['organisasi']['name'];
            $posisi_id = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['posisi']['id'];
            $posisi_name = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['posisi']['name'];
            $business_area = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['businessArea']['id'];
            $business_area_name = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['businessArea']['name'];
            $nip = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['nip'];
            $phone = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['phone'];
            $pernr = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['pernr'];
        } catch (\Exception $e) {
            $personel_area_id = '0';
            $personel_area_name = 'unkwown';
            $personel_sub_area_id = '0';
            $personel_sub_area_name = 'unknown';
            $organisasi_id = '0';
            $organisasi_name = 'unknown';
            $posisi_id = '0';
            $posisi_name = 'unknown';
            $business_area = '0';
            $business_area_name = 'unknown';
            $nip = '0';
            $phone = '0';
            $pernr = '0';
        }

        $user->name = $user_sso->get('https://iam.pln.co.id/svc-core/account/hrinfo')['registeredName'];
        $user->email = $user_sso->get('email');
        $user->password = Hash::make('123');
        $user->personel_area_id = $personel_area_id;
        $user->personel_area_name = $personel_area_name;
        $user->personel_sub_area_id = $personel_sub_area_id;
        $user->personel_sub_area_name = $personel_sub_area_name;
        $user->posisi_id = $posisi_id;
        $user->posisi_name = $posisi_name;
        $user->organisasi_id = $organisasi_id;
        $user->organisasi_name = $organisasi_name;
        $user->business_area = $business_area;
        $user->business_area_name = $business_area_name;
        $user->nip = $nip;
        $user->phone = $phone;
        $user->pernr = $pernr;
        $user->last_login = Carbon::now();
        if ($action == 'baru') {
            $user->user_id = Str::uuid();
        }
        $user->save();
        if ($action == 'baru') {
            // set user role as admin
            $user->syncRoles([1]);
        }

        //  ===================================================================================================
        session(['login_from' => 'SSO', 'id_token' => $id_token]);
        // $value = $request->session()->get('login_from');
        $socialUser = $user;
        auth()->login($socialUser, true);
        // StaticConstantController::log_access('iam_login', 'auth_iam');
        // dd('ini muncul karena dianggap berhasil');
        // return view('welcome');
        return redirect('/home');
    }

    public function logoutSSO()
    {
        $login_from = session('login_from');
        $urlLogout = url('logout');
        $ur_logout_sso = 'https://iam.pln.co.id/svc-core/oauth2/session/end?post_logout_redirect_uri=' . $urlLogout . '&id_token_hint=' . session('id_token');

        // if ($login_from == 'SSO') {
        Auth::logout();
        return redirect($ur_logout_sso);
        // }
    }
}
