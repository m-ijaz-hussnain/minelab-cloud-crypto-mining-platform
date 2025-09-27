<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Miner;
use App\Models\Plan;
use App\Rules\FileTypeValidate;

class MinerController extends Controller
{
    public function index()
    {
        $pageTitle     = "All Miners";
        $miners = Miner::searchable(['coin_code', 'name'])->with('plans')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.miner.index', compact('pageTitle', 'miners'));
    }

    public function plans($minerId)
    {
        $plans        = Plan::where('miner_id', $minerId)->with('miner')->orderBy('id', 'DESC')->paginate(getPaginate());
        $currentMiner = Miner::find($minerId);
        $miners       = Miner::orderBy('name')->get();

        $pageTitle     = "All Plans For " . $currentMiner->name;
        return view('admin.miner.plans', compact('pageTitle', 'plans', 'miners', 'currentMiner'));
    }

    public function store(Request $request, $id = 0)
    {
        $imageValidation = 'required';
        if ($id) {
            $imageValidation = 'nullable';
        }
        $validateRule = [
            'name'               => 'required|string|max:255|unique:miners,name,' . $id,
            'coin_code'          => 'required|string|max:40|unique:miners,coin_code,' . $id,
            'min_withdraw_limit' => 'required|numeric',
            'max_withdraw_limit' => 'required|numeric|gt:min_withdraw_limit',
            'coin_image'         => [$imageValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ];

        $request->validate($validateRule);

        $miner = Miner::find($id);
        $notification = 'Miner updated successfully';

        if (!$miner) {
            $miner = new Miner();
            $notification = 'Miner added successfully';
        }

        if ($request->hasFile('coin_image')) {
            try {
                $miner->coin_image = fileUploader($request->coin_image, getFilePath('miner'), getFileSize('miner'), @$miner->coin_image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the coin image'];
                return back()->withNotify($notify);
            }
        }
        
        $miner->name                = $request->name;
        $miner->coin_code           = $request->coin_code;
        $miner->min_withdraw_limit  = $request->min_withdraw_limit;
        $miner->max_withdraw_limit  = $request->max_withdraw_limit;
        $miner->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
