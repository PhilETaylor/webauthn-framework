<?php

declare(strict_types=1);

namespace Webauthn\Event;

use Psr\Http\Message\ServerRequestInterface;
use Webauthn\AuthenticatorAssertionResponse;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialSource;

class AuthenticatorAssertionResponseValidationSucceededEvent
{
    public function __construct(
        private readonly null|string $credentialId,
        private readonly AuthenticatorAssertionResponse $authenticatorAssertionResponse,
        private readonly PublicKeyCredentialRequestOptions $publicKeyCredentialRequestOptions,
        public readonly ServerRequestInterface|string $host,
        private readonly ?string $userHandle,
        private readonly PublicKeyCredentialSource $publicKeyCredentialSource
    ) {
        if ($host instanceof ServerRequestInterface) {
            trigger_deprecation(
                'web-auth/webauthn-lib',
                '4.5.0',
                sprintf(
                    'Passing a %s to the class "%s" is deprecated since 4.5.0 and will be removed in 5.0.0. Please inject the host as a string instead.',
                    ServerRequestInterface::class,
                    self::class
                )
            );
        }
        if ($this->credentialId !== null) {
            trigger_deprecation(
                'web-auth/webauthn-lib',
                '4.6.0',
                'The argument "$credentialId" is deprecated since 4.6.0 and will be removed in 5.0.0. Please set null instead.'
            );
        }
    }

    public function getCredentialId(): string
    {
        return $this->publicKeyCredentialSource->publicKeyCredentialId;
    }

    public function getAuthenticatorAssertionResponse(): AuthenticatorAssertionResponse
    {
        return $this->authenticatorAssertionResponse;
    }

    public function getPublicKeyCredentialRequestOptions(): PublicKeyCredentialRequestOptions
    {
        return $this->publicKeyCredentialRequestOptions;
    }

    /**
     * @deprecated since 4.5.0 and will be removed in 5.0.0. Please use the `host` property instead
     * @infection-ignore-all
     */
    public function getRequest(): ServerRequestInterface|string
    {
        return $this->host;
    }

    public function getUserHandle(): ?string
    {
        return $this->userHandle;
    }

    public function getPublicKeyCredentialSource(): PublicKeyCredentialSource
    {
        return $this->publicKeyCredentialSource;
    }
}
