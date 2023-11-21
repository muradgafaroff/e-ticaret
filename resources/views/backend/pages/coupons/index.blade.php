@extends('backend.layout.app')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Coupons</h4>
          <p class="card-description">
            <a href="{{route('panel.coupons.create')}}" class="btn btn-primary">New</a>
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
                  <th>Coupon</th>
                  <th>Discount Price</th>
                  <th>Percentage Discount Price</th>
                  <th>Status</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                @if (!empty($coupons) && $coupons->count() > 0)
                    @foreach ($coupons as $coupon)
                    <tr class="item" item-id="{{ $coupon->id }}">
                        <td>{{$coupon->name}}</td>
                        <td>{{$coupon->price ?? ''}}</td>
                        <td>{{$coupon->discount_rate}}</td>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" class="durum" data-on="Aktive" value="1" data-off="Passive" data-onstyle="success" data-offstyle="danger" {{ $coupon->status == '1' ? 'checked' : '' }}  data-toggle="toggle">
                            </label>
                          </div>

                        </td>
                        <td class="d-flex">
                            <a href="{{route('panel.coupons.edit',$coupon->id)}}" class="btn btn-primary mr-2">Edit</a>

                           {{-- <form action="{{route('panel.slider.destroy',$coupon->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>  --}}


                            <button type="button" class="silBtn btn btn-danger">Delete</button>
                        </td>
                      </tr>

                    @endforeach
                @endif

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>



  </div>
@endsection

@section('customjs')
<script>

    $(document).on('change', '.durum', function(e) {

            id = $(this).closest('.item').attr('item-id');
            statu = $(this).prop('checked');
            $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            url:"{{route('panel.coupons.status')}}",
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
                            url:"{{route('panel.coupons.destroy')}}",
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
