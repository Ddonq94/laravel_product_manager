@extends('layouts.app')

@section('content')



<div class="container mt-4">
 
<h1>Edit Product below</h1>
 
  @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
  @endif
  
  @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

  <div class="card">
    
    <div class="card-body">
      <form name="add-product" id="add-product" method="post" action="{{url('product')}}/{{$product['id']}}">
       @csrf
        <div class="form-group">
          <label >Product Name</label>
          <input type="text" id="name" value="{{$product['name']}}" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label >Quantity in stock</label>
          <input type="number" id="quantity" value="{{$product['quantity']}}" name="quantity" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label > Price per item</label>
          <input type="number" id="unit_price" value="{{$product['unit_price']}}" name="unit_price" class="form-control" required>
        </div>
        <input name="_method" type="hidden" value="PUT">
        
        <button type="submit" class="btn btn-primary">Update</button>
      </form>


      
    </div>
  </div>
  
</div> 






   
    
      






@endsection