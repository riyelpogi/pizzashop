<div class="w-full relative flex flex-col justify-center items-center">
    <x-message />
    @if (session()->has('failed'))
        <p>{{session('failed')}}</p>
    @endif
    
    @if ($carts)
    @foreach ($carts as $cart)
    <div class="w-10/12 m-10 relative border flex justify-between rounded " style="background-color:#F48B29;">
        <div class="flex h-full justify-center items-center w-full">
        <div class="h-16 w-16 flex justify-center items-center small:w-24 small:h-24  small:w-32 small:h-32 relative ml-3">
            <img src="/storage/pizza/{{$cart['pizza_img']}}" class="w-full h-full rounded" alt="">
        </div>
        <div class="flex flex-col ml-2 mb-5 w-full">
            <h1 class="pl-5 pt-5 text-xs sm:text-sm">{{$cart['name']}}</h1>
            <h1 class="pl-5 pt-1 text-xs sm:text-sm">₱{{$cart['price']}}</h1>
            <h1 class="pl-5 pt-1 text-xs sm:text-sm">{{$cart['pcs'] > 1 ? 'PCS' : 'PC'}}:{{$cart['pcs']}}</h1>
            <p class="pl-5 pt-1 text-xs hidden sm:block sm:text-sm">{{$cart['description']}}</p>
        </div>
      </div>
      <div class="mt-5 ml-3 flex justify-center items-end ">
        <x-button wire:click="removeOnCart({{$cart['pizza_id']}})" class="mb-3 mr-2">delete</x-button>
      </div>
    </div>
@endforeach
    @else
        <div class="flex h-screen w-full justify-center items-center">
            <h1 class="text-center font-bold text-2xl mt-10 text-white">CART EMPTY</h1>

        </div>    

    @endif
       
    @if ($carts)
    <div class="mb-5">
        <a href="{{ route('checkout') }}">
            <x-button class=""  style="background-color:#4681f4;">Place order</x-button>
        </a>
    </div>


    @endif
  
    

   
 {{--  --}}


</div>


  