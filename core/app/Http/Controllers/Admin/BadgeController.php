<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;

class BadgeController extends Controller
{
    public function index()
    {
        $pageTitle = "Badge";
        $badges =  Badge::paginate(getPaginate());
        return view('admin.badge.index', compact('pageTitle', 'badges'));
    }


    public function save(Request $request, $id = 0)
    {
        $this->validateRequest($request, $id);

        $badge = $id ? Badge::findOrFail($id) : new Badge();

        $message = $id ? "Badge updated successfully" : "Badge created successfully";

        if ($request->hasFile('image')) {
            try {
                $oldImage = $badge->image;
                $badge->image = fileUploader($request->file('image'), getFilePath('badge'), getFileSize('badge'), $oldImage);
            } catch (\Exception $exp) {
                return back()->withNotify([['error', "Couldn't upload your image"]]);
            }
        }

        $badge->name                      = $request->name;
        $badge->earning_amount            = $request->earning_amount;
        $badge->discount_maintenance_cost = $request->discount_maintenance_cost;
        $badge->plan_price_discount       = $request->plan_price_discount;
        $badge->earning_boost             = $request->earning_boost;
        $badge->referral_bonus_boost      = $request->referral_bonus_boost;

        $badge->save();

        return back()->withNotify([['success', $message]]);
    }

    private function validateRequest($request, $id = 0)
    {
        $request->validate([
            'image'                     => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name'                      => ['required', 'unique:badges,name,' . $id],
            'earning_amount'            => ['required', 'numeric', 'min:0'],
            'discount_maintenance_cost' => 'sometimes|required|numeric|min:0',
            'plan_price_discount'       => 'sometimes|required|numeric|min:0',
            'earning_boost'             => 'sometimes|required|numeric|min:0',
            'referral_bonus_boost'      => 'sometimes|required|numeric|min:0',
        ]);
    }


}
