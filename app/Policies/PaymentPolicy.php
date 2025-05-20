<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Payment $payment)
    {
        return $user->id === $payment->user_id;
    }
}
