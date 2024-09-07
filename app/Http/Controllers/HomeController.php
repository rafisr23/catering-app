<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function pageView($routeName, $page = null)
    {
        // Construct the view name based on the provided routeName and optional page parameter
        $viewName = ($page) ? $routeName.'.'.$page : $routeName;
        // Check if the constructed view exists
        if (\View::exists($viewName)) {
            // If the view exists, return the view
            return view($viewName);
        } else {
            // If the view doesn't exist, return a 404 error
            abort(404);
        }
    }

    public function editProfile(Request $request) {
        $user = User::where('id', auth()->user()->id)->first();

        return view('home.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request) {
        $user = User::where('id', auth()->user()->id)->first();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->hasRole('merchant')) {
            $user->merchant->name = $request->name;
            $user->merchant->address = $request->address;
            $user->merchant->contact = $request->contact;
            $user->merchant->description = $request->description;
            $user->merchant->save();
        }

        if ($user->hasRole('customer')) {
            $user->customer->address = $request->address;
            $user->customer->contact = $request->contact;
            $user->customer->save();
        }

        $user->save();

        return redirect()->route('edit.profile')->with('success', 'Profile updated successfully');
    }
}