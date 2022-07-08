@props([
'vacation' => false,
'user',
'method' => '',
'isHead' => false,
])

@php
    $opUpdateAccess = $vacation && $vacation->user_id == Auth::id() && !$vacation->fix;
    $opDeleteAccess = $vacation && $vacation->user_id == Auth::id() && !$vacation->fix;
    $opFixAccess = $vacation && $isHead && !$vacation->fix;
@endphp

<form {{ $attributes->merge(['class' => 'flex mt-2 j-vacation']) }} method="{{ $method }}" action="{{ route('vacation.store') }}">
    <div class="w-1/3 flex items-center">{{ @$user->name }}</div>
    <div class="w-1/6">
        @if(!$vacation || $opUpdateAccess)
            <x-input class="block w-40 datepicker" type="text" name="start" value="{{ $vacation ? $vacation->start : '' }}"/>
        @else
            {{ $vacation->start }}
        @endif
    </div>
    <div class="w-1/6">
        @if(!$vacation || $opUpdateAccess)
            <x-input class="block w-40 datepicker" type="text" name="stop" value="{{ $vacation ? $vacation->stop : '' }}"/>
        @else
            {{ $vacation->stop }}
        @endif
    </div>
    <div class="w-1/3 flex items-center">

        <input type="hidden" name="user_id" value="{{ @$user->id }}">

        @if(!$vacation)
            <x-button class="j-vacation-add mx-1" type="button" data-action="{{ route('vacation.store') }}">
                {{ __('Add') }}
            </x-button>
        @elseif($opUpdateAccess)
            <x-button class="j-vacation-update mx-1" type="button" data-action="{{ route('vacation.update', ['vacation' => $vacation->id]) }}">
                {{ __('Update') }}
            </x-button>
        @endif

        @if($opDeleteAccess)
            <x-button class="j-vacation-delete mx-1" type="button" data-action="{{ route('vacation.update', ['vacation' => $vacation->id]) }}">
                {{ __('Delete') }}
            </x-button>
        @endif

        @if($opFixAccess)
            <x-button class="j-vacation-fix mx-1" type="button" data-action="{{ route('vacation.update', ['vacation' => $vacation->id]) }}">
                {{ __('Fix') }}
            </x-button>
        @endif

        @csrf
    </div>
</form>
