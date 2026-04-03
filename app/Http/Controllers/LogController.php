<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $date    = $request->query('date');
        $keyword = $request->query('keyword');

        $query = ActionLog::with('user')->latest();

        if ($date && strtotime($date)) {
            $query->whereDate('created_at', $date);
        }

        if ($keyword !== null && $keyword !== '') {
            $query->where('action', 'like', "%{$keyword}%");
        }

        $logs = $query->paginate(50);

        return view('logs.index', compact('logs', 'date', 'keyword'));
    }

    public function purge(Request $request)
    {
        ActionLog::where('created_at', '<', now()->subMonths(12))->delete();

        return redirect()->route('logs.index')->with('status', 'Logs purgés avec succès.');
    }
}
