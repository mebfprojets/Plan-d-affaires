<?php
namespace App\Services;

use OpenAI\Factory;

class AITextGenerationService
{
    protected $client;

    public function __construct()
    {
        $this->client = Factory::build()->withApiKey(env('OPENAI_API_KEY'));
    }

    public function generateExecutiveSummary($project_name)
    {
        $response = $this->client->completions->create([
            'model' => 'gpt-4',
            'prompt' => "Generate an executive summary for a business plan named '$project_name'.",
            'max_tokens' => 500,
        ]);
        return $response['choices'][0]['text'];
    }

    public function generateMarketAnalysis($project_name)
    {
        $response = $this->client->completions->create([
            'model' => 'gpt-4',
            'prompt' => "Generate a market analysis for a business plan named '$project_name'.",
            'max_tokens' => 500,
        ]);
        return $response['choices'][0]['text'];
    }

    // Autres méthodes pour générer d'autres sections comme Marketing, Operations, Financial
}
