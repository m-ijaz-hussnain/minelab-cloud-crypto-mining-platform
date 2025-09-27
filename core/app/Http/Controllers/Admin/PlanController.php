<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Miner;
use App\Models\Order;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller {
    public function index() {
        $pageTitle = "Mining Plans";
        $plans     = Plan::with('miner');

        if (request()->search) {
            $key   = trim(request()->search);
            $plans = $plans->where('title', 'LIKE', "%$key%")
                ->orWhereHas('miner', function ($product) use ($key) {
                    $product->where('name', 'like', "%$key%");
                });
        }

        $plans  = $plans->orderBy('id', 'desc')->paginate(getPaginate());
        $miners = Miner::orderBy('name')->get();

        return view('admin.miner.plans', compact('pageTitle', 'plans', 'miners'));
    }

    public function store(Request $request) {
        $this->validation($request);

        $plan         = new Plan();
        $plan->status = Status::ENABLE;
        $this->savePlan($plan, $request);

        $notify[] = ['success', 'Plan created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id) {
        $this->validation($request);
        $plan         = Plan::findOrFail($id);
        $plan->status = isset($request->status) ? Status::ENABLE : Status::DISABLE;
        $this->savePlan($plan, $request);

        $notify[] = ['success', 'Plan updated successfully'];
        return back()->withNotify($notify);
    }

    public function orders() {
        $pageTitle = "Mining Tracks";
        $orders    = Order::with('user');

        if (request()->search) {
            $key    = request()->search;
            $orders = Order::where('trx', $key);
        }

        $orders = $orders->with('deposit.gateway', 'miner')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.miner.order', compact('pageTitle', 'orders'));
    }

    protected function validation($request) {
        $request->validate([
            'miner'              => 'required|exists:miners,id',
            'title'              => 'required|string|max:255',
            'price'              => 'required|numeric',
            'return_per_day'     => 'required_if:return_type,1|numeric',
            'min_return_per_day' => 'required_if:return_type,2|numeric',
            'max_return_per_day' => 'required_if:return_type,2|numeric',
            'speed'              => 'required|numeric',
            'speed_unit'         => 'required|integer|between:0,8',
            'period'             => 'required|numeric|gt:0',
            'period_unit'        => 'required|integer|between:0,2',
            'description'        => 'nullable|string',
            'status'             => 'nullable|regex:(on)',
            'features'           => 'nullable|array',
            'features.*'         => 'string',
            'maintenance_cost'   => 'required|numeric|gte:0',
        ]);
    }

    protected function savePlan($plan, $request) {
        $plan->miner_id           = $request->miner;
        $plan->title              = $request->title;
        $plan->price              = $request->price;
        $plan->min_return_per_day = $request->return_per_day ?? $request->min_return_per_day;
        $plan->max_return_per_day = $request->max_return_per_day ?? null;
        $plan->speed              = $request->speed;
        $plan->speed_unit         = $request->speed_unit;
        $plan->period             = $request->period;
        $plan->period_unit        = $request->period_unit;
        $plan->description        = $request->description;
        $plan->maintenance_cost   = $request->maintenance_cost;
        $plan->features           = $request->features ?? [];
        $plan->save();
    }


    public function status($id)
    {
        return Plan::changeStatus($id);
    }
}
