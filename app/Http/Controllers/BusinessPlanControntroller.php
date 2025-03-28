<?php

namespace App\Http\Controllers;

use App\Models\BusinessPlan;
use App\Services\AITextGenerationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BusinessPlanControntroller extends Controller
{
    protected $aiService;

    public function __construct(AITextGenerationService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('businessplans.index')){
            $businessplans = BusinessPlan::all();
            return view('backend.businessplans.index', compact('businessplans'));
        }
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        return view('backend.businessplans.create');
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
        ]);

        // Création du plan d'affaires
        $businessPlan = BusinessPlan::create([
            'project_name' => $validated['project_name'],
            'executive_summary' => $this->aiService->generateExecutiveSummary($validated['project_name']),
            'market_analysis' => $this->aiService->generateMarketAnalysis($validated['project_name']),
            'marketing_strategy' => $this->aiService->generateMarketingStrategy($validated['project_name']),
            'operations_plan' => $this->aiService->generateOperationsPlan($validated['project_name']),
            'financial_plan' => $this->aiService->generateFinancialPlan($validated['project_name']),
        ]);

        // Optionnel : Générer des annexes, graphiques, tableaux, etc.
        $businessPlan->update([
            'annexes' => json_encode([
                'graph1' => '/path/to/graph1',
                'graph2' => '/path/to/graph2',
            ])
        ]);

        return redirect()->route('business-plans.show', $businessPlan);
    }

    public function show(BusinessPlan $businessPlan)
    {
        return view('business-plan.show', compact('businessPlan'));
    }
}
