@extends('backend.layout.app')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Category</h4>
          <p class="card-description">
            <a href="{{route('panel.product.create')}}" class="btn btn-primary">New</a>

            <a href="{{route('panel.product.export')}}" class="btn btn-primary">Excel Export</a>
          </p>

            @if (session()->get('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                @endif


          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Slogan</th>
                  <th>Link</th>
                  <th>Status</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                @if (!empty($products) && $products->count() > 0)
                    @foreach ($products as $item)
                    <tr class="item" item-id="{{ $item->id }}">
                        <td class="py-1">


                            @php
                            $images = collect($item->images->data ?? '');
                            @endphp
                            <img src="{{asset($images->sortByDesc('vitrin')->first()['image'] ?? 'img/resimyok.png')}}" ></img>


                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->category->name ?? ''}}</td>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" class="status" data-on="Aktive" value="1" data-off="Passive" data-onstyle="success" data-offstyle="danger" {{ $item->status == '1' ? 'checked' : '' }}  data-toggle="toggle">
                            </label>
                          </div>
                        </td>
                        <td class="d-flex">
                            <a href="{{route('panel.product.edit',$item->id)}}" class="btn btn-primary mr-2">Edit</a>

                            <button type="button" class="silBtn btn btn-danger">Delete</button>
                        </td>
                      </tr>

                    @endforeach
                @endif

              </tbody>
            </table>
          </div>

          {{$products->links('pagination::custom')}}
        </div>
      </div>
    </div>



  </div>
@endsection

@section('customjs')
<script>

    $(document).on('change', '.status', function(e) {

            id = $(this).closest('.item').attr('item-id');
            statu = $(this).prop('checked');
            $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            url:"{{route('panel.product.status')}}",
            data:{
                id:id,
                statu:statu
            },
            success: function (response) {
                if (response.status == "true")
                {
                    alertify.success("Status Activated");
                } else {
                    alertify.error("Status Disabled");
                }
            }
        });
    });


        $(document).on('click', '.silBtn', function(e) {
            e.preventDefault();
                var item = $(this).closest('.item');
                 id = item.attr('item-id');
                alertify.confirm("Are You Sure You Want to Delete?","Are You Sure You Want to Delete?",
                    function(){

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:"DELETE",
                            url:"{{route('panel.product.destroy')}}",
                            data:{
                                id:id,
                            },
                            success: function (response) {
                                if (response.error == false)
                                {
                                    item.remove();
                                    alertify.success(response.message);
                                }else {
                                    alertify.error("Error");
                                }
                            }
                        });
                    },
                    function(){
                        alertify.error('Deletion Canceled');
                    });
        });

</script>
@endsection
