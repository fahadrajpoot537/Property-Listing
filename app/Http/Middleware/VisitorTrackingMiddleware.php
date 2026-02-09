<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorTrackingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Simple bot detection (can be improved)
        $userAgent = $request->userAgent();
        $botPatterns = ['bot', 'crawl', 'spider', 'slurp', 'mediapartners'];
        foreach ($botPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return $next($request);
            }
        }

        // Affiliate Tracking Logic
        $affiliateId = session('affiliate_id');

        if ($request->has('ref')) {
            $refCode = $request->query('ref');
            $affiliate = \App\Models\Affiliate::where('referral_code', $refCode)->first();
            if ($affiliate && $affiliate->status === 'active') {
                $affiliateId = $affiliate->id;
                session(['affiliate_id' => $affiliateId]);
            }
        }

        try {
            \App\Models\VisitorAnalytic::create([
                'ip_address' => $request->ip(),
                'user_id' => auth()->id(),
                'affiliate_id' => $affiliateId,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $userAgent,
                // These would typically require a GeoIP service, leaving null for now or using headers if available
                'country' => $request->header('CF-IPCountry'), // Example for Cloudflare
                'city' => null,
                'device' => $this->getDevice($userAgent),
                'platform' => $this->getPlatform($userAgent),
                'browser' => $this->getBrowser($userAgent),
            ]);
        } catch (\Exception $e) {
            // Do not fail the request if analytics fail
            \Illuminate\Support\Facades\Log::error('Visitor Tracking Failed: ' . $e->getMessage());
        }

        return $next($request);
    }

    private function getDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) {
            return 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    private function getPlatform($userAgent)
    {
        if (preg_match('/linux/i', $userAgent))
            return 'Linux';
        if (preg_match('/macintosh|mac os x/i', $userAgent))
            return 'Mac';
        if (preg_match('/windows|win32/i', $userAgent))
            return 'Windows';
        return 'Unknown';
    }

    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false)
            return 'IE';
        if (strpos($userAgent, 'Edge') !== false)
            return 'Edge';
        if (strpos($userAgent, 'Firefox') !== false)
            return 'Firefox';
        if (strpos($userAgent, 'Chrome') !== false)
            return 'Chrome';
        if (strpos($userAgent, 'Safari') !== false)
            return 'Safari';
        return 'Unknown';
    }
}
