<?php

declare(strict_types=1);

namespace Webauthn\Tests\Functional;

use Cose\Algorithms;
use PHPUnit\Framework\Attributes\Test;
use Webauthn\AuthenticatorAttestationResponse;
use Webauthn\PublicKeyCredential;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialParameters;
use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\Tests\AbstractTestCase;

/**
 * @internal
 */
final class Fido2AttestationStatementTest extends AbstractTestCase
{
    #[Test]
    public function aFidoU2FAttestationCanBeVerified(): void
    {
        $publicKeyCredentialCreationOptions = PublicKeyCredentialCreationOptions::create(
            PublicKeyCredentialRpEntity::create('My Application'),
            PublicKeyCredentialUserEntity::create(
                'test@foo.com',
                random_bytes(64),
                'Test PublicKeyCredentialUserEntity'
            ),
            base64_decode(
                'pGRaBff9zpaw3CDAsggpOMRonJaqMXYjkvIGTPt3rHH+53RCW7LQ9l4NmGcv8dNZSNLDrvQDKaSNhFjviggcZA==',
                true
            ),
            [PublicKeyCredentialParameters::create('public-key', Algorithms::COSE_ALGORITHM_ES256)],
            attestation: PublicKeyCredentialCreationOptions::ATTESTATION_CONVEYANCE_PREFERENCE_DIRECT
        );
        $publicKeyCredential = $this->getSerializer()
            ->deserialize(
                '{"id":"eHouz_Zi7-BmByHjJ_tx9h4a1WZsK4IzUmgGjkhyOodPGAyUqUp_B9yUkflXY3yHWsNtsrgCXQ3HjAIFUeZB-w","type":"public-key","rawId":"eHouz/Zi7+BmByHjJ/tx9h4a1WZsK4IzUmgGjkhyOodPGAyUqUp/B9yUkflXY3yHWsNtsrgCXQ3HjAIFUeZB+w==","response":{"clientDataJSON":"eyJjaGFsbGVuZ2UiOiJwR1JhQmZmOXpwYXczQ0RBc2dncE9NUm9uSmFxTVhZamt2SUdUUHQzckhILTUzUkNXN0xROWw0Tm1HY3Y4ZE5aU05MRHJ2UURLYVNOaEZqdmlnZ2NaQSIsImNsaWVudEV4dGVuc2lvbnMiOnt9LCJoYXNoQWxnb3JpdGhtIjoiU0hBLTI1NiIsIm9yaWdpbiI6Imh0dHBzOi8vbG9jYWxob3N0Ojg0NDMiLCJ0eXBlIjoid2ViYXV0aG4uY3JlYXRlIn0","attestationObject":"o2NmbXRoZmlkby11MmZnYXR0U3RtdKJjc2lnWEcwRQIhALAccRlhFqq41JTqOC3cHkkN+O6ouvv4izWZY2W7NFh/AiBndeDPR6P2DZzia1sD4JFa87f3t/8bUgWzOsELduLkRWN4NWOBWQLCMIICvjCCAaagAwIBAgIEdIb9wjANBgkqhkiG9w0BAQsFADAuMSwwKgYDVQQDEyNZdWJpY28gVTJGIFJvb3QgQ0EgU2VyaWFsIDQ1NzIwMDYzMTAgFw0xNDA4MDEwMDAwMDBaGA8yMDUwMDkwNDAwMDAwMFowbzELMAkGA1UEBhMCU0UxEjAQBgNVBAoMCVl1YmljbyBBQjEiMCAGA1UECwwZQXV0aGVudGljYXRvciBBdHRlc3RhdGlvbjEoMCYGA1UEAwwfWXViaWNvIFUyRiBFRSBTZXJpYWwgMTk1NTAwMzg0MjBZMBMGByqGSM49AgEGCCqGSM49AwEHA0IABJVd8633JH0xde/9nMTzGk6HjrrhgQlWYVD7OIsuX2Unv1dAmqWBpQ0KxS8YRFwKE1SKE1PIpOWacE5SO8BN6+2jbDBqMCIGCSsGAQQBgsQKAgQVMS4zLjYuMS40LjEuNDE0ODIuMS4xMBMGCysGAQQBguUcAgEBBAQDAgUgMCEGCysGAQQBguUcAQEEBBIEEPigEfOMCk0VgAYXER+e3H0wDAYDVR0TAQH/BAIwADANBgkqhkiG9w0BAQsFAAOCAQEAMVxIgOaaUn44Zom9af0KqG9J655OhUVBVW+q0As6AIod3AH5bHb2aDYakeIyyBCnnGMHTJtuekbrHbXYXERIn4aKdkPSKlyGLsA/A+WEi+OAfXrNVfjhrh7iE6xzq0sg4/vVJoywe4eAJx0fS+Dl3axzTTpYl71Nc7p/NX6iCMmdik0pAuYJegBcTckE3AoYEg4K99AM/JaaKIblsbFh8+3LxnemeNf7UwOczaGGvjS6UzGVI0Odf9lKcPIwYhuTxM5CaNMXTZQ7xq4/yTfC3kPWtE4hFT34UJJflZBiLrxG4OsYxkHw/n5vKgmpspB3GfYuYTWhkDKiE8CYtyg87mhhdXRoRGF0YVjESZYN5YgOjGh0NBcPZHZgW4/krrmihjLHmVzzuoMdl2NBAAAAAAAAAAAAAAAAAAAAAAAAAAAAQHh6Ls/2Yu/gZgch4yf7cfYeGtVmbCuCM1JoBo5IcjqHTxgMlKlKfwfclJH5V2N8h1rDbbK4Al0Nx4wCBVHmQfulAQIDJiABIVgglXnq9GsW6ygN/2GbeIOaWVzHFfPMrI71au4rDiRbHvMiWCD+erreXwgwlwh0oMlxdGH2GjPQv6dXA/U7GKXf+g1Biw=="}}',
                PublicKeyCredential::class,
                'json'
            );
        static::assertInstanceOf(AuthenticatorAttestationResponse::class, $publicKeyCredential->response);
        $this->getAuthenticatorAttestationResponseValidator()
            ->check($publicKeyCredential->response, $publicKeyCredentialCreationOptions, 'localhost');
    }
}
