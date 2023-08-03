<div class="w-full relative z-10  ">  
    <div class="flex justify-center items-center">
        <x-message />
    </div>
    <div class="w-full relative flex flex-col justify-center items-center gap-5 small:grid small:grid-cols-2 sm:grid-cols-3 small:justify-items-center small:item-center small:gap-10 ">
    @foreach ($pizzas as $pizza)
        <div class="w-32  h-48 relative flex flex-col rounded-lg border mt-2" style="background-color: #F48B29;">
            <div class="w-30 h-30 relative flex justify-center items-center">
                <img src="/storage/pizza/{{$pizza->picture}}" class="w-24 pt-1 h-24 rounded" alt="">
            </div>
            <div class="mt-2">
                <h1 class="text-xs">{{$pizza->name}}</h1>
                <h1 class="text-xs">₱{{$pizza->price}}</h1>
            </div>


            <div class="mt-3 flex gap-3 justify-center items-center mb-2">
                <button class="text-xs  py-2 px-2 rounded hover:bg-orange-600 font-semibold" style="background-color:#4681f4  ;"  wire:click="showModal({{$pizza->id}})" wire:key="addtocart-{{$pizza->id}}">view</button>
                <button class="text-xs  py-2 px-1 rounded hover:bg-orange-600 font-semibold" style="background-color:#4681f4 ;" wire:click="addtocart({{$pizza->id}})" wire:key="addtocart-{{$pizza->id}}">add to cart</button>
            </div>
        </div>
    @endforeach

    
    <x-modal wire:model="pizzaModal">

   <div class="w-full relative flex flex-col justify-center items-center mt-10 mb-10 ">
            <div class="w-16 h-16 small:w-32 small:h-32 relative flex flex-col small:flex-row justify-center items-center gap-10 mb-5 small:mb-0">
                <img src="/storage/pizza/{{$pizza_img}}" class="w-full h-full" alt="">
                <div class="w-32">
                    <h1 class="text-xs small:text-sm font-semibold whitespace-nowrap">{{$pizza_name}}</h1>
                    <h1 class="font-semibold text-xs small:text-sm">₱{{$pizza_price}}</h1>
                </div>
            </div>
            <div class="text-center w-64 mt-5 small:mt-0">
                <h1 class="font-semibold text-xs small:text-sm ">{{$pizza_description}}</h1>
            </div>
        </div>
    
    </x-modal>
</div>
</div>
