<?php

namespace App\Http\Middleware;

use Closure;

class HSTS{
  
  public function handle($request, Closure $next){
    $response = $next($request);

    // Add security headers
    // $response->headers->set('Content-Security-Policy', "default-src 'self' https://ticketm.co https://www.ticketm.co; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' data: https:; connect-src 'self' wss://ticketm.co:9801; frame-src 'self' https:; object-src 'none'; base-uri 'self'; form-action 'self'; upgrade-insecure-requests; block-all-mixed-content;");
    
    $response->headers->set('Content-Security-Policy', "default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' data: https:; connect-src 'self' https: wss://ticketm.co:9801 wss://bitmo.co:13600; frame-src 'self' https:; object-src 'none'; base-uri 'self'; form-action 'self'; upgrade-insecure-requests; block-all-mixed-content;");

    $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('Referrer-Policy', 'no-referrer, strict-origin-when-cross-origin');
    $response->headers->set('Permissions-Policy', 'geolocation=(), vibrate=(), payment=(), autoplay=(self)');

    $response->headers->set('Access-Control-Allow-Origin', '*'); // O reemplaza '*' con tu dominio específico
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

    return $response;
  }
}