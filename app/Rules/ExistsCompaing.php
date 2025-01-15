<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExistsCompaing implements Rule
{
    public function passes($attribute, $value)
    {
        $exists = DB::table('campaigns')->where('id', $value)->first();

        if (!$exists) {
            throw ValidationException::withMessages([
                'campaigns' => "Campaign {$value} does not exist.",
            ]);
        }

        return true;
    }

    public function message()
    {
        //
    }
}
