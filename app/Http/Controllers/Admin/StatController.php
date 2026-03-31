<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use App\Services\CacheService;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::ordered()->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'    => 'required|string|max:100',
            'value'    => 'required|string|max:20',
            'target'   => 'required|integer|min:0',
            'suffix'   => 'nullable|string|max:5',
            'duration' => 'required|integer|min:1|max:1000',
            'step'     => 'required|integer|min:1',
            'order'    => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = true;
        $validated['order']     = $validated['order'] ?? Stat::max('order') + 1;

        Stat::create($validated);

        CacheService::clearStats();

        return redirect()
            ->route('admin.stats.index')
            ->with('success', 'Estadística creada correctamente.');
    }

    public function update(Request $request, Stat $stat)
    {
        $validated = $request->validate([
            'label'    => 'required|string|max:100',
            'value'    => 'required|string|max:20',
            'target'   => 'required|integer|min:0',
            'suffix'   => 'nullable|string|max:5',
            'duration' => 'required|integer|min:1|max:1000',
            'step'     => 'required|integer|min:1',
            'order'    => 'nullable|integer|min:0',
            'is_active'=> 'nullable|boolean',
        ]);

        $validated['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);

        $stat->update($validated);

        CacheService::clearStats();

        return redirect()
            ->route('admin.stats.index')
            ->with('success', 'Estadística actualizada correctamente.');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();

        CacheService::clearStats();

        return redirect()
            ->route('admin.stats.index')
            ->with('success', 'Estadística eliminada.');
    }

    public function toggleActive(Stat $stat)
    {
        $stat->update(['is_active' => !$stat->is_active]);

        CacheService::clearStats();

        return redirect()
            ->route('admin.stats.index')
            ->with('success', 'Estado actualizado.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:stats,id',
        ]);

        foreach ($request->order as $position => $id) {
            Stat::where('id', $id)->update(['order' => $position + 1]);
        }

        CacheService::clearStats();

        return response()->json(['success' => true]);
    }
}
