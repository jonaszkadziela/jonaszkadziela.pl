<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request, string $code): RedirectResponse
    {
        $request
            ->merge(['code' => $code])
            ->validate([
                'code' => 'required|in:' . join(',', config('app.languages')),
            ]);

        Session::put('language', $request['code']);

        return redirect()->back();
    }

    public function options(): JsonResponse
    {
        $options = collect(config('app.languages'))
            ->map(fn (string $code) => [
                'label' => Lang::get('main.languages.' . $code),
                'value' => $code,
            ])
            ->toArray();

        return response()->json($options);
    }
}
