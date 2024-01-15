<?php

namespace App\Services;

use App\Models\Establishment as Tenant;

class TenantManager
{

    protected $tenant;

    public function setTenant(Tenant $tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function loadTenant(string $domain): ?self
    {
        if (!$tenant = Tenant::whereDomain($this->extractSubdomain($domain))->first()) {
            return $this;
        }

        $this->setTenant($tenant);

        return $this;
    }

    public function switchTenant($tenant)
    {
        if(!$tenant instanceof Tenant) {
            $tenant = Tenant::findOrFail((int) $tenant);
        }

        config(['database.connections.tenant.database' => $tenant->database]);
        config(['database.connections.tenant.username' => $tenant->database_username]);
        config(['database.connections.tenant.password' => $tenant->database_password]);
        \DB::purge('tenant');
        \DB::connection('tenant')->reconnect();
        $this->setTenant($tenant);
        \DB::setDefaultConnection('tenant');

        $this->setTenantGlobally();
    }

    // Set tenant globally so that it is accessible from every where.
    private function setTenantGlobally()
    {
        \App::singleton('tenant', function() {
            return $this->getTenant();
        });
    }

    private function extractSubdomain($domain): string
    {
        return explode('.', $domain)[0];
    }

}