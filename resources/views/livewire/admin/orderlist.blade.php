<div class="w-full flex flex-col justify-center items-center ">
    <x-message /> 
    @foreach ($orders as $order)
    <div class="w-9/12 m-5 rounded-lg relative p-2" style="background-color: #F48B29;" wire:init="LoadTransactions">
        <div class="w-full relative">
            <h1 class="text-lg font-bold">Transaction ID: {{$order->id}}</h1>
        </div>
        
        @foreach ($order['orders'] as $pizza)
            <div class="w-full relative mt-1 flex gap-3">
                <div class="w-16 h-16">
                    <img src="/storage/pizza/{{$pizza['pizza_img']}}" class="w-full rounded" alt="">
                </div>  

                <div class="flex flex-col justify-center ">
                    <h1 class="font-semibold text-sm">{{$pizza['pizza_name']}}</h1>
                    <h1 class="font-semibold text-sm">{{$pizza['pcs'] > 1 ? 'PCS' : 'PC'}}:{{$pizza['pcs']}}</h1>
                    <h1 class="font-semibold text-sm">₱{{$pizza['price']}}</h1>
                </div>

            </div>
        @endforeach
       
        <div class="w-full relative mt-2">
            <h1 class="text-xs font-semibold">Total Price: ₱{{$order->price}}</h1>
            <h1 class="text-xs font-semibold">Receiver Name: {{$order->receiver_name}}</h1>
            <h1 class="text-xs font-semibold">Mobile Number: {{$order->receiver_number}}</h1>
            <h1 class="text-xs font-semibold">Address: {{$order->billing_address}}</h1>
            <h1 class="text-xs font-semibold">Order Status: {{strtoupper($order->status )}}</h1>
            <h1 class="text-xs font-semibold">Payment Status: {{strtoupper($order->payment_status )}}</h1>
            <h1 class="text-xs font-semibold">Payment Method: {{strtoupper($order->payment_method )}}</h1>
        </div>

        <div class="w-full flex justify-end mt-2">
            <div class="flex gap-2 justify-center items-center">
                
                @if ($order->status == 'pending')
                     <x-button wire:click="preparing({{$order->id}})"  wire:key="status-({{$order->id}})" style="background-color:#4681f4 ;">Mark as preparing</x-button>

                @elseif ($order->status == 'preparing')
                     <x-button wire:click="delivering({{$order->id}})"  wire:key="status-({{$order->id}})" style="background-color:#4681f4 ;">mark as  delivering</x-button>

                @elseif ($order->status == 'delivering')
                <x-button wire:click="delivered({{$order->id}})"  wire:key="status-({{$order->id}})" style="background-color:#4681f4 ;">mark as delivered</x-button>

                

                @endif

                <x-button wire:click="cancelOrder({{$order->id}})" wire:key="cancel-({{$order->id}})" style="background-color:#4681f4 ;">cancel order</x-button>

            </div>
        </div>
    </div>
    @endforeach



</div>
