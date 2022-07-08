<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vacation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex">
                        <div class="w-1/3 font-bold">{{ __('Name') }}</div>
                        <div class="w-1/6 font-bold">{{ __('Start') }}</div>
                        <div class="w-1/6 font-bold">{{ __('End') }}</div>
                        <div class="w-1/3"></div>
                    </div>


                    <x-vacation-row :user="$user" method="POST"/>

                    @foreach ($vacationsMy as $vacation)
                        <x-vacation-row :vacation="$vacation" :user="$vacation->user" method="PUT" :isHead="$isHead"/>
                    @endforeach

                    @foreach ($vacationsOther as $vacation)
                        <x-vacation-row :vacation="$vacation" :user="$vacation->user" :isHead="$isHead"/>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
