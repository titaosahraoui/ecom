<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Address; // Assuming you have an Address model
use App\Models\Payment; // Assuming you have a PaymentMethod model
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountController extends Controller
{
    use AuthorizesRequests;

    public function profile()
    {
        $user = auth()->guard()->user();
        $address = $user->address ?? null;
        return view('account.profile', compact('user', 'address'));
    }

    public function settings()
    {
        $user = auth()->user();

        // Always return a collection, even if empty
        $addresses = $user->addresses()->get();

        // Same for payment methods
        $paymentMethods = $user->paymentMethods()->get();

        $orders = $user->orders()->latest()->take(5)->get();

        return view('account.settings', [
            'user' => $user,
            'addresses' => $addresses,
            'paymentMethods' => $paymentMethods,
            'orders' => $orders
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password updated successfully');
    }
    public function showAddresses()
    {
        $addresses = auth()->user()->addresses; // assuming one-to-many relationship
        return view('profile.addresses', compact('addresses'));
    }


    public function storeAddress(Request $request)
    {
        $request->validate([
            'address_line1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'is_default' => 'sometimes|boolean'
        ]);

        $user = auth()->user();

        // If setting as default, remove default status from other addresses
        if ($request->is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create($request->all());

        return back()->with('success', 'Address added successfully');
    }
    public function getAddress(Address $address)
    {
        $this->authorize('view', $address);
        return response()->json($address);
    }

    public function updateAddress(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $request->validate([
            'address_line1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'is_default' => 'sometimes|boolean'
        ]);

        // If setting as default, remove default status from other addresses
        if ($request->is_default) {
            $address->user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($request->all());

        return back()->with('success', 'Address updated successfully');
    }

    public function deleteAddress(Address $address)
    {
        if (!auth()->user()->can('delete', $address)) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', 'Address deleted successfully');
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'card_number' => 'required|digits_between:13,19',
            'card_holder_name' => 'required|string|max:255',
            'expiry_month' => 'required|numeric|between:1,12',
            'expiry_year' => 'required|numeric|min:' . date('Y'),
            'cvv' => 'required|digits_between:3,4',
            'is_default' => 'sometimes|boolean',
        ]);

        $user = auth()->user();

        // Determine card type (basic example, can be improved)
        $cardNumber = str_replace(' ', '', $request->card_number);
        $cardType = match (true) {
            str_starts_with($cardNumber, '4') => 'Visa',
            str_starts_with($cardNumber, '5') => 'Mastercard',
            str_starts_with($cardNumber, '3') => 'American Express',
            default => 'Unknown',
        };

        // Reset other default payment methods if this one is default
        if ($request->is_default) {
            $user->paymentMethods()->update(['is_default' => false]);
        }

        $user->paymentMethods()->create([
            'card_holder_name' => $request->card_holder_name,
            'expiry_month' => $request->expiry_month,
            'expiry_year' => $request->expiry_year,
            'last_four' => substr($cardNumber, -4),
            'card_type' => $cardType,
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('account.settings')->with('success', 'Payment method added successfully.');
    }


    public function deletePaymentMethod(Payment $payment)
    {
        $this->authorize('delete', $payment); // Optional: add policy if needed

        $payment->delete();

        return response()->json(['success' => true]);
    }



    private function determineCardType($number)
    {
        // Simple card type detection
        $firstDigit = substr($number, 0, 1);

        switch ($firstDigit) {
            case '4':
                return 'Visa';
            case '5':
                return 'Mastercard';
            case '3':
                return 'American Express';
            case '6':
                return 'Discover';
            default:
                return 'Unknown';
        }
    }

    public function setDefaultPaymentMethod(Payment $payment)
    {
        $user = auth()->user();

        if ($payment->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $user->paymentMethods()->update(['is_default' => false]);
        $payment->update(['is_default' => true]);

        return response()->json(['success' => true]);
    }
}
