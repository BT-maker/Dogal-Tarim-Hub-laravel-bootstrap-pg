<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTService
{
    private string $secretKey;
    private string $algorithm;
    private int $expirationTime;

    public function __construct()
    {
        $this->secretKey = config('app.key') . '_jwt_secret';
        $this->algorithm = 'HS256';
        $this->expirationTime = 60 * 60 * 24; // 24 hours
    }

    /**
     * Generate JWT token for admin user
     *
     * @param array $payload
     * @return string
     */
    public function generateToken(array $payload): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + $this->expirationTime;

        $token = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'iss' => config('app.url'),
            'data' => $payload
        ];

        return JWT::encode($token, $this->secretKey, $this->algorithm);
    }

    /**
     * Decode and validate JWT token
     *
     * @param string $token
     * @return array|null
     */
    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, $this->algorithm));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Check if token is expired
     *
     * @param string $token
     * @return bool
     */
    public function isTokenExpired(string $token): bool
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, $this->algorithm));
            return $decoded->exp < time();
        } catch (Exception $e) {
            return true;
        }
    }

    /**
     * Refresh token if it's close to expiration
     *
     * @param string $token
     * @return string|null
     */
    public function refreshToken(string $token): ?string
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, $this->algorithm));
            
            // If token expires in less than 1 hour, refresh it
            if ($decoded->exp - time() < 3600) {
                return $this->generateToken((array) $decoded->data);
            }
            
            return $token;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Extract user data from token
     *
     * @param string $token
     * @return array|null
     */
    public function getUserFromToken(string $token): ?array
    {
        return $this->validateToken($token);
    }
}