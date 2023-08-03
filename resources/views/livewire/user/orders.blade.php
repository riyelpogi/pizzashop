<div class="w-full relative flex flex-col justify-center items-center">

    @foreach ($orders as $order)
    <div class="w-9/12 m-5 rounded-lg relative p-2 bg-white" style="background-color: #F48B29;">
        <div class="w-full relative">
            <h1 class="text-xs md:text-lg font-bold">Transaction ID: {{$order->id}}</h1>
        </div>
        @foreach ($order['orders'] as $pizza)
            <div class="w-full relative mt-1 flex gap-3">

                <div class="w-20 h-20  sm:w-32 sm:h-32">
                    <img src="/storage/pizza/{{$pizza['pizza_img']}}" class="w-full rounded" alt="">
                </div>

                <div class="flex flex-col justify-center ">
                    <h1 class="font-semibold text-xs sm:text-sm">{{$pizza['pizza_name']}}</h1>
                    <h1 class="font-semibold text-xs sm:text-sm">{{$pizza['pcs'] > 1 ? 'PCS' : 'PC'}}:{{$pizza['pcs']}}</h1>
                    <h1 class="font-semibold text-xs sm:text-sm">₱{{$pizza['price']}}</h1>
                </div>

            </div>
        @endforeach
        <div class="w-full flex justify-end">
            <div class="flex gap-2 justify-center items-center">
                <p class="text-xs noticetext hidden sm:block">Note: If your order is more than 1 it will take some time so please be patient.</p>
                @if ($order->status == 'delivered')
                      <x-button disabled class="bg-green-400" style="background-color:#4681f4 ;"> Delivery Successful</x-button>
                @else 
                    <x-button disabled style="background-color:#4681f4 ;">{{$order->status}}</x-button>
                    <x-button disabled style="background-color:#4681f4 ;">{{$order->payment_status}}</x-button>
                @endif


            </div>
        </div>
    </div>
    @endforeach
    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var text = document.querySelectorAll('.noticetext');
        var count = 0;
        var timer = setInterval(() => {
            count++;

        text.forEach(element => {
                if (count%2 == 0) {
                    element.innerHTML = "Note: If your order is more than 1 it will take some time so please be patient.";
                }else{
                    element.innerHTML = "Note: Please prepare the exact amount if your order is cash on delivery.";
                }

            });

        }, 5000);

        });

       
       

      


</script>        
</div>
