<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function update($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
}
