<?php

namespace ProNetworkUtilitiesSecurityAnalytics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProNetwork\Models\CompanyProfile;
use ProNetwork\Services\ProfileEnhancementService;
use ProNetworkUtilitiesSecurityAnalytics\Http\Requests\UpdateCompanyProfileRequest;

class CompanyProfileController extends Controller
{
    public function __construct(protected ProfileEnhancementService $profileEnhancementService)
    {
    }

    public function show(Request $request, int $companyId)
    {
        $profile = CompanyProfile::with('employees')->where('page_id', $companyId)->firstOrFail();
        $employeeCount = $this->profileEnhancementService->computeEmployeeCount($profile);

        if ($request->expectsJson()) {
            return response()->json([
                'profile' => $profile,
                'employee_count' => $employeeCount,
            ]);
        }

        return view('pro_network::company.show', [
            'profile' => $profile,
            'employeeCount' => $employeeCount,
        ]);
    }

    public function update(UpdateCompanyProfileRequest $request, int $companyId)
    {
        $payload = $request->validated();
        $profile = $this->profileEnhancementService->updateCompanyProfile($companyId, [
            'name' => $payload['name'] ?? null,
            'description' => $payload['description'] ?? null,
            'website' => $payload['website'] ?? null,
            'location' => $payload['location'] ?? null,
            'industries' => $payload['industries'] ?? [],
            'tags' => $payload['tags'] ?? [],
            'is_hiring' => $payload['is_hiring'] ?? false,
            'is_remote_friendly' => $payload['is_remote_friendly'] ?? false,
        ]);

        $employeeCount = $this->profileEnhancementService->computeEmployeeCount($profile);

        if ($request->expectsJson()) {
            return response()->json([
                'profile' => $profile->fresh(),
                'employee_count' => $employeeCount,
            ]);
        }

        return view('pro_network::company.show', [
            'profile' => $profile->fresh(),
            'employeeCount' => $employeeCount,
        ]);
    }
}
