@if (session()->has('success'))
<div role="alert" x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false , 3000)" class="absolute z-40">
    <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2 w-48 sm:w-64 mt-5 relative">
      Success
    </div>
    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
      <p>{{session('success')}}</p>
    </div>
  </div>
@elseif(session()->has('error'))
<div role="alert" x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false , 3000)" class="absolute z-40">
  <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2 w-48 sm:64 relative">
    Success
  </div>
  <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
    <p>{{session('error')}}</p>
  </div>
</div>


@endif


