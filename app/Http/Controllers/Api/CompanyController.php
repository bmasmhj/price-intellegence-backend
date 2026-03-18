<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\ScrapperLog;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query()->withCount('scrapperLogs')->withCount('products');

        if ($request->search) {
            $query->where('company_name', 'like', "%{$request->search}%");
        }

        return response()->json($query->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'full_script' => 'nullable|string|max:50',
        ]);

        $validated['created_at'] = now();
        $validated['updated_at'] = now();
        $validated['last_scrapped'] = now();

        $company = Company::create($validated);

        return response()->json($company, 201);
    }

    public function show(Company $company)
    {
        return response()->json($company);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'company_name' => 'sometimes|string|max:100',
            'url' => 'sometimes|string|max:255',
            'full_script' => 'nullable|string|max:50',
        ]);

        $company->update($validated);

        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted.']);
    }

    public function logs(Request $request, Company $company)
    {
        $statusMap = ['completed' => 1, 'processing' => 2, 'error' => 3 , 'no_script' => 4];

        $query = ScrapperLog::where('company_id', $company->id)
            ->orderByDesc('started_at');

        if ($request->status && isset($statusMap[$request->status])) {
            $query->where('status', $statusMap[$request->status]);
        }

        return response()->json($query->paginate(20));
    }
}
