<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->favicon(asset('favicon.svg'))
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                \Filament\Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => <<<'HTML'
                <style>
                    [x-ref="panel"] {
                        /* Ensure panels are hidden by default to prevent flash of unstyled content */
                        display: none;
                    }
                </style>
                <script>
                    (function() {
                        // --- Sidebar store (unchanged) ---
                        const createStore = () => ({
                            isOpen: window.innerWidth >= 1024,
                            collapsedGroups: [],

                            open() { this.isOpen = true },
                            close() { this.isOpen = false },
                            toggle() { this.isOpen = !this.isOpen },

                            groupIsCollapsed(label) {
                                return this.collapsedGroups.includes(label)
                            },

                            toggleCollapsedGroup(label) {
                                const index = this.collapsedGroups.indexOf(label)
                                if (index === -1) {
                                    this.collapsedGroups.push(label)
                                } else {
                                    this.collapsedGroups.splice(index, 1)
                                }
                            }
                        });

                        const initSidebarStore = () => {
                            if (typeof Alpine !== "undefined" && Alpine.store) {
                                if (!Alpine.store("sidebar")) {
                                    Alpine.store("sidebar", createStore());
                                    console.log("✅ Sidebar store created");
                                }
                                return true;
                            }
                            return false;
                        };

                        // --- Robust element methods fallback ---
                        // Provide toggle() and close() on elements so $refs.panel?.toggle/close won't throw.
                        const ensureElementPrototypeMethods = () => {
                            try {
                                if (typeof Element === "undefined") return;

                                // Only define if not present to avoid overwriting native behavior
                                if (!Object.prototype.hasOwnProperty.call(Element.prototype, "toggle")) {
                                    Object.defineProperty(Element.prototype, "toggle", {
                                        configurable: true,
                                        enumerable: false,
                                        writable: true,
                                        value: function() {
                                            try {
                                                const el = this;
                                                const hidden = el.hasAttribute("hidden") || el.classList.contains("hidden") || window.getComputedStyle(el).display === "none";

                                                if (hidden) {
                                                    el.removeAttribute("hidden");
                                                    el.classList.remove("hidden");
                                                    el.style.display = "";
                                                } else {
                                                    el.setAttribute("hidden", "");
                                                    el.classList.add("hidden");
                                                    el.style.display = "none";
                                                }

                                                // emit event for other code listening
                                                el.dispatchEvent(new CustomEvent("filament.panel.toggled", { bubbles: true }));
                                            } catch (e) {
                                                // swallow
                                            }
                                        }
                                    });
                                }

                                if (!Object.prototype.hasOwnProperty.call(Element.prototype, "close")) {
                                    Object.defineProperty(Element.prototype, "close", {
                                        configurable: true,
                                        enumerable: false,
                                        writable: true,
                                        value: function() {
                                            try {
                                                const el = this;
                                                el.setAttribute("hidden", "");
                                                el.classList.add("hidden");
                                                el.style.display = "none";
                                                el.dispatchEvent(new CustomEvent("filament.panel.closed", { bubbles: true }));
                                            } catch (e) {
                                                // swallow
                                            }
                                        }
                                    });
                                }
                            } catch (e) {
                                // ignore
                            }
                        };

                        // Attach per-element fallback (in case some code expects instance methods)
                        const attachPanelMethodsToElements = (root = document) => {
                            try {
                                ensureElementPrototypeMethods();
                                root.querySelectorAll('[x-ref="panel"]').forEach(el => {
                                    // Ensure methods exist on instance too (defensive)
                                    if (typeof el.toggle !== "function") {
                                        try { el.toggle = Element.prototype.toggle.bind(el); } catch (_) {}
                                    }
                                    if (typeof el.close !== "function") {
                                        try { el.close = Element.prototype.close.bind(el); } catch (_) {}
                                    }
                                });
                            } catch (e) {
                                // ignore
                            }
                        };

                        // Try to initialize sidebar store immediately; otherwise wait for alpine:init
                        if (!initSidebarStore()) {
                            document.addEventListener("alpine:init", initSidebarStore);
                        }

                        // Ensure element methods are attached at key lifecycle points
                        const safeAttach = () => attachPanelMethodsToElements(document);

                        // initial attempt
                        safeAttach();

                        // After Alpine ready
                        document.addEventListener("alpine:init", () => {
                            safeAttach();
                        });

                        // Filament / Livewire lifecycle hooks
                        document.addEventListener("filament::rendered", () => {
                            safeAttach();
                        });
                        // Livewire events that may re-render parts
                        document.addEventListener("livewire:load", () => safeAttach());
                        document.addEventListener("livewire:update", () => safeAttach());
                        document.addEventListener("livewire:navigated", () => safeAttach());

                        // Polling fallback for very early loads (a limited number of tries)
                        let attempts = 0;
                        const poll = setInterval(() => {
                            safeAttach();
                            if (++attempts > 120) clearInterval(poll);
                        }, 50);

                        // MutationObserver catches nodes inserted by Livewire / Filament
                        try {
                            const observer = new MutationObserver(mutations => {
                                for (const m of mutations) {
                                    for (const n of m.addedNodes) {
                                        if (n && n.nodeType === 1) {
                                            attachPanelMethodsToElements(n);
                                        }
                                    }
                                }
                            });
                            observer.observe(document.body, { childList: true, subtree: true });
                        } catch (e) {
                            // ignore
                        }
                    })();
                </script>
                HTML
            );
    }
}
