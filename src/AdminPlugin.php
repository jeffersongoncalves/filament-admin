<?php

namespace JeffersonGoncalves\Filament\Admin;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Tables\Enums\ActionsPosition;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource;

class AdminPlugin implements Plugin
{
    /** @var class-string<AdminResource> */
    protected string $resource = AdminResource::class;

    protected ?string $navigationGroup = null;

    protected bool|Closure $groupRecordActions = false;

    protected ActionsPosition|Closure|null $recordActionsPosition = null;

    public function getId(): string
    {
        return 'filament-admin';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            $this->resource,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    /**
     * Swap in the app's own resource (usually a subclass of AdminResource).
     *
     * @param  class-string<AdminResource>  $resource
     */
    public function resource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * Navigation group for the resource. null keeps the translated default ("Management").
     */
    public function navigationGroup(?string $navigationGroup): static
    {
        $this->navigationGroup = $navigationGroup;

        return $this;
    }

    public function getNavigationGroup(): string
    {
        return $this->navigationGroup ?? __('filament-admin::resources/admin.navigation.group');
    }

    /**
     * Wrap the resource table's record actions in a single ActionGroup dropdown.
     */
    public function groupRecordActions(bool|Closure $condition = true): static
    {
        $this->groupRecordActions = $condition;

        return $this;
    }

    /**
     * Whether the record actions should be wrapped in an ActionGroup.
     */
    public function shouldGroupRecordActions(): bool
    {
        return (bool) value($this->groupRecordActions);
    }

    /**
     * Position of the resource table's record actions. null keeps the table's (or global) default.
     */
    public function recordActionsPosition(ActionsPosition|Closure|null $position): static
    {
        $this->recordActionsPosition = $position;

        return $this;
    }

    /**
     * Record actions position override, or null to keep the table's (or global) default.
     */
    public function getRecordActionsPosition(): ActionsPosition|Closure|null
    {
        return $this->recordActionsPosition;
    }
}
