<footer class="footer mx-3 mx-md-5 my-5" id="footer">
    <div class="container-fluid">
        <div class="row my-5">
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
                                        Account Settings
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('privacy') }}">
                                    <font-awesome-icon :icon="['far', 'user-secret']" class="nav-icon"></font-awesome-icon>
                                    Privacy Policy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('battlenet') }}">
                                    <font-awesome-icon :icon="['fab', 'battle-net']" class="nav-icon"></font-awesome-icon>
                                    Battle.net API Usage
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
                                    Roster
                                </a>
                            </li>

                            {{-- News --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('news') }}">
                                    <font-awesome-icon :icon="['far', 'newspaper']" class="nav-icon"></font-awesome-icon>
                                    News
                                </a>
                            </li> --}}

                            {{-- Forum --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('forum') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'comments']" class="nav-icon"></font-awesome-icon>
                                    Forum
                                </a>
                            </li> --}}

                            {{-- Events --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('events') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'calendar-alt']" class="nav-icon"></font-awesome-icon>
                                    Events
                                </a>
                            </li>

                            {{-- Teams --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('teams') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'helmet-battle']" class="nav-icon"></font-awesome-icon>
                                    Teams
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="w-100 d-sm-none"></div>
                    <div class="col">
                        <ul class="nav flex-column">
                            {{-- Guild Bank --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('bank') }}">
                                    <font-awesome-icon :icon="['far', 'treasure-chest']" class="nav-icon"></font-awesome-icon>
                                    Guild Bank
                                </a>
                            </li>

                            {{-- Marketplace --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="{{ url('marketplace') }}" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['far', 'balance-scale']" class="nav-icon"></font-awesome-icon>
                                    Marketplace
                                </a>
                            </li>

                            {{-- Applications --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('join') }}">
                                    <font-awesome-icon :icon="['far', 'user-plus']" class="nav-icon"></font-awesome-icon>
                                    Join The Order
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
                                    Discord
                                </a>
                            </li>

                            {{-- Patreon --}}
                            <li class="nav-item">
                                <a class="nav-link disabled" href="https://patreon.com/fortheorder" tabindex="-1" aria-disabled="true">
                                    <font-awesome-icon :icon="['fab', 'patreon']" class="nav-icon"></font-awesome-icon>
                                    Patreon
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
                                    Website by Ben Argo
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col col-md-2 d-none d-md-flex text-right">
                <a href="https://worldofwarcraft.com/wowclassic" class="d-inline-block">
                    <img class="img-fluid max-height-150 mr-4" src="{{ asset('images/wow_classic_logo.png') }}" alt="World of Warcraft: Classic" height="100" />
                    <span class="sr-only">World of Warcraft: Classic</span>
                </a>
            </div>
        </div>
        <div class="row my-4" rel="disclaimer">
            <div class="col">
                <p class="disclaimer text-muted">
                    Disclaimer: Classic is a trademark, and World of Warcraft and Warcraft are trademarks or registered trademarks of Blizzard Entertainment, Inc., in the U.S. and/or other countries. All related materials, logos, and images are copyright &copy; Blizzard Entertainment, Inc.. The Order is in no way associated with or endorsed by Blizzard Entertainment.
                </p>
            </div>
        </div>
    </div>
</footer>
