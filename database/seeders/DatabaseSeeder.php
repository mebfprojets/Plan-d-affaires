<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessPlan;
use App\Models\Document;
use App\Models\AnalysisChart;
use App\Models\FinancialStructure;
use App\Models\Notification;
use App\Models\AssistanceMessage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Plans d'affaires
        for ($i = 1; $i <= 10; $i++) {
            BusinessPlan::create([
                'user_id' => 1, // À adapter
                'title' => "Plan d'affaires $i",
                'description' => "Description du plan d'affaires $i",
                'total_budget' => rand(10000, 1000000),
                'financial_projections' => json_encode(['year1' => 50000, 'year2' => 100000]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Documents
        for ($i = 1; $i <= 20; $i++) {
            Document::create([
                'business_plan_id' => rand(1, 10),
                'file_name' => "document_$i.pdf",
                'file_path' => "uploads/documents/document_$i.pdf",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Graphiques d'analyse
        for ($i = 1; $i <= 15; $i++) {
            AnalysisChart::create([
                'business_plan_id' => rand(1, 10),
                'chart_type' => 'bar',
                'data' => json_encode(['x' => [1, 2, 3], 'y' => [100, 200, 300]]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Structures de financement
        for ($i = 1; $i <= 5; $i++) {
            FinancialStructure::create([
                'name'=>'name'.$i,
                 'contact'=>'contact'.$i,
               'email'=>'email'.$i,
                'address'=>'address'.$i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Notifications
        for ($i = 1; $i <= 30; $i++) {
            Notification::create([
                'title' => "Notification $i",
                'message' => "Message de la notification $i",
                'type' => 'info',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Messages d'assistance
        for ($i = 1; $i <= 50; $i++) {
            AssistanceMessage::create([
                'content' => "Message d'assistance $i",
                'sender' => 'Système',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
