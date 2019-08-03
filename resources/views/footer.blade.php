<footer class="footer m-4" id="footer">
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col col-md-2 d-none d-md-flex">
                <img src="{{ asset('images/guild_emblem.png') }}" alt="Guild Emblem" class="img-fluid ml-4 max-height-150">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <ul class="nav flex-column">
                            <li class="nav-item py-2 px-3" rel="copyright">
                                <font-awesome-icon :icon="['far', 'copyright']" class="nav-icon"></font-awesome-icon>
                                {{ Carbon::now()->year }} The Order
                            </li>
                            @if ($user)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('account/settings') }}">
                                        <font-awesome-icon :icon="['far', 'user-cog']" class="nav-icon"></font-awesome-icon>
                                        {{ __('navigation.account_settings') }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('privacy') }}">
                                    <font-awesome-icon :icon="['far', 'user-secret']" class="nav-icon"></font-awesome-icon>
                                    {{ __('footer.privacy') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('battlenet') }}">
                                    <font-awesome-icon :icon="['fab', 'battle-net']" class="nav-icon"></font-awesome-icon>
                                    {{ __('footer.battlenet') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="w-100 my-2 d-sm-none"></div>
                    <div class="col">
                        <ul class="nav flex-column">
                            {{-- Roster --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('roster') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'address-book']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.roster') }}
                                </a>
                            </li>

                            {{-- News --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('news') }}">
                                    <font-awesome-icon :icon="['far', 'newspaper']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.news') }}
                                </a>
                            </li>

                            {{-- Forum --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('forum') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'comments']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.forum') }}
                                </a>
                            </li> --}}

                            {{-- Events --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('events') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'calendar-alt']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.events') }}
                                </a>
                            </li>

                            {{-- Teams --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('teams') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'helmet-battle']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.teams') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="w-100 d-sm-none"></div>
                    <div class="col">
                        <ul class="nav flex-column">
                            {{-- Guild Bank --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('bank') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'treasure-chest']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.guild_bank') }}
                                </a>
                            </li>

                            {{-- Marketplace --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('marketplace') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'balance-scale']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.marketplace') }}
                                </a>
                            </li>

                            {{-- Applications --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('join') }}">
                                    <font-awesome-icon :icon="['far', 'user-plus']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.join') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="w-100 my-2 d-sm-none"></div>
                    <div class="col">
                        <ul class="nav flex-column">
                            {{-- Discord --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('discord') }}">
                                    <font-awesome-icon :icon="['fab', 'discord']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.discord') }}
                                </a>
                            </li>

                            {{-- Patreon --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="https://patreon.com/fortheorder" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['fab', 'patreon']" class="nav-icon"></font-awesome-icon>
                                    {{ __('navigation.patreon') }}
                                </a>
                            </li>

                            {{-- Email --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="mailto:hey@theorder.gg">
                                    <font-awesome-icon :icon="['far', 'envelope-open']" class="nav-icon"></font-awesome-icon>
                                    hey@theorder.gg
                                </a>
                            </li> --}}

                            {{-- Creator --}}
                            <li class="nav-item">
                                <a class="nav-link" href="http://benargo.com" title="Ben Argo">
                                    <font-awesome-icon :icon="['fab', 'safari']" class="nav-icon"></font-awesome-icon>
                                    {{ __('footer.creator') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col col-md-2 d-none d-md-flex text-right">
                <a href="https://worldofwarcraft.com/wowclassic" class="d-inline-block">
                    <img class="img-fluid max-height-150 mr-4" src="{{ asset('images/wow_classic_logo.png') }}" alt="{{ __('footer.wow_classic') }}" height="100" />
                    <span class="sr-only">{{ __('footer.wow_classic') }}</span>
                </a>
            </div>
        </div>
        <div class="row my-4" rel="disclaimer">
            <div class="col">
                <p class="disclaimer text-muted">
                    {!! __('footer.disclaimer') !!}
                </p>
            </div>
        </div>
    </div>
</footer>
