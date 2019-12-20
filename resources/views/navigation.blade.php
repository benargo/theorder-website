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
    <a class="nav-link" href="{{ url('forum') }}">
        <font-awesome-icon :icon="['far', 'comments']" class="nav-icon"></font-awesome-icon>
        Forum
    </a>
</li> --}}

{{-- Raiding --}}
<li class="nav-item">
    <a class="nav-link disabled" href="{{ url('raids') }}" tabindex="-1" aria-disabled="true">
        <font-awesome-icon :icon="['far', 'calendar-alt']" class="nav-icon"></font-awesome-icon>
        Raiding
    </a>
</li>

{{-- Teams --}}
{{-- <li class="nav-item">
    <a class="nav-link disabled" href="{{ url('teams') }}" tabindex="-1" aria-disabled="true">
        <font-awesome-icon :icon="['far', 'helmet-battle']" class="nav-icon"></font-awesome-icon>
        Teams
    </a>
</li> --}}

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

{{-- Discord --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('discord') }}">
        <font-awesome-icon :icon="['fab', 'discord']" class="nav-icon"></font-awesome-icon>
        Discord
    </a>
</li>

{{-- Applications --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('join') }}">
        <font-awesome-icon :icon="['far', 'user-plus']" class="nav-icon"></font-awesome-icon>
        Join The Order
    </a>
</li>
