<div class="w-full relative flex flex-col justify-center items-center">
    


    <div class="w-10/12 flex justify-center items-center relative flex-col">
            
        @foreach ($carts as $cart)
        <div class="w-10/12 h-16 m-2 relative border flex justify-between bg-white rounded "  style="background-color: #F48B29;">
            <div class="flex h-full">
            <div class="h-16 w-16 relative flex justify-center items-center ">
                <img src="/storage/pizza/{{$cart['pizza_img']}}" class="w-12 h-12 rounded" alt="">
            </div>
            <div class="flex flex-col ml-5 mb-5 justify-center mt-5">
                <h1 class="text-xs">{{$cart['name']}}</h1>
                <h1 class="text-xs">PHP{{$cart['price']}}</h1>
                <h1 class="text-xs">{{$cart['pcs'] > 1 ? 'PCS' : 'PC'}}:{{$cart['pcs']}}</h1>                 
            </div>
          </div>
         
        </div>
    @endforeach


    <div class="w-full relative flex flex-col justify-center items-center relative rounded " >
        <div class="w-full flex justify-start">
            <h1 class="pl-6 sm:pl-20 text-white">Address:</h1>
        </div>

        @if ($user->billing_address)
            <div class="border break-words w-10/12 bg-white rounded relative flex-col flex sm:flex-row sm:gap- sm:justify-around"  style="background-color: #F48B29;">
                <h1 class="text-xs p-5">{{$user->billing_address->country}},{{$user->billing_address->province}},{{$user->billing_address->city}},{{$user->billing_address->region}},{{$user->billing_address->posta_id}},{{$user->billing_address->barangay}},{{$user->billing_address->street_name}},</h1>
                <div class="ml-2 sm:mr-2 sm:ml-0 ">
                    <button class="border my-4 rounded " wire:click="changeAddress" style="background-color:#4681f4 ;"><p class="p-1">Change</p></button>
                </div>
                
            </div>

    <div class="flex flex-col w-10/12 relative">
        <form wire:submit.prevent="checkout" method="POST">
            @csrf
            <div class="flex flex-col relative">
                <x-label class="text-white">Receiver Name:*</x-label>
                <x-input type="text" wire:model.defer="receiver_name"  style="background-color: #F48B29;"/>
                @error('receiver_name')
                <p class="text-xs text-red-400">{{$message}}</p>
            @enderror
            </div>
            <div class="flex flex-col relative"  > 
                <x-label class="text-white">Receiver Mobile Number:*</x-label>
                <x-input type="number" wire:model.defer="receiver_mobile_number"  style="background-color: #F48B29;" />
                @error('receiver_mobile_number')
                <p class="text-xs text-red-400">{{$message}}</p>
            @enderror
            </div>
        <h1 class="font-semibold text-white" >Payment Method*</h1>
        <div class="flex w-full flex-col">
            <select name="payment_method" wire:model.defer="payment_method" id="" class="rounded border-gray-300"  style="background-color: #F48B29;">
                <option value=""></option>
                <option value="card">Debit / Credit Card</option>
                <option value="cod">Cash On Hand</option>
            </select>
            @error('payment_method')
                <p class="text-xs text-red-400">{{$message}}</p>
            @enderror
            </div>
            <div class="flex w-full relative justify-end mr-20 mt-10 items-center gap-2">
                <p class="text-xs text-white" id="note">Note: There is no cancelation of an order so please be mindful</p>
                <x-button type="submit" class="break-keep" style="background-color:#4681f4 ;"   >
                    ₱{{$total_price}} checkout
                </x-button>
        </div>
    </form>
    </div>




        @else    
        <form wire:submit.prevent="saveAddress">
            @csrf
            <div class="flex gap-32">
                <div class="flex flex-col h-16 relative">
                    <x-label for="country">Country*</x-label>
                    <x-input wire:model="country" name="country" type="text" />
                </div>
                <div class="flex flex-col h-16 relative">
                    <x-label for="province">Province*</x-label>
                    <x-input wire:model="province" name="province" type="text" />
                </div>
            </div>

            <div class="flex gap-32">
                <div class="flex flex-col h-16 relative">
                    <x-label for="city">City*</x-label>
                    <x-input wire:model="city" name="city" type="text" />
                </div>
                <div class="flex flex-col h-16 relative">
                    <x-label for="region">Region*</x-label>
                    <x-input wire:model="region" name="region" type="text" />
                </div>
            </div>

            <div class="flex gap-32">
             
                <div class="flex flex-col h-16 relative">
                    <x-label for="postal_id">Postal ID*</x-label>
                    <x-input wire:model="postal_id" name="postal_id" type="number" />
                </div>

                <div class="flex flex-col h-16 relative">
                    <x-label for="barangay">Barangay*</x-label>
                    <x-input wire:model="barangay" name="barangay" type="text" />
                </div>

            </div> 

            <div class="flex gap-32">

                <div class="flex flex-col h-16 relative">
                    <x-label for="address">Street Address</x-label>
                    <x-input wire:model="address" name="address" type="text" />
                </div>
                <div class="flex flex-col h-16 relative mt-10">
                    <x-button>Save</x-button>
                </div>
            </div>
        </form>
        @endif
       
    </div>

   

   
    </div> 
         
    <x-modal wire:model="changeAddressModal">
        <div class="m-5 flex flex-col w-full relativejustify-center items-center">
            <form wire:submit.prevent="saveNewAddress">
                @csrf
                <div class="flex flex-col w-full sm:flex-row sm:gap-32 justify-center items-center">
                    <div class="flex flex-col h-16 relative">
                        <x-label for="newcountry">Country*</x-label>
                        <x-input wire:model.defer="newcountry" name="newcountry"  type="text" />
                        @error('newcountry')
                        <p class="text-xs text-red-400">{{$message}}</p>
                    @enderror
                    </div>
                    <div class="flex flex-col h-16 relative">
                        <x-label for="newprovince">Province*</x-label>
                        <x-input wire:model.defer="newprovince" name="newprovince" type="text" />
                        @error('newprovince')
                        <p class="text-xs text-red-400">{{$message}}</p>
                    @enderror
                    </div>
                </div>
    
                <div class="flex sm:gap-32 flex-col w-full sm:flex-row justify-center items-center">
                    <div class="flex flex-col h-16 relative">
                        <x-label for="newcity">City*</x-label>
                        <x-input wire:model.defer="newcity" name="newcity" type="text" />
                        @error('newcity')
                            <p class="text-xs text-red-400">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col h-16 relative ">
                        <x-label for="newregion">Region*</x-label>
                        <x-input wire:model.defer="newregion" name="newregion" type="text" />
                        @error('newregion')
                        <p class="text-xs text-red-400">{{$message}}</p>
                    @enderror
                    </div>
                </div>
    
                <div class="flex sm:gap-32 flex-col w-full sm:flex-row justify-center items-center">
                 
                    <div class="flex flex-col h-16 relative">
                        <x-label for="newpostal_id">Postal ID*</x-label>
                        <x-input wire:model.defer="newpostal_id" name="newpostal_id" type="number" />
                        @error('newpostal_id')
                        <p class="text-xs text-red-400">{{$message}}</p>
                    @enderror
                    </div>
    
                    <div class="flex flex-col h-16 relative">
                        <x-label for="newbarangay">Barangay*</x-label>
                        <x-input wire:model.defer="newbarangay" name="newbarangay" type="text" />
                        @error('newbarangay')
                        <p class="text-xs text-red-400">{{$message}}</p>
                    @enderror
                    </div>
    
                </div> 
    
                <div class="flex sm:gap-32 flex-col w-full sm:flex-row  ">
    
                    <div class="flex flex-col h-16 relative">
                        <x-label for="newaddress">Street Address</x-label>
                        <x-input wire:model.defer="newaddress" name="newaddress" type="text" />
                        @error('newaddress')
                        <p class="text-xs text-red-400">{{$message}}</p>
                    @enderror
                    </div>
                    <div class="flex flex-col h-16 relative mt-10">
                        <x-button type="submit" style="background-color:#4681f4;" >Save</x-button>
                    </div>
                </div>
            </form>
        </div>
          </x-modal>
    


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var note = document.getElementById('note');
        var count = 0;
        var interval = setInterval(() => {
            count++;
            if (count%2 == 0) {
                note.innerHTML = "Note: Use a real receiver name and number to prevent the admin to cancel your order";
            }else{
                note.innerHTML = "Note: There is no cancelation of an order so please be mindful";
                
            }
        }, 4000);

    });
</script>

        
</div>
