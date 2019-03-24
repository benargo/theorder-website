{{-- Roster --}}
{{-- <li class="nav-item">
    <a class="nav-link" href="{{ url('roster') }}">
        <font-awesome-icon :icon="['far', 'address-book']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.roster') }}
    </a>
</li> --}}

{{-- News --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('news') }}">
        <font-awesome-icon :icon="['far', 'newspaper']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.news') }}
    </a>
</li>

{{-- Forum --}}
{{-- <li class="nav-item">
    <a class="nav-link" href="{{ url('forum') }}">
        <font-awesome-icon :icon="['far', 'comments']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.forum') }}
    </a>
</li> --}}

{{-- Events --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('events') }}">
        <font-awesome-icon :icon="['far', 'calendar-alt']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.events') }}
    </a>
</li>

{{-- Teams --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('teams') }}">
        <font-awesome-icon :icon="['far', 'helmet-battle']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.teams') }}
    </a>
</li>

{{-- Guild Bank --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('bank') }}">
        <font-awesome-icon :icon="['far', 'treasure-chest']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.guild_bank') }}
    </a>
</li>

{{-- Marketplace --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('marketplace') }}">
        <font-awesome-icon :icon="['far', 'balance-scale']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.marketplace') }}
    </a>
</li>

{{-- Discord --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('discord') }}">
        <font-awesome-icon :icon="['fab', 'discord']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.discord') }}
    </a>
</li>

{{-- Applications --}}
<li class="nav-item">
    <a class="nav-link" href="{{ url('join') }}">
        <font-awesome-icon :icon="['far', 'user-plus']" class="nav-icon"></font-awesome-icon>
        {{ __('navigation.join') }}
    </a>
</li>
