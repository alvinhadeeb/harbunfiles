<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockSuspiciousRequests
{
    /**
     * Block common hacking attempts:
     * - PHP shell uploads
     * - SQL injection patterns in URLs
     * - Path traversal attacks
     * - Common exploit scanners
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->getRequestUri();
        $userAgent = $request->userAgent() ?? '';

        // Block common exploit paths
        $blockedPaths = [
            '/wp-admin', '/wp-login', '/wp-content', '/wp-includes', // WordPress exploits
            '/xmlrpc.php', '/wp-cron.php',
            '/administrator', '/admin.php',                          // Other CMS
            '/phpmyadmin', '/pma', '/myadmin', '/mysql',             // Database tools
            '/.env', '/.git', '/.svn',                               // Config/VCS files
            '/config.php', '/configuration.php',
            '/shell', '/cmd', '/c99', '/r57',                        // Web shells
            '/eval-stdin.php', '/vendor/phpunit',                    // Known exploits
            '/.well-known/security.txt',
        ];

        foreach ($blockedPaths as $blocked) {
            if (stripos($uri, $blocked) !== false) {
                abort(404);
            }
        }

        // Block SQL injection patterns in URL
        $sqlPatterns = [
            '/union\s+(all\s+)?select/i',
            '/\bor\b\s+\d+\s*=\s*\d+/i',
            '/\band\b\s+\d+\s*=\s*\d+/i',
            '/select\s+.*\s+from\s+/i',
            '/insert\s+into\s+/i',
            '/drop\s+table/i',
            '/update\s+.*\s+set\s+/i',
            '/delete\s+from\s+/i',
            '/\bexec\b/i',
            '/benchmark\s*\(/i',
            '/sleep\s*\(/i',
        ];

        $fullUrl = urldecode($uri);
        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $fullUrl)) {
                abort(403, 'Forbidden');
            }
        }

        // Block path traversal
        if (preg_match('/\.\.\/|\.\.\\\\/', $uri)) {
            abort(403, 'Forbidden');
        }

        // Block suspicious user agents (common scanners/bots)
        $blockedAgents = [
            'sqlmap', 'nikto', 'nmap', 'masscan', 'dirbuster',
            'gobuster', 'wpscan', 'nuclei', 'zgrab', 'python-requests',
            'go-http-client', 'curl/', 'wget/',
        ];

        foreach ($blockedAgents as $blocked) {
            if (stripos($userAgent, $blocked) !== false) {
                abort(403, 'Forbidden');
            }
        }

        // Block requests with suspicious file extensions
        $blockedExtensions = [
            '.php~', '.bak', '.sql', '.tar.gz', '.zip',
            '.log', '.ini', '.sh', '.bash',
        ];

        foreach ($blockedExtensions as $ext) {
            if (str_ends_with(strtolower($uri), $ext)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
