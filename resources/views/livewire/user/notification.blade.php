<div class="w-8 mr-5 relative">
        <x-dropdown >
            <x-slot name="trigger">
                <div class="flex justify-center items-center relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer "  wire:click="markAsRead" height="20" viewBox="0 -960 960 960" width="20"><path d="M160-200v-60h84v-306q0-84 49.5-149.5T424-798v-29q0-23 16.5-38t39.5-15q23 0 39.5 15t16.5 38v29q81 17 131 82.5T717-566v306h83v60H160Zm320-295Zm0 415q-32 0-56-23.5T400-160h160q0 33-23.5 56.5T480-80ZM304-260h353v-306q0-74-51-126t-125-52q-74 0-125.5 52T304-566v306Z" /></svg>
                    <div class="">
                        <span class="text-xs rounded-full p-0.5">{{$notificationsCount}}</span>
                    </div>
                   
                </div>
            </x-slot>

            <x-slot name="content">
                @foreach ($notifications as $notification)
                    <div class="w-full m-1">
                        <h1 class="p-1">{{$notification->data['message']}}.</h1>
                    </div>
                @endforeach
            </x-slot>
        </x-dropdown>
</div>
