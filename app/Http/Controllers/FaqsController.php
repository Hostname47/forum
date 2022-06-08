<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;

class FaqsController extends Controller
{
    public function faqs() {
        /**
         * We check for live attribute because when normal user submit a question the default value of live column is 0
         * and so it is not shown directly to FAQs page until an admin review it
         */
        $faqs = FAQ::where('live', 1)->orderBy('priority')->paginate(10);
        return view('faqs')
            ->with(compact('faqs'));
    }

    public function store(Request $request) {
        $this->authorize('store', [FAQ::class]);

        $data = $request->validate([
            'question'=>'required|min:10|max:400',
            'desc'=>'sometimes|max:800'
        ]);
        $data['user_id'] = auth()->user()->id;
        $data['priority'] = 10000; // This make it appear at the end when accepted

        FAQ::create($data);

        \Session::flash('message', __('Your question has been sent successfully'));
    }
}
