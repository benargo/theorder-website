@extends('template')

@section('title', $title)

@section('content')
    <div id="app">
        <header class="container-fluid bg-engineering py-6 text-light">
            <div class="content">
                <h1 class="text-center">{{ $title }}</h1>
            </div>
        </header>
        <div class="py-6 text-light">
            <div class="container pb-6">
                <new-rank
                    :discord-roles='{!! $roles->toJson() !!}'
                    :lang="{
                        btnNewRank:       '{{ Lang::get('controlpanel.ranks.btn_new_rank') }}',
                        btnCreateRank:    '{{ Lang::get('controlpanel.ranks.btn_create_rank') }}',
                        errTitle:         '{{ Lang::get('controlpanel.ranks.errors.title') }}',
                        errSeniority:     '{{ Lang::get('controlpanel.ranks.errors.seniority') }}',
                        errKudosPerDay:   '{{ Lang::get('controlpanel.ranks.errors.kudos_per_day') }}',
                        errKudosRequired: '{{ Lang::get('controlpanel.ranks.errors.kudos_required') }}',
                        errEmpty:         '{{ Lang::get('controlpanel.ranks.errors.empty') }}',
                        hdrTitle:         '{{ Lang::get('controlpanel.ranks.hdr_title') }}',
                        hdrSeniority:     '{{ Lang::get('controlpanel.ranks.hdr_seniority') }}',
                        hdrKudosPerDay:   '{{ Lang::get('controlpanel.ranks.hdr_kudos_per_day') }}',
                        hdrKudosRequired: '{{ Lang::get('controlpanel.ranks.hdr_kudos_required') }}',
                        hdrDiscordRole:   '{{ Lang::get('controlpanel.ranks.hdr_discord_role') }}',
                    }"
                ></new-rank>
            </div>
            <ranks-manager
                ref="RanksManagerComponent"
                :discord-roles='{!! $roles->toJson() !!}'
                :lang="{
                    btnCancel:             '{{ Lang::get('forms.buttons.cancel') }}',
                    btnDelete:             '{{ Lang::get('controlpanel.ranks.btn_delete') }}',
                    btnEdit:               '{{ Lang::get('controlpanel.ranks.btn_edit') }}',
                    btnSave:               '{{ Lang::get('forms.buttons.save') }}',
                    errTitle:              '{{ Lang::get('controlpanel.ranks.errors.title') }}',
                    errSeniority:          '{{ Lang::get('controlpanel.ranks.errors.seniority') }}',
                    errKudosPerDay:        '{{ Lang::get('controlpanel.ranks.errors.kudos_per_day') }}',
                    errKudosRequired:      '{{ Lang::get('controlpanel.ranks.errors.kudos_required') }}',
                    errEmpty:              '{{ Lang::get('controlpanel.ranks.errors.empty') }}',
                    hdrTitle:              '{{ Lang::get('controlpanel.ranks.hdr_title') }}',
                    hdrSeniority:          '{{ Lang::get('controlpanel.ranks.hdr_seniority') }}',
                    hdrKudosPerDay:        '{{ Lang::get('controlpanel.ranks.hdr_kudos_per_day') }}',
                    hdrKudosRequired:      '{{ Lang::get('controlpanel.ranks.hdr_kudos_required') }}',
                    hdrDiscordRole:        '{{ Lang::get('controlpanel.ranks.hdr_discord_role') }}',
                    hdrActions:            '{{ Lang::get('controlpanel.ranks.hdr_actions') }}',
                    hdrNewRank:            '{{ Lang::get('controlpanel.ranks.hdr_new_rank') }}',
                    abbrUnlimited:         '{{ Lang::get('controlpanel.ranks.abbr_unlimited') }}',
                    fieldUnlimited:        '{{ Lang::get('controlpanel.ranks.field_unlimited') }}',
                    warnDeleteIsPermanent: '<p>{{ Lang::get('controlpanel.ranks.warn_delete_is_permanent.p1') }}</p><p>{{ Lang::get('controlpanel.ranks.warn_delete_is_permanent.p2') }}</p>',
                    areYouSure:            '{{ Lang::get('controlpanel.ranks.are_you_sure') }}',
                    noRole:                '{{ Lang::get('controlpanel.ranks.no_role') }}',
                    usersToMoveLead:       '{{ Lang::get('controlpanel.ranks.users_to_move.lead') }}',
                    usersToMoveSmall:      '{{ Lang::get('controlpanel.ranks.users_to_move.small') }}',
                }"
            ></ranks-manager>
        </div>
    </div>
@endsection
