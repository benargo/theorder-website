@extends('template')

@section('title', $title)

@section('content')
    <div id="app">
        <header class="container-fluid bg-engineering extra-padding-top extra-padding-bottom text-light">
            <div class="content">
                <h1 class="text-center">{{ $title }}</h1>
            </div>
        </header>
        <div class="extra-padding-top extra-padding-bottom text-light">
            <div class="container extra-padding-bottom">
                <new-rank
                    :discord-roles='{!! $roles->toJson() !!}'
                    :lang="{
                        btnNewRank:       '{{ __('controlpanel.ranks.btn_new_rank') }}',
                        btnCreateRank:    '{{ __('controlpanel.ranks.btn_create_rank') }}',
                        errTitle:              '{{ __('controlpanel.ranks.errors.title') }}',
                        errSeniority:          '{{ __('controlpanel.ranks.errors.seniority') }}',
                        errKudosPerDay:        '{{ __('controlpanel.ranks.errors.kudos_per_day') }}',
                        errKudosRequired:      '{{ __('controlpanel.ranks.errors.kudos_required') }}',
                        errEmpty:              '{{ __('controlpanel.ranks.errors.empty') }}',
                        hdrTitle:         '{{ __('controlpanel.ranks.hdr_title') }}',
                        hdrSeniority:     '{{ __('controlpanel.ranks.hdr_seniority') }}',
                        hdrKudosPerDay:   '{{ __('controlpanel.ranks.hdr_kudos_per_day') }}',
                        hdrKudosRequired: '{{ __('controlpanel.ranks.hdr_kudos_required') }}',
                        hdrDiscordRole:   '{{ __('controlpanel.ranks.hdr_discord_role') }}',
                    }"
                ></new-rank>
            </div>
            <ranks-manager
                ref="RanksManagerComponent"
                :discord-roles='{!! $roles->toJson() !!}'
                :lang="{
                    btnCancel:             '{{ __('forms.buttons.cancel') }}',
                    btnDelete:             '{{ __('controlpanel.ranks.btn_delete') }}',
                    btnEdit:               '{{ __('controlpanel.ranks.btn_edit') }}',
                    btnSave:               '{{ __('forms.buttons.save') }}',
                    errTitle:              '{{ __('controlpanel.ranks.errors.title') }}',
                    errSeniority:          '{{ __('controlpanel.ranks.errors.seniority') }}',
                    errKudosPerDay:        '{{ __('controlpanel.ranks.errors.kudos_per_day') }}',
                    errKudosRequired:      '{{ __('controlpanel.ranks.errors.kudos_required') }}',
                    errEmpty:              '{{ __('controlpanel.ranks.errors.empty') }}',
                    hdrTitle:              '{{ __('controlpanel.ranks.hdr_title') }}',
                    hdrSeniority:          '{{ __('controlpanel.ranks.hdr_seniority') }}',
                    hdrKudosPerDay:        '{{ __('controlpanel.ranks.hdr_kudos_per_day') }}',
                    hdrKudosRequired:      '{{ __('controlpanel.ranks.hdr_kudos_required') }}',
                    hdrDiscordRole:        '{{ __('controlpanel.ranks.hdr_discord_role') }}',
                    hdrActions:            '{{ __('controlpanel.ranks.hdr_actions') }}',
                    hdrNewRank:            '{{ __('controlpanel.ranks.hdr_new_rank') }}',
                    abbrUnlimited:         '{{ __('controlpanel.ranks.abbr_unlimited') }}',
                    fieldUnlimited:        '{{ __('controlpanel.ranks.field_unlimited') }}',
                    warnDeleteIsPermanent: '<p>{{ __('controlpanel.ranks.warn_delete_is_permanent.p1') }}</p><p>{{ __('controlpanel.ranks.warn_delete_is_permanent.p2') }}</p>',
                    areYouSure:            '{{ __('controlpanel.ranks.are_you_sure') }}',
                    noRole:                '{{ __('controlpanel.ranks.no_role') }}',
                    usersToMoveLead:       '{{ __('controlpanel.ranks.users_to_move.lead') }}',
                    usersToMoveSmall:      '{{ __('controlpanel.ranks.users_to_move.small') }}',
                }"
            ></ranks-manager>
        </div>
    </div>
@endsection
