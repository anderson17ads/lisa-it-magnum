<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExistsInfluencer implements Rule
{
    public function passes($attribute, $value)
    {
        $exists = DB::table('influencers')->where('id', $value)->first();

        if (!$exists) {
            throw ValidationException::withMessages([
                'influencers' => "Influencer {$value} does not exist.",
            ]);
        }

        return true;
    }

    public function message()
    {
        //
    }
}
