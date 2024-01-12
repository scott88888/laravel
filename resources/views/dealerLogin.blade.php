<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
        <img src="{{ asset('images/icon/Logo_index.png') }}">
        </x-slot>

        <x-validation-errors class="mb-4" />



        <form method="POST" action="DealerCheckLogin">
            @csrf

            <div>
                <x-label for="dealer_id" value="account" />
                <x-input id="dealer_id" class="block mt-1 w-full" type="text" name="dealer_id"  />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Password" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" />
            </div>

       

            <div class="flex items-center justify-end mt-4">
                

                <x-button class="ml-4">
                   Log in
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
