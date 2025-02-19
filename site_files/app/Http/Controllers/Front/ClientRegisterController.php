<?php

namespace App\Http\Controllers\Front;

use Auth;
use Mail;
use Image;
use Redirect;
use App\Models\Back\City;
use App\Models\Back\Client;
use App\Models\Back\State;
use Illuminate\Http\Request;
use App\Models\Back\Metadata;
use App\Models\Back\Country;
use App\Models\Back\CmsModuleData;
use App\Mail\RegistrationApproval;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

define('PATH', dirname(__FILE__));
class ClientRegisterController extends Controller
{
    //shows registration form to seller
    public function showRegistrationForm()
    {
        $states = State::active()->sorted()->get();
        $seoArr = getSeoArrayModule(104);
        $seoArr['title'] = 'Sign Up';
        $conditions = getModuleData(38);
        return view('front.auth.clientregister', compact('states', 'seoArr', 'conditions'));
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        //Create seller
        $client  = new Client();
        $client->name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->state_id = $request->state_id;
        $client->city_id = $request->city_id;
        $client->email = $request->email;
        $client->zip = $request->zip;
        if (isset($request->conditions)) {
            $client->conditions = json_encode($request->conditions);
        }
        $client->dob = $request->dob;
        $client->ip = $request->ip();
        $client->password = Hash::make($request->password);
        $client->save();
        //return redirect()->route('client_login_s');
        return Redirect::back()->with('msg', 'Sign Up Succefully!');
    }
    public function getState($id)
    {
        $states = State::active()->sorted()->get();
        $option = '';
        $option .= '<option selected disabled>Select State</option>';
        foreach ($states as $state) {
            $option .= '<option value="' . $state->id . '">' . $state->state_name . '</option>';
        }
        echo $option;
    }
    public function getCity($id)
    {
        $cities = City::where('state_id', $id)->active()->sorted()->get();
        $option = '';
        $option .= '<option selected disabled>Select City</option>';
        foreach ($cities as $city) {
            $option .= '<option value="' . $city->id . '">' . $city->city_name . '</option>';
        }
        echo $option;
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:500',
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'dob' => 'required',
            'zip' => 'required|min:5|max:5',
            'email' => 'required|email|max:255|unique:clients',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|recaptcha',
        ], [
            'first_name.required' => 'First Name is required.',
            'last_name.required' => 'Last Name is required.',
            'phone.required' => ' Phone is required.',
            'state.required' => ' State is required.',
            'city.required' => ' City is required.',
            'dob.required' => ' Date of Birth is required.',
            'zip.required' => ' Zip Code is required with limit 5 characters.',
            'address.required' => 'Address is required.',
            'password.required' => 'Password is Required.',
            'email.required' => 'Email is Required.',
            'g-recaptcha-response.required' => 'Please verify yourself',
            'g-recaptcha-response.recaptcha' => 'Please verify yourself',
        ]);
    }
    protected function guard()
    {
        return Auth::guard('client');
    }
}
