<div class="collection-container">
    @foreach($collections as $collection)
    <div class="collection-items w-full flex flex-col items-center">
      <!-- images row -->
      <div class="flex w-full">
        <div class="main-image w-[60%] h-[300px] bg-gray-200 m-1 rounded-xl overflow-hidden">
            <img class="w-full h-full object-cover rounded-xl" src="{{ asset('storage/' . $collection['collection_image_1']) }}"  alt="">
        </div>

        <div class="w-[40%] h-[300px] flex flex-col">
          <div class="sub-image flex-1 bg-gray-200 m-1 rounded-xl overflow-hidden">
              <img class="w-full h-full object-cover rounded-xl" src="{{ asset('storage/' . $collection['collection_image_2']) }}"  alt="">
          </div>
          <div class="sub-image flex-1 bg-gray-200 m-1 mb-0 rounded-xl overflow-hidden">
              <img class="w-full h-full object-cover rounded-xl" src="{{ asset('storage/' . $collection['collection_image_3']) }}"  alt="">
          </div>
        </div>
      </div>

      <!--title -->
      <h1 class="mt-6 text-xl font-bold">{{$collection['title']}}</h1>
      <h1 class="mt-2 text-sm font-light">Starting from GHS {{$collection['starting_from']}}</h1>
      <!-- <a href="{{route('collection', $collection['id'])}}" class="mt-2 text-sm font-light underline hover:text-blue-500">View all</a> -->
    </div>
    @endforeach

</div>
