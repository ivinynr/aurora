<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {}

    public function __invoke(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'resumo' => $this->dashboardService->resumo(),
            'doacoesRecentes' => $this->dashboardService->doacoesRecentes(),
            'campanhasMaisArrecadadas' => $this->dashboardService->campanhasMaisArrecadadas(),
        ]);
    }
}
