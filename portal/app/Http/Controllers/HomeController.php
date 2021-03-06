<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Setting;
use Validator;
use App\UserLabelPrint;
use GuzzleHttp\Exception\ClientException as Exception;

class HomeController extends FrontController
{
    /**
     * Dashboard
     * @param  Request $request
     * @return data for dashboard - account, order and order history
     */
    public function dashboard(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            
            $response = $this->client->request('GET', 'orders/pending', ['query' =>['token' => $token]]);
            
            $tickets_printed = UserLabelPrint::Archived()->get(['order_id','type','created_at','quantity']);

            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
            }

        } catch (Exception $e) {
            $error = json_decode((string) $e->getResponse()->getBody(), true);
            $errors = [$error['message']];
            
            return view('dashboard')->withErrors($errors)->withTitle('dashboard');
        }

        return view('dashboard', ['orders' => $result['data'],'tickets' => $tickets_printed,'nav' => false])->withTitle('dashboard');
    }

    /**
     * User account settings
     * @param  Request $request
     * @return settings data array
     */
    public function setting(Request $request)
    {
        //get user account from user
        $currentuser = $this->getAuthUser($request);
        
        if ($request->isMethod('post')) {
            $credentials = $request->only(
            'email',
                'password',
                'password_confirmation'
            );

            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                
                return view('account.edit')->withErrors($errors)->withTitle('setting');
            }

            try {
                $token = $request->session()->get('token');
                $request->merge(['token' => $token]);
                
                $response = $this->client->request('POST', 'auth/reset', $request->only('email', 'password', 'password_confirmation', 'token'));
                
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                }
            } catch (Exception $e) {
                $error = json_decode((string) $e->getResponse()->getBody(), true);
                $errors = [$error['message']];
                
                return view('account.edit')->withErrors($errors)->withTitle('dashboard');
            }
        } else {
            return view('account.edit')->withTitle('setting');
        }
    }

    /**
     * User manual for setting up the printer
     */
    public function usermanual()
    {
        return response()->download(storage_path('app\public\User_Manual.pdf'));
    }
}
