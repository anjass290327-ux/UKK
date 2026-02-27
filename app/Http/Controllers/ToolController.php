<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $tools = Tool::with('category')->paginate(10);
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:tools',
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'condition' => 'required|in:sangat baik,baik,sedang,rusak',
            'location' => 'nullable|string',
            'purchase_date' => 'nullable|date',
        ]);

        $tool = Tool::create($validated);

        $this->logActivity('CREATE', "Alat {$tool->name} berhasil dibuat", 'tools', $tool->id);

        return redirect()->route('tools.index')->with('success', 'Alat berhasil ditambahkan');
    }

    public function edit(Tool $tool)
    {
        $categories = Category::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:tools,code,' . $tool->id,
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'condition' => 'required|in:sangat baik,baik,sedang,rusak',
            'location' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $tool->update($validated);

        $this->logActivity('UPDATE', "Alat {$tool->name} berhasil diperbarui", 'tools', $tool->id);

        return redirect()->route('tools.index')->with('success', 'Alat berhasil diperbarui');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();

        $this->logActivity('DELETE', "Alat {$tool->name} berhasil dihapus", 'tools', $tool->id);

        return redirect()->route('tools.index')->with('success', 'Alat berhasil dihapus');
    }

    protected function logActivity($action, $description, $table_name = null, $record_id = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'table_name' => $table_name,
            'record_id' => $record_id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
