<?php

namespace App\Services;

use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    public function __construct()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path(env('GOOGLE_APPLICATION_CREDENTIALS')));
    }

    public function validateToken(string $recaptchaKey, string $token, string $project, string $action): ?float
    {
        if (!file_exists(getenv('GOOGLE_APPLICATION_CREDENTIALS'))) {
            throw new \Exception('Google Cloud credentials file not found.');
        }

        $client = new RecaptchaEnterpriseServiceClient();
        $projectName = $client->projectName($project);

        $event = (new Event())
            ->setSiteKey($recaptchaKey)
            ->setToken($token);

        $request = (new CreateAssessmentRequest())
            ->setParent($projectName)
            ->setAssessment((new Assessment())->setEvent($event));

        try {
            $response = $client->createAssessment($request);

            if (!$response->getTokenProperties()->getValid()) {
                throw new \Exception('Invalid token: ' . InvalidReason::name($response->getTokenProperties()->getInvalidReason()));
            }

            if ($response->getTokenProperties()->getAction() !== $action) {
                throw new \Exception('Action mismatch. Expected: ' . $action);
            }

            return $response->getRiskAnalysis()->getScore();
        } catch (\Exception $e) {
            Log::error('reCAPTCHA validation failed: ' . $e->getMessage());
            return null;
        }
    }
}
