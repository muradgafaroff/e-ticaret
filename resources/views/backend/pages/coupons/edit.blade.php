@extends('backend.layout.app')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Coupon</h4>

                @if ($errors)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                    @endforeach
                @endif
                @if (session()->get('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                @endif

                @if (session()->get('error'))
                <div class="alert alert-danger">
                    {{session()->get('error')}}
                </div>
                @endif


                @if (!empty($coupon->id))
                @php
                        $routelink = route('panel.coupons.update',$coupon->id);

                @endphp
                @else
                    @php
                        $routelink = route('panel.coupons.store');
                    @endphp
                @endif
                <form action="{{$routelink}}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($coupon->id))
                        @method('PUT')
                    @endif

                  <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$coupon->name ?? ''}}" placeholder="coupon title">
                  </div>


                  <div class="form-group">
                    <label for="name">Discount Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{$coupon->price ?? ''}}" >
                  </div>


                  

                  <div class="form-group">
                    <label for="durum">Status</label>
                    @php
                      $status =  $coupon->status ?? '1';
                    @endphp
                    <select name="status" id="status" class="form-control">
                        <option value="0" {{$status == '0' ? 'selected' : ''}}>Passive</option>
                        <option value="1" {{$status == '1' ? 'selected' : ''}}>Aktive</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
              </div>
            </div>
          </div>
    </div>
@endsection
