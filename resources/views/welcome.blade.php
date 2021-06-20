@extends('layouts.app')

@section('content')



<div class="container mt-4">
 
<h1>Add a Product below</h1>
 
  @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
  @endif
  
  @error('name')
    <div class="alert alert-danger ">{{ $message }}</div>
  @enderror

  <!-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif -->

    <div class="alert alert-success alert-dismissible" id="alert">
        <p>Product added successfully</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

  <div class="card">
    
    <div class="card-body">
      <!-- <form name="add-task" id="add-task" method="post" action="{{url('product')}}"> -->
       @csrf
        <div class="form-group">
          <label >Product Name</label>
          <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label >Quantity in stock</label>
          <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label > Price per item</label>
          <input type="number" id="unit_price" name="unit_price" class="form-control" required>
        </div>
        
        <button type="submit" id="submit" onclick="save()" class="btn btn-primary">Submit</button>
      <!-- </form> -->


      
    </div>
  </div>
  <table class="table table-bordered table-sm mt-4 ml-4" style="width:80%">
       <thead>
        <tr>
            
            <th>Product name</th>
            <th>Quantity in stock</th>
            <th>Price per item </th>
            <th>Datetime submitted </th>
            <th>Total value number </th>
            <th >Action</th>
        </tr>
       </thead>
       <tbody id="tblData">

       </tbody>  
    </table>
</div> 






   
    
      
<script>
    $(document).ready(function() {
        $("#alert").hide();
        
        load();
    });

    function load(){
        $("#tblData").empty();

        let url = "{{URL('product')}}";
        $.ajax({
            url: "product",
            type: "GET",
            data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(res){
                let resData = res;

                let tblData = '';
                
                $.each(resData,function(index,row){
                    let tvn = row.quantity * row.unit_price
                    let editUrl = url+'/'+row.id+"/edit";
                    tblData+="<tr>"
                    tblData+=
                    "<td>"+row.name+"</td><td>"+row.quantity+"</td><td>"+row.unit_price+"</td><td>"+row.created_at+"</td><td>"+tvn+"</td>"
                    +"<td><a class='btn btn-primary' href='"+editUrl+"'>Edit</a>" ;
                    tblData+="</tr>";
                    
                })
                let sum = resData.map(rd => {
                    return rd.quantity * rd.unit_price;
                }).reduce((a, b) => a + b, 0)


                tblData += `<tr><td colspan="4"> Sum Total</td><td colspan="2">`+sum+`</td></tr>`
                $("#tblData").append(tblData);
            }
        });
    }


function save(){

    if($("#name").val() === ""){
        alert("Please Fill the name field")
        return;
    }
    if($("#quantity").val() === ""){
        alert("Please Fill the quantity field")
        return;
    }
    if($("#unit_price").val() === ""){
        alert("Please Fill the price field")
        return;
    }

    $.ajax({
           type:'POST',
           url:"{{ route('product.store') }}",
           data:{ 
                _token:'{{ csrf_token() }}',
                name:$("#name").val(),
                quantity:$("#quantity").val(),
                unit_price:$("#unit_price").val(),
            },
           success:function(data){
              console.log(data);
              $("#alert").show();

              load();
           }
        });


}


</script>





@endsection