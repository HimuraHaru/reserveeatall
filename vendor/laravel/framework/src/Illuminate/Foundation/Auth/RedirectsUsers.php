<?php

namespace Illuminate\Foundation\Auth;

use App\Http\Helpers;
use Illuminate\Support\Facades\Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
//        if (method_exists($this, 'redirectTo')) {
//            return $this->redirectTo();
//        }

        $redirectTo = (Helpers::checkIfUser()) ? $redirectTo = '/' : $redirectTo = '/dashboard';

        return property_exists($this, 'redirectTo') ? $this->redirectTo : $redirectTo;
    }
}
